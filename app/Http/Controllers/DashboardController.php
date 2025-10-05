<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Appointment;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        if ($user->isDoctor()) {
            return redirect()->route('doctor.dashboard');
        }
        
        if ($user->isPatient()) {
            return redirect()->route('patient.dashboard');
        }
        
        // Default fallback
        return view('dashboard');
    }
}