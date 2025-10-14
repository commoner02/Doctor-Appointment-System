@extends('layouts.app')

@section('title', 'Find Doctors')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Find Doctors</h1>
            <p class="page-subtitle">Search and book appointments with verified doctors</p>
        </div>

        <!-- Search and Filter Section -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('patient.doctors') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search"
                            placeholder="Search by name, speciality, or chamber..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="speciality" class="form-label">Speciality</label>
                        <select class="form-control" id="speciality" name="speciality">
                            <option value="">All Specialities</option>
                            @foreach($specialities as $spec)
                                <option value="{{ $spec }}" {{ request('speciality') == $spec ? 'selected' : '' }}>
                                    {{ $spec }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location"
                            placeholder="Chamber location..." value="{{ request('location') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i>Search
                        </button>
                    </div>
                </form>

                @if(request()->hasAny(['search', 'speciality', 'location']))
                    <div class="mt-3">
                        <a href="{{ route('patient.doctors') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-times me-1"></i>Clear Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Results Count -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">{{ $doctors->count() }} Doctor{{ $doctors->count() != 1 ? 's' : '' }} Found</h5>
            @if(request()->hasAny(['search', 'speciality', 'location']))
                <small class="text-muted">
                    Showing results for:
                    @if(request('search')) "{{ request('search') }}" @endif
                    @if(request('speciality')) | {{ request('speciality') }} @endif
                    @if(request('location')) | {{ request('location') }} @endif
                </small>
            @endif
        </div>

        <!-- Doctors Grid -->
        @if($doctors->count() > 0)
            <div class="row">
                @foreach($doctors as $doctor)
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <!-- Doctor Info -->
                                <div class="d-flex align-items-start mb-3">
                                    <div class="avatar-circle me-3"
                                        style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 1.5rem;">
                                        {{ substr($doctor->first_name, 0, 1) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-1">Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</h5>
                                        <p class="text-muted mb-1">{{ $doctor->speciality }}</p>
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-phone me-1"></i>
                                            <small>{{ $doctor->phone }}</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Qualifications -->
                                <div class="mb-3">
                                    <h6 class="text-muted mb-2">Qualifications</h6>
                                    <p class="small mb-0">{{ $doctor->qualifications }}</p>
                                </div>

                                <!-- Chambers -->
                                <div class="mb-3">
                                    <h6 class="text-muted mb-2">
                                        <i class="fas fa-building me-1"></i>Chambers ({{ $doctor->chambers->count() }})
                                    </h6>
                                    @if($doctor->chambers->count() > 0)
                                        @foreach($doctor->chambers as $chamber)
                                            <div class="chamber-item border rounded p-2 mb-2">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <strong class="small">{{ $chamber->chamber_name }}</strong>
                                                        <br>
                                                        <small class="text-muted">
                                                            <i class="fas fa-map-marker-alt me-1"></i>{{ $chamber->chamber_location }}
                                                        </small>
                                                        <br>
                                                        <small class="text-muted">
                                                            <i class="fas fa-clock me-1"></i>{{ $chamber->start_time }} -
                                                            {{ $chamber->end_time }}
                                                        </small>
                                                        <br>
                                                        <small class="text-muted">
                                                            <i
                                                                class="fas fa-calendar-week me-1"></i>{{ implode(', ', $chamber->working_days) }}
                                                        </small>
                                                    </div>
                                                    @if($chamber->phone)
                                                        <div class="text-end">
                                                            <small class="text-muted">
                                                                <i class="fas fa-phone me-1"></i>{{ $chamber->phone }}
                                                            </small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="small text-muted mb-0">No chambers available</p>
                                    @endif
                                </div>

                                <!-- Action Button -->
                                <div class="d-grid">
                                    <a href="{{ route('doctor.show', $doctor->id) }}" class="btn btn-primary">
                                        <i class="fas fa-eye me-1"></i>View Profile & Book
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- No Results -->
            <div class="text-center py-5">
                <div class="card">
                    <div class="card-body py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No doctors found</h5>
                        <p class="text-muted">
                            @if(request()->hasAny(['search', 'speciality', 'location']))
                                Try adjusting your search criteria or clear the filters.
                            @else
                                There are currently no verified doctors available.
                            @endif
                        </p>
                        @if(request()->hasAny(['search', 'speciality', 'location']))
                            <a href="{{ route('patient.doctors') }}" class="btn btn-primary">
                                <i class="fas fa-refresh me-1"></i>Clear Filters
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        .chamber-item {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0 !important;
            transition: all 0.3s ease;
        }

        .chamber-item:hover {
            background-color: #f1f5f9;
            border-color: #cbd5e1 !important;
        }

        .avatar-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }
    </style>
@endsection