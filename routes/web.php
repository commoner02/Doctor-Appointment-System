<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ChamberController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});


require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    // Main dashboard redirect
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Patient routes
    Route::prefix('patient')->name('patient.')->group(function () {
        Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
        Route::get('/appointments', [AppointmentController::class, 'myAppointments'])->name('appointments');
        Route::get('/doctors', [PatientController::class, 'findDoctors'])->name('doctors');
    });
    // Doctor routes
    Route::prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
        Route::get('/appointments', [DoctorController::class, 'appointments'])->name('appointments');
        Route::get('/chambers', [DoctorController::class, 'chambers'])->name('chambers');
        Route::get('/pending', [DoctorController::class, 'pending'])->name('pending');
        Route::get('/browse', [DoctorController::class, 'browse'])->name('browse');
        Route::patch('/appointments/{appointment}/update-status', [DoctorController::class, 'updateAppointmentStatus'])->name('update-appointment-status');
    });

    // Admin routes (remove role middleware for now to avoid binding error)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/verify-doctor/{user}', [AdminController::class, 'verifyDoctor'])->name('verify-doctor');

        // Management routes
        Route::get('/patients', [AdminController::class, 'patients'])->name('patients');
        Route::get('/patients/{patient}', [AdminController::class, 'patientShow'])->name('patients.show');

        Route::get('/doctors', [AdminController::class, 'doctors'])->name('doctors');
        Route::get('/doctors/{doctor}', [AdminController::class, 'doctorShow'])->name('doctors.show');

        Route::get('/chambers', [AdminController::class, 'chambers'])->name('chambers');
        Route::get('/chambers/{chamber}', [AdminController::class, 'chamberShow'])->name('chambers.show');

        Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
        Route::get('/appointments/{appointment}', [AdminController::class, 'appointmentShow'])->name('appointments.show');
    });

    // Chamber routes
    Route::prefix('chambers')->name('chambers.')->group(function () {
        Route::get('/', [ChamberController::class, 'index'])->name('index');
        Route::get('/create', [ChamberController::class, 'create'])->name('create');
        Route::post('/', [ChamberController::class, 'store'])->name('store');
        Route::get('/{chamber}/edit', [ChamberController::class, 'edit'])->name('edit');
        Route::put('/{chamber}', [ChamberController::class, 'update'])->name('update');
        Route::delete('/{chamber}', [ChamberController::class, 'destroy'])->name('destroy');
    });

    // Appointment routes
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/create/{doctor}', [AppointmentController::class, 'create'])->name('create');
        Route::post('/', [AppointmentController::class, 'store'])->name('store');
        Route::get('/my', [AppointmentController::class, 'myAppointments'])->name('my');
        Route::get('/{appointment}', [AppointmentController::class, 'show'])->name('show');
        Route::patch('/{appointment}/update-status', [AppointmentController::class, 'updateStatus'])->name('update-status');
        Route::patch('/{appointment}/update-payment', [AppointmentController::class, 'updatePaymentStatus'])->name('update-payment');
    });

    Route::get('/pending', [DoctorController::class, 'pending'])->name('doctors.pending');

    // Public-facing routes (for viewing doctor profiles and patient info)
    Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
});