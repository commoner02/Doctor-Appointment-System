{{-- filepath: /opt/lampp/htdocs/DAS-Project/das-project/resources/views/chambers/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Add Chamber')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Add New Chamber</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('chambers.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Chamber Name <span class="text-danger">*</span></label>
                                <input type="text" name="chamber_name" class="form-control @error('chamber_name') is-invalid @enderror" 
                                    value="{{ old('chamber_name') }}" required>
                                @error('chamber_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Location <span class="text-danger">*</span></label>
                                <textarea name="chamber_location" class="form-control @error('chamber_location') is-invalid @enderror" 
                                    rows="2" required>{{ old('chamber_location') }}</textarea>
                                @error('chamber_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                    value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Start Time <span class="text-danger">*</span></label>
                                    <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" 
                                        value="{{ old('start_time') }}" required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">End Time <span class="text-danger">*</span></label>
                                    <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" 
                                        value="{{ old('end_time') }}" required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Visiting Fee (BDT) <span class="text-danger">*</span></label>
                                <input type="number" name="visiting_fee" class="form-control @error('visiting_fee') is-invalid @enderror" 
                                    value="{{ old('visiting_fee') }}" min="0" step="0.01" required>
                                @error('visiting_fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Working Days <span class="text-danger">*</span></label>
                                <div class="row">
                                    @foreach(['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="working_days[]" value="{{ $day }}" 
                                                    class="form-check-input" id="day_{{ $day }}"
                                                    {{ in_array($day, old('working_days', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="day_{{ $day }}">
                                                    {{ $day }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('working_days')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('doctor.chambers') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Add Chamber</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection