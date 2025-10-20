
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="admin-dashboard">

        <!-- Stats Cards -->
            <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-injured"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ \App\Models\Patient::count() }}</h3>
                    <span>Patients</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ \App\Models\Doctor::count() }}</h3>
                    <span>Doctors</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ \App\Models\Appointment::count() }}</h3>
                    <span>Appointments</span>
                </div>
            </div>


            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clinic-medical"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ \App\Models\Chamber::count() }}</h3>
                    <span>Chambers</span>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Recent Appointments -->
            <div class="content-card">
                <h5>Recent Appointments</h5>
                <div class="card-content">
                    @if($recentAppointments->count() > 0)
                        @foreach($recentAppointments as $appointment)
                            <div class="appointment-item">
                                <div class="appointment-info">
                                    <strong>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</strong>
                                    <small>Dr. {{ $appointment->doctor->first_name }} • {{ $appointment->appointment_date->format('M d, H:i') }}</small>
                                </div>
                                <div class="appointment-badges">
                                    <span class="badge status-{{ $appointment->appointment_status }}">{{ ucfirst($appointment->appointment_status) }}</span>
                                    <span class="badge payment-{{ $appointment->payment_status }}">{{ ucfirst($appointment->payment_status) }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <p>No recent appointments</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pending Verifications -->
            <div class="content-card">
                <h5>Pending Verifications</h5>
                <div class="card-content">
                    @if($pendingDoctors->count() > 0)
                        @foreach($pendingDoctors as $user)
                            <div class="verification-item">
                                <div class="doctor-info">
                                    <strong>{{ $user->name }}</strong>
                                    {{-- <small>{{ $user->doctor->speciality }}</small> --}}
                                </div>
                                <form action="{{ route('admin.verify-doctor', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="verify-btn">
                                        <i class="fas fa-check"></i> Verify
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-check-circle"></i>
                            <p>All verified</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .admin-dashboard {
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
            font-size: 32px;
            font-weight: 600;
            color: #20B2AA;
            margin: 0 0 8px 0;
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
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin: 0 0 4px 0;
        }

        .stat-info span {
            color: #666;
            font-size: 14px;
        }

        /* Management Grid */
        .management-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .management-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 25px 15px;
            text-align: center;
            text-decoration: none;
            color: inherit;
            display: block;
            transition: all 0.2s ease;
        }

        .management-card:hover {
            border-color: #20B2AA;
            transform: translateY(-2px);
            text-decoration: none;
            color: inherit;
        }

        .management-card i {
            font-size: 28px;
            color: #20B2AA;
            margin-bottom: 10px;
        }

        .management-card span {
            font-size: 15px;
            font-weight: 500;
            color: #333;
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

        .appointment-info small {
            color: #666;
            font-size: 13px;
        }

        .appointment-badges {
            display: flex;
            flex-direction: column;
            gap: 4px;
            align-items: flex-end;
        }

        /* Verification Items */
        .verification-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .verification-item:last-child {
            border-bottom: none;
        }

        .doctor-info strong {
            display: block;
            color: #333;
            font-size: 15px;
            margin-bottom: 4px;
        }

        .doctor-info small {
            color: #666;
            font-size: 13px;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 500;
            border-radius: 10px;
            text-transform: uppercase;
        }

        .status-scheduled, .payment-unpaid {
            background: #fff3cd;
            color: #856404;
        }

        .status-completed, .payment-paid {
            background: #E6F7F6;
            color: #178A84;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        /* Verify Button */
        .verify-btn {
            background: #20B2AA;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 4px;
            font-size: 13px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .verify-btn:hover {
            background: #178A84;
        }

        .verify-btn i {
            margin-right: 5px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 25px;
            color: #999;
        }

        .empty-state i {
            font-size: 28px;
            margin-bottom: 10px;
            color: #20B2AA;
            opacity: 0.5;
        }

        .empty-state p {
            margin: 0;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-dashboard {
                padding: 15px;
            }

            .dashboard-header h1 {
                font-size: 28px;
            }

            .dashboard-header p {
                font-size: 14px;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            .management-grid {
                grid-template-columns: 1fr 1fr;
            }

            .content-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .appointment-item,
            .verification-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .appointment-badges {
                flex-direction: row;
                align-items: flex-start;
            }
        }
    </style>
@endsection