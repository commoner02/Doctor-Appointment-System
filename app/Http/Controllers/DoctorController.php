<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Chamber;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $doctor = auth()->user()->doctor;

        if (!$doctor) {
            Doctor::create(['user_id' => auth()->id()]);
            $doctor = auth()->user()->doctor;
        }

        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', today())
            ->with(['patient.user'])
            ->get();

        $totalAppointments = Appointment::where('doctor_id', $doctor->id)->count();
        $totalChambers = Chamber::where('doctor_id', $doctor->id)->count();

        return view('doctor.dashboard', compact('todayAppointments', 'totalAppointments', 'totalChambers'));
    }

    public function chambers()
    {
        $doctor = auth()->user()->doctor;

        if (!$doctor) {
            Doctor::create(['user_id' => auth()->id()]);
            $doctor = auth()->user()->doctor;
        }

        $chambers = Chamber::where('doctor_id', $doctor->id)->get();

        return view('doctor.chambers', compact('chambers'));
    }

    public function appointments()
    {
        $doctor = auth()->user()->doctor;

        if (!$doctor) {
            Doctor::create(['user_id' => auth()->id()]);
            $doctor = auth()->user()->doctor;
        }

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->whereHas('chamber') // Only include appointments with existing chambers
            ->with(['patient.user', 'chamber'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('doctor.appointments', compact('appointments'));
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['user', 'chambers']);
        return view('doctor.show', compact('doctor'));
    }
}