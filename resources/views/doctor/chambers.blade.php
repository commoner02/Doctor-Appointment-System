@extends('layouts.app')

@section('title', 'My Chambers')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">My Chambers</h1>
            <p class="page-subtitle">Manage your medical chambers and availability</p>
        </div>

        <!-- Add Chamber Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">{{ $chambers->count() }} Chamber{{ $chambers->count() != 1 ? 's' : '' }}</h5>
            <a href="{{ route('chambers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Add New Chamber
            </a>
        </div>

        @if($chambers->count() > 0)
            <div class="row">
                @foreach($chambers as $chamber)
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title mb-0">{{ $chamber->chamber_name }}</h5>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('chambers.edit', $chamber) }}">
                                                    <i class="fas fa-edit me-2"></i>Edit
                                                </a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form action="{{ route('chambers.destroy', $chamber) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"
                                                        onclick="return confirm('Are you sure you want to delete this chamber?')">
                                                        <i class="fas fa-trash me-2"></i>Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="chamber-details">
                                    <div class="d-flex align-items-center text-muted mb-2">
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        <span>{{ $chamber->chamber_location ?: 'No location specified' }}</span>
                                    </div>

                                    <div class="d-flex align-items-center text-muted mb-2">
                                        <i class="fas fa-clock me-2"></i>
                                        <span>{{ $chamber->start_time }} - {{ $chamber->end_time }}</span>
                                    </div>

                                    <div class="d-flex align-items-center text-muted mb-2">
                                        <i class="fas fa-calendar-week me-2"></i>
                                        <span>{{ implode(', ', $chamber->working_days) }}</span>
                                    </div>

                                    <div class="d-flex align-items-center text-muted mb-2">
                                        <i class="fas fa-money-bill-wave me-2"></i>
                                        <span>Visiting Fee: {{ number_format($chamber->visiting_fee, 2) }}</span>
                                    </div>

                                    @if($chamber->phone)
                                        <div class="d-flex align-items-center text-muted mb-3">
                                            <i class="fas fa-phone me-2"></i>
                                            <span>{{ $chamber->phone }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Chamber Stats -->
                                <div class="chamber-stats border-top pt-3">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div class="stat-item">
                                                <h6 class="mb-1 text-primary">{{ $chamber->appointments->count() }}</h6>
                                                <small class="text-muted">Appointments</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="stat-item">
                                                <h6 class="mb-1 text-success">
                                                    {{ $chamber->appointments->where('appointment_status', 'scheduled')->count() }}</h6>
                                                <small class="text-muted">Scheduled</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- No Chambers -->
            <div class="text-center py-5">
                <div class="card">
                    <div class="card-body py-5">
                        <i class="fas fa-building fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No chambers found</h5>
                        <p class="text-muted">Add your first chamber to start accepting appointments</p>
                        <a href="{{ route('chambers.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Add Chamber
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        .chamber-details {
            margin-bottom: 1rem;
        }

        .chamber-stats {
            background-color: #f8fafc;
            border-radius: 8px;
            margin: 0 -1rem -1rem -1rem;
            padding: 1rem;
        }

        .stat-item h6 {
            font-weight: 600;
        }

        .card:hover {
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }
    </style>
@endsection