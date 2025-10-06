<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorApprovalController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes (login, register, logout)
require __DIR__.'/auth.php';

// Protected routes - must be authenticated
Route::middleware(['auth'])->group(function () {
    // Main dashboard route - redirects based on role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Patient-specific routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/patient/dashboard', function () {
            // Only allow patients to access this
            if (auth()->user()->role !== 'patient') {
                return redirect()->route('dashboard');
            }
            
            $departments = \App\Models\Department::with('doctors')->get();
            $myAppointments = collect(); // Empty collection for now
            
            if (auth()->user()->patient) {
                $myAppointments = \App\Models\Appointment::with('doctor')
                    ->where('patient_id', auth()->user()->patient->id)
                    ->latest()
                    ->limit(5)
                    ->get();
            }
            
            return view('patient.dashboard', compact('departments', 'myAppointments'));
        })->name('patient.dashboard');
    });

    // Doctor-specific routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/doctor/dashboard', function () {
            // Only allow doctors to access this
            if (auth()->user()->role !== 'doctor') {
                return redirect()->route('dashboard');
            }
            
            $todayAppointments = collect();
            $totalAppointments = 0;
            
            if (auth()->user()->doctor) {
                $todayAppointments = \App\Models\Appointment::with('patient')
                    ->where('doctor_id', auth()->user()->doctor->id)
                    ->whereDate('appointment_date', today())
                    ->get();
                    
                $totalAppointments = \App\Models\Appointment::where('doctor_id', auth()->user()->doctor->id)->count();
            }
            
            return view('doctor.dashboard', compact('todayAppointments', 'totalAppointments'));
        })->name('doctor.dashboard');
        
        Route::get('/doctor/appointments', function () {
            if (auth()->user()->role !== 'doctor') {
                return redirect()->route('dashboard');
            }
            
            $appointments = collect();
            if (auth()->user()->doctor) {
                $appointments = \App\Models\Appointment::with('patient')
                    ->where('doctor_id', auth()->user()->doctor->id)
                    ->latest()
                    ->get();
            }
            
            return view('doctor.appointment', compact('appointments'));
        })->name('doctor.appointments');
    });

    // Admin-specific routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin/dashboard', function () {
            // Only allow admins to access this
            if (auth()->user()->role !== 'admin') {
                return redirect()->route('dashboard');
            }
            
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });

    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/pending-doctors', [DoctorApprovalController::class, 'pendingDoctors'])->name('admin.pending-doctors');
    Route::post('/approve-doctor/{user}', [DoctorApprovalController::class, 'approveDoctor'])->name('admin.approve-doctor');
    Route::post('/reject-doctor/{user}', [DoctorApprovalController::class, 'rejectDoctor'])->name('admin.reject-doctor');
});

    // Common routes (accessible by all authenticated users)
    Route::get('/doctors', [DoctorController::class, 'browse'])->name('doctors.browse');
    Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
    
    // Appointment routes (mainly for patients)
    Route::get('/appointments/create/{doctor}', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])->name('appointments.my');
});