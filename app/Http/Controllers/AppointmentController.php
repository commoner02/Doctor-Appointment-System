<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Chamber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\AppointmentBooked;
use App\Mail\AppointmentCompleted;
use App\Mail\AppointmentCancelled;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    // Removed BrevoEmailService dependency

    public function create(Doctor $doctor)
    {
        // Ensure only patients can access
        if (!auth()->check() || !auth()->user()->isPatient()) {
            abort(403, 'Only patients can book appointments.');
        }

        $chambers = Chamber::where('doctor_id', $doctor->id)
            ->where('is_active', true)
            ->get();

        return view('appointments.create', compact('doctor', 'chambers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'chamber_id' => 'required|exists:chambers,id',
            'appointment_date' => 'required|date|after:today',
            'notes' => 'nullable|string|max:500',
        ]);

        $patient = Auth::user()->patient;
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient profile not found.');
        }

        // Check if doctor owns the chamber
        $chamber = Chamber::find($request->chamber_id);
        if (!$chamber || $chamber->doctor_id != $request->doctor_id) {
            return redirect()->back()->with('error', 'Invalid chamber selection.');
        }

        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'chamber_id' => $request->chamber_id,
            'appointment_date' => $request->appointment_date,
            'status' => 'scheduled',
            'notes' => $request->notes,
        ]);

        // Send booked email to patient and doctor
        try {
            Log::info('Sending booked email to patient: ' . $patient->user->email);
            Mail::to($patient->user->email)->send(new AppointmentBooked($appointment));
            Log::info('Sending booked email to doctor: ' . $appointment->doctor->user->email);
            Mail::to($appointment->doctor->user->email)->send(new AppointmentBooked($appointment));
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            // Continue without failing the request
        }

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

        return view('patient.appointments', compact('appointments'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        // Handle both GET (query param) and POST/PATCH (form data)
        $status = $request->input('status') ?? $request->query('status');
        if (!$status || !in_array($status, ['scheduled', 'completed', 'cancelled'])) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        $oldStatus = $appointment->status;
        $appointment->update(['status' => $status]);

        // Send emails based on status change
        if ($status === 'completed' && $oldStatus !== 'completed') {
            Log::info('Sending completed email to: ' . $appointment->patient->user->email);
            Mail::to($appointment->patient->user->email)->send(new AppointmentCompleted($appointment));
        } elseif ($status === 'cancelled' && $oldStatus !== 'cancelled') {
            Log::info('Sending cancelled email to: ' . $appointment->patient->user->email);
            Mail::to($appointment->patient->user->email)->send(new AppointmentCancelled($appointment));
        }

        return redirect()->back()->with('success', 'Appointment status updated successfully.');
    }

    public function updatePayment(Request $request, Appointment $appointment)
    {
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();
        if ($appointment->doctor_id !== $doctor->id) {
            abort(403);
        }

        $request->validate([
            'payment_status' => 'required|in:pending,paid,cancelled',
        ]);

        $appointment->update(['payment_status' => $request->payment_status]);

        return redirect()->back()->with('success', 'Payment status updated!');
    }

    public function updateNotes(Request $request, Appointment $appointment)
    {
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();
        if ($appointment->doctor_id !== $doctor->id) {
            abort(403);
        }

        $request->validate([
            'notes' => 'nullable|string|max:2000',
        ]);

        $appointment->update(['notes' => $request->notes]);

        return back()->with('success', 'Notes updated.');
    }

    public function edit(Appointment $appointment)
    {
        $user = auth()->user();

        // Patient can only edit their own appointments
        if (!$user->isPatient() || $appointment->patient_id !== $user->patient->id) {
            abort(403, 'Unauthorized');
        }

        // Can't edit completed or cancelled appointments
        if (in_array($appointment->status, ['completed', 'cancelled'])) {
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
        if (in_array($appointment->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'Cannot update completed or cancelled appointments.');
        }

        $validated = $request->validate([
            'chamber_id' => 'required|exists:chambers,id',
            'appointment_date' => 'required|date|after:now',
            'notes' => 'nullable|string|max:500'
        ]);

        // Update appointment
        $appointment->update([
            'chamber_id' => $validated['chamber_id'],
            'appointment_date' => $validated['appointment_date'],
            'notes' => $validated['notes'],
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
        if (in_array($appointment->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'This appointment is already ' . $appointment->status);
        }

        $appointment->update([
            'status' => 'cancelled',
            'updated_at' => now()
        ]);

        // Send cancellation email
        Mail::to($appointment->patient->user->email)->send(new AppointmentCancelled($appointment));

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