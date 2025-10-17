<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        if (auth()->user()->role !== 'patient') {
            abort(403, 'Unauthorized access');
        }

        $patient = auth()->user()->patient;

        // Get all appointments (scheduled, completed, cancelled)
        $appointments = Appointment::where('patient_id', $patient->id)
            ->orderBy('appointment_date', 'desc')
            ->with(['doctor.user', 'chamber'])
            ->get();

        return view('patient.dashboard', compact('appointments'));
    }

    public function show($id)
    {
        $patient = Patient::with('user')->findOrFail($id);
        return view('patients.show', compact('patient'));
    }
}
