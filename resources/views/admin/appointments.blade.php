@extends('layouts.app')

@section('title', 'Appointments')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-900">Appointments</h1>
                <div class="text-sm text-gray-600">{{ $appointments->total() }} total</div>
            </div>
        </div>

        <!-- Appointments Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Doctor</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($appointments as $appointment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $appointment->patient->user->name }}
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $appointment->doctor->user->name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                </td>
                                <td class="px-4 py-2">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full
                                                    {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $appointment->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full
                                                    {{ $appointment->payment_status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $appointment->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $appointment->payment_status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($appointment->payment_status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                    No appointments found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($appointments->hasPages())
            <div class="flex justify-center mt-4">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>
@endsection