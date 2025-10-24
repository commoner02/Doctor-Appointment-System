@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">My Appointments</h1>
                    <p class="text-gray-600">View and manage your medical appointments</p>
                </div>
                <a href="{{ route('patient.doctors') }}"
                    class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 font-medium">
                    <i class="fas fa-plus mr-2"></i>Book New Appointment
                </a>
            </div>
        </div>

        <!-- Appointments List -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6">
                @if($appointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($appointments as $appointment)
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-4">
                                                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-user-md text-primary-600"></i>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-semibold text-gray-900">
                                                            <a href="{{ route('doctor.show', $appointment->doctor->id) }}"
                                                                class="hover:text-primary-600">
                                                                Dr. {{ $appointment->doctor->user->name }}
                                                            </a>
                                                        </h3>
                                                        <p class="text-sm text-gray-600">{{ $appointment->doctor->speciality ?? 'General' }}</p>
                                                        <div class="flex items-center space-x-4 mt-1 text-sm text-gray-500">
                                                            <span>
                                                                <i class="fas fa-calendar mr-1"></i>
                                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                                            </span>
                                                            @if($appointment->appointment_time)
                                                                <span>
                                                                    <i class="fas fa-clock mr-1"></i>
                                                                    {{ $appointment->appointment_time }}
                                                                </span>
                                                            @endif
                                                            @if($appointment->chamber)
                                                                <span>
                                                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                                                    {{ $appointment->chamber->name }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    @php
                                                        $status = $appointment->status ?? 'pending';
                                                        $statusColors = [
                                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                                            'confirmed' => 'bg-blue-100 text-blue-800',
                                                            'completed' => 'bg-green-100 text-green-800',
                                                            'cancelled' => 'bg-red-100 text-red-800'
                                                        ];
                                                    @endphp
                             <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$status] ?? $statusColors['pending'] }}">
                                                        {{ ucfirst($status) }}
                                                    </span>
                                                    @if($appointment->fee)
                                                        <p class="text-sm text-gray-600 mt-1">Fee: ৳{{ number_format($appointment->fee) }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-calendar-times text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-600 text-lg mb-4">No appointments found</p>
                        <a href="{{ route('patient.doctors') }}"
                            class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600">
                            <i class="fas fa-plus mr-2"></i>Book Your First Appointment
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pagination -->
        @if($appointments->hasPages())
            <div class="flex justify-center">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>
@endsection