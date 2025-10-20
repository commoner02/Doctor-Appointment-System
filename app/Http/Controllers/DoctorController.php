<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Chamber;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function browse()
    {
        $doctors = Doctor::with(['user', 'chambers'])
            ->whereHas('user', function ($query) {
                $query->where('is_verified', true);
            })
            ->get();

        return view('doctor.browse', compact('doctors'));
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['user', 'chambers']);
        return view('doctor.show', compact('doctor'));
    }

    public function dashboard()
    {
        $user = Auth::user();

        // Check if user has doctor profile
        if (!$user->doctor) {
            return redirect()->route('doctor.pending');
        }

        $doctor = $user->doctor;

        // Today's appointments (actual collection for display)
        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', Carbon::today())
            ->with(['patient.user', 'chamber'])
            ->orderBy('appointment_date', 'asc')
            ->get();

        // Today's appointments count
        $todayAppointmentsCount = $todayAppointments->count();

        // Upcoming appointments count (next 7 days excluding today)
        $upcomingAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereBetween('appointment_date', [
                Carbon::tomorrow(),
                Carbon::today()->addDays(7)
            ])
            ->where('appointment_status', '!=', 'cancelled')
            ->count();

        // Total unique patients
        $totalPatients = Patient::whereHas('appointments', function ($query) use ($doctor) {
            $query->where('doctor_id', $doctor->id);
        })->count();

        // Doctor's chambers
        $chambers = Chamber::where('doctor_id', $doctor->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent patients (last 10 unique patients who had appointments)
        $recentPatients = Patient::whereHas('appointments', function ($query) use ($doctor) {
            $query->where('doctor_id', $doctor->id);
        })
            ->with([
                'user',
                'appointments' => function ($query) use ($doctor) {
                    $query->where('doctor_id', $doctor->id)->latest();
                }
            ])
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        return view('doctor.dashboard', compact(
            'todayAppointments',
            'todayAppointmentsCount',
            'upcomingAppointments',
            'totalPatients',
            'chambers',
            'recentPatients'
        ));
    }

    public function appointments()
    {
        $doctor = auth()->user()->doctor;
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with(['patient.user', 'chamber'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(15);

        return view('doctor.appointments', compact('appointments'));
    }

    public function chambers()
    {
        $user = auth()->user();

        // Check if user is doctor and verified
        if (!$user->isDoctor() || !$user->is_verified) {
            abort(403, 'Unauthorized');
        }

        $doctor = $user->doctor;

        $chambers = Chamber::where('doctor_id', $doctor->id)->get();

        return view('doctor.chambers', compact('chambers'));
    }

    public function updateAppointmentStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'appointment_status' => 'required|in:scheduled,completed,cancelled'
        ]);

        // Check if current user is the doctor for this appointment
        if ($appointment->doctor_id !== auth()->user()->doctor->id) {
            abort(403, 'Unauthorized');
        }

        $appointment->update([
            'appointment_status' => $request->appointment_status
        ]);

        return redirect()->back()->with('success', 'Appointment status updated successfully!');
    }

    public function updatePaymentStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'payment_status' => 'required|in:paid,unpaid'
        ]);

        // Check if current user is the doctor for this appointment
        if ($appointment->doctor_id !== auth()->user()->doctor->id) {
            abort(403, 'Unauthorized');
        }

        $appointment->update([
            'payment_status' => $request->payment_status
        ]);

        return redirect()->back()->with('success', 'Payment status updated successfully!');
    }

    public function pending()
    {
        return view('doctor.pending-verification');
    }
}