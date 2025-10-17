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
                                            <th>Doctor</th>
                                            <th>Date & Time</th>
                                            <th>Chamber</th>
                                            <th>Status</th>
                                            <th>Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($appointments as $appointment)
                                            <tr>
                                                <td>
                                                    Dr. {{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}
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
                                                <td>{{ $appointment->reason ?? '—' }}</td>
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
