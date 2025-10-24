
@extends('layouts.app')

@section('title', 'All Appointments')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">All Appointments</h1>
                <p class="text-gray-600">Manage system-wide appointments</p>
            </div>
            <div class="text-sm text-gray-500">
                Total: {{ $appointments->total() }} appointments
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="GET" class="space-y-4">
            <div class="grid md:grid-cols-4 gap-4">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search patient or doctor..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div>
                    <input type="date" name="date" value="{{ request('date') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="flex space-x-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                    <a href="{{ route('appointments.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                        <i class="fas fa-refresh"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Quick Stats -->
    <div class="grid md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-check text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Confirmed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['confirmed'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Completed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['completed'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Cancelled</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['cancelled'] ?? 0 }}</p>
                </div>
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
                                            <span class="text-gray-400">→</span>
                                            <h3 class="font-semibold text-primary-600">
                                                Dr. {{ $appointment->doctor->user->name ?? 'N/A' }}
                                            </h3>
                                        </div>
                                        
                                        <div class="flex items-center space-x-6 text-sm text-gray-500">
                                            <span>
                                                <i class="fas fa-calendar mr-1"></i>
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                            </span>
                                            
                                            @if($appointment->appointment_time)
                                                <span>
                                                    <i class="fas fa-clock mr-1"></i>
                                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                                </span>
                                            @endif
                                            
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
                                            $status = $appointment->status ?? 'pending';
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'confirmed' => 'bg-blue-100 text-blue-800',
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
                                        
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$status] ?? $statusColors['pending'] }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                        
                                        @if($appointment->fee)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paymentColors[$paymentStatus] ?? $paymentColors['pending'] }} mt-1">
                                                {{ ucfirst($paymentStatus) }}
                                            </span>
                                        @endif
                                        
                                        <div class="text-xs text-gray-400 mt-1">
                                            {{ $appointment->created_at->format('M d, g:i A') }}
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    @if(auth()->user()->isAdmin() || auth()->user()->isDoctor())
                                        <div class="flex flex-col space-y-1">
                                            @if($status === 'pending')
                                                <form action="{{ route('appointments.update-status', $appointment->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded hover:bg-blue-200">
                                                        Confirm
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if(in_array($status, ['confirmed', 'pending']))
                                                <form action="{{ route('appointments.update-status', $appointment->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded hover:bg-green-200">
                                                        Complete
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if(!in_array($status, ['completed', 'cancelled']))
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
                                        </div>
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
                    @if(auth()->user()->isPatient())
                        <a href="{{ route('patient.doctors') }}" class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600">
                            <i class="fas fa-plus mr-2"></i>Book New Appointment
                        </a>
                    @endif
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

@push('scripts')
<script>
// Auto-refresh every 30 seconds for real-time updates
setInterval(function() {
    if (!document.hidden) {
        window.location.reload();
    }
}, 30000);

// Quick status update without page reload
function updateStatus(appointmentId, status) {
    if (confirm(`Change status to ${status}?`)) {
        fetch(`/appointments/${appointmentId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>
@endpush
@endsection