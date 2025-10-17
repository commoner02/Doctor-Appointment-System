<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Chamber;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            'chamber_id' => 'required|exists:chambers,id',
            'appointment_date' => 'required|date|after:now',
            'reason' => 'required|string|max:500'
        ]);

        $patient = $user->patient;

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $validated['doctor_id'],
            'chamber_id' => $validated['chamber_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_status' => 'scheduled',
            'payment_status' => 'unpaid',
            'reason' => $validated['reason']
        ]);

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

        return back()->with('success', 'Appointment status updated successfully!');
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
}