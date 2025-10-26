@extends('layouts.app')

@section('title', 'Find Doctors')

@section('content')
    <div class="space-y-3">
        <!-- Search Section -->
        <div class="bg-white shadow-sm p-3 border border-gray-200">
            <h1 class="text-xl font-bold text-text-dark mb-3">Find Doctors</h1>

            <form method="GET" action="{{ route('patient.doctors') }}" class="space-y-3">
                <div class="grid md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-text-default mb-1">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Doctor name or speciality"
                            class="w-full px-3 py-2 border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-default mb-1">Speciality</label>
                        <select name="speciality"
                            class="w-full px-3 py-2 border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
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
                            class="flex-1 px-3 py-2 bg-primary-500 text-white hover:bg-primary-600 font-medium">
                            <i class="fas fa-search mr-2"></i>Search
                        </button>
                        <a href="{{ route('patient.doctors') }}"
                            class="px-3 py-2 bg-gray-100 text-text-default hover:bg-gray-200">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Doctors Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-3">
            @forelse($doctors as $doctor)
                <div class="bg-white shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-3 text-center">
                        <!-- Doctor Icon -->
                        <div class="w-14 h-14 bg-primary-100 flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-user-md text-primary-600 text-xl"></i>
                        </div>

                        <!-- Doctor Info -->
                        <h3 class="text-lg font-semibold text-text-dark mb-1"> {{ $doctor->user->name }}</h3>
                        <p class="text-primary-600 font-medium text-sm mb-1">{{ $doctor->speciality ?? 'General Physician' }}
                        </p>

                        @if($doctor->qualifications)
                            <p class="text-text-light text-sm mb-1">{{ $doctor->qualifications }}</p>
                        @endif

                        @if($doctor->experience)
                            <p class="text-text-light text-sm mb-1">{{ $doctor->experience }} years experience</p>
                        @endif

                        @if($doctor->chambers->count() > 0)
                            <p class="text-text-light text-xs mb-1">{{ $doctor->chambers->first()->name }}</p>
                            <p class="text-text-light text-xs mb-2">
                                {{ $doctor->chambers->first()->start_time }} - {{ $doctor->chambers->first()->end_time }}
                                @if($doctor->chambers->first()->working_days)
                                    • {{ $doctor->chambers->first()->working_days }}
                                @endif
                            </p>
                            <p class="text-text-light text-xs mb-2">Fee: ${{ $doctor->chambers->first()->fee ?? 'N/A' }}</p>
                        @endif

                        <!-- Book Now Button -->
                        <a href="{{ route('appointments.create', $doctor->id) }}"
                            class="w-full px-3 py-2 bg-primary-500 text-white hover:bg-primary-600 text-sm font-medium inline-block text-center">
                            Book Now
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-6">
                    <i class="fas fa-user-md text-text-light text-2xl mb-2"></i>
                    <h3 class="text-base font-medium text-text-dark mb-1">No doctors found</h3>
                    <p class="text-text-light text-xs mb-3">Try adjusting your search criteria.</p>
                    <a href="{{ route('patient.doctors') }}"
                        class="inline-flex items-center px-3 py-2 bg-primary-500 text-white text-xs hover:bg-primary-600">
                        <i class="fas fa-refresh mr-1"></i>Show All Doctors
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($doctors->hasPages())
            <div class="flex justify-center pt-2">
                {{ $doctors->links() }}
            </div>
        @endif
    </div>
@endsection