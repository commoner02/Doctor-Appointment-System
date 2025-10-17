@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
    <div class="container">
        <h2 class="mb-4">Dashboard</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3>{{ $todayAppointments->count() }}</h3>
                        <p class="text-muted mb-0">Today's Appointments</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3>{{ $totalAppointments }}</h3>
                        <p class="text-muted mb-0">Total Appointments</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3>{{ $completedAppointments }}</h3>
                        <p class="text-muted mb-0">Completed</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="mb-0">{{ auth()->user()->doctor->speciality }}</h5>
                        <p class="text-muted mb-0">Speciality</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">All Appointments</h5>
            </div>
            <div class="card-body">
                @if($upcomingAppointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Date</th>
                                    <th>Chamber</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingAppointments as $appointment)
                                    <tr>
                                        <td>
                                            <a href="{{ route('patients.show', $appointment->patient->id) }}">
                                                {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                            </a>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y H:i') }}</td>
                                        <td>{{ $appointment->chamber->chamber_name }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $appointment->appointment_status == 'scheduled' ? 'warning' : ($appointment->appointment_status == 'completed' ? 'success' : 'danger') }}">
                                                {{ ucfirst($appointment->appointment_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('appointments.update-status', $appointment) }}"
                                                class="d-inline">
                                                @csrf @method('PATCH')
                                                <select name="appointment_status" class="form-select form-select-sm"
                                                    style="width: auto; display: inline-block;" onchange="this.form.submit()">
                                                    <option value="scheduled" {{ $appointment->appointment_status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                                    <option value="completed" {{ $appointment->appointment_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="cancelled" {{ $appointment->appointment_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </form>
                                            <a href="{{ route('appointments.show', $appointment) }}"
                                                class="btn btn-sm btn-info ms-2">View</a>
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
@endsection