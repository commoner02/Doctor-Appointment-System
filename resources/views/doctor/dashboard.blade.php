@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Welcome, Dr. {{ auth()->user()->name }}!</h1>
            <p class="text-gray-600">Manage your practice and patient appointments.</p>
        </div>

        <!-- Stats -->
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-primary-100 rounded-lg">
                        <i class="fas fa-calendar-check text-primary-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Appointments</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalAppointments }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-primary-100 rounded-lg">
                        <i class="fas fa-clinic-medical text-primary-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">My Chambers</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalChambers }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-primary-100 rounded-lg">
                        <i class="fas fa-clock text-primary-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Today's Appointments</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $todayAppointments->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Appointments Table -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-900">Today's Appointments</h2>
                <a href="{{ route('doctor.appointments') }}"
                    class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    View All →
                </a>
            </div>
            <div class="p-6">
                @if($todayAppointments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-primary-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-primary-700 uppercase">Date</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-primary-700 uppercase">Chamber</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-primary-700 uppercase">Patient</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-primary-700 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($todayAppointments as $appointment)
                                                    <tr class="hover:bg-primary-50">
                                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                                        </td>
                                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                            @if($appointment->chamber)
                                                                {{ $appointment->chamber->name }} ({{ $appointment->chamber->start_time }} -
                                                                {{ $appointment->chamber->end_time }})
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                            {{ $appointment->patient->user->name ?? 'N/A' }}
                                                        </td>
                                                        <td class="px-4 py-2 whitespace-nowrap">
                                                            @php
                                                                $status = $appointment->status ?? 'scheduled';
                                                                $statusColors = [
                                                                    'scheduled' => 'bg-yellow-100 text-yellow-800',
                                                                    'completed' => 'bg-green-100 text-green-800',
                                                                    'cancelled' => 'bg-red-100 text-red-800'
                                                                ];
                                                            @endphp
                                     <span
                                                                class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium {{ $statusColors[$status] ?? $statusColors['scheduled'] }}">
                                                                {{ ucfirst($status) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-check text-gray-400 text-3xl mb-4"></i>
                        <p class="text-gray-600 mb-4">No appointments scheduled for today</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection