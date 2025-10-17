@extends('layouts.app')

@section('title', 'Patient Dashboard')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Welcome back, {{ auth()->user()->name }}!</h1>
            <p class="page-subtitle">Manage your health appointments and find the best doctors</p>
        </div>

        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">{{ $upcomingAppointments->count() }}</h3>
                            <p class="mb-0 opacity-75">Upcoming Appointments</p>
                        </div>
                        <i class="fas fa-calendar-check fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card success">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">{{ auth()->user()->patient->appointments->count() }}</h3>
                            <p class="mb-0 opacity-75">Total Appointments</p>
                        </div>
                        <i class="fas fa-history fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card info">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">Active</h3>
                            <p class="mb-0 opacity-75">Profile Status</p>
                        </div>
                        <i class="fas fa-user-check fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Upcoming Appointments -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Upcoming Appointments</h5>
                        <a href="{{ route('patient.appointments') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        @if($upcomingAppointments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Doctor</th>
                                            <th>Date & Time</th>
                                            <th>Location</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($upcomingAppointments as $appointment)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-circle me-3"
                                                            style="width: 40px; height: 40px; background: #e0e7ff; color: #3730a3;">
                                                            {{ substr($appointment->doctor->first_name, 0, 1) }}
                                                        </div>
                                                        <div>
                                                            <strong>Dr. {{ $appointment->doctor->first_name }}
                                                                {{ $appointment->doctor->last_name }}</strong>
                                                            <br><small
                                                                class="text-muted">{{ $appointment->doctor->speciality }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <strong>{{ $appointment->appointment_date->format('M d, Y') }}</strong>
                                                    <br><small
                                                        class="text-muted">{{ $appointment->appointment_date->format('h:i A') }}</small>
                                                </td>
                                                <td>{{ $appointment->chamber->chamber_name }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-warning">{{ ucfirst($appointment->appointment_status) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No upcoming appointments</h5>
                                <p class="text-muted">Book your first appointment to get started</p>
                                <a href="{{ route('patient.doctors') }}" class="btn btn-primary">Find Doctors</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            <a href="{{ route('patient.doctors') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>Find Doctors
                            </a>
                            <a href="{{ route('patient.appointments') }}" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-list me-2"></i>View All Appointments
                            </a>
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-user-edit me-2"></i>Edit Profile
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Health Tips -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Health Tips</h5>
                    </div>
                    <div class="card-body">
                        <div class="health-tip">
                            <i class="fas fa-heart text-danger me-2"></i>
                            <small>Regular check-ups help prevent health issues</small>
                        </div>
                        <hr class="my-3">
                        <div class="health-tip">
                            <i class="fas fa-dumbbell text-success me-2"></i>
                            <small>Stay active with 30 minutes of exercise daily</small>
                        </div>
                        <hr class="my-3">
                        <div class="health-tip">
                            <i class="fas fa-apple-alt text-warning me-2"></i>
                            <small>Eat a balanced diet with fruits and vegetables</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- All Appointments -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">All Appointments</h5>
                    </div>
                    <div class="card-body">
                        @if($appointments->count() > 0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Doctor</th>
                                            <th>Date</th>
                                            <th>Chamber</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($appointments as $appointment)
                                            <tr>
                                                <td>Dr. {{ $appointment->doctor->user->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y H:i') }}
                                                </td>
                                                <td>{{ $appointment->chamber->chamber_name }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $appointment->appointment_status == 'scheduled' ? 'warning' : ($appointment->appointment_status == 'completed' ? 'success' : 'danger') }}">
                                                        {{ ucfirst($appointment->appointment_status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('appointments.show', $appointment) }}"
                                                        class="btn btn-sm btn-info">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-center text-muted">No appointments found</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection