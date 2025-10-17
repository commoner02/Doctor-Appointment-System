@extends('layouts.app')

@section('title', 'Find Doctors')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('patient.doctors') }}" class="row g-2">
                    <div class="col-md-4">
                        <input name="search" value="{{ request('search') }}" class="form-control"
                            placeholder="Name, speciality, chamber...">
                    </div>
                    <div class="col-md-3">
                        <input name="location" value="{{ request('location') }}" class="form-control"
                            placeholder="Location">
                    </div>
                    <div class="col-md-3">
                        <input name="speciality" value="{{ request('speciality') }}" class="form-control"
                            placeholder="Speciality">
                    </div>
                    <div class="col-md-2 d-grid">
                        <button class="btn btn-primary">Search</button>
                    </div>
                </form>
                @if(request()->hasAny(['search', 'location', 'speciality']))
                    <div class="mt-2">
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('patient.doctors') }}">Clear</a>
                    </div>
                @endif
            </div>
        </div>

        @forelse($doctors as $doctor)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="mb-1">Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</h5>
                    <div class="text-muted mb-2">{{ $doctor->speciality }} • {{ $doctor->phone }}</div>
                    <div class="row">
                        @forelse($doctor->chambers as $ch)
                            <div class="col-md-6">
                                <div class="border rounded p-2 mb-2">
                                    <strong>{{ $ch->chamber_name }}</strong>
                                    <div class="small text-muted">{{ $ch->chamber_location }}</div>
                                    <div class="small">Time: {{ $ch->start_time }} - {{ $ch->end_time }}</div>
                                    <div class="small">Days: {{ implode(', ', $ch->working_days) }}</div>
                                    <div class="small">Fee: {{ number_format($ch->visiting_fee, 2) }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12"><small class="text-muted">No chambers available</small></div>
                        @endforelse
                    </div>
                    <a href="{{ route('doctor.show', $doctor->id) }}" class="btn btn-sm btn-primary">View & Book</a>
                </div>
            </div>
        @empty
            <div class="alert alert-info">No doctors found.</div>
        @endforelse
    </div>
@endsection