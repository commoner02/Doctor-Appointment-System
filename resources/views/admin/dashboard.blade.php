@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
            <p class="text-gray-600">System overview and management</p>
        </div>

        <!-- Pending Verifications Alert -->
        @if($pendingDoctors > 0)
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-800">
                            <strong>{{ $pendingDoctors }} doctors</strong> are waiting for verification approval.
                            <a href="{{ route('admin.doctors', ['status' => 'pending']) }}"
                                class="font-medium underline hover:text-yellow-900">
                                Review now
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Patients</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalPatients }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-user-md text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Verified Doctors</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $verifiedDoctors }}</p>
                        @if($pendingDoctors > 0)
                            <p class="text-xs text-yellow-600">{{ $pendingDoctors }} pending</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <i class="fas fa-calendar-check text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Appointments</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalAppointments }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <i class="fas fa-clinic-medical text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Active Chambers</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalChambers }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Doctor Verifications -->
        @if($pendingDoctorsList->count() > 0)
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-medium text-gray-900">Pending Doctor Verifications</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($pendingDoctorsList as $doctor)
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user-md text-yellow-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Dr. {{ $doctor->user->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $doctor->speciality }} • {{ $doctor->experience }} years</p>
                                    <p class="text-sm text-gray-500">License: {{ $doctor->license_number }}</p>
                                    <p class="text-xs text-gray-400">Registered {{ $doctor->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <form action="{{ route('admin.doctors.verify', $doctor->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1 bg-green-100 text-green-700 rounded hover:bg-green-200">
                                        Verify
                                    </button>
                                </form>
                                <form action="{{ route('admin.doctors.verify', $doctor->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200"
                                        onclick="return confirm('Reject this doctor?')">
                                        Reject
                                    </button>
                                </form>
                                <a href="{{ route('admin.doctors') }}?search={{ $doctor->user->email }}"
                                    class="px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recent Appointments -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 border-b">
                <h3 class="text-lg font-medium text-gray-900">Recent Appointments</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentAppointments as $appointment)
                    <div class="p-6 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-calendar text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">
                                    {{ $appointment->patient->user->name ?? 'N/A' }} → Dr.
                                    {{ $appointment->doctor->user->name ?? 'N/A' }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                    @if($appointment->appointment_time)
                                        at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $appointment->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        No recent appointments
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection