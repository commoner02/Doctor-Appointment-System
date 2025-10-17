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

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Patient
    Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
    Route::get('/patient/appointments', [PatientController::class, 'appointments'])->name('patient.appointments');
    Route::get('/patient/doctors', [PatientController::class, 'findDoctors'])->name('patient.doctors');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');

    // Doctor
    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/doctor/appointments', [DoctorController::class, 'appointments'])->name('doctor.appointments');
    Route::get('/doctor/chambers', [ChamberController::class, 'index'])->name('doctor.chambers');
    Route::get('/doctor/pending', [DoctorController::class, 'pending'])->name('doctor.pending');

    // Doctors (public-facing)
    Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctor.show');

    // Chambers
    Route::get('/chambers/create', [ChamberController::class, 'create'])->name('chambers.create');
    Route::post('/chambers', [ChamberController::class, 'store'])->name('chambers.store');
    Route::get('/chambers/{chamber}/edit', [ChamberController::class, 'edit'])->name('chambers.edit');
    Route::put('/chambers/{chamber}', [ChamberController::class, 'update'])->name('chambers.update');
    Route::delete('/chambers/{chamber}', [ChamberController::class, 'destroy'])->name('chambers.destroy');

    // Admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/doctors/{user}/verify', [AdminController::class, 'verifyDoctor'])->name('admin.doctors.verify');

    // Appointments
    Route::get('/appointments/create/{doctor}', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.update-status');
    Route::delete('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
});

Route::get('/waiting', function () {
    return view('guest.waiting');
})->name('guest.waiting')->middleware('auth');