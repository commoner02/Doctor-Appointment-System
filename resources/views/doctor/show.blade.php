@extends('layouts.app')

@section('title', 'Doctor Profile')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Doctor Profile</h1>
            <p class="page-subtitle">View doctor details and book an appointment</p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <!-- Doctor Header -->
                        <div class="d-flex align-items-start mb-4">
                            <div class="avatar-circle me-4"
                                style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 2rem;">
                                {{ substr($doctor->first_name, 0, 1) }}
                            </div>
                            <div class="flex-grow-1">
                                <h2 class="mb-1">Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</h2>
                                <p class="text-muted mb-2">{{ $doctor->speciality }}</p>
                                <div class="d-flex align-items-center text-muted mb-2">
                                    <i class="fas fa-phone me-2"></i>
                                    <span>{{ $doctor->phone }}</span>
                                </div>
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-certificate me-2"></i>
                                    <span>{{ $doctor->license_no }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Qualifications -->
                        <div class="mb-4">
                            <h5 class="mb-3"><i class="fas fa-graduation-cap me-2"></i>Qualifications</h5>
                            <p class="text-muted">{{ $doctor->qualifications }}</p>
                        </div>

                        <!-- Available Chambers -->
                        <div class="mb-4">
                            <h5 class="mb-3"><i class="fas fa-building me-2"></i>Available Chambers</h5>
                            @if($doctor->chambers->count() > 0)
                                <div class="row">
                                    @foreach($doctor->chambers as $chamber)
                                        <div class="col-md-6 mb-3">
                                            <div class="chamber-card border rounded p-3">
                                                <h6 class="mb-2">{{ $chamber->chamber_name }}</h6>
                                                <div class="chamber-details">
                                                    <div class="d-flex align-items-center text-muted mb-1">
                                                        <i class="fas fa-map-marker-alt me-2"></i>
                                                        <small>{{ $chamber->chamber_location }}</small>
                                                    </div>
                                                    <div class="d-flex align-items-center text-muted mb-1">
                                                        <i class="fas fa-clock me-2"></i>
                                                        <small>{{ $chamber->start_time }} - {{ $chamber->end_time }}</small>
                                                    </div>
                                                    <div class="d-flex align-items-center text-muted mb-1">
                                                        <i class="fas fa-calendar-week me-2"></i>
                                                        <small>{{ implode(', ', $chamber->working_days) }}</small>
                                                    </div>
                                                    <div class="d-flex align-items-center text-primary mb-1">
                                                        <i class="fas fa-money-bill-wave me-2"></i>
                                                        <small><strong>৳{{ number_format($chamber->visiting_fee, 0) }}</strong>
                                                            Visiting Fee</small>
                                                    </div>
                                                    @if($chamber->phone)
                                                        <div class="d-flex align-items-center text-muted">
                                                            <i class="fas fa-phone me-2"></i>
                                                            <small>{{ $chamber->phone }}</small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-building fa-2x text-muted mb-2"></i>
                                    <p class="text-muted">No chambers available</p>
                                </div>
                            @endif
                        </div>

                        <!-- Book Appointment Button -->
                        @auth
                            @if(auth()->user()->isPatient())
                                <div class="d-grid">
                                    <a href="{{ route('appointments.create', $doctor->id) }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-calendar-plus me-2"></i>Book Appointment
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Please <a href="{{ route('login') }}" class="alert-link">login</a> as a patient to book an
                                appointment.
                            </div>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Info -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Quick Info</h5>
                    </div>
                    <div class="card-body">
                        <div class="info-item d-flex justify-content-between mb-3">
                            <span class="text-muted">Speciality</span>
                            <strong>{{ $doctor->speciality }}</strong>
                        </div>
                        <div class="info-item d-flex justify-content-between mb-3">
                            <span class="text-muted">License</span>
                            <strong>{{ $doctor->license_no }}</strong>
                        </div>
                        <div class="info-item d-flex justify-content-between mb-3">
                            <span class="text-muted">Chambers</span>
                            <strong>{{ $doctor->chambers->count() }}</strong>
                        </div>
                        <div class="info-item d-flex justify-content-between">
                            <span class="text-muted">Status</span>
                            <span class="badge bg-success">Verified</span>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Contact</h5>
                    </div>
                    <div class="card-body">
                        <div class="contact-item d-flex align-items-center mb-3">
                            <i class="fas fa-phone text-primary me-3"></i>
                            <div>
                                <strong>Phone</strong>
                                <br><small class="text-muted">{{ $doctor->phone }}</small>
                            </div>
                        </div>
                        <div class="contact-item d-flex align-items-center">
                            <i class="fas fa-envelope text-primary me-3"></i>
                            <div>
                                <strong>Email</strong>
                                <br><small class="text-muted">{{ $doctor->user->email }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .chamber-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0 !important;
            transition: all 0.3s ease;
        }

        .chamber-card:hover {
            background-color: #f1f5f9;
            border-color: #cbd5e1 !important;
            transform: translateY(-2px);
        }

        .avatar-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .info-item {
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .contact-item i {
            width: 20px;
            text-align: center;
        }
    </style>
@endsection