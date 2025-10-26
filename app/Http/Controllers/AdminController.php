<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Chamber;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_patients' => Patient::count(),
            'total_doctors' => Doctor::where('verification_status', 'verified')->count(),
            'total_appointments' => Appointment::count(),
            'total_chambers' => Chamber::count(),
            'appointments_scheduled' => Appointment::where('status', 'scheduled')->count(),
            'appointments_completed' => Appointment::where('status', 'completed')->count(),
            'appointments_cancelled' => Appointment::where('status', 'cancelled')->count(),
            'total_revenue' => Appointment::join('chambers', 'appointments.chamber_id', '=', 'chambers.id')
                ->where('appointments.payment_status', 'paid')
                ->sum('chambers.fee'),
        ];

        // Monthly revenue
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $stats['monthly_revenue'] = Appointment::join('chambers', 'appointments.chamber_id', '=', 'chambers.id')
            ->where('appointments.payment_status', 'paid')
            ->whereMonth('appointments.appointment_date', $currentMonth)
            ->whereYear('appointments.appointment_date', $currentYear)
            ->sum('chambers.fee');

        return view('admin.dashboard', compact('stats'));
    }

    public function patients()
    {
        $patients = Patient::with('user')->paginate(20);
        return view('admin.patients', compact('patients'));
    }

    public function doctors()
    {
        $doctors = Doctor::with(['user', 'chambers'])->paginate(20);
        return view('admin.doctors', compact('doctors'));
    }

    public function appointments()
    {
        $appointments = Appointment::with(['patient.user', 'doctor.user', 'chamber'])->latest()->paginate(20);
        return view('admin.appointments', compact('appointments'));
    }

    public function chambers()
    {
        $chambers = Chamber::with('doctor.user')->paginate(20);
        return view('admin.chambers', compact('chambers'));
    }

    public function togglePatientStatus(User $user)
    {
        $user->update(['status' => $user->status === 'active' ? 'inactive' : 'active']);
        return back()->with('success', 'Patient status updated.');
    }

    public function verifyDoctor(Doctor $doctor)
    {
        $doctor->update(['verification_status' => 'verified']);
        return back()->with('success', 'Doctor verified.');
    }

    public function rejectDoctor(Doctor $doctor)
    {
        $doctor->update(['verification_status' => 'rejected']);
        return back()->with('success', 'Doctor rejected.');
    }

    public function toggleChamberStatus(Chamber $chamber)
    {
        $chamber->update(['is_active' => !$chamber->is_active]);
        return back()->with('success', 'Chamber status updated.');
    }
}
