<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Chamber;

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
            'reason' => 'required|string|max:255',
        ]);

        // Get patient ID from logged in user
        $patientId = auth()->user()->patient->id;

        $appointment = Appointment::create([
            'patient_id' => $patientId,
            'doctor_id' => $request->doctor_id,
            'chamber_id' => $request->chamber_id,
            'appointment_date' => $request->appointment_date,
            'reason' => $request->reason,
            'status' => 'scheduled',
        ]);

        return redirect()->route('patient.dashboard')
            ->with('success', 'Appointment booked successfully!');
    }

    public function myAppointments()
    {
        $appointments = Appointment::with(['doctor', 'chamber'])
            ->where('patient_id', auth()->user()->patient->id)
            ->latest()
            ->get();

        return view('appointments.my-appointments', compact('appointments'));
    }
}