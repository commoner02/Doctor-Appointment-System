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
                                            <th>Payment</th>
                                            <th>Notes</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($appointments as $appointment)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('patients.show', $appointment->patient) }}">
                                                        {{ $appointment->patient->first_name }}
                                                        {{ $appointment->patient->last_name }}
                                                    </a>
                                                </td>
                                                <td>{{ $appointment->appointment_date->format('M d, Y h:i A') }}</td>
                                                <td>{{ $appointment->chamber->chamber_name }}</td>
                                                <td>
                                                    <span class="badge 
                                                                        @if($appointment->appointment_status == 'scheduled') bg-success
                                                                        @elseif($appointment->appointment_status == 'completed') bg-primary
                                                                        @else bg-danger
                                                                        @endif">
                                                        {{ ucfirst($appointment->appointment_status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $appointment->reason ?? 'No reason provided' }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('appointments.update-details', $appointment) }}" class="d-flex gap-2">
                                                        @csrf @method('PATCH')
                                                        <select name="payment_status" class="form-select form-select-sm" style="max-width:130px">
                                                            <option value="unpaid" {{ $appointment->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                                            <option value="paid" {{ $appointment->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                                        </select>
                                                        <button class="btn btn-sm btn-outline-primary">Save</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{ route('appointments.update-details', $appointment) }}" class="d-flex gap-2">
                                                        @csrf @method('PATCH')
                                                        <input type="text" name="notes" class="form-control form-control-sm"
                                                               placeholder="Notes" value="{{ $appointment->notes }}" style="max-width:220px">
                                                        <button class="btn btn-sm btn-outline-primary">Save</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form action="{{ route('appointments.update-status', $appointment) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <select name="appointment_status" class="form-select form-select-sm"
                                                            onchange="this.form.submit()">
                                                            <option value="scheduled" {{ $appointment->appointment_status == 'scheduled' ? 'selected' : '' }}>
                                                                Scheduled</option>
                                                            <option value="completed" {{ $appointment->appointment_status == 'completed' ? 'selected' : '' }}>
                                                                Completed</option>
                                                            <option value="cancelled" {{ $appointment->appointment_status == 'cancelled' ? 'selected' : '' }}>
                                                                Cancelled</option>
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