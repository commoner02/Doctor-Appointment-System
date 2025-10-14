@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>My Appointments</h2>

                <div class="card">
                    <div class="card-body">
                        @if($appointments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Patient</th>
                                            <th>Date & Time</th>
                                            <th>Chamber</th>
                                            <th>Status</th>
                                            <th>Reason</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($appointments as $appointment)
                                            <tr>
                                                <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                                </td>
                                                <td>{{ $appointment->appointment_date->format('M d, Y h:i A') }}</td>
                                                <td>{{ $appointment->chamber->chamber_name }}</td>
                                                <td>
                                                    <span class="badge 
                                                            @if($appointment->status == 'scheduled') bg-success
                                                            @elseif($appointment->status == 'completed') bg-primary
                                                            @else bg-danger
                                                            @endif">
                                                        {{ ucfirst($appointment->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $appointment->reason ?? 'No reason provided' }}</td>
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
                            <p>No appointments found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection