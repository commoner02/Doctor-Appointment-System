<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Chamber;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        // Check if user is patient
        if (!$user->isPatient()) {
            abort(403, 'Unauthorized');
        }
        
        $patient = $user->patient;
        
        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('appointment_status', 'scheduled')
            ->with(['doctor', 'chamber'])
            ->get();

        return view('patient.dashboard', compact('upcomingAppointments'));
    }

    public function findDoctors(Request $request)
    {
        $user = auth()->user();
        
        // Check if user is patient
        if (!$user->isPatient()) {
            abort(403, 'Unauthorized');
        }
        
        $query = Doctor::with(['user', 'chambers'])
            ->whereHas('user', function($query) {
                $query->where('is_verified', true);
            });

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('first_name', 'like', "%{$searchTerm}%")
                  ->orWhere('last_name', 'like', "%{$searchTerm}%")
                  ->orWhere('speciality', 'like', "%{$searchTerm}%")
                  ->orWhereHas('chambers', function($chamberQuery) use ($searchTerm) {
                      $chamberQuery->where('chamber_name', 'like', "%{$searchTerm}%")
                                   ->orWhere('chamber_location', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Filter by speciality
        if ($request->filled('speciality')) {
            $query->where('speciality', 'like', "%{$request->speciality}%");
        }

        // Filter by chamber location
        if ($request->filled('location')) {
            $query->whereHas('chambers', function($chamberQuery) use ($request) {
                $chamberQuery->where('chamber_location', 'like', "%{$request->location}%");
            });
        }

        $doctors = $query->get();
        
        // Get unique specialities for filter dropdown
        $specialities = Doctor::whereHas('user', function($query) {
            $query->where('is_verified', true);
        })->distinct()->pluck('speciality')->filter()->sort();

        return view('patient.doctors', compact('doctors', 'specialities'));
    }

    public function appointments()
    {
        $user = auth()->user();
        
        // Check if user is patient
        if (!$user->isPatient()) {
            abort(403, 'Unauthorized');
        }
        
        $patient = $user->patient;
        
        $appointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor', 'chamber'])
            ->latest()
            ->get();

        return view('patient.appointments', compact('appointments'));
    }

    public function show(\App\Models\Patient $patient)
    {
        $user = auth()->user();
        // Allow patient themselves or any doctor to view a patient's basic profile
        if (!($user->isDoctor() || ($user->isPatient() && $user->patient && $user->patient->id === $patient->id))) {
            abort(403, 'Unauthorized');
        }

        $patient->load('user');
        return view('patient.show', compact('patient'));
    }
}
