<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;

class AppointmentController extends Controller
{
    public function create(Doctor $doctor)
    {
        $doctor->load(['user', 'chambers']);
        return view('appointments.create', compact('doctor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'chamber_id' => 'required|exists:chambers,id',
            'appointment_date' => 'required|date',
            'reason' => 'nullable|string|max:255',
        ]);

        $patientId = auth()->user()->patient->id;

        Appointment::create([
            'patient_id' => $patientId,
            'doctor_id' => $request->doctor_id,
            'chamber_id' => $request->chamber_id,
            'appointment_date' => $request->appointment_date,
            'appointment_status' => 'scheduled',
            'payment_status' => 'unpaid',
            'reason' => $request->reason,
        ]);

        return redirect()->route('patient.appointments')->with('success', 'Appointment booked successfully.');
    }

    public function myAppointments()
    {
        $appointments = Appointment::with(['doctor.user', 'chamber'])
            ->where('patient_id', auth()->user()->patient->id)
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('appointments.my-appointments', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor.user', 'chamber']);
        return view('appointments.show', compact('appointment'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'appointment_status' => 'required|in:scheduled,completed,cancelled'
        ]);

        // Check authorization
        $user = auth()->user();
        if (!$user->isAdmin() && !($user->isDoctor() && $appointment->doctor_id == $user->doctor->id)) {
            abort(403, 'Unauthorized');
        }

        // Update the appointment status
        $updated = $appointment->update([
            'appointment_status' => $request->appointment_status
        ]);

        if ($updated) {
            return redirect()->back()->with('success', 'Appointment status updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update appointment status.');
        }
    }

    public function updatePaymentStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'payment_status' => 'required|in:paid,unpaid'
        ]);

        // Check authorization
        $user = auth()->user();
        if (!$user->isAdmin() && !($user->isDoctor() && $appointment->doctor_id == $user->doctor->id)) {
            abort(403, 'Unauthorized');
        }

        // Update the payment status

    \Log::info('Update attempt', [
    'appointment_id' => $appointment->id,
    'old_status' => $appointment->appointment_status,
    'new_status' => $request->appointment_status ?? $request->payment_status,
    'user_id' => auth()->id()
]);
        $updated = $appointment->update([
            'payment_status' => $request->payment_status
        ]);

        if ($updated) {
            return redirect()->back()->with('success', 'Payment status updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update payment status.');
        }
    }
}