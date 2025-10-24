@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">My Appointments</h1>
            <div class="text-sm text-gray-500">
                Total: {{ $appointments->total() }} appointments
            </div>
        </div>
    </div>

    <!-- Appointments List -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6">
            @if($appointments->count() > 0)
                <div class="space-y-4">
                    @foreach($appointments as $appointment)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <!-- Appointment Info -->
                                <div class="flex items-center space-x-4 flex-1">
                                    <!-- Patient Avatar -->
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    
                                    <!-- Details -->
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-4 mb-2">
                                            <h3 class="font-semibold text-gray-900">
                                                {{ $appointment->patient->user->name ?? 'N/A' }}
                                            </h3>
                                            <span class="text-gray-400">•</span>
                                            <span class="text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                                @if($appointment->appointment_time)
                                                    at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                                @endif
                                            </span>
                                        </div>
                                        
                                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                                            @if($appointment->chamber)
                                                <span>
                                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                                    {{ $appointment->chamber->name }}
                                                </span>
                                            @endif
                                            
                                            @if($appointment->fee)
                                                <span>
                                                    <i class="fas fa-money-bill mr-1"></i>
                                                    ৳{{ number_format($appointment->fee) }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        @if($appointment->notes)
                                            <p class="text-sm text-gray-600 mt-1 italic">
                                                "{{ Str::limit($appointment->notes, 80) }}"
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Status & Actions -->
                                <div class="flex items-center space-x-3">
                                    <!-- Status Badges -->
                                    <div class="text-right">
                                        @php
                                            $status = $appointment->status ?? 'scheduled';
                                            $statusColors = [
                                                'scheduled' => 'bg-yellow-100 text-yellow-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800'
                                            ];
                                            
                                            $paymentStatus = $appointment->payment_status ?? 'pending';
                                            $paymentColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'paid' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800'
                                            ];
                                        @endphp
                                        
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$status] ?? $statusColors['scheduled'] }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                        
                                        @if($appointment->fee)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paymentColors[$paymentStatus] ?? $paymentColors['pending'] }} mt-1">
                                                {{ ucfirst($paymentStatus) }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex flex-col space-y-1">
                                        @if($status === 'scheduled')
                                            <form action="{{ route('appointments.update-status', $appointment->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded hover:bg-green-200">
                                                    Complete
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($status !== 'cancelled')
                                            <form action="{{ route('appointments.update-status', $appointment->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded hover:bg-red-200" 
                                                        onclick="return confirm('Cancel this appointment?')">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif

                                        @if($appointment->fee && $paymentStatus === 'pending')
                                            <form action="{{ route('appointments.update-status', $appointment->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="payment_status" value="paid">
                                                <button type="submit" class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded hover:bg-blue-200">
                                                    Mark Paid
                                                </button>
                                            </form>
                                        @endif
                                    </div>
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