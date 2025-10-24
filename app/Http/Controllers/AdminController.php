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
    public function dashboard()
    {
        $totalPatients = Patient::count();
        $verifiedDoctors = Doctor::where('verification_status', 'verified')->count();
        $pendingDoctors = Doctor::where('verification_status', 'pending')->count();
        $totalAppointments = Appointment::count();
        $totalChambers = Chamber::where('is_active', true)->count();

        $pendingDoctorsList = Doctor::with('user')
            ->where('verification_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentAppointments = Appointment::with(['patient.user', 'doctor.user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPatients',
            'verifiedDoctors',
            'pendingDoctors',
            'totalAppointments',
            'totalChambers',
            'pendingDoctorsList',
            'recentAppointments'
        ));
    }

    public function patients(Request $request)
    {
        $query = Patient::with('user');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $patients = $query->paginate(15);
        return view('admin.patients', compact('patients'));
    }

    public function doctors(Request $request)
    {
        $query = Doctor::with('user');

        if ($request->filled('status')) {
            $query->where('verification_status', $request->get('status'));
        }

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('speciality', 'like', "%{$search}%");
        }

        $doctors = $query->paginate(15);
        return view('admin.doctors', compact('doctors'));
    }

    public function chambers(Request $request)
    {
        $query = Chamber::with(['doctor.user']);

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('doctor.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        $chambers = $query->paginate(15);
        return view('admin.chambers', compact('chambers'));
    }

    // New appointment management methods
    public function appointments(Request $request)
    {
        $query = Appointment::with(['patient.user', 'doctor.user', 'chamber']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient.user', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('doctor.user', function ($subQ) use ($search) {
                        $subQ->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Date filter
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->get('date'));
        }

        // Date range filter
        if ($request->filled('from_date')) {
            $query->whereDate('appointment_date', '>=', $request->get('from_date'));
        }
        if ($request->filled('to_date')) {
            $query->whereDate('appointment_date', '<=', $request->get('to_date'));
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(15);

        // Get statistics
        $stats = [
            'total' => Appointment::count(),
            'scheduled' => Appointment::where('status', 'scheduled')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
            'today' => Appointment::whereDate('appointment_date', today())->count(),
        ];

        return view('admin.appointments', compact('appointments', 'stats'));
    }

    public function showAppointment(Appointment $appointment)
    {
        $appointment->load(['patient.user', 'doctor.user', 'chamber']);
        return view('admin.appointments.show', compact('appointment'));
    }

    public function updateAppointmentStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:scheduled,completed,cancelled',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $appointment->update([
            'status' => $request->status,
            'notes' => $request->admin_notes ?
                ($appointment->notes ? $appointment->notes . "\n\nAdmin Note: " . $request->admin_notes : "Admin Note: " . $request->admin_notes) :
                $appointment->notes,
        ]);

        return redirect()->back()->with('success', 'Appointment status updated successfully!');
    }

    public function deleteAppointment(Appointment $appointment)
    {
        // Only allow deletion of cancelled appointments or in emergencies
        if ($appointment->status !== 'cancelled') {
            return redirect()->back()->with('error', 'Only cancelled appointments can be deleted. Please cancel the appointment first.');
        }

        $appointment->delete();
        return redirect()->route('admin.appointments')->with('success', 'Appointment deleted successfully!');
    }

    public function verifyDoctor(Doctor $doctor)
    {
        $doctor->update(['verification_status' => 'verified']);
        $doctor->user->update(['status' => 'active']);

        return back()->with('success', 'Doctor verified successfully!');
    }

    public function rejectDoctor(Doctor $doctor)
    {
        $doctor->update(['verification_status' => 'rejected']);
        $doctor->user->update(['status' => 'inactive']);

        return back()->with('success', 'Doctor rejected!');
    }
}
