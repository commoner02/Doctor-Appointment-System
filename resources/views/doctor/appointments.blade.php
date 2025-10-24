@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">My Appointments</h1>
            <p class="text-gray-600">Manage your patient appointments</p>
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
                                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-user text-blue-600"></i>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-semibold text-gray-900">
                                                            <a href="{{ route('patient.show', $appointment->patient->id) }}"
                                                                class="hover:text-primary-600">
                                                                {{ $appointment->patient->user->name }}
                                                            </a>
                                                        </h3>
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
                                                        @if($appointment->notes)
                                                            <p class="text-sm text-gray-600 mt-1">{{ $appointment->notes }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-3">
                                                    <!-- Status Badge -->
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

                                                    <!-- Action Buttons -->
                                                    @if($status === 'pending')
                                                        <form action="{{ route('appointments.update-status', $appointment->id) }}" method="POST"
                                                            class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="confirmed">
                                                            <button type="submit"
                                                                class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200">
                                                                Confirm
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if(in_array($status, ['confirmed', 'pending']))
                                                        <form action="{{ route('appointments.update-status', $appointment->id) }}" method="POST"
                                                            class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="completed">
                                                            <button type="submit"
                                                                class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded-lg hover:bg-green-200">
                                                                Complete
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if($appointment->fee && $appointment->payment_status !== 'paid')
                                                        <form action="{{ route('appointments.update-payment', $appointment->id) }}" method="POST"
                                                            class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="payment_status" value="paid">
                                                            <button type="submit"
                                                                class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded-lg hover:bg-green-200">
                                                                Mark Paid
                                                            </button>
                                                        </form>
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