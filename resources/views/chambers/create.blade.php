{{-- filepath: resources/views/chambers/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Add Chamber')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h4 class="mb-0">
                            <i class="fas fa-plus-circle me-2"></i>Add New Chamber
                        </h4>
                        <p class="mb-0 small">Fill in the details to create your chamber</p>
                    </div>
                    <div class="card-body p-5">
                        <form method="POST" action="{{ route('chambers.store') }}">
                            @csrf

                            <!-- Chamber Name -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-building me-1 text-primary"></i>Chamber Name <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="name"
                                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="Enter chamber name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-map-marker-alt me-1 text-primary"></i>Address <span
                                        class="text-danger">*</span>
                                </label>
                                <textarea name="address"
                                    class="form-control form-control-lg @error('address') is-invalid @enderror" rows="3"
                                    placeholder="Enter full address" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-phone me-1 text-primary"></i>Phone Number
                                </label>
                                <input type="text" name="phone"
                                    class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}" placeholder="e.g., +1 234 567 890">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Time Fields -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-clock me-1 text-primary"></i>Start Time
                                    </label>
                                    <input type="time" name="start_time"
                                        class="form-control form-control-lg @error('start_time') is-invalid @enderror"
                                        value="{{ old('start_time', '09:00') }}">
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-clock me-1 text-primary"></i>End Time
                                    </label>
                                    <input type="time" name="end_time"
                                        class="form-control form-control-lg @error('end_time') is-invalid @enderror"
                                        value="{{ old('end_time', '17:00') }}">
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Fee -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-dollar-sign me-1 text-primary"></i>Consultation Fee
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="fee"
                                        class="form-control form-control-lg @error('fee') is-invalid @enderror"
                                        value="{{ old('fee') }}" min="0" step="0.01" placeholder="0.00">
                                </div>
                                @error('fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Working Days -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar-alt me-1 text-primary"></i>Working Days
                                </label>
                                <input type="text" name="working_days"
                                    class="form-control form-control-lg @error('working_days') is-invalid @enderror"
                                    value="{{ old('working_days') }}" placeholder="e.g., Monday-Friday">
                                @error('working_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('doctor.chambers') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Add Chamber
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection