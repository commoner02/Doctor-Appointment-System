<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PatientController extends Controller
{
    public function dashboard()
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            Patient::create(['user_id' => auth()->id()]);
            $patient = auth()->user()->patient;
        }

        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('appointment_date', '>=', now())
            ->with(['doctor.user', 'chamber']) // Chamber is already loaded
            ->orderBy('appointment_date', 'asc')
            ->limit(3)
            ->get();

        $totalAppointments = Appointment::where('patient_id', $patient->id)->count();

        return view('patient.dashboard', compact('upcomingAppointments', 'totalAppointments'));
    }

    public function findDoctors(Request $request)
    {
        $query = Doctor::with(['user', 'chambers']);

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('speciality', 'like', "%{$search}%");
        }

        if ($request->filled('speciality')) {
            $query->where('speciality', $request->get('speciality'));
        }

        $doctors = $query->paginate(12);

        $specialities = Doctor::distinct()
            ->whereNotNull('speciality')
            ->pluck('speciality')
            ->sort()
            ->values();

        return view('patient.doctors', compact('doctors', 'specialities'));
    }

    public function appointments()
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            Patient::create(['user_id' => auth()->id()]);
            $patient = auth()->user()->patient;
        }

        $appointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor.user', 'chamber']) // Ensure chamber is loaded
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('patient.appointments', compact('appointments'));
    }

    public function show(Patient $patient)
    {
        $patient->load('user');
        return view('patient.show', compact('patient'));
    }
}
