@extends('layouts.app')

@section('title', 'Patient Dashboard')

@section('content')
    <div class="patient-dashboard">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $upcomingAppointments->count() }}</h3>
                    <span>Upcoming</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-history"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ auth()->user()->patient->appointments->count() }}</h3>
                    <span>Total Appointments</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-info">
                    <h3>Active</h3>
                    <span>Profile Status</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Upcoming Appointments -->
            <div class="content-card">
                <h5>Upcoming Appointments</h5>
                <div class="card-content">
                    @if($upcomingAppointments->count() > 0)
                        @foreach($upcomingAppointments as $appointment)
                            <div class="appointment-item">
                                <div class="appointment-info">
                                    <strong>Dr. {{ $appointment->doctor->first_name }}
                                        {{ $appointment->doctor->last_name }}</strong>
                                    <div class="appointment-meta">
                                        {{ $appointment->doctor->speciality }} •
                                        {{ $appointment->appointment_date->format('M d, Y H:i') }}
                                    </div>
                                    <small>{{ $appointment->chamber->chamber_name }}</small>
                                </div>
                                <div class="appointment-status">
                                    <span class="badge status-{{ $appointment->appointment_status }}">
                                        {{ ucfirst($appointment->appointment_status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <h6>No upcoming appointments</h6>
                            <p>Book your first appointment</p>
                            <a href="{{ route('patient.doctors') }}" class="btn-find">Find Doctors</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Health Tips -->
            <div class="content-card">
                <h5>Health Tips</h5>
                <div class="card-content">
                    <div class="health-tip">
                        <i class="fas fa-heart"></i>
                        <span>Regular check-ups prevent health issues</span>
                    </div>
                    <div class="health-tip">
                        <i class="fas fa-dumbbell"></i>
                        <span>Exercise 30 minutes daily</span>
                    </div>
                    <div class="health-tip">
                        <i class="fas fa-apple-alt"></i>
                        <span>Eat balanced diet with fruits</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .patient-dashboard {
            max-width: 1100px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header */
        .dashboard-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #20B2AA;
        }

        .dashboard-header h1 {
            font-size: 28px;
            font-weight: 600;
            color: #20B2AA;
            margin: 0 0 5px 0;
        }

        .dashboard-header p {
            color: #666;
            font-size: 16px;
            margin: 0;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 18px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: border-color 0.2s ease;
        }

        .stat-card:hover {
            border-color: #20B2AA;
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            background: #20B2AA;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .stat-info h3 {
            font-size: 22px;
            font-weight: 600;
            color: #333;
            margin: 0 0 3px 0;
        }

        .stat-info span {
            color: #666;
            font-size: 14px;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .action-btn {
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            text-align: center;
            text-decoration: none;
            color: #333;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .action-btn.primary {
            background: #20B2AA;
            color: white;
            border-color: #20B2AA;
        }

        .action-btn.primary:hover {
            background: #178A84;
            border-color: #178A84;
            color: white;
            text-decoration: none;
        }

        .action-btn.secondary:hover {
            border-color: #20B2AA;
            color: #20B2AA;
            text-decoration: none;
        }

        .action-btn i {
            font-size: 20px;
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .content-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            overflow: hidden;
        }

        .content-card h5 {
            font-size: 16px;
            font-weight: 600;
            color: white;
            background: #20B2AA;
            margin: 0;
            padding: 14px 18px;
        }

        .card-content {
            padding: 18px;
        }

        /* Appointment Items */
        .appointment-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .appointment-item:last-child {
            border-bottom: none;
        }

        .appointment-info strong {
            display: block;
            color: #333;
            font-size: 15px;
            margin-bottom: 4px;
        }

        .appointment-meta {
            color: #666;
            font-size: 13px;
            margin-bottom: 3px;
        }

        .appointment-info small {
            color: #999;
            font-size: 12px;
        }

        .badge {
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 500;
            border-radius: 10px;
            text-transform: uppercase;
        }

        .status-scheduled {
            background: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background: #E6F7F6;
            color: #178A84;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 30px;
            color: #999;
        }

        .empty-state i {
            font-size: 36px;
            margin-bottom: 12px;
            color: #20B2AA;
            opacity: 0.5;
        }

        .empty-state h6 {
            font-size: 16px;
            color: #333;
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: 14px;
            margin-bottom: 15px;
        }

        .btn-find {
            background: #20B2AA;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
        }

        .btn-find:hover {
            background: #178A84;
            color: white;
            text-decoration: none;
        }

        /* Health Tips */
        .health-tip {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .health-tip:last-child {
            border-bottom: none;
        }

        .health-tip i {
            color: #20B2AA;
            font-size: 16px;
            width: 20px;
        }

        .health-tip span {
            font-size: 13px;
            color: #666;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .patient-dashboard {
                padding: 15px;
            }

            .dashboard-header h1 {
                font-size: 24px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

            .content-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }
    </style>
@endsection