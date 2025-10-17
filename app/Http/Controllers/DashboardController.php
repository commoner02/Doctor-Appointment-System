<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user->is_verified) {
            return redirect()->route('guest.waiting');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isDoctor()) {
            return redirect()->route('doctor.dashboard');
        }

        if ($user->isPatient()) {
            return redirect()->route('patient.dashboard');
        }

        return redirect()->route('guest.waiting');
    }
}