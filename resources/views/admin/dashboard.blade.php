@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Admin Dashboard</h1>
            <p class="page-subtitle">Manage users, verify doctors, and monitor system activity</p>
        </div>

        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">{{ \App\Models\User::count() }}</h3>
                            <p class="mb-0 opacity-75">Total Users</p>
                        </div>
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card success">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">
                                {{ \App\Models\User::where('role', 'doctor')->where('is_verified', true)->count() }}</h3>
                            <p class="mb-0 opacity-75">Verified Doctors</p>
                        </div>
                        <i class="fas fa-user-md fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card warning">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">
                                {{ \App\Models\User::where('role', 'doctor')->where('is_verified', false)->count() }}</h3>
                            <p class="mb-0 opacity-75">Pending Doctors</p>
                        </div>
                        <i class="fas fa-clock fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card info">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">{{ \App\Models\Appointment::count() }}</h3>
                            <p class="mb-0 opacity-75">Total Appointments</p>
                        </div>
                        <i class="fas fa-calendar-check fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Appointments -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Recent Appointments</h5>
                    </div>
                    <div class="card-body">
                        @if($recentAppointments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Patient</th>
                                            <th>Doctor</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentAppointments as $appointment)
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
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-circle me-3"
                                                            style="width: 40px; height: 40px; background: #e0e7ff; color: #3730a3;">
                                                            {{ substr($appointment->doctor->first_name, 0, 1) }}
                                                        </div>
                                                        <div>
                                                            <strong>Dr. {{ $appointment->doctor->first_name }}
                                                                {{ $appointment->doctor->last_name }}</strong>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $appointment->appointment_date->format('M d, Y H:i') }}</td>
                                                <td>
                                                    <span class="badge bg-warning">{{ ucfirst($appointment->status) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No recent appointments</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Pending Doctor Verifications -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-user-clock me-2"></i>Pending Verifications</h5>
                    </div>
                    <div class="card-body">
                        @if($pendingDoctors->count() > 0)
                            @foreach($pendingDoctors as $user)
                                <div class="verification-item border-bottom pb-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $user->name }}</h6>
                                            <small class="text-muted">{{ $user->email }}</small>
                                            <br><small class="text-muted">{{ $user->doctor->speciality }}</small>
                                        </div>
                                        <form action="{{ route('admin.doctors.verify', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-check me-1"></i>Verify
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                <p class="text-muted mb-0">No pending verifications</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection