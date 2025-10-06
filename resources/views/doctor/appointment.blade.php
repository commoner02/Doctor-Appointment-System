@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>My Appointments</h2>
            
            <div class="card">
                <div class="card-body">
                    @php
                        $appointments = \App\Models\Appointment::with('patient')
                            ->where('doctor_id', auth()->user()->doctor->id)
                            ->latest()
                            ->get();
                    @endphp
                    
                    @if($appointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Patient</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Reason</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->appointment_date->format('M d, Y h:i A') }}</td>
                                        <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                                        <td>{{ $appointment->patient->phone }}</td>
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
                                        <td>
                                            @if($appointment->status == 'pending')
                                                <form action="#" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">Confirm</button>
                                                </form>
                                                <form action="#" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                                </form>
                                            @endif
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