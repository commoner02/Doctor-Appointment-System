@extends('layouts.app')

@section('title', 'Patient Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
            <p class="text-gray-600">Manage your appointments and healthcare journey.</p>
        </div>

        <!-- Stats -->
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-primary-100 rounded-lg">
                        <i class="fas fa-calendar-check text-primary-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Appointments</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalAppointments }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-clock text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Upcoming</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $upcomingAppointments->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Quick Book</p>
                        <a href="{{ route('patient.doctors') }}"
                            class="text-primary-600 hover:text-primary-700 font-medium">
                            Find Doctors →
                        </a>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-user-md text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Appointments -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Upcoming Appointments</h2>
            </div>
            <div class="p-6">
                @if($upcomingAppointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingAppointments as $appointment)
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-md text-primary-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Dr. {{ $appointment->doctor->user->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $appointment->doctor->speciality ?? 'General' }}</p>
                                        <p class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Scheduled
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-times text-gray-400 text-3xl mb-4"></i>
                        <p class="text-gray-600 mb-4">No upcoming appointments</p>
                        <a href="{{ route('patient.doctors') }}"
                            class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600">
                            <i class="fas fa-plus mr-2"></i>Book Appointment
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection