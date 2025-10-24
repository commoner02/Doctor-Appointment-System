<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Chamber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentBooked;
use App\Mail\AppointmentCancelled;
use App\Mail\AppointmentCompleted;

class AppointmentController extends Controller
{
    public function create(Doctor $doctor)
    {
        $user = auth()->user();

        if (!$user->isPatient()) {
            abort(403, 'Unauthorized');
        }

        // Check if doctor is verified
        if ($doctor->verification_status !== 'verified') {
            return redirect()->back()->with('error', 'This doctor is not verified yet.');
        }

        // Get doctor's active chambers
        $chambers = Chamber::where('doctor_id', $doctor->id)
            ->where('is_active', true)
            ->get();

        return view('appointments.create', compact('doctor', 'chambers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'chamber_id' => 'nullable|exists:chambers,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string|max:1000',
        ]);

        $appointment = Appointment::create([
            'patient_id' => Auth::user()->patient->id,
            'doctor_id' => $request->doctor_id,
            'chamber_id' => $request->chamber_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'scheduled', // Default status
            'payment_status' => 'pending', // Default payment status
            'fee' => $request->fee ?? null,
            'notes' => $request->notes,
        ]);

        // Send booking confirmation email
        $patientEmail = Auth::user()->email;
        $doctorName = 'Dr. ' . $appointment->doctor->user->name;
        Mail::to($patientEmail)->send(new AppointmentBooked($appointment, $doctorName));

        return redirect()->route('patient.appointments')->with('success', 'Appointment booked successfully!');
    }

    public function myAppointments()
    {
        $user = auth()->user();

        if (!$user->isPatient()) {
            abort(403, 'Unauthorized');
        }

        $patient = $user->patient;

        $appointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor', 'chamber'])
            ->latest()
            ->get();

        return view('appointments.my-appointments', compact('appointments'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        // Check if user is authorized to update this appointment
        if (Auth::user()->role === 'doctor' && $appointment->doctor_id !== Auth::user()->doctor->id) {
            abort(403, 'Unauthorized');
        }

        if (Auth::user()->role === 'patient' && $appointment->patient_id !== Auth::user()->patient->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'status' => 'required|in:scheduled,completed,cancelled',
            'payment_status' => 'nullable|in:pending,paid,cancelled',
            'notes' => 'nullable|string|max:1000'
        ]);

        $oldStatus = $appointment->status;
        $appointment->status = $request->status;

        if ($request->filled('payment_status')) {
            $appointment->payment_status = $request->payment_status;
        }

        if ($request->filled('notes')) {
            $appointment->notes = $appointment->notes ?
                $appointment->notes . "\n\n" . $request->notes :
                $request->notes;
        }

        $appointment->save();

        // Send email notifications based on status change
        $this->sendStatusNotification($appointment, $oldStatus);

        return redirect()->back()->with('success', 'Appointment updated successfully!');
    }

    private function sendStatusNotification(Appointment $appointment, $oldStatus)
    {
        // Only send emails for status changes (not payment status)
        if ($appointment->status === $oldStatus) {
            return;
        }

        $patientEmail = $appointment->patient->user->email;
        $doctorName = 'Dr. ' . $appointment->doctor->user->name;

        switch ($appointment->status) {
            case 'scheduled':
                // This would be sent when booking, handled in store method
                break;
            case 'completed':
                Mail::to($patientEmail)->send(new AppointmentCompleted($appointment, $doctorName));
                break;
            case 'cancelled':
                Mail::to($patientEmail)->send(new AppointmentCancelled($appointment, $doctorName));
                break;
        }
    }

    public function updatePayment(Request $request, Appointment $appointment)
    {
        $request->validate([
            'payment_status' => 'required|in:paid,pending,cancelled'
        ]);

        $appointment->update(['payment_status' => $request->payment_status]);

        return back()->with('success', 'Payment status updated successfully!');
    }

    public function edit(Appointment $appointment)
    {
        $user = auth()->user();

        // Patient can only edit their own appointments
        if (!$user->isPatient() || $appointment->patient_id !== $user->patient->id) {
            abort(403, 'Unauthorized');
        }

        // Can't edit completed or cancelled appointments
        if (in_array($appointment->appointment_status, ['completed', 'cancelled'])) {
            return back()->with('error', 'Cannot edit completed or cancelled appointments.');
        }

        $doctor = $appointment->doctor;
        $doctor->load('chambers');

        return view('appointments.edit', compact('appointment', 'doctor'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $user = auth()->user();

        // Patient can only update their own appointments
        if (!$user->isPatient() || $appointment->patient_id !== $user->patient->id) {
            abort(403, 'Unauthorized');
        }

        // Can't update completed or cancelled appointments
        if (in_array($appointment->appointment_status, ['completed', 'cancelled'])) {
            return back()->with('error', 'Cannot update completed or cancelled appointments.');
        }

        $validated = $request->validate([
            'chamber_id' => 'required|exists:chambers,id',
            'appointment_date' => 'required|date|after:now',
            'reason' => 'required|string|max:500'
        ]);

        // Update appointment
        $appointment->update([
            'chamber_id' => $validated['chamber_id'],
            'appointment_date' => $validated['appointment_date'],
            'reason' => $validated['reason'],
            'updated_at' => now()
        ]);

        return redirect()->route('patient.appointments')->with('success', 'Appointment updated successfully!');
    }

    public function cancel(Appointment $appointment)
    {
        $user = auth()->user();

        // Patient can cancel their own appointments
        if (!$user->isPatient() || $appointment->patient_id !== $user->patient->id) {
            abort(403, 'Unauthorized');
        }

        // Can't cancel already completed or cancelled appointments
        if (in_array($appointment->appointment_status, ['completed', 'cancelled'])) {
            return back()->with('error', 'This appointment is already ' . $appointment->appointment_status);
        }

        $appointment->update([
            'appointment_status' => 'cancelled',
            'updated_at' => now()
        ]);

        return back()->with('success', 'Appointment cancelled successfully!');
    }

    public function show(Appointment $appointment)
    {
        $user = auth()->user();

        // Check if user has permission to view this appointment
        $canView = false;
        if ($user->isPatient() && $appointment->patient_id === $user->patient->id) {
            $canView = true;
        } elseif ($user->isDoctor() && $appointment->doctor_id === $user->doctor->id) {
            $canView = true;
        } elseif ($user->isAdmin()) {
            $canView = true;
        }

        if (!$canView) {
            abort(403, 'Unauthorized');
        }

        $appointment->load(['patient', 'doctor', 'chamber']);

        return view('appointments.show', compact('appointment'));
    }

    public function index(Request $request)
    {
        $query = Appointment::with(['patient.user', 'doctor.user', 'chamber']);

        // Apply role-based filtering
        if (auth()->user()->isDoctor()) {
            $query->where('doctor_id', auth()->user()->doctor->id);
        } elseif (auth()->user()->isPatient()) {
            $query->where('patient_id', auth()->user()->patient->id);
        }
        // Admin sees all appointments

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient.user', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('doctor.user', function ($subQ) use ($search) {
                        $subQ->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Date filter
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->get('date'));
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(10);

        // Get stats for quick overview
        $statsQuery = Appointment::query();
        if (auth()->user()->isDoctor()) {
            $statsQuery->where('doctor_id', auth()->user()->doctor->id);
        } elseif (auth()->user()->isPatient()) {
            $statsQuery->where('patient_id', auth()->user()->patient->id);
        }

        $stats = [
            'pending' => $statsQuery->clone()->where('status', 'pending')->count(),
            'confirmed' => $statsQuery->clone()->where('status', 'confirmed')->count(),
            'completed' => $statsQuery->clone()->where('status', 'completed')->count(),
            'cancelled' => $statsQuery->clone()->where('status', 'cancelled')->count(),
        ];

        return view('appointments.index', compact('appointments', 'stats'));
    }
}