<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get all appointments (scheduled, completed, cancelled)
        $recentAppointments = Appointment::orderBy('appointment_date', 'desc')
            ->with(['patient', 'doctor.user', 'chamber'])
            ->limit(10)
            ->get();

        $totalAppointments = Appointment::count();
        $totalDoctors = Doctor::count();
        $totalPatients = Patient::count();

        return view('admin.dashboard', compact(
            'recentAppointments',
            'totalAppointments',
            'totalDoctors',
            'totalPatients'
        ));
    }

    public function verifyDoctor(User $user)
    {
        $authUser = auth()->user();

        if (!$authUser->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $user->update(['is_verified' => true]);
        return redirect()->back()->with('success', 'Doctor verified successfully!');
    }
}
