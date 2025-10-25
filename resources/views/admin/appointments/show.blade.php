
@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-4">
        <div class="flex items-center justify-between">
            <h1 class="text-lg font-semibold text-gray-900">Appointment Details</h1>
            <a href="{{ route('admin.appointments') }}" class="px-3 py-1 bg-gray-100 text-gray-700 rounded text-sm hover:bg-gray-200">Back</a>
        </div>
    </div>

    <!-- Appointment Info -->
    <div class="bg-white rounded-lg shadow-sm p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Patient Info -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-2">Patient</h3>
                <div class="text-sm space-y-1">
                    <div><strong>Name:</strong> {{ $appointment->patient->user->name }}</div>
                    <div><strong>Email:</strong> {{ $appointment->patient->user->email }}</div>
                    <div><strong>Phone:</strong> {{ $appointment->patient->phone ?? $appointment->patient->user->phone ?? 'N/A' }}</div>
                    @if($appointment->patient->blood_group)
                        <div><strong>Blood Group:</strong> {{ $appointment->patient->blood_group }}</div>
                    @endif
                </div>
            </div>

            <!-- Doctor Info -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-2">Doctor</h3>
                <div class="text-sm space-y-1">
                    <div><strong>Name:</strong> {{ $appointment->doctor->user->name }}</div>
                    <div><strong>Speciality:</strong> {{ $appointment->doctor->speciality ?? 'General' }}</div>
                    <div><strong>Email:</strong> {{ $appointment->doctor->user->email }}</div>
                    <div><strong>Phone:</strong> {{ $appointment->doctor->phone ?? $appointment->doctor->user->phone ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Appointment Details -->
        <div class="mt-4 pt-4 border-t border-gray-200">
            <h3 class="text-sm font-semibold text-gray-900 mb-2">Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="space-y-1">
                    <div><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</div>
                    <div><strong>Status:</strong>
                        <span class="px-2 py-1 text-xs rounded-full ml-1
                            {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $appointment->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>
                    <div><strong>Payment:</strong>
                        <span class="px-2 py-1 text-xs rounded-full ml-1
                            {{ $appointment->payment_status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $appointment->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $appointment->payment_status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($appointment->payment_status) }}
                        </span>
                    </div>
                </div>
                <div class="space-y-1">
                    <div><strong>Chamber:</strong> {{ $appointment->chamber->name ?? 'N/A' }}</div>
                    <div><strong>Fee:</strong> ৳{{ number_format($appointment->chamber->fee ?? 0, 2) }}</div>
                    <div><strong>Created:</strong> {{ $appointment->created_at->format('M d, Y H:i') }}</div>
                </div>
            </div>
        </div>

        @if($appointment->reason)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <h4 class="text-sm font-semibold text-gray-900 mb-1">Reason:</h4>
                <p class="text-sm text-gray-700">{{ $appointment->reason }}</p>
            </div>
        @endif

        @if($appointment->notes)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <h4 class="text-sm font-semibold text-gray-900 mb-1">Notes:</h4>
                <p class="text-sm text-gray-700">{{ $appointment->notes }}</p>
            </div>
        @endif
    </div>

    <!-- Actions -->
    <div class="bg-white rounded-lg shadow-sm p-4">
        <h3 class="text-sm font-semibold text-gray-900 mb-2">Update Status</h3>
        <form method="POST" action="{{ route('admin.appointments.update-status', $appointment->id) }}" class="flex items-center gap-2">
            @csrf @method('PATCH')
            <select name="status" class="px-3 py-1 border rounded text-sm">
                <option value="scheduled" {{ $appointment->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="px-3 py-1 bg-primary-600 text-white rounded text-sm hover:bg-primary-700">Update</button>
        </form