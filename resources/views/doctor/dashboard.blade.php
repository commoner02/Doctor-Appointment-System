@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Welcome, Dr. {{ auth()->user()->name }}!</h1>
            <p class="page-subtitle">Manage your appointments and provide quality healthcare</p>
        </div>

        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">{{ $todayAppointments->count() }}</h3>
                            <p class="mb-0 opacity-75">Today's Appointments</p>
                        </div>
                        <i class="fas fa-calendar-day fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card success">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">{{ $totalAppointments }}</h3>
                            <p class="mb-0 opacity-75">Total Appointments</p>
                        </div>
                        <i class="fas fa-chart-line fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card info">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">{{ auth()->user()->doctor->speciality }}</h3>
                            <p class="mb-0 opacity-75">Speciality</p>
                        </div>
                        <i class="fas fa-stethoscope fa-2x opacity-75"></i>
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
                        <a href="{{ route('doctor.appointments') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        @if($upcomingAppointments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Patient</th>
                                            <th>Date & Time</th>
                                            <th>Chamber</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($upcomingAppointments as $appointment)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-circle me-3"
                                                            style="width: 40px; height: 40px; background: #f0f9ff; color: #0369a1;">
                                                            {{ substr($appointment->patient->first_name, 0, 1) }}
                                                        </div>
                                                        <div>
                                                            <strong>{{ $appointment->patient->first_name }}
                                                                {{ $appointment->patient->last_name }}</strong>
                                                            <br><small class="text-muted">{{ $appointment->patient->phone }}</small>
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
                                                    <span class="badge bg-warning">{{ ucfirst($appointment->status) }}</span>
                                                </td>
                                                <td>
                                                    <form action="{{ route('appointments.update-status', $appointment) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <select name="status" class="form-select form-select-sm"
                                                            onchange="this.form.submit()">
                                                            <option value="scheduled" {{ $appointment->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                                            <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                            <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                        </select>
                                                    </form>
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
                                <p class="text-muted">Your schedule is clear for now</p>
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
                            <a href="{{ route('doctor.appointments') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-calendar-alt me-2"></i>View Appointments
                            </a>
                            <a href="{{ route('doctor.chambers') }}" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-building me-2"></i>Manage Chambers
                            </a>
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-user-edit me-2"></i>Edit Profile
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Today's Schedule -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Today's Schedule</h5>
                    </div>
                    <div class="card-body">
                        @if($todayAppointments->count() > 0)
                            @foreach($todayAppointments as $appointment)
                                <div class="schedule-item d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <strong>{{ $appointment->patient->first_name }}
                                            {{ $appointment->patient->last_name }}</strong>
                                        <br><small class="text-muted">{{ $appointment->appointment_date->format('h:i A') }}</small>
                                    </div>
                                    <span class="badge bg-primary">{{ $appointment->status }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-smile fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">No appointments today</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection