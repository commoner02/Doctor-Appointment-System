@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h1 class="text-2xl font-semibold text-gray-900">Admin Dashboard</h1>
            <p class="text-sm text-gray-600 mt-1">System overview and analytics</p>
        </div>

        <!-- Main Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="text-sm text-gray-500">Total Users</div>
                <div class="text-2xl font-semibold text-gray-900">{{ $stats['total_users'] }}</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="text-sm text-gray-500">Patients</div>
                <div class="text-2xl font-semibold text-gray-900">{{ $stats['total_patients'] }}</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="text-sm text-gray-500">Doctors</div>
                <div class="text-2xl font-semibold text-gray-900">{{ $stats['total_doctors'] }}</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="text-sm text-gray-500">Appointments</div>
                <div class="text-2xl font-semibold text-gray-900">{{ $stats['total_appointments'] }}</div>
            </div>
        </div>

        <!-- Analytics Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Appointment Status -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Appointment Status</h3>
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-700">Scheduled</span>
                        <span class="text-sm font-medium">{{ $stats['appointments_scheduled'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-700">Completed</span>
                        <span class="text-sm font-medium">{{ $stats['appointments_completed'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-700">Cancelled</span>
                        <span class="text-sm font-medium">{{ $stats['appointments_cancelled'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Revenue Overview -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Revenue Overview</h3>
                <div class="space-y-2">
                    <div>
                        <div class="text-sm text-gray-500">Total Revenue</div>
                        <div class="text-xl font-semibold text-gray-900">৳{{ number_format($stats['total_revenue'], 2) }}
                        </div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">This Month</div>
                        <div class="text-lg font-semibold text-primary-600">
                            ৳{{ number_format($stats['monthly_revenue'], 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.patients') }}"
                class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition border border-gray-200 hover:border-primary-600 text-center">
                <div class="text-sm font-medium text-gray-900">View Patients</div>
                <div class="text-xs text-gray-500 mt-1">{{ $stats['total_patients'] }} total</div>
            </a>
            <a href="{{ route('admin.doctors') }}"
                class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition border border-gray-200 hover:border-primary-600 text-center">
                <div class="text-sm font-medium text-gray-900">View Doctors</div>
                <div class="text-xs text-gray-500 mt-1">{{ $stats['total_doctors'] }} verified</div>
            </a>
            <a href="{{ route('admin.appointments') }}"
                class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition border border-gray-200 hover:border-primary-600 text-center">
                <div class="text-sm font-medium text-gray-900">View Appointments</div>
                <div class="text-xs text-gray-500 mt-1">{{ $stats['total_appointments'] }} total</div>
            </a>
            <a href="{{ route('admin.chambers') }}"
                class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition border border-gray-200 hover:border-primary-600 text-center">
                <div class="text-sm font-medium text-gray-900">View Chambers</div>
                <div class="text-xs text-gray-500 mt-1">{{ $stats['total_chambers'] }} total</div>
            </a>
        </div>
    </div>
@endsection