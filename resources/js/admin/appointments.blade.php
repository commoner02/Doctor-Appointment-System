
@extends('layouts.app')

@section('title', 'Manage Appointments')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Appointments</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Chamber</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Reason</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->id }}</td>
                                <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                                <td>Dr. {{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</td>
                                <td>{{ $appointment->chamber->chamber_name }}</td>
                                <td>{{ $appointment->appointment_date->format('M d, Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $appointment->appointment_status == 'scheduled' ? 'warning' : ($appointment->appointment_status == 'completed' ? 'success' : 'danger') }}">
                                        {{ ucfirst($appointment->appointment_status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $appointment->payment_status == 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($appointment->payment_status) }}
                                    </span>
                                </td>
                                <td>{{ Str::limit($appointment->reason, 30) }}</td>
                                <td>
                                    <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No appointments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $appointments->links() }}
        </div>
    </div>
</div>
@endsection