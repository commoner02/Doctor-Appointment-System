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
            ->whereHas('user', function ($query) {
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
        if (!$user->isDoctor() || !$user->is_verified)
            return redirect()->route('doctor.pending');

        $doctor = $user->doctor;

        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', Carbon::today())
            ->where('appointment_status', 'scheduled')
            ->with(['patient'])
            ->get();

        $totalAppointments = Appointment::where('doctor_id', $doctor->id)->count();

        // Fixed: Changed 'status' to 'appointment_status'
        $upcomingAppointments = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_status', 'scheduled')
            ->where('appointment_date', '>=', now())
            ->with(['patient', 'chamber'])
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('doctor.dashboard', compact('todayAppointments', 'totalAppointments', 'upcomingAppointments'));
    }

    public function appointments()
    {
        $doctor = auth()->user()->doctor;
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with(['patient', 'chamber'])
            ->orderBy('appointment_date', 'desc')
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

    public function updateAppointmentStatus(Appointment $appointment)
    {
        $status = request('appointment_status');
        if (!in_array($status, ['scheduled', 'completed', 'cancelled'])) {
            return back()->withErrors(['appointment_status' => 'Invalid appointment status']);
        }
        $appointment->update(['appointment_status' => $status]);
        return back()->with('success', 'Appointment status updated.');
    }

    public function pending()
    {
        return view('doctor.pending-verification');
    }
}