@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-gray-900">My Appointments</h1>
                <a href="{{ route('patient.doctors') }}"
                    class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Book New</a>
            </div>
        </div>

        @if($appointments->count() > 0)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Doctor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Chamber</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Working Days</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($appointments as $appointment)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $appointment->doctor->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $appointment->doctor->speciality }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $appointment->chamber->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $appointment->chamber->working_days ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $appointment->chamber->start_time ?? 'N/A' }} -
                                        {{ $appointment->chamber->end_time ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full
                                                                            {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                                            {{ $appointment->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : '' }}
                                                                            {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if($appointments->hasPages())
                <div class="flex justify-center">
                    {{ $appointments->links() }}
                </div>
            @endif
        @else
            <div class="bg-white rounded-lg shadow-sm p-12 text-center text-gray-500">
                <p class="mb-4">No appointments yet</p>
                <a href="{{ route('patient.doctors') }}"
                    class="inline-block px-6 py-2 bg-primary-600 text-white rounded-lg">Find Doctors</a>
            </div>
        @endif
    </div>
@endsection