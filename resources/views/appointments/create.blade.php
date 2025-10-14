@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Book Appointment</div>
                    <div class="card-body">
                        <h5>Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</h5>
                        <p><strong>Speciality:</strong> {{ $doctor->speciality }}</p>
                        <p><strong>Phone:</strong> {{ $doctor->phone }}</p>

                        <form method="POST" action="{{ route('appointments.store') }}">
                            @csrf
                            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                            <div class="mb-3">
                                <label for="chamber_id" class="form-label">Select Chamber</label>
                                <select name="chamber_id" id="chamber_id" class="form-control" required>
                                    <option value="">Select Chamber</option>
                                    @foreach($doctor->chambers as $chamber)
                                        <option value="{{ $chamber->id }}">{{ $chamber->chamber_name }} -
                                            {{ $chamber->chamber_location }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="appointment_date" class="form-label">Appointment Date & Time</label>
                                <input type="datetime-local" name="appointment_date" id="appointment_date"
                                    class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason for Visit</label>
                                <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Book Appointment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection