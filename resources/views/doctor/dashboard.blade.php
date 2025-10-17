@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
    <div class="container">
        <h2>Doctor Dashboard</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row g-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-muted">Today</div>
                        <div class="h3">{{ $todayAppointments->count() }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-muted">Total Appointments</div>
                        <div class="h3">{{ $totalAppointments }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-muted">Speciality</div>
                        <div class="h5 mb-0">{{ auth()->user()->doctor->speciality }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">Upcoming</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Date</th>
                                <th>Chamber</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($upcomingAppointments as $a)
                                <tr>
                                    <td>
                                        <a href="{{ route('patients.show', $a->patient->id) }}">
                                            {{ $a->patient->first_name }} {{ $a->patient->last_name }}
                                        </a>
                                    </td>
                                    <td>{{ $a->appointment_date->format('M d, Y H:i') }}</td>
                                    <td>{{ $a->chamber->chamber_name }}</td>
                                    <td>{{ ucfirst($a->status) }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('appointments.update-status', $a) }}">
                                            @csrf @method('PATCH')
                                            <select name="status" class="form-select form-select-sm"
                                                onchange="this.form.submit()">
                                                <option value="scheduled" {{ $a->status == 'scheduled' ? 'selected' : '' }}>
                                                    Scheduled
                                                </option>
                                                <option value="completed" {{ $a->status == 'completed' ? 'selected' : '' }}>
                                                    Completed
                                                </option>
                                                <option value="cancelled" {{ $a->status == 'cancelled' ? 'selected' : '' }}>
                                                    Cancelled
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No upcoming appointments</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">All Appointments</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Date</th>
                                <th>Chamber</th>
                                <th>Appointment Status</th>
                                <th>Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($upcomingAppointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y H:i') }}</td>
                                    <td>{{ $appointment->chamber->chamber_name }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('appointments.update-status', $appointment->id) }}"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="appointment_status" class="form-select form-select-sm"
                                                onchange="this.form.submit()" style="min-width: 120px;">
                                                <option value="scheduled" {{ $appointment->appointment_status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                                <option value="completed" {{ $appointment->appointment_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ $appointment->appointment_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('appointments.update-payment', $appointment->id) }}"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="payment_status" class="form-select form-select-sm"
                                                onchange="this.form.submit()" style="min-width: 100px;">
                                                <option value="unpaid" {{ $appointment->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                                <option value="paid" {{ $appointment->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No appointments found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection