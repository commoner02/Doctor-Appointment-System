@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
    <div class="space-y-3">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-3">
            <div class="flex justify-between items-center">
                <h1 class="text-lg font-bold text-gray-900">My Appointments</h1>
                <div class="text-sm text-gray-500">
                    Total: {{ $appointments->total() }}
                </div>
            </div>
        </div>

        <!-- Appointments Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            @if($appointments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-sm font-medium text-blue-700 uppercase">Patient</th>
                                <th class="px-3 py-2 text-left text-sm font-medium text-blue-700 uppercase">Date & Time</th>
                                <th class="px-3 py-2 text-left text-sm font-medium text-blue-700 uppercase">Chamber</th>
                                <th class="px-3 py-2 text-left text-sm font-medium text-blue-700 uppercase">Fee</th>
                                <th class="px-3 py-2 text-left text-sm font-medium text-blue-700 uppercase">Status</th>
                                <th class="px-3 py-2 text-left text-sm font-medium text-blue-700 uppercase">Payment</th>
                                <th class="px-3 py-2 text-left text-sm font-medium text-blue-700 uppercase min-w-64">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($appointments as $appointment)
                                <tr class="hover:bg-blue-50">
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $appointment->patient->user->name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                        @if($appointment->chamber)({{ $appointment->chamber->start_time }} -
                                        {{ $appointment->chamber->end_time }})
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                        {{ $appointment->chamber ? $appointment->chamber->name : 'N/A' }}
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                        @if($appointment->chamber && $appointment->chamber->fee) ৳{{ number_format($appointment->chamber->fee) }} @else N/A @endif
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        @php
                                            $status = $appointment->status ?? 'scheduled';
                                            $statusColors = [
                                                'scheduled' => 'bg-yellow-100 text-yellow-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800'
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium {{ $statusColors[$status] ?? $statusColors['scheduled'] }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        @php
                                            $paymentStatus = $appointment->payment_status ?? 'pending';
                                            $paymentColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'paid' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800'
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium {{ $paymentColors[$paymentStatus] ?? $paymentColors['pending'] }}">
                                            {{ ucfirst($paymentStatus) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm min-w-64">
                                        <div class="space-y-0.5">
                                            <!-- Status Update -->
                                            <form action="{{ route('appointments.update-status', $appointment->id) }}" method="POST" class="flex items-center space-x-1">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" class="border border-gray-300 rounded px-2 py-1 text-sm w-28 appearance-none bg-white">
                                                    <option value="scheduled" {{ $status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                                    <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                                <button type="submit" class="px-2 py-1 text-sm bg-primary-600 text-white rounded hover:bg-primary-700">Update</button>
                                            </form>

                                            <!-- Payment Status Update -->
                                            <form action="{{ route('appointments.update-payment', $appointment->id) }}" method="POST" class="flex items-center space-x-1">
                                                @csrf
                                                @method('PATCH')
                                                <select name="payment_status" class="border border-gray-300 rounded px-2 py-1 text-sm w-28 appearance-none bg-white">
                                                    <option value="pending" {{ $paymentStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="paid" {{ $paymentStatus == 'paid' ? 'selected' : '' }}>Paid</option>
                                                    <option value="cancelled" {{ $paymentStatus == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                                <button type="submit" class="px-2 py-1 text-sm bg-primary-600 text-white rounded hover:bg-primary-700">Update</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-6">
                    <i class="fas fa-calendar-times text-gray-400 text-2xl mb-2"></i>
                    <p class="text-gray-600 text-sm">No appointments found</p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($appointments->hasPages())
            <div class="flex justify-center">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>
@endsection