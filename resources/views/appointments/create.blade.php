@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
    <div class="max-w-2xl mx-auto py-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Book Appointment</h1>

            <!-- Doctor Info -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Doctor Details</h2>
                <p class="text-gray-700"><strong>Name:</strong> {{ $doctor->user->name }}</p>
                <p class="text-gray-700"><strong>Speciality:</strong> {{ $doctor->speciality ?? 'General Physician' }}</p>
                @if($doctor->qualifications)
                    <p class="text-gray-700"><strong>Qualifications:</strong> {{ $doctor->qualifications }}</p>
                @endif
                @if($doctor->experience)
                    <p class="text-gray-700"><strong>Experience:</strong> {{ $doctor->experience }} years</p>
                @endif
            </div>

            <!-- Chambers Info -->
            @if($chambers->count() > 0)
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Available Chambers</h2>
                    <div class="space-y-2">
                        @foreach($chambers as $chamber)
                            <div class="border border-gray-200 p-3 rounded">
                                <p class="text-gray-700"><strong>Name:</strong> {{ $chamber->name }}</p>
                                <p class="text-gray-700"><strong>Address:</strong> {{ $chamber->address }}</p>
                                <p class="text-gray-700"><strong>Time:</strong> {{ $chamber->start_time }} -
                                    {{ $chamber->end_time }}</p>
                                <p class="text-gray-700"><strong>Fee:</strong> ${{ $chamber->fee ?? 'N/A' }}</p>
                                @if($chamber->working_days)
                                    <p class="text-gray-700"><strong>Days:</strong> {{ $chamber->working_days }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Booking Form -->
            <form method="POST" action="{{ route('appointments.store') }}">
                @csrf
                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Chamber</label>
                    <select name="chamber_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        <option value="">Choose a chamber</option>
                        @foreach($chambers as $chamber)
                            <option value="{{ $chamber->id }}">{{ $chamber->name }} - ${{ $chamber->fee ?? 'N/A' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Appointment Date</label>
                    <input type="date" name="appointment_date" class="w-full border border-gray-300 rounded px-3 py-2"
                        required min="{{ now()->addDay()->format('Y-m-d') }}">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                    <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded px-3 py-2"
                        placeholder="Any special requests..."></textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                    Book Appointment
                </button>
            </form>
        </div>
    </div>
@endsection