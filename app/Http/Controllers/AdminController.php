<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Chamber;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private function checkAdminAccess()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
    }

    public function dashboard()
    {
        $this->checkAdminAccess();

        $recentAppointments = Appointment::with(['patient', 'doctor', 'chamber'])
            ->orderBy('appointment_date', 'desc')
            ->limit(5)
            ->get();

        $pendingDoctors = User::where('role', 'doctor')
            ->where('is_verified', false)
            ->with('doctor')
            ->get();

        return view('admin.dashboard', compact('recentAppointments', 'pendingDoctors'));
    }

    public function verifyDoctor(User $user)
    {
        $this->checkAdminAccess();

        $user->update(['is_verified' => true]);
        return back()->with('success', 'Doctor verified successfully!');
    }

    // Patients Management
    public function patients()
    {
        $this->checkAdminAccess();

        $patients = Patient::with('user')->paginate(15);
        return view('admin.patients', compact('patients'));
    }

    public function patientShow(Patient $patient)
    {
        $this->checkAdminAccess();

        $patient->load(['user', 'appointments.doctor', 'appointments.chamber']);
        return view('admin.patients.show', compact('patient'));
    }

    // Doctors Management
    public function doctors()
    {
        $this->checkAdminAccess();

        $doctors = Doctor::with(['user', 'chambers'])->paginate(15);
        return view('admin.doctors', compact('doctors'));
    }

    public function doctorShow(Doctor $doctor)
    {
        $this->checkAdminAccess();

        $doctor->load(['user', 'chambers', 'appointments.patient']);
        return view('admin.doctors.show', compact('doctor'));
    }

    // Chambers Management
    public function chambers()
    {
        $this->checkAdminAccess();

        $chambers = Chamber::with(['doctor.user'])->paginate(15);
        return view('admin.chambers', compact('chambers'));
    }

    public function chamberShow(Chamber $chamber)
    {
        $this->checkAdminAccess();

        $chamber->load(['doctor.user', 'appointments.patient']);
        return view('admin.chambers.show', compact('chamber'));
    }

    // Appointments Management
    public function appointments()
    {
        $this->checkAdminAccess();

        $appointments = Appointment::with(['patient', 'doctor', 'chamber'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(20);
        return view('admin.appointments', compact('appointments'));
    }

    public function appointmentShow(Appointment $appointment)
    {
        $this->checkAdminAccess();

        $appointment->load(['patient', 'doctor.user', 'chamber']);
        return view('admin.appointments.show', compact('appointment'));
    }
}
