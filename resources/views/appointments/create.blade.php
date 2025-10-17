@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5>Dr. {{ $doctor->first_name }} {{ $doctor->last_name }} <span class="text-muted">•
                        {{ $doctor->speciality }}</span></h5>
                <form method="POST" action="{{ route('appointments.store') }}" class="mt-3">
                    @csrf
                    <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                    <div class="mb-2">
                        <label class="form-label">Chamber</label>
                        <select name="chamber_id" class="form-control" required>
                            <option value="">Select chamber</option>
                            @foreach($doctor->chambers as $ch)
                                <option value="{{ $ch->id }}">{{ $ch->chamber_name }} — {{ $ch->chamber_location }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Date & Time</label>
                        <input type="datetime-local" name="appointment_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Reason (optional)</label>
                        <input type="text" name="reason" class="form-control" placeholder="Reason">
                    </div>

                    <button class="btn btn-primary">Book</button>
                </form>
            </div>
        </div>
    </div>
@endsection