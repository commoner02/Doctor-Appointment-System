<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function create(Doctor $doctor)
    {
        $user = auth()->user();

        if (!$user->isPatient()) {
            abort(403, 'Unauthorized');
        }

        $doctor->load('chambers');

        if ($doctor->chambers->isEmpty()) {
            return back()->with('error', 'This doctor has no chambers available.');
        }

        return view('appointments.create', compact('doctor'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->isPatient()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'chamber_id' => 'nullable|exists:chambers,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'nullable|string',
            'notes' => 'nullable|string|max:500',
        ]);

        $patient = $user->patient;

        if (!$patient) {
            $patient = Patient::create(['user_id' => $user->id]);
        }

        $chamber = null;
        if ($request->chamber_id) {
            $chamber = \App\Models\Chamber::find($request->chamber_id);
        }

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $validated['doctor_id'],
            'chamber_id' => $validated['chamber_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'status' => 'pending',
            'fee' => $chamber ? $chamber->fee : null,
            'payment_status' => 'pending',
            'notes' => $validated['notes'],
        ]);

        // Send email notification (we'll implement this later)
        // $this->sendAppointmentNotification($appointment, 'created');

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
        $user = auth()->user();

        // Check authorization - only doctor can update their appointments
        if (!$user->isDoctor() || $appointment->doctor_id !== $user->doctor->id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'appointment_status' => 'required|in:scheduled,completed,cancelled',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Save the update
        $appointment->update([
            'appointment_status' => $validated['appointment_status'],
            'notes' => $validated['notes'] ?? $appointment->notes,
            'updated_at' => now()
        ]);

        // Send email notification
        // $this->sendAppointmentNotification($appointment, 'status_updated');

        return back()->with('success', 'Appointment status updated successfully!');
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