@extends('layouts.app')

@section('title', 'Find Doctors')

@section('content')
    <div class="container">
        <h2 class="mb-4">Find Doctors</h2>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('patient.doctors') }}">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by name or speciality" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-5">
                            <select name="speciality" class="form-select">
                                <option value="">All Specialities</option>
                                @foreach($specialities as $speciality)
                                    <option value="{{ $speciality }}"
                                        {{ request('speciality') == $speciality ? 'selected' : '' }}>
                                        {{ $speciality }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @forelse($doctors as $doctor)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</h5>
                            <p class="text-muted mb-2">{{ $doctor->speciality }}</p>
                            <p class="mb-2"><small>{{ $doctor->qualifications }}</small></p>
                            <p class="mb-2"><i class="bi bi-telephone"></i> {{ $doctor->phone }}</p>

                            @if($doctor->chambers->count() > 0)
                                <p class="mb-2"><strong>Chambers:</strong></p>
                                @foreach($doctor->chambers as $chamber)
                                    <small class="d-block">• {{ $chamber->chamber_name }} - BDT
                                        {{ number_format($chamber->visiting_fee, 2) }}</small>
                                @endforeach
                            @endif

                            <a href="{{ route('appointments.create', $doctor) }}"
                                class="btn btn-primary btn-sm mt-2">Book Appointment</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">No doctors found</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection