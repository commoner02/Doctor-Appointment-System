@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Welcome, Dr. {{ auth()->user()->name }}</h2>
                <p class="text-muted">Doctor Dashboard</p>

                <!-- Quick Stats -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <h5 class="card-title">Today's Appointments</h5>
                                <p class="card-text display-6">
                                    {{ \App\Models\Appointment::where('doctor_id', auth()->user()->doctor->id)
        ->whereDate('appointment_date', today())
        ->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <h5 class="card-title">Total Appointments</h5>
                                <p class="card-text display-6">
                                    {{ \App\Models\Appointment::where('doctor_id', auth()->user()->doctor->id)->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning">
                            <div class="card-body">
                                <h5 class="card-title">Pending</h5>
                                <p class="card-text display-6">
                                    {{ \App\Models\Appointment::where('doctor_id', auth()->user()->doctor->id)
        ->where('status', 'pending')
        ->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">My Appointments</h5>
                                <p class="card-text">View and manage appointments</p>
                                <a href="{{ route('doctor.appointments') }}" class="btn btn-primary">View Appointments</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">My Schedule</h5>
                                <p class="card-text">Manage availability</p>
                                <a href="#" class="btn btn-outline-primary">Manage Schedule</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Today's Appointments -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Today's Appointments</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $todayAppointments = \App\Models\Appointment::with('patient')
                                ->where('doctor_id', auth()->user()->doctor->id)
                                ->whereDate('appointment_date', today())
                                ->orderBy('appointment_date')
                                ->get();
                        @endphp

                        @if($todayAppointments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Time</th>
                                            <th>Patient</th>
                                            <th>Status</th>
                                            <th>Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($todayAppointments as $appointment)
                                            <tr>
                                                <td>{{ $appointment->appointment_date->format('h:i A') }}</td>
                                                <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                                </td>
                                                <td>
                                                    <span class="badge 
                                                            @if($appointment->status == 'confirmed') bg-success
                                                            @elseif($appointment->status == 'pending') bg-warning
                                                            @else bg-danger
                                                            @endif">
                                                        {{ ucfirst($appointment->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $appointment->reason ?? 'No reason provided' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>No appointments scheduled for today.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection