<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        // Check if user is admin
        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        $recentAppointments = Appointment::with(['patient', 'doctor'])
            ->latest()
            ->take(10)
            ->get();
            
        $pendingDoctors = User::where('role', 'doctor')
            ->where('is_verified', false)
            ->with('doctor')
            ->get();

        return view('admin.dashboard', compact('recentAppointments', 'pendingDoctors'));
    }

    public function verifyDoctor(User $user)
    {
        $authUser = auth()->user();
        
        // Check if user is admin
        if (!$authUser->isAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        $user->update(['is_verified' => true]);
        return redirect()->back()->with('success', 'Doctor verified successfully!');
    }
}
