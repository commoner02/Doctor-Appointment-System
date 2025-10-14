<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ChamberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::get('login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
Route::post('logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('password', [App\Http\Controllers\Auth\PasswordController::class, 'update'])->name('password.update');

    // Patient routes
    Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
    Route::get('/patient/appointments', [PatientController::class, 'appointments'])->name('patient.appointments');
    Route::get('/patient/doctors', [PatientController::class, 'findDoctors'])->name('patient.doctors');

    // Doctor routes
    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/doctor/appointments', [DoctorController::class, 'appointments'])->name('doctor.appointments');
    Route::get('/doctor/{doctor}', [DoctorController::class, 'show'])->name('doctor.show');
    Route::get('/doctor/pending', [DoctorController::class, 'pending'])->name('doctor.pending');
    Route::patch('/appointments/{appointment}/status', [DoctorController::class, 'updateAppointmentStatus'])->name('appointments.update-status');

    // Chamber management
    Route::get('/chambers', [ChamberController::class, 'index'])->name('chambers.index');
    Route::get('/chambers/create', [ChamberController::class, 'create'])->name('chambers.create');
    Route::post('/chambers', [ChamberController::class, 'store'])->name('chambers.store');
    Route::get('/chambers/{chamber}/edit', [ChamberController::class, 'edit'])->name('chambers.edit');
    Route::put('/chambers/{chamber}', [ChamberController::class, 'update'])->name('chambers.update');
    Route::delete('/chambers/{chamber}', [ChamberController::class, 'destroy'])->name('chambers.destroy');

    // Admin routes
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/doctors/{user}/verify', [AdminController::class, 'verifyDoctor'])->name('admin.doctors.verify');

    // Appointments
    Route::get('/appointments/create/{doctor}', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
});