@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Book Appointment with Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('appointments.store') }}">
                            @csrf
                            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                            <div class="mb-3">
                                <label class="form-label">Select Chamber <span class="text-danger">*</span></label>
                                <select name="chamber_id" class="form-select @error('chamber_id') is-invalid @enderror" required>
                                    <option value="">Choose a chamber</option>
                                    @foreach($doctor->chambers as $chamber)
                                        <option value="{{ $chamber->id }}" {{ old('chamber_id') == $chamber->id ? 'selected' : '' }}>
                                            {{ $chamber->chamber_name }} - {{ $chamber->chamber_location }} (BDT {{ number_format($chamber->visiting_fee, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('chamber_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Appointment Date & Time <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror" 
                                    value="{{ old('appointment_date') }}" min="{{ now()->format('Y-m-d\TH:i') }}" required>
                                @error('appointment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Reason for Visit <span class="text-danger">*</span></label>
                                <textarea name="reason" class="form-control @error('reason') is-invalid @enderror" 
                                    rows="3" required>{{ old('reason') }}</textarea>
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('patient.doctors') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Book Appointment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection