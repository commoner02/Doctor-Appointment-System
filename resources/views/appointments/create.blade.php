@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Book Appointment with Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('appointments.store') }}">
                        @csrf
                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                        <!-- Doctor Info -->
                        <div class="mb-3">
                            <h5>Doctor Information</h5>
                            <p><strong>Specialty:</strong> {{ $doctor->specialty }}</p>
                            <p><strong>Department:</strong> {{ $doctor->department->name }}</p>
                        </div>

                        <!-- Available Schedules -->
                        <div class="mb-3">
                            <label for="schedule_id" class="form-label">Select Available Schedule</label>
                            <select class="form-select @error('schedule_id') is-invalid @enderror" 
                                    id="schedule_id" name="schedule_id" required>
                                <option value="">Choose a schedule</option>
                                @foreach($doctor->schedules->where('is_available', true) as $schedule)
                                <option value="{{ $schedule->id }}">
                                    {{ $schedule->day }}: {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                    ({{ $schedule->chamber->chamber_name }})
                                </option>
                                @endforeach
                            </select>
                            @error('schedule_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Appointment Date -->
                        <div class="mb-3">
                            <label for="appointment_date" class="form-label">Preferred Date</label>
                            <input type="datetime-local" 
                                   class="form-control @error('appointment_date') is-invalid @enderror" 
                                   id="appointment_date" name="appointment_date" required>
                            @error('appointment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Reason -->
                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason for Visit</label>
                            <textarea class="form-control @error('reason') is-invalid @enderror" 
                                      id="reason" name="reason" rows="3" 
                                      placeholder="Briefly describe your symptoms or reason for appointment" 
                                      required></textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Book Appointment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection