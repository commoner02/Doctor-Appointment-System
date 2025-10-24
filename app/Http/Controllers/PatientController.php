<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function dashboard()
    {
        // No need for role check - middleware handles it
        $patient = auth()->user()->patient;

        if (!$patient) {
            return redirect()->route('profile.edit')->with('error', 'Please complete your patient profile.');
        }

        // Get upcoming appointments
        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('appointment_date', '>=', now())
            ->where('appointment_status', '!=', 'cancelled')
            ->orderBy('appointment_date', 'asc')
            ->with(['doctor.user', 'chamber'])
            ->limit(5)
            ->get();


        // Get all appointments for stats
        $appointments = Appointment::where('patient_id', $patient->id)
            ->orderBy('appointment_date', 'desc')
            ->with(['doctor.user', 'chamber'])
            ->get();

        // Calculate stats
        $totalAppointments = $appointments->count();
        $completedAppointments = $appointments->where('appointment_status', 'completed')->count();
        $upcomingCount = $upcomingAppointments->count();

        return view('patient.dashboard', compact(
            'appointments',
            'upcomingAppointments',
            'totalAppointments',
            'completedAppointments',
            'upcomingCount'
        ));
    }

    public function appointments()
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            return redirect()->route('profile.edit')->with('error', 'Please complete your patient profile.');
        }

        $appointments = Appointment::where('patient_id', $patient->id)
            ->orderBy('appointment_date', 'desc')
            ->with(['doctor.user', 'chamber'])
            ->paginate(10);

        return view('patient.appointments', compact('appointments'));
    }

    public function findDoctors(Request $request)
    {
        $query = Doctor::with(['user', 'chambers']);

        // Search filters
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('speciality', 'like', "%{$search}%");
        }

        if ($request->filled('speciality')) {
            $query->where('speciality', $request->get('speciality'));
        }

        if ($request->filled('location')) {
            $query->whereHas('chambers', function ($q) use ($request) {
                $q->where('address', 'like', "%{$request->get('location')}%");
            });
        }

        $doctors = $query->paginate(12);

        // Get unique specialities for filter dropdown
        $specialities = Doctor::distinct()
            ->whereNotNull('speciality')
            ->pluck('speciality')
            ->sort()
            ->values(); // This ensures proper array indexing

        return view('patient.doctors', compact('doctors', 'specialities'));
    }

    public function show($id)
    {
        $patient = Patient::with('user')->findOrFail($id);

        // Only allow patients to view their own profile or admin/doctor access
        if (auth()->user()->role === 'patient' && auth()->user()->patient->id !== $patient->id) {
            abort(403, 'Unauthorized access');
        }

        return view('patient.show', compact('patient'));
    }
}
