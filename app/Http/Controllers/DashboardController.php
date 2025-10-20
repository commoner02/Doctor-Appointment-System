<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        if ($user->isPatient()) {
            return redirect()->route('patient.dashboard');
        }
        
        if ($user->isDoctor()) {
            if ($user->is_verified) {
                return redirect()->route('doctor.dashboard');
            } else {
                return redirect()->route('doctor.pending');
            }
        }

        return redirect('/');
    }
}