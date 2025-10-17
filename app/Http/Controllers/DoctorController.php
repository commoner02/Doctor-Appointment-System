<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        if (auth()->user()->role !== 'doctor') {
            abort(403, 'Unauthorized access');
        }

        $doctor = auth()->user()->doctor;
        
        // Get all appointments (scheduled, completed, cancelled)
        $upcomingAppointments = Appointment::where('doctor_id', $doctor->id)
            ->orderBy('appointment_date', 'desc')
            ->with(['patient', 'chamber'])
            ->get();
        
        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', today())
            ->get();
        
        $totalAppointments = Appointment::where('doctor_id', $doctor->id)->count();
        
        $completedAppointments = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_status', 'completed')
            ->count();
        
        return view('doctor.dashboard', compact(
            'upcomingAppointments',
            'todayAppointments',
            'totalAppointments',
            'completedAppointments'
        ));
    }

    public function show($id)
    {
        $doctor = Doctor::with('user')->findOrFail($id);
        return view('doctors.show', compact('doctor'));
    }
}