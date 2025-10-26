<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChamberController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

require __DIR__ . '/auth.php';

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Doctor routes
    Route::prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
        Route::get('/chambers', [DoctorController::class, 'chambers'])->name('chambers');
        Route::get('/appointments', [DoctorController::class, 'appointments'])->name('appointments');
        Route::get('/show/{doctor}', [DoctorController::class, 'show'])->name('show');
    });

    // Patient routes
    Route::prefix('patient')->name('patient.')->group(function () {
        Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
        Route::get('/doctors', [PatientController::class, 'doctors'])->name('doctors');
        Route::get('/appointments', [AppointmentController::class, 'myAppointments'])->name('appointments');
        Route::get('/show/{patient}', [PatientController::class, 'show'])->name('show');
    });

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/doctors', [AdminController::class, 'doctors'])->name('doctors');
        Route::get('/patients', [AdminController::class, 'patients'])->name('patients');
        Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
        Route::get('/chambers', [AdminController::class, 'chambers'])->name('chambers');
    });

    // Appointment routes (accessible to authenticated users based on permissions in controller)
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/create/{doctor}', [AppointmentController::class, 'create'])->name('create');
        Route::post('/', [AppointmentController::class, 'store'])->name('store');
        Route::get('/{appointment}', [AppointmentController::class, 'show'])->name('show');
        Route::get('/{appointment}/edit', [AppointmentController::class, 'edit'])->name('edit');
        Route::put('/{appointment}', [AppointmentController::class, 'update'])->name('update');
        Route::match(['get', 'patch'], '/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('update-status');
        Route::patch('/{appointment}/payment', [AppointmentController::class, 'updatePayment'])->name('update-payment');
        Route::patch('/{appointment}/notes', [AppointmentController::class, 'updateNotes'])->name('update-notes');
        Route::delete('/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('cancel');
        Route::get('/', [AppointmentController::class, 'index'])->name('index');
    });

    // Chamber routes
    Route::resource('chambers', ChamberController::class);
});

// Waiting page for unverified users
Route::get('/waiting', function () {
    return view('guest.waiting');
})->name('guest.waiting')->middleware('auth');

// Add this route for pending verification page
Route::get('/doctor/pending-verification', function () {
    return view('doctor.pending-verification');
})->name('doctor.pending-verification');

// Admin specific routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/patients', [AdminController::class, 'patients'])->name('admin.patients');
    Route::patch('/admin/patients/{user}/toggle-status', [AdminController::class, 'togglePatientStatus'])->name('admin.patients.toggle-status');
    Route::get('/admin/doctors', [AdminController::class, 'doctors'])->name('admin.doctors');
    Route::patch('/admin/doctors/{doctor}/verify', [AdminController::class, 'verifyDoctor'])->name('admin.doctors.verify');
    Route::patch('/admin/doctors/{doctor}/reject', [AdminController::class, 'rejectDoctor'])->name('admin.doctors.reject');
    Route::get('/admin/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');
    Route::get('/admin/chambers', [AdminController::class, 'chambers'])->name('admin.chambers');
    Route::patch('/admin/chambers/{chamber}/toggle-status', [AdminController::class, 'toggleChamberStatus'])->name('admin.chambers.toggle-status');
});

// // Temporary route for testing Brevo email service
// Route::get('/test-brevo', function () {
//     $service = app(\App\Services\BrevoEmailService::class);

//     // Create a dummy appointment for testing (replace with real IDs)
//     $appointment = \App\Models\Appointment::first();

//     if ($appointment) {
//         $result = $service->sendAppointmentBooked($appointment);
//         return $result ? 'Email sent successfully!' : 'Failed to send email.';
//     }

//     return 'No appointment found for testing.';
// });