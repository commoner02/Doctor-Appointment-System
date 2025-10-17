<?php

namespace App\Http\Controllers\Admin;


use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorApprovalController extends Controller
{
    public function pendingDoctors()
    {
        $pendingDoctors = User::where('role', 'doctor')
                            ->where('status', 'pending')
                            ->get();
        
        return view('admin.doctors.pending', compact('pendingDoctors'));
    }

    public function approveDoctor(User $user)
    {
        // Create doctor record from registration data
        $registrationData = $user->registration_data;
        
        Doctor::create([
            'user_id' => $user->id,
            'department_id' => $registrationData['department_id'],
            'first_name' => $user->name,
            'last_name' => '',
            'specialty' => $registrationData['specialty'],
            'phone' => $registrationData['phone'],
        ]);

        // Activate user account
        $user->update([
            'status' => 'active',
            'registration_data' => null, // Clear temporary data
        ]);

        // TODOs: Send approval email to doctor

        return back()->with('success', 'Doctor approved successfully!');
        
    }

    public function rejectDoctor(User $user)
    {
        $user->update([
            'status' => 'suspended',
            'registration_data' => null,
        ]);

        // TODOs: Send rejection email

        return back()->with('success', 'Doctor application rejected.');
    }
}