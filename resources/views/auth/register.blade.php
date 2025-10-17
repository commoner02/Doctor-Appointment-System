@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="mb-0"><i class="fas fa-user-plus me-2"></i>Create Account</h3>
                        <p class="text-muted mb-0">Join our healthcare platform</p>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Role Selection -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label for="role" class="form-label">I want to register as:</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="role" id="patient"
                                                    value="patient" {{ old('role') == 'patient' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="patient">
                                                    <i class="fas fa-user me-2"></i>Patient
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="role" id="doctor"
                                                    value="doctor" {{ old('role') == 'doctor' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="doctor">
                                                    <i class="fas fa-user-md me-2"></i>Doctor
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Basic Information -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input id="first_name" type="text"
                                        class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                        value="{{ old('first_name') }}" required>
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input id="last_name" type="text"
                                        class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                        value="{{ old('last_name') }}" required>
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="password-confirm" class="form-label">Confirm Password</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required>
                                </div>
                            </div>

                            <!-- Patient Fields -->
                            <div id="patient-fields" style="display: none;">
                                <h5 class="mb-3"><i class="fas fa-heartbeat me-2"></i>Patient Information</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select id="gender" class="form-control @error('gender') is-invalid @enderror"
                                            name="gender">
                                            <option value="">Select Gender</option>
                                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female
                                            </option>
                                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                                        <input id="date_of_birth" type="date"
                                            class="form-control @error('date_of_birth') is-invalid @enderror"
                                            name="date_of_birth" value="{{ old('date_of_birth') }}">
                                        @error('date_of_birth')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="blood_group" class="form-label">Blood Group</label>
                                        <select id="blood_group"
                                            class="form-control @error('blood_group') is-invalid @enderror"
                                            name="blood_group">
                                            <option value="">Select Blood Group</option>
                                            <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                            <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                            <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                            <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                            <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+
                                            </option>
                                            <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-
                                            </option>
                                            <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                            <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                                        </select>
                                        @error('blood_group')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea id="address" class="form-control @error('address') is-invalid @enderror"
                                            name="address" rows="3">{{ old('address') }}</textarea>
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Doctor Fields -->
                            <div id="doctor-fields" style="display: none;">
                                <h5 class="mb-3"><i class="fas fa-stethoscope me-2"></i>Doctor Information</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="speciality" class="form-label">Speciality</label>
                                        <input id="speciality" type="text"
                                            class="form-control @error('speciality') is-invalid @enderror" name="speciality"
                                            value="{{ old('speciality') }}">
                                        @error('speciality')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="license_no" class="form-label">License Number</label>
                                        <input id="license_no" type="text"
                                            class="form-control @error('license_no') is-invalid @enderror" name="license_no"
                                            value="{{ old('license_no') }}">
                                        @error('license_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label for="qualifications" class="form-label">Qualifications</label>
                                        <textarea id="qualifications"
                                            class="form-control @error('qualifications') is-invalid @enderror"
                                            name="qualifications" rows="3">{{ old('qualifications') }}</textarea>
                                        @error('qualifications')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>Create Account
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <p class="text-muted">Already have an account? <a href="{{ route('login') }}"
                                        class="text-decoration-none">Sign in</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const patientRadio = document.getElementById('patient');
            const doctorRadio = document.getElementById('doctor');
            const patientFields = document.getElementById('patient-fields');
            const doctorFields = document.getElementById('doctor-fields');

            function toggleFields() {
                if (patientRadio.checked) {
                    patientFields.style.display = 'block';
                    doctorFields.style.display = 'none';
                    // Set required attributes
                    patientFields.querySelectorAll('input, select, textarea').forEach(field => {
                        field.required = true;
                    });
                    doctorFields.querySelectorAll('input, select, textarea').forEach(field => {
                        field.required = false;
                    });
                } else if (doctorRadio.checked) {
                    patientFields.style.display = 'none';
                    doctorFields.style.display = 'block';
                    // Set required attributes
                    doctorFields.querySelectorAll('input, select, textarea').forEach(field => {
                        field.required = true;
                    });
                    patientFields.querySelectorAll('input, select, textarea').forEach(field => {
                        field.required = false;
                    });
                }
            }

            patientRadio.addEventListener('change', toggleFields);
            doctorRadio.addEventListener('change', toggleFields);

            // Initialize on page load
            toggleFields();
        });
    </script>
@endsection