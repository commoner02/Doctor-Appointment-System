
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

@section('title', 'Doctor Profile')

@section('page-header')
@endsection

@section('page-title', 'Doctor Profile')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Doctor Profile Card -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-user-md text-primary me-2"></i>
                        Doctor Information
                    </h5>
                    @if(auth()->user()->role === 'patient')
                        <a href="{{ route('appointments.create', $doctor->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-calendar-plus me-1"></i>Book Appointment
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Doctor Photo Placeholder -->
                    <div class="col-md-3 text-center mb-4">
                        <div class="doctor-avatar mx-auto mb-3">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="badge badge-success">
                            <i class="fas fa-check-circle me-1"></i>Verified
                        </div>
                    </div>
                    
                    <!-- Doctor Details -->
                    <div class="col-md-9">
                        <h4 class="text-primary mb-1">
                            Dr. {{ $doctor->user->name }}
                        </h4>
                        
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <p class="mb-2">
                                    <strong>Speciality:</strong><br>
                                    <span class="text-muted">{{ $doctor->speciality ?? 'Not specified' }}</span>
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <p class="mb-2">
                                    <strong>Qualifications:</strong><br>
                                    <span class="text-muted">{{ $doctor->qualifications ?? 'Not specified' }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <p class="mb-2">
                                    <strong>Experience:</strong><br>
                                    <span class="text-muted">{{ $doctor->experience ?? 'Not specified' }} years</span>
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <p class="mb-2">
                                    <strong>Contact:</strong><br>
                                    <span class="text-muted">{{ $doctor->phone ?? $doctor->user->email }}</span>
                                </p>
                            </div>
                        </div>

                        @if($doctor->bio)
                            <p class="mb-2">
                                <strong>About:</strong><br>
                                <span class="text-muted">{{ $doctor->bio }}</span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Chambers Information -->
        @if($doctor->chambers && $doctor->chambers->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-clinic-medical text-primary me-2"></i>
                        Chambers & Schedule
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($doctor->chambers as $chamber)
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="text-primary mb-2">{{ $chamber->name }}</h6>
                                    
                                    <p class="mb-1">
                                        <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                        {{ $chamber->address }}
                                    </p>
                                    
                                    <p class="mb-1">
                                        <i class="fas fa-clock text-muted me-2"></i>
                                        {{ $chamber->visiting_hours ?? 'Contact for schedule' }}
                                    </p>
                                    
                                    <p class="mb-2">
                                        <i class="fas fa-money-bill text-muted me-2"></i>
                                        Consultation Fee: <strong>৳{{ number_format($chamber->fee ?? 0) }}</strong>
                                    </p>

                                    @if(auth()->user()->role === 'patient')
                                        <a href="{{ route('appointments.create', $doctor->id) }}" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-calendar-plus me-1"></i>Book Here
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Back Button -->
        <div class="text-center mt-4">
            @if(auth()->user()->role === 'patient')
                <a href="{{ route('patient.doctors') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Doctors
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                </a>
            @endif
        </div>
    </div>
</div>

<style>
.doctor-avatar {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: white;
}

.badge {
    font-size: 0.75rem;
}
</style>
@endsection