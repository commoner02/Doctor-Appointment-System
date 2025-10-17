@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
    <div class="container">
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
                                                    <option value="scheduled" {{ $a->status == 'scheduled' ? 'selected' : '' }}>Scheduled
                                                    </option>
                                                    <option value="completed" {{ $a->status == 'completed' ? 'selected' : '' }}>Completed
                                                    </option>
                                                    <option value="cancelled" {{ $a->status == 'cancelled' ? 'selected' : '' }}>Cancelled
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
    </div>
@endsection