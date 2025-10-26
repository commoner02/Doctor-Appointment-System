@extends('layouts.app')

@section('title', 'Patient Dashboard')

@section('content')
    <div class="space-y-4">
        <!-- Welcome -->
        <div class="bg-white rounded-lg shadow-sm p-4">
            <h1 class="text-xl font-bold text-text-dark">Welcome, {{ auth()->user()->name }}</h1>
            <p class="text-text-light text-sm">Manage your healthcare</p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-primary-100 rounded-lg">
                        <i class="fas fa-calendar-check text-primary-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-text-light">Total</p>
                        <p class="text-lg font-bold text-text-dark">{{ $totalAppointments }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-primary-100 rounded-lg">
                        <i class="fas fa-clock text-primary-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-text-light">Upcoming</p>
                        <p class="text-lg font-bold text-text-dark">{{ $upcomingAppointments->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-4 md:col-span-1 col-span-2">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-text-light">Book Now</p>
                        <a href="{{ route('patient.doctors') }}"
                            class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                            Find Doctors →
                        </a>
                    </div>
                    <div class="p-2 bg-primary-100 rounded-lg">
                        <i class="fas fa-user-md text-primary-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Appointments Table -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-4 py-3 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-text-dark">Upcoming Appointments</h2>
            </div>
            <div class="overflow-x-auto">
                @if($upcomingAppointments->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-text-light uppercase tracking-wider">
                                    Doctor</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-text-light uppercase tracking-wider">
                                    Chamber</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-text-light uppercase tracking-wider">
                                    Working Days</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-text-light uppercase tracking-wider">
                                    Time</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-text-light uppercase tracking-wider">
                                    Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-text-light uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($upcomingAppointments as $appointment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm font-medium text-text-dark">Dr.
                                            {{ $appointment->doctor->user->name }}</div>
                                        <div class="text-sm text-text-light">
                                            {{ $appointment->doctor->speciality ?? 'General' }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-text-dark">
                                        {{ $appointment->chamber->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-text-dark">
                                        {{ $appointment->chamber->working_days ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-text-dark">
                                        {{ $appointment->chamber->start_time ?? 'N/A' }} - {{ $appointment->chamber->end_time ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-text-dark">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-times text-text-light text-3xl mb-3"></i>
                        <h3 class="text-lg font-medium text-text-dark mb-2">No Upcoming Appointments</h3>
                        <p class="text-text-light text-sm mb-4">You don't have any scheduled appointments yet.</p>
                        <a href="{{ route('patient.doctors') }}"
                            class="inline-flex items-center px-4 py-2 bg-primary-500 text-white text-sm rounded-lg hover:bg-primary-600">
                            <i class="fas fa-plus mr-2"></i>Book Your First Appointment
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection