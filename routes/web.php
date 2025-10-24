<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ChamberController;
use Illuminate\Support\Facades\Route;

// Welcome page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
require __DIR__ . '/auth.php';

// Protected routes - must be authenticated
Route::middleware(['auth'])->group(function () {

    // Main dashboard route - redirects based on role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Patient routes
    Route::prefix('patient')->name('patient.')->middleware(\App\Http\Middleware\CheckRole::class . ':patient')->group(function () {
        Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
        Route::get('/appointments', [PatientController::class, 'appointments'])->name('appointments');
        Route::get('/doctors', [PatientController::class, 'findDoctors'])->name('doctors');
        Route::get('/profile', [PatientController::class, 'show'])->name('show');
    });

    // Doctor routes
    Route::prefix('doctor')->name('doctor.')->middleware(\App\Http\Middleware\CheckRole::class . ':doctor')->group(function () {
        Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
        Route::get('/appointments', [DoctorController::class, 'appointments'])->name('appointments');
        Route::get('/chambers', [DoctorController::class, 'chambers'])->name('chambers');
        Route::get('/pending', [DoctorController::class, 'pendingVerification'])->name('pending');
        Route::get('/browse', [DoctorController::class, 'browse'])->name('browse');
    });

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware(\App\Http\Middleware\CheckRole::class . ':admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/doctors/{user}/verify', [AdminController::class, 'verifyDoctor'])->name('doctors.verify');
    });

    // Public doctor viewing (accessible to all authenticated users)
    Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctor.show');

    // Appointment routes
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/create/{doctor}', [AppointmentController::class, 'create'])->name('create');
        Route::post('/', [AppointmentController::class, 'store'])->name('store');
        Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])->name('my');
        Route::get('/{appointment}', [AppointmentController::class, 'show'])->name('show');
        Route::patch('/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('cancel');
    });

    // Chamber routes (accessible to doctors)
    Route::prefix('chambers')->name('chambers.')->middleware(\App\Http\Middleware\CheckRole::class . ':doctor')->group(function () {
        Route::get('/create', [ChamberController::class, 'create'])->name('create');
        Route::post('/', [ChamberController::class, 'store'])->name('store');
        Route::get('/{chamber}/edit', [ChamberController::class, 'edit'])->name('edit');
        Route::put('/{chamber}', [ChamberController::class, 'update'])->name('update');
        Route::delete('/{chamber}', [ChamberController::class, 'destroy'])->name('destroy');
    });
});

// Waiting page for unverified users
Route::get('/waiting', function () {
    return view('guest.waiting');
})->name('guest.waiting')->middleware('auth');