@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>My Appointments</h2>

                @if(session('success'))
                    <div class="alert alert-success py-2">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-body">
                        @if($appointments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th>Patient</th>
                                            <th>Date & Time</th>
                                            <th>Chamber</th>
                                            <th>Visiting Fee</th>
                                            <th>Appointment Status</th>
                                            <th>Payment Status</th>
                                            <th>Reason</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($appointments as $appointment)
                                            <tr>
                                                <td>
                                                    {{ $appointment->patient->first_name ?? $appointment->patient->user->first_name ?? '' }}
                                                    {{ $appointment->patient->last_name ?? $appointment->patient->user->last_name ?? '' }}
                                                </td>
                                                <td>{{ $appointment->appointment_date?->format('M d, Y h:i A') }}</td>
                                                <td>{{ $appointment->chamber->chamber_name ?? '-' }}</td>
                                                <td>৳{{ number_format($appointment->chamber->visiting_fee ?? 0, 0) }}</td>
                                                <td>
                                                    @php $astat = $appointment->appointment_status ?? 'scheduled'; @endphp
                                                    <span class="badge
                                                                    @if($astat === 'scheduled') bg-success
                                                                    @elseif($astat === 'completed') bg-primary
                                                                    @else bg-danger @endif">
                                                        {{ ucfirst($astat) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @php $pstat = $appointment->payment_status ?? 'unpaid'; @endphp
                                                    <span
                                                        class="badge {{ $pstat === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                        {{ ucfirst($pstat) }}
                                                    </span>
                                                </td>
                                                <td>{{ $appointment->reason ?? 'No reason provided' }}</td>
                                                <td class="d-flex gap-2">
                                                    {{-- Update appointment status --}}
                                                    <form action="{{ route('appointments.update-status', $appointment) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <select name="appointment_status" class="form-select form-select-sm"
                                                            onchange="this.form.submit()">
                                                            <option value="scheduled" {{ $astat === 'scheduled' ? 'selected' : '' }}>
                                                                Scheduled</option>
                                                            <option value="completed" {{ $astat === 'completed' ? 'selected' : '' }}>
                                                                Completed</option>
                                                            <option value="cancelled" {{ $astat === 'cancelled' ? 'selected' : '' }}>
                                                                Cancelled</option>
                                                        </select>
                                                    </form>

                                                    {{-- Update payment status --}}
                                                    <form action="{{ route('appointments.update-payment', $appointment) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <select name="payment_status" class="form-select form-select-sm"
                                                            onchange="this.form.submit()">
                                                            <option value="unpaid" {{ $pstat === 'unpaid' ? 'selected' : '' }}>Unpaid
                                                            </option>
                                                            <option value="paid" {{ $pstat === 'paid' ? 'selected' : '' }}>Paid
                                                            </option>
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