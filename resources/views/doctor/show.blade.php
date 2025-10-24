@extends('layouts.app')

@section('title', 'Find Doctors')

@section('content')
    <div class="container">
        <h2 class="mb-4">Find Doctors</h2>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('patient.doctors') }}">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by name or speciality" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-5">
                            <select name="speciality" class="form-select">
                                <option value="">All Specialities</option>
                                @foreach($specialities as $speciality)
                                    <option value="{{ $speciality }}"
                                        {{ request('speciality') == $speciality ? 'selected' : '' }}>
                                        {{ $speciality }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @forelse($doctors as $doctor)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</h5>
                            <p class="text-muted mb-2">{{ $doctor->speciality }}</p>
                            <p class="mb-2"><small>{{ $doctor->qualifications }}</small></p>
                            <p class="mb-2"><i class="bi bi-telephone"></i> {{ $doctor->phone }}</p>

                            @if($doctor->chambers->count() > 0)
                                <p class="mb-2"><strong>Chambers:</strong></p>
                                @foreach($doctor->chambers as $chamber)
                                    <small class="d-block">• {{ $chamber->chamber_name }} - BDT
                                        {{ number_format($chamber->visiting_fee, 2) }}</small>
                                @endforeach
                            @endif

                            <a href="{{ route('appointments.create', $doctor) }}"
                                class="btn btn-primary btn-sm mt-2">Book Appointment</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">No doctors found</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@section('title', 'Doctor Profile')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ url()->previous() }}" class="inline-flex items-center text-primary-600 hover:text-primary-700">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <!-- Doctor Profile Card -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6">
            <div class="flex items-start space-x-6">
                <!-- Doctor Avatar -->
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 bg-primary-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-md text-primary-600 text-3xl"></i>
                    </div>
                </div>

                <!-- Doctor Info -->
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Dr. {{ $doctor->user->name }}</h1>
                            <p class="text-lg text-primary-600 font-medium">{{ $doctor->speciality ?? 'General Physician' }}</p>
                            
                            @if($doctor->qualifications)
                                <p class="text-gray-600 mt-1">{{ $doctor->qualifications }}</p>
                            @endif
                            
                            @if($doctor->experience)
                                <p class="text-gray-600 mt-1">{{ $doctor->experience }} years of experience</p>
                            @endif
                        </div>

                        @if(auth()->user()->role === 'patient')
                            <a href="{{ route('appointments.create', $doctor->id) }}" 
                               class="px-6 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 font-medium">
                                <i class="fas fa-calendar-plus mr-2"></i>Book Appointment
                            </a>
                        @endif
                    </div>

                    @if($doctor->bio)
                        <div class="mt-4">
                            <h3 class="font-semibold text-gray-900 mb-2">About</h3>
                            <p class="text-gray-600">{{ $doctor->bio }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chambers -->
    @if($doctor->chambers->count() > 0)
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Practice Locations</h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach($doctor->chambers as $chamber)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h3 class="font-semibold text-gray-900 mb-2">{{ $chamber->name }}</h3>
                            
                            @if($chamber->address)
                                <p class="text-sm text-gray-600 mb-2">
                                    <i class="fas fa-map-marker-alt mr-2"></i>{{ $chamber->address }}
                                </p>
                            @endif

                            @if($chamber->phone)
                                <p class="text-sm text-gray-600 mb-2">
                                    <i class="fas fa-phone mr-2"></i>{{ $chamber->phone }}
                                </p>
                            @endif

                            @if($chamber->visiting_hours)
                                <p class="text-sm text-gray-600 mb-2">
                                    <i class="fas fa-clock mr-2"></i>{{ $chamber->visiting_hours }}
                                </p>
                            @endif

                            @if($chamber->fee)
                                <p class="text-sm font-medium text-gray-900 mb-3">
                                    <i class="fas fa-money-bill mr-2"></i>Consultation Fee: ৳{{ number_format($chamber->fee) }}
                                </p>
                            @endif

                            @if(auth()->user()->role === 'patient')
                                <a href="{{ route('appointments.create', $doctor->id) }}?chamber={{ $chamber->id }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-primary-500 text-white text-sm rounded-lg hover:bg-primary-600">
                                    <i class="fas fa-calendar-plus mr-1"></i>Book Here
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection