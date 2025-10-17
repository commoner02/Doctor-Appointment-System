@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Doctor</th>
                                <th>Date</th>
                                <th>Chamber</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appointments as $a)
                                <tr>
                                    <td>Dr. {{ $a->doctor->first_name }} {{ $a->doctor->last_name }}</td>
                                    <td>{{ $a->appointment_date->format('M d, Y H:i') }}</td>
                                    <td>{{ $a->chamber->chamber_name }}</td>
                                    <td>{{ ucfirst($a->appointment_status) }}</td>
                                    <td>{{ ucfirst($a->payment_status ?? 'unpaid') }}</td>
                                    <td>{{ $a->reason ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted p-3">No appointments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection