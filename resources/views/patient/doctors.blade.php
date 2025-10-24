@extends('layouts.app')

@section('title', 'Find Doctors')

@section('page-header')
@endsection

@section('page-title', 'Find Doctors')
@section('page-description', 'Search and book appointments with verified doctors')

@section('content')
    <!-- Search Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('patient.doctors') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search by name or speciality"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Speciality</label>
                        <select name="speciality" class="form-select">
                            <option value="">All Specialities</option>
                            @foreach($specialities as $speciality)
                                <option value="{{ $speciality }}" {{ request('speciality') == $speciality ? 'selected' : '' }}>
                                    {{ $speciality }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="fas fa-search me-1"></i>Search
                            </button>
                            <a href="{{ route('patient.doctors') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Doctors Grid -->
    <div class="row">
        @forelse($doctors as $doctor)
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex">
                            <!-- Doctor Avatar -->
                            <div class="doctor-avatar-sm me-3 flex-shrink-0">
                                <i class="fas fa-user-md"></i>
                            </div>

                            <!-- Doctor Info -->
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-1">Dr. {{ $doctor->user->name }}</h5>
                                <p class="text-primary mb-2">{{ $doctor->speciality ?? 'General Physician' }}</p>

                                @if($doctor->qualifications)
                                    <p class="text-muted small mb-2">{{ $doctor->qualifications }}</p>
                                @endif

                                @if($doctor->experience)
                                    <p class="text-muted small mb-2">
                                        <i class="fas fa-clock me-1"></i>{{ $doctor->experience }} years experience
                                    </p>
                                @endif

                                @if($doctor->chambers->count() > 0)
                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-1"><strong>Available at:</strong></small>
                                        @foreach($doctor->chambers->take(2) as $chamber)
                                            <small class="d-block text-muted">
                                                • {{ $chamber->name }} - ৳{{ number_format($chamber->fee ?? 500) }}
                                            </small>
                                        @endforeach
                                        @if($doctor->chambers->count() > 2)
                                            <small class="text-primary">+{{ $doctor->chambers->count() - 2 }} more locations</small>
                                        @endif
                                    </div>
                                @endif

                                <div class="d-flex gap-2">
                                    <a href="{{ route('doctor.show', $doctor->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>View Profile
                                    </a>
                                    <a href="{{ route('appointments.create', $doctor->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-calendar-plus me-1"></i>Book Appointment
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-user-md text-muted" style="font-size: 4rem;"></i>
                    <h4 class="text-muted mt-3">No doctors found</h4>
                    <p class="text-muted">Try adjusting your search criteria</p>
                    <a href="{{ route('patient.doctors') }}" class="btn btn-primary">
                        <i class="fas fa-refresh me-1"></i>Show All Doctors
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($doctors->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $doctors->links() }}
        </div>
    @endif

    <style>
        .doctor-avatar-sm {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }
    </style>
@endsection