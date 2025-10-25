@extends('layouts.app')

@section('title', 'Find Doctors')

@section('content')
<div class="space-y-6">
    <!-- Search Section -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h1 class="text-2xl font-semibold text-gray-900 mb-4">Find Doctors</h1>
        <form method="GET" action="{{ route('patient.doctors') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or speciality" class="px-4 py-3 border rounded-lg text-base">
            <select name="speciality" class="px-4 py-3 border rounded-lg text-base">
                <option value="">All Specialities</option>
                <option value="Cardiology" {{ request('speciality') === 'Cardiology' ? 'selected' : '' }}>Cardiology</option>
                <option value="Dermatology" {{ request('speciality') === 'Dermatology' ? 'selected' : '' }}>Dermatology</option>
                <option value="Gynecology & Obstetrics" {{ request('speciality') === 'Gynecology & Obstetrics' ? 'selected' : '' }}>Gynecology</option>
                <option value="Internal Medicine" {{ request('speciality') === 'Internal Medicine' ? 'selected' : '' }}>Internal Medicine</option>
                <option value="Neurology" {{ request('speciality') === 'Neurology' ? 'selected' : '' }}>Neurology</option>
                <option value="Ophthalmology" {{ request('speciality') === 'Ophthalmology' ? 'selected' : '' }}>Ophthalmology</option>
                <option value="Orthopedics" {{ request('speciality') === 'Orthopedics' ? 'selected' : '' }}>Orthopedics</option>
                <option value="Pediatrics" {{ request('speciality') === 'Pediatrics' ? 'selected' : '' }}>Pediatrics</option>
            </select>
            <button type="submit" class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Search</button>
        </form>
    </div>

    <!-- Doctors Grid -->
    @if($doctors->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($doctors as $doctor)
                <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
                    <div class="text-center mb-4">
                        <div class="w-16 h-16 bg-primary-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                            <span class="text-2xl font-semibold text-primary-600">{{ substr($doctor->user->name, 0, 1) }}</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $doctor->user->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $doctor->speciality }}</p>
                    </div>

                    <div class="space-y-2 text-sm text-gray-700 mb-4">
                        <div class="flex items-center justify-center gap-2">
                            <span class="text-gray-500">Experience:</span>
                            <span>{{ $doctor->experience }} years</span>
                        </div>
                        <div class="text-xs text-gray-500 text-center">{{ $doctor->qualifications }}</div>
                    </div>

                    @if($doctor->chambers->count() > 0)
                        <div class="text-xs text-gray-600 mb-3 text-center">
                            <div class="font-medium">{{ $doctor->chambers->first()->name }}</div>
                            <div class="mt-1">{{ $doctor->chambers->first()->start_time }} - {{ $doctor->chambers->first()->end_time }}</div>
                            @if($doctor->chambers->first()->working_days)
                                <div class="mt-1 text-gray-500">{{ $doctor->chambers->first()->working_days }}</div>
                            @endif
                        </div>
                    @endif

                    <a href="{{ route('appointments.create', $doctor->id) }}" class="block w-full text-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                        Book Appointment
                    </a>
                </div>
            @endforeach
        </div>

        @if($doctors->hasPages())
            <div class="flex justify-center">
                {{ $doctors->links() }}
            </div>
        @endif
    @else
        <div class="bg-white rounded-lg shadow-sm p-12 text-center text-gray-500">
            No doctors found. Try different search criteria.
        </div>
    @endif
</div>
@endsection