{{-- filepath: /opt/lampp/htdocs/DocTime-Project/docTime/resources/views/doctor/chamber-edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Edit Chamber')

@section('content')
    <div class="chamber-form-page">
        <div class="container py-4">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="header-card">
                        <h1><i class="fas fa-edit me-2"></i>Edit Chamber</h1>
                        <p class="text-muted">Update chamber information and settings</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="form-card">
                        <form method="POST" action="{{ route('chambers.update', $chamber) }}">
                            @csrf
                            @method('PUT')

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Chamber Information -->
                            <div class="form-section">
                                <h5><i class="fas fa-info-circle me-2"></i>Chamber Information</h5>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="chamber_name" class="form-label">Chamber Name *</label>
                                        <input type="text" class="form-control @error('chamber_name') is-invalid @enderror" 
                                               id="chamber_name" name="chamber_name" value="{{ old('chamber_name', $chamber->chamber_name) }}" 
                                               placeholder="e.g., City Medical Center" required>
                                        @error('chamber_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Chamber Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone', $chamber->phone) }}" 
                                               placeholder="e.g., +880 123 456 7890">
                                        @error('phone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="chamber_location" class="form-label">Chamber Location</label>
                                        <textarea class="form-control @error('chamber_location') is-invalid @enderror" 
                                                  id="chamber_location" name="chamber_location" rows="2" 
                                                  placeholder="Full address of the chamber">{{ old('chamber_location', $chamber->chamber_location) }}</textarea>
                                        @error('chamber_location')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="visiting_fee" class="form-label">Visiting Fee (৳) *</label>
                                        <input type="number" class="form-control @error('visiting_fee') is-invalid @enderror" 
                                               id="visiting_fee" name="visiting_fee" value="{{ old('visiting_fee', $chamber->visiting_fee) }}" 
                                               placeholder="500" min="0" step="1" required>
                                        @error('visiting_fee')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Working Hours -->
                            <div class="form-section">
                                <h5><i class="fas fa-clock me-2"></i>Working Hours</h5>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="start_time" class="form-label">Start Time *</label>
                                        <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                                               id="start_time" name="start_time" value="{{ old('start_time', $chamber->start_time) }}" required>
                                        @error('start_time')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="end_time" class="form-label">End Time *</label>
                                        <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                                               id="end_time" name="end_time" value="{{ old('end_time', $chamber->end_time) }}" required>
                                        @error('end_time')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Working Days -->
                            <div class="form-section">
                                <h5><i class="fas fa-calendar-week me-2"></i>Working Days *</h5>
                                
                                <div class="working-days">
                                    @php
                                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                        $selectedDays = old('working_days', $chamber->working_days);
                                    @endphp
                                    @foreach($days as $day)
                                        <div class="day-checkbox">
                                            <input class="form-check-input" type="checkbox" name="working_days[]" 
                                                   value="{{ $day }}" id="day_{{ $day }}" 
                                                   {{ in_array($day, $selectedDays) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="day_{{ $day }}">
                                                {{ $day }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('working_days')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-actions">
                                <a href="{{ route('chambers.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Update Chamber
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Same styles as chamber-create.blade.php -->
    <style>
        /* ... same styles as create form ... */
    </style>
@endsection