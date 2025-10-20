@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
    <div class="dashboard">
        <div class="container py-4">
    
            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="stat-card">
                        <div class="icon-box bg-light-teal">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <h3>{{ $todayAppointmentsCount ?? 0 }}</h3>
                            <p>Today's Appointments</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="stat-card">
                        <div class="icon-box bg-light-blue">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div>
                            <h3>{{ $upcomingAppointments ?? 0 }}</h3>
                            <p>Upcoming Appointments</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="icon-box bg-light-green">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h3>{{ $totalPatients ?? 0 }}</h3>
                            <p>Total Patients</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="row">
                <!-- Today's Appointments -->
                <div class="col-lg-8 mb-4">
                    <div class="content-card">
                        <div class="card-header-custom">
                            <h5><i class="fas fa-calendar-day me-2"></i>Today's Appointments</h5>
                            <a href="{{ route('doctor.appointments') }}" class="view-all">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Patient</th>
                                        <th>Chamber</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($todayAppointments as $appointment)
                                        <tr>
                                            <td>
                                                <div class="appointment-time">
                                                    {{ $appointment->appointment_date->format('h:i A') }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar">
                                                        <span>{{ substr($appointment->patient->user->first_name, 0, 1) }}{{ substr($appointment->patient->user->last_name, 0, 1) }}</span>
                                                    </div>
                                                    <div class="ms-2">
                                                        <div class="patient-name">
                                                            {{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->last_name }}
                                                        </div>
                                                        <div class="patient-email">
                                                            {{ $appointment->patient->user->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="chamber-info">
                                                    <div class="chamber-name">{{ $appointment->chamber->chamber_name }}</div>
                                                    <div class="visiting-fee">৳{{ number_format($appointment->chamber->visiting_fee, 0) }}</div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($appointment->appointment_status == 'scheduled')
                                                    <span class="badge bg-info">Scheduled</span>
                                                @elseif($appointment->appointment_status == 'completed')
                                                    <span class="badge bg-success">Completed</span>
                                                @elseif($appointment->appointment_status == 'cancelled')
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @else
                                                    <span class="badge bg-warning">{{ ucfirst($appointment->appointment_status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="action-btns">
                                                    <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-outline-primary" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($appointment->appointment_status != 'completed')
                                                        <button type="button" class="btn btn-sm btn-outline-success" 
                                                                onclick="markCompleted({{ $appointment->id }})" title="Mark Complete">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <div class="empty-state">
                                                    <i class="fas fa-calendar-times"></i>
                                                    <p>No appointments scheduled for today</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="col-lg-4">
                    <!-- Chambers -->
                    <div class="content-card mb-4">
                        <div class="card-header-custom">
                            <h5><i class="fas fa-clinic-medical me-2"></i>My Chambers</h5>
                            <a href="{{ route('chambers.index') }}" class="view-all">Manage</a>
                        </div>
                        <div class="chambers-list">
                            @forelse($chambers as $chamber)
                                <div class="chamber-item">
                                    <div>
                                        <h6>{{ $chamber->chamber_name }}</h6>
                                        <p class="text-muted small mb-0">
                                            <i class="fas fa-map-marker-alt me-1"></i> 
                                            {{ $chamber->chamber_location ? Str::limit($chamber->chamber_location, 25) : 'No location' }}
                                        </p>
                                        <p class="text-primary small mb-0">
                                            <i class="fas fa-money-bill-wave me-1"></i> 
                                            ৳{{ number_format($chamber->visiting_fee, 0) }}
                                        </p>
                                    </div>
                                    <div class="chamber-status active">
                                        Active
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state">
                                    <i class="fas fa-clinic-medical"></i>
                                    <p>No chambers added yet</p>
                                    <a href="{{ route('chambers.create') }}" class="btn btn-sm btn-outline-primary mt-2">Add Chamber</a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Recent Patients -->
                    <div class="content-card">
                        <div class="card-header-custom">
                            <h5><i class="fas fa-user-injured me-2"></i>Recent Patients</h5>
                        </div>
                        <div class="recent-patients">
                            @forelse($recentPatients as $patient)
                                <div class="patient-item">
                                    <div class="avatar">
                                        <span>{{ substr($patient->user->first_name, 0, 1) }}{{ substr($patient->user->last_name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <h6>{{ $patient->user->first_name }} {{ $patient->user->last_name }}</h6>
                                        <p class="text-muted small mb-0">
                                            Last visit: {{ $patient->appointments()->where('doctor_id', Auth::user()->doctor->id)->latest()->first()?->appointment_date?->format('M d, Y') ?? 'No visits' }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state">
                                    <i class="fas fa-user-injured"></i>
                                    <p>No recent patients</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary: #20B2AA;
            --primary-dark: #178A84;
            --primary-light: #4DCBC2;
            --primary-very-light: #E6F7F6;
        }

        .dashboard {
            background-color: #f8f9fa;
            min-height: calc(100vh - 60px);
        }

        /* Welcome Card */
        .welcome-card {
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            padding: 20px 25px;
            border-radius: 10px;
            color: white;
            margin-bottom: 20px;
        }

        .welcome-card h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .welcome-card p {
            margin: 0;
            opacity: 0.9;
        }

        .welcome-card .btn {
            background: white;
            color: var(--primary-dark);
            border: none;
            padding: 8px 16px;
            transition: all 0.2s;
        }

        .welcome-card .btn:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
        }

        /* Stat Cards */
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            height: 100%;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .bg-light-teal {
            background-color: var(--primary-very-light);
            color: var(--primary);
        }

        .bg-light-blue {
            background-color: #e6f3ff;
            color: #0d6efd;
        }

        .bg-light-green {
            background-color: #e6f8e6;
            color: #198754;
        }

        .stat-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
            color: #333;
        }

        .stat-card p {
            margin: 0;
            font-size: 14px;
            color: #6c757d;
        }

        /* Content Cards */
        .content-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            height: 100%;
        }

        .card-header-custom {
            background: white;
            padding: 15px 20px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header-custom h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .card-header-custom i {
            color: var(--primary);
        }

        .view-all {
            font-size: 13px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .view-all:hover {
            text-decoration: underline;
            color: var(--primary-dark);
        }

        /* Tables */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            font-size: 14px;
            font-weight: 500;
            color: #6c757d;
            background: #fafafa;
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .table tbody td {
            padding: 12px 15px;
            font-size: 14px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table-hover tbody tr:hover {
            background-color: #fafafa;
        }

        /* Patient Info */
        .patient-name {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .patient-email {
            font-size: 12px;
            color: #6c757d;
        }

        /* Chamber Info */
        .chamber-name {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .visiting-fee {
            font-size: 12px;
            color: var(--primary);
            font-weight: 500;
        }

        /* Appointment Time */
        .appointment-time {
            font-weight: 600;
            color: #333;
        }

        /* Avatar */
        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary-very-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 13px;
        }

        /* Action Buttons */
        .action-btns {
            display: flex;
            gap: 5px;
        }

        .action-btns .btn {
            width: 32px;
            height: 32px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Chambers */
        .chambers-list {
            padding: 0 20px 15px;
        }

        .chamber-item {
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chamber-item:last-child {
            border-bottom: none;
        }

        .chamber-item h6 {
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: 600;
        }

        .chamber-status {
            font-size: 12px;
            padding: 3px 8px;
            border-radius: 12px;
        }

        .chamber-status.active {
            background: #e6f8e6;
            color: #198754;
        }

        .chamber-status.inactive {
            background: #f8d7da;
            color: #dc3545;
        }

        /* Recent Patients */
        .recent-patients {
            padding: 0 20px 15px;
        }

        .patient-item {
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .patient-item:last-child {
            border-bottom: none;
        }

        .patient-item h6 {
            margin-bottom: 3px;
            font-size: 14px;
            font-weight: 600;
        }

        /* Empty State */
        .empty-state {
            padding: 20px 0;
            text-align: center;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 24px;
            color: #adb5bd;
            margin-bottom: 10px;
        }

        .empty-state p {
            margin-bottom: 0;
            font-size: 14px;
        }

        /* Badges */
        .badge {
            font-weight: 500;
            font-size: 12px;
            padding: 5px 8px;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        /* Modal */
        .modal-header {
            background: var(--primary-very-light);
            color: var(--primary-dark);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .welcome-card h1 {
                font-size: 1.5rem;
            }

            .stat-card {
                padding: 15px;
            }

            .icon-box {
                width: 45px;
                height: 45px;
                font-size: 18px;
            }
        }

        @media (max-width: 767px) {
            .welcome-card {
                text-align: center;
            }

            .welcome-card .text-md-end {
                text-align: center !important;
            }

            .table-responsive {
                font-size: 12px;
            }
        }
    </style>

    <script>
        function markCompleted(appointmentId) {
            if (confirm('Mark this appointment as completed?')) {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/doctor/appointments/${appointmentId}/status`;
                
                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                
                // Add method override for PATCH
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PATCH';
                
                // Add status input
                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'appointment_status';
                statusInput.value = 'completed';
                
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                form.appendChild(statusInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection