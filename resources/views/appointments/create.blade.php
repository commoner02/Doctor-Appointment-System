@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ url()->previous() }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 mb-4">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Book Appointment</h1>
            <p class="text-gray-600">Schedule an appointment with Dr. {{ $doctor->user->name }}</p>
        </div>

        <!-- Doctor Info Card -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-md text-primary-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Dr. {{ $doctor->user->name }}</h3>
                    <p class="text-primary-600">{{ $doctor->speciality ?? 'General Physician' }}</p>
                    @if($doctor->qualifications)
                        <p class="text-sm text-gray-600">{{ $doctor->qualifications }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Appointment Form -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                <div>
                    <label for="chamber_id" class="block text-sm font-medium text-gray-700 mb-2">Select Chamber</label>
                    <select id="chamber_id" name="chamber_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Select a chamber</option>
                        @foreach($chambers as $chamber)
                            <option value="{{ $chamber->id }}" {{ request('chamber') == $chamber->id ? 'selected' : '' }}>
                                {{ $chamber->name }} - {{ $chamber->address }}
                                @if($chamber->fee)
                                    (Fee: ৳{{ number_format($chamber->fee) }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('chamber_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-2">Appointment Date
                        *</label>
                    <input type="date" id="appointment_date" name="appointment_date" value="{{ old('appointment_date') }}"
                        min="{{ date('Y-m-d') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('appointment_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="appointment_time" class="block text-sm font-medium text-gray-700 mb-2">Preferred
                        Time</label>
                    <input type="time" id="appointment_time" name="appointment_time" value="{{ old('appointment_time') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('appointment_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        placeholder="Brief description of your health concern (optional)">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-info-circle text-yellow-600 mt-1 mr-3"></i>
                        <div class="text-sm text-yellow-700">
                            <p class="font-medium mb-1">Important Notes:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Please arrive 15 minutes before your appointment time</li>
                                <li>Bring your previous medical records if any</li>
                                <li>The doctor will confirm your appointment</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 font-medium">
                        <i class="fas fa-calendar-check mr-2"></i>Book Appointment
                    </button>
                    <a href="{{ url()->previous() }}"
                        class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 text-center rounded-lg hover:bg-gray-200 font-medium">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection