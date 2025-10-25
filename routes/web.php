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
})->name('home');

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Patient routes
    Route::middleware('role:patient')->prefix('patient')->name('patient.')->group(function () {
        Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
        Route::get('/doctors', [PatientController::class, 'findDoctors'])->name('doctors');
        Route::get('/appointments', [PatientController::class, 'appointments'])->name('appointments');
    });

    // Doctor routes
    Route::middleware('role:doctor')->prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
        Route::get('/appointments', [DoctorController::class, 'appointments'])->name('appointments');
        Route::get('/chambers', [DoctorController::class, 'chambers'])->name('chambers');
    });

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/patients', [AdminController::class, 'patients'])->name('patients');
        Route::get('/doctors', [AdminController::class, 'doctors'])->name('doctors');
        Route::get('/chambers', [AdminController::class, 'chambers'])->name('chambers');

        // Admin appointment management
        Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
        Route::get('/appointments/{appointment}', [AdminController::class, 'showAppointment'])->name('appointments.show');
        Route::patch('/appointments/{appointment}/status', [AdminController::class, 'updateAppointmentStatus'])->name('appointments.update-status');
        Route::delete('/appointments/{appointment}', [AdminController::class, 'deleteAppointment'])->name('appointments.delete');

        // Doctor verification
        Route::patch('/doctors/{doctor}/verify', [AdminController::class, 'verifyDoctor'])->name('doctors.verify');
        Route::patch('/doctors/{doctor}/reject', [AdminController::class, 'rejectDoctor'])->name('doctors.reject');
    });

    // Public routes
    Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctor.show');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patient.show');

    // Appointment routes (for all authenticated users)
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/create/{doctor}', [AppointmentController::class, 'create'])->name('create');
        Route::post('/', [AppointmentController::class, 'store'])->name('store');
        Route::get('/{appointment}', [AppointmentController::class, 'show'])->name('show');
        Route::get('/{appointment}/edit', [AppointmentController::class, 'edit'])->name('edit');
        Route::put('/{appointment}', [AppointmentController::class, 'update'])->name('update');
        Route::patch('/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('update-status');
        Route::patch('/{appointment}/payment', [AppointmentController::class, 'updatePayment'])->name('update-payment');
        Route::patch('/{appointment}/notes', [AppointmentController::class, 'updateNotes'])->name('update-notes');
        Route::delete('/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('cancel');
        Route::get('/', [AppointmentController::class, 'index'])->name('index');
    });

    // Chamber routes
    Route::middleware('role:doctor')->prefix('chambers')->name('chambers.')->group(function () {
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

// Temporary route for testing Brevo email service
Route::get('/test-brevo', function () {
    $service = app(\App\Services\BrevoEmailService::class);

    // Create a dummy appointment for testing (replace with real IDs)
    $appointment = \App\Models\Appointment::first();

    if ($appointment) {
        $result = $service->sendAppointmentBooked($appointment);
        return $result ? 'Email sent successfully!' : 'Failed to send email.';
    }

    return 'No appointment found for testing.';
});