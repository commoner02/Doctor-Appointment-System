<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Chamber;

class AppointmentController extends Controller
{
    public function create(Doctor $doctor)
    {
        $doctor->load('schedules.chamber');
        return view('appointments.create', compact('doctor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'schedule_id' => 'required|exists:schedules,id',
            'appointment_date' => 'required|date',
            'reason' => 'required|string|max:255',
        ]);

        // Get patient ID from logged in user
        $patientId = auth()->user()->patient->id;

        // Get chamber from schedule
        $schedule = Schedule::find($request->schedule_id);

        $appointment = Appointment::create([
            'patient_id' => $patientId,
            'doctor_id' => $request->doctor_id,
            'chamber_id' => $schedule->chamber_id,
            'schedule_id' => $request->schedule_id,
            'appointment_date' => $request->appointment_date,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Appointment booked successfully! We will confirm soon.');
    }

    public function myAppointments()
    {
        $appointments = Appointment::with('doctor', 'chamber')
            ->where('patient_id', auth()->user()->patient->id)
            ->latest()
            ->get();

        return view('appointments.my-appointments', compact('appointments'));
    }
}