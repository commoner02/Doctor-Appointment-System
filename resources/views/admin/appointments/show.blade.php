@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Back Button -->
        <div>
            <a href="{{ route('admin.appointments') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700">
                <i class="fas fa-arrow-left mr-2"></i>Back to Appointments
            </a>
        </div>

        <!-- Appointment Details -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Appointment Details</h1>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Patient Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Patient Information</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $appointment->patient->user->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $appointment->patient->user->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                            @if($appointment->patient->phone)
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-phone mr-2"></i>{{ $appointment->patient->phone }}
                                </p>
                            @endif
                            @if($appointment->patient->address)
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-2"></i>{{ $appointment->patient->address }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Doctor Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Doctor Information</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-user-md text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Dr. {{ $appointment->doctor->user->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $appointment->doctor->speciality ?? 'General' }}</p>
                                </div>
                            </div>
                            @if($appointment->doctor->qualifications)
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-graduation-cap mr-2"></i>{{ $appointment->doctor->qualifications }}
                                </p>
                            @endif
                            @if($appointment->doctor->experience)
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-clock mr-2"></i>{{ $appointment->doctor->experience }} years experience
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Appointment Details -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Appointment Details</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date & Time</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }}
                                    @if($appointment->appointment_time)
                                        at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                    @endif
                                </p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                @php
                                    $statusColors = [
                                        'scheduled' => 'bg-yellow-100 text-yellow-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800'
                                    ];
                                    $status = $appointment->status ?? 'scheduled';
                                @endphp
                                <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$status] ?? $statusColors['scheduled'] }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </div>

                            @if($appointment->chamber)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Chamber</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $appointment->chamber->name }}</p>
                                    @if($appointment->chamber->address)
                                        <p class="text-sm text-gray-500">{{ $appointment->chamber->address }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="space-y-4">
                            @if($appointment->fee)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Consultation Fee</label>
                                    <p class="mt-1 text-sm text-gray-900">৳{{ number_format($appointment->fee) }}</p>
                                    <p class="text-sm text-gray-500">Payment Status: {{ ucfirst($appointment->payment_status ?? 'pending') }}</p>
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Created</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $appointment->created_at->format('M j, Y g:i A') }}</p>
                            </div>

                            @if($appointment->updated_at && $appointment->updated_at != $appointment->created_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $appointment->updated_at->format('M j, Y g:i A') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                @if($appointment->notes)
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Notes</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $appointment->notes }}</p>
                        </div>
                    </div>
                @endif

                <!-- Admin Actions -->
                @if($appointment->status !== 'completed')
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Admin Actions</h3>
                        <div class="flex space-x-4">
                            @if($appointment->status !== 'completed')
                                <form action="{{ route('admin.appointments.update-status', $appointment->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                                        <i class="fas fa-check mr-2"></i>Mark as Completed
                                    </button>
                                </form>
                            @endif

                            @if($appointment->status !== 'cancelled')
                                <form action="{{ route('admin.appointments.update-status', $appointment->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600"
                                        onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                        <i class="fas fa-times mr-2"></i>Cancel Appointment
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection