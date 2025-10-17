@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container">
        <h2 class="mb-4">Admin Dashboard</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h3>{{ $totalAppointments }}</h3>
                        <p class="text-muted mb-0">Total Appointments</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h3>{{ $totalDoctors }}</h3>
                        <p class="text-muted mb-0">Total Doctors</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h3>{{ $totalPatients }}</h3>
                        <p class="text-muted mb-0">Total Patients</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Pending Doctor Verifications</h5>
            </div>
            <div class="card-body">
                @if($pendingDoctors->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Speciality</th>
                                    <th>License</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingDoctors as $user)
                                    <tr>
                                        <td>{{ $user->doctor->first_name }} {{ $user->doctor->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->doctor->speciality }}</td>
                                        <td>{{ $user->doctor->license_no }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.doctors.verify', $user) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Verify</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">No pending doctor verifications</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Appointments</h5>
            </div>
            <div class="card-body">
                @if($recentAppointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
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
                                        <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                                        <td>Dr. {{ $appointment->doctor->user->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y H:i') }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $appointment->appointment_status == 'scheduled' ? 'warning' : ($appointment->appointment_status == 'completed' ? 'success' : 'danger') }}">
                                                {{ ucfirst($appointment->appointment_status) }}
                                            </span>
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