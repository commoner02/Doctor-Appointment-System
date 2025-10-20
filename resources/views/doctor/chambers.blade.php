@extends('layouts.app')

@section('title', 'My Chambers')

@section('content')
    <div class="chambers-page">
        <div class="container py-4">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="header-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1><i class="fas fa-clinic-medical me-2"></i>My Chambers</h1>
                                <p class="text-muted">Manage your medical chambers and availability</p>
                            </div>
                            <a href="{{ route('chambers.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Add Chamber
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($chambers->count() > 0)
                <div class="row">
                    @foreach($chambers as $chamber)
                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="chamber-card">
                                <div class="chamber-header">
                                    <h5>{{ $chamber->chamber_name }}</h5>
                                    <div class="chamber-actions">
                                        <a href="{{ route('chambers.edit', $chamber) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('chambers.destroy', $chamber) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this chamber?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="chamber-body">
                                    <div class="chamber-info">
                                        <div class="info-item">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>{{ $chamber->chamber_location ?: 'No location specified' }}</span>
                                        </div>

                                        <div class="info-item">
                                            <i class="fas fa-clock"></i>
                                            <span>{{ $chamber->start_time }} - {{ $chamber->end_time }}</span>
                                        </div>

                                        <div class="info-item">
                                            <i class="fas fa-calendar-week"></i>
                                            <span>{{ implode(', ', $chamber->working_days) }}</span>
                                        </div>

                                        @if($chamber->phone)
                                            <div class="info-item">
                                                <i class="fas fa-phone"></i>
                                                <span>{{ $chamber->phone }}</span>
                                            </div>
                                        @endif

                                        <div class="info-item visiting-fee">
                                            <i class="fas fa-money-bill-wave"></i>
                                            <span><strong>৳{{ number_format($chamber->visiting_fee, 0) }}</strong> Visiting
                                                Fee</span>
                                        </div>
                                    </div>

                                    <div class="chamber-stats">
                                        <div class="stat">
                                            <span class="stat-number">{{ $chamber->appointments_count }}</span>
                                            <span class="stat-label">Appointments</span>
                                        </div>
                                        <div class="stat">
                                            <span
                                                class="stat-number">{{ $chamber->appointments()->where('appointment_status', 'scheduled')->count() }}</span>
                                            <span class="stat-label">Scheduled</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-chambers">
                    <div class="empty-state">
                        <i class="fas fa-clinic-medical"></i>
                        <h3>No Chambers Found</h3>
                        <p>Add your first chamber to start accepting appointments</p>
                        <a href="{{ route('chambers.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Add Chamber
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        :root {
            --primary: #20B2AA;
            --primary-dark: #178A84;
        }

        .chambers-page {
            background-color: #f8f9fa;
            min-height: calc(100vh - 60px);
        }

        .header-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .header-card h1 {
            color: var(--primary);
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .chamber-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: transform 0.2s ease;
            height: 100%;
        }

        .chamber-card:hover {
            transform: translateY(-2px);
        }

        .chamber-header {
            background: var(--primary);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .chamber-header h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            flex-grow: 1;
        }

        .chamber-actions {
            display: flex;
            gap: 5px;
        }

        .chamber-actions .btn {
            width: 32px;
            height: 32px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-color: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .chamber-actions .btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: white;
            color: white;
        }

        .chamber-body {
            padding: 20px;
        }

        .chamber-info {
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            font-size: 14px;
            color: #495057;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-item i {
            width: 16px;
            color: var(--primary);
            font-size: 13px;
        }

        .visiting-fee {
            color: var(--primary) !important;
            font-weight: 500;
        }

        .chamber-stats {
            display: flex;
            justify-content: space-around;
            border-top: 1px solid #e9ecef;
            padding-top: 15px;
        }

        .stat {
            text-align: center;
        }

        .stat-number {
            display: block;
            font-size: 20px;
            font-weight: 600;
            color: var(--primary);
        }

        .stat-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .no-chambers {
            background: white;
            border-radius: 10px;
            padding: 60px 20px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .empty-state i {
            font-size: 48px;
            color: #adb5bd;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #495057;
        }

        .empty-state p {
            color: #6c757d;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .alert {
            border: none;
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            .chamber-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .chamber-actions {
                align-self: flex-end;
            }
        }
    </style>
@endsection