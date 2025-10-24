@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Welcome, Dr. {{ auth()->user()->name }}!</h1>
            <p class="text-gray-600">Manage your practice and patient appointments.</p>
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
                        <i class="fas fa-clinic-medical text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">My Chambers</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalChambers }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-clock text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Today's Appointments</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $todayAppointments->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Appointments -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-900">Today's Appointments</h2>
                <a href="{{ route('doctor.appointments') }}"
                    class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    View All →
                </a>
            </div>
            <div class="p-6">
                @if($todayAppointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($todayAppointments as $appointment)
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $appointment->patient->user->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $appointment->appointment_time ?? 'Time TBD' }}</p>
                                        @if($appointment->chamber)
                                            <p class="text-sm text-gray-500">{{ $appointment->chamber->name }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded-lg hover:bg-green-200">
                                        Complete
                                    </button>
                                    <button class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded-lg hover:bg-red-200">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-check text-gray-400 text-3xl mb-4"></i>
                        <p class="text-gray-600 mb-4">No appointments scheduled for today</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Manage Chambers</h3>
                        <p class="text-gray-600 text-sm">Add or update your practice locations</p>
                    </div>
                    <div class="p-3 bg-primary-100 rounded-lg">
                        <i class="fas fa-clinic-medical text-primary-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('doctor.chambers') }}"
                        class="text-primary-600 hover:text-primary-700 font-medium text-sm">
                        Manage Chambers →
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">View Profile</h3>
                        <p class="text-gray-600 text-sm">Update your professional information</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-user-md text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('profile.edit') }}"
                        class="text-primary-600 hover:text-primary-700 font-medium text-sm">
                        Edit Profile →
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection