@extends('layouts.app')

@section('title', 'Find Doctors')

@section('content')
    <div class="space-y-6">
        <!-- Search Section -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-4">Find Doctors</h1>

            <form method="GET" action="{{ route('patient.doctors') }}" class="space-y-4">
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Doctor name or speciality"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Speciality</label>
                        <select name="speciality"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">All Specialities</option>
                            @foreach($specialities as $speciality)
                                <option value="{{ $speciality }}" {{ request('speciality') == $speciality ? 'selected' : '' }}>
                                    {{ $speciality }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 font-medium">
                            <i class="fas fa-search mr-2"></i>Search
                        </button>
                        <a href="{{ route('patient.doctors') }}"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Doctors Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($doctors as $doctor)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-md text-primary-600 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Dr. {{ $doctor->user->name }}</h3>
                                <p class="text-primary-600 font-medium">{{ $doctor->speciality ?? 'General Physician' }}</p>
                            </div>
                        </div>

                        @if($doctor->qualifications)
                            <p class="text-sm text-gray-600 mb-2">{{ $doctor->qualifications }}</p>
                        @endif

                        @if($doctor->experience)
                            <p class="text-sm text-gray-600 mb-4">{{ $doctor->experience }} years experience</p>
                        @endif

                        @if($doctor->chambers->count() > 0)
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-700 mb-2">Available at:</p>
                                @foreach($doctor->chambers->take(2) as $chamber)
                                    <p class="text-sm text-gray-600">• {{ $chamber->name }}</p>
                                @endforeach
                                @if($doctor->chambers->count() > 2)
                                    <p class="text-sm text-primary-600">+{{ $doctor->chambers->count() - 2 }} more</p>
                                @endif
                            </div>
                        @endif

                        <div class="flex space-x-2">
                            <a href="{{ route('doctor.show', $doctor->id) }}"
                                class="flex-1 px-3 py-2 text-center bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium">
                                View Profile
                            </a>
                            <a href="{{ route('appointments.create', $doctor->id) }}"
                                class="flex-1 px-3 py-2 text-center bg-primary-500 text-white rounded-lg hover:bg-primary-600 text-sm font-medium">
                                Book Appointment
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-user-md text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-600 text-lg mb-4">No doctors found</p>
                    <a href="{{ route('patient.doctors') }}"
                        class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600">
                        <i class="fas fa-refresh mr-2"></i>Show All Doctors
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($doctors->hasPages())
            <div class="flex justify-center">
                {{ $doctors->links() }}
            </div>
        @endif
    </div>
@endsection