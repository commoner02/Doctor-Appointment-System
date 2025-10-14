<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Chamber;
use Carbon\Carbon;

class DoctorController extends Controller
{
    public function browse()
    {
        $doctors = Doctor::with(['user', 'chambers'])
            ->whereHas('user', function($query) {
                $query->where('is_verified', true);
            })
            ->get();
        
        return view('doctor.browse', compact('doctors'));
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['user', 'chambers']);
        return view('doctor.show', compact('doctor'));
    }

    public function dashboard()
    {
        $user = auth()->user();
        
        // Check if user is doctor and verified
        if (!$user->isDoctor() || !$user->is_verified) {
            abort(403, 'Unauthorized');
        }
        
        $doctor = $user->doctor;
        
        $today = Carbon::today();
        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $today)
            ->where('status', 'scheduled')
            ->get();
            
        $totalAppointments = Appointment::where('doctor_id', $doctor->id)->count();
        
        $upcomingAppointments = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'scheduled')
            ->where('appointment_date', '>=', now())
            ->with(['patient', 'chamber'])
            ->get();

        return view('doctor.dashboard', compact('todayAppointments', 'totalAppointments', 'upcomingAppointments'));
    }

    public function appointments()
    {
        $user = auth()->user();
        
        // Check if user is doctor and verified
        if (!$user->isDoctor() || !$user->is_verified) {
            abort(403, 'Unauthorized');
        }
        
        $doctor = $user->doctor;
        
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with(['patient', 'chamber'])
            ->latest()
            ->get();

        return view('doctor.appointments', compact('appointments'));
    }

    public function chambers()
    {
        $user = auth()->user();
        
        // Check if user is doctor and verified
        if (!$user->isDoctor() || !$user->is_verified) {
            abort(403, 'Unauthorized');
        }
        
        $doctor = $user->doctor;
        
        $chambers = Chamber::where('doctor_id', $doctor->id)->get();

        return view('doctor.chambers', compact('chambers'));
    }

    public function updateAppointmentStatus(Appointment $appointment, Request $request)
    {
        $user = auth()->user();
        
        // Check if user is doctor and verified
        if (!$user->isDoctor() || !$user->is_verified) {
            abort(403, 'Unauthorized');
        }
        
        $appointment->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Appointment status updated!');
    }

    public function pending()
    {
        return view('doctor.pending-verification');
    }
}