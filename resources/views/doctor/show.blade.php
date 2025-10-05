@extends('layouts.app')

@section('title', 'Doctor Profile')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2>Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</h2>
                    <p><strong>Specialty:</strong> {{ $doctor->specialty }}</p>
                    <p><strong>Department:</strong> {{ $doctor->department->name }}</p>
                    <p><strong>Phone:</strong> {{ $doctor->phone }}</p>
                    <p><strong>About:</strong> {{ $doctor->department->description }}</p>

                    <!-- Available Schedules -->
                    <h4 class="mt-4">Available Schedules</h4>
                    @if($doctor->schedules->count() > 0)
                        @foreach($doctor->schedules->where('is_available', true) as $schedule)
                        <div class="card mb-2">
                            <div class="card-body">
                                <h6>{{ $schedule->day }}</h6>
                                <p class="mb-1">Time: {{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
                                <p class="mb-1">Location: {{ $schedule->chamber->chamber_name }}</p>
                                <p class="mb-1">Address: {{ $schedule->chamber->chamber_location }}</p>
                                <small class="text-muted">Slot: {{ $schedule->slot_duration }} minutes</small>
                            </div>
                        </div>
                        @endforeach
                        
                        @auth
                            @if(auth()->user()->isPatient())
                                <a href="{{ route('appointments.create', $doctor->id) }}" class="btn btn-primary mt-3">
                                    Book Appointment
                                </a>
                            @endif
                        @endauth
                    @else
                        <p>No available schedules at the moment.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection