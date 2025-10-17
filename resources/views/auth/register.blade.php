@extends('layouts.guest')

@section('content')
    <div class="register-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-9">
                    <!-- Logo Section -->
                    <div class="text-center mb-4">
                        <div class="logo-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h2>Create Account</h2>
                        <p class="subtitle">Join DocTime Healthcare Platform</p>
                    </div>

                    <!-- Register Card -->
                    <div class="register-card">
                        <div class="card-header">
                            <h4>Register</h4>
                            <p>Fill in the details to create your account</p>
                        </div>

                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
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
                                <div class="form-section">
                                    <h5>Account Type</h5>
                                    <div class="role-selection">
                                        <div class="role-option" data-role="patient">
                                            <input type="radio" name="role" id="patient" value="patient" 
                                                {{ old('role') == 'patient' ? 'checked' : '' }}>
                                            <label for="patient">
                                                <i class="fas fa-user"></i>
                                                <span>Patient</span>
                                            </label>
                                        </div>
                                        <div class="role-option" data-role="doctor">
                                            <input type="radio" name="role" id="doctor" value="doctor" 
                                                {{ old('role') == 'doctor' ? 'checked' : '' }}>
                                            <label for="doctor">
                                                <i class="fas fa-user-md"></i>
                                                <span>Doctor</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Basic Information -->
                                <div class="form-section">
                                    <h5>Basic Information</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="first_name">First Name *</label>
                                                <input id="first_name" type="text"
                                                    class="form-control @error('first_name') is-invalid @enderror"
                                                    name="first_name" value="{{ old('first_name') }}" required>
                                                @error('first_name')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="last_name">Last Name *</label>
                                                <input id="last_name" type="text"
                                                    class="form-control @error('last_name') is-invalid @enderror"
                                                    name="last_name" value="{{ old('last_name') }}" required>
                                                @error('last_name')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email Address *</label>
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    name="email" value="{{ old('email') }}" required>
                                                @error('email')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Phone Number *</label>
                                                <input id="phone" type="text"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    name="phone" value="{{ old('phone') }}" required>
                                                @error('phone')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Password *</label>
                                                <div class="password-wrapper">
                                                    <input id="password" type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" required>
                                                    <button type="button" class="toggle-password" data-target="password" aria-label="Show password" aria-pressed="false">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                @error('password')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password-confirm">Confirm Password *</label>
                                                <div class="password-wrapper">
                                                    <input id="password-confirm" type="password" class="form-control"
                                                        name="password_confirmation" required>
                                                    <button type="button" class="toggle-password" data-target="password-confirm" aria-label="Show password" aria-pressed="false">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Patient Fields -->
                                <div id="patient-fields" style="display: none;" class="form-section">
                                    <h5>Patient Information</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gender">Gender</label>
                                                <select id="gender" class="form-control @error('gender') is-invalid @enderror"
                                                    name="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                                @error('gender')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="date_of_birth">Date of Birth</label>
                                                <input id="date_of_birth" type="date"
                                                    class="form-control @error('date_of_birth') is-invalid @enderror"
                                                    name="date_of_birth" value="{{ old('date_of_birth') }}">
                                                @error('date_of_birth')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="blood_group">Blood Group</label>
                                                <select id="blood_group" class="form-control @error('blood_group') is-invalid @enderror"
                                                    name="blood_group">
                                                    <option value="">Select Blood Group</option>
                                                    <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                                    <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                                    <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                                    <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                                    <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                                    <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                                    <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                                    <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                                                </select>
                                                @error('blood_group')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea id="address" class="form-control @error('address') is-invalid @enderror"
                                            name="address" rows="2">{{ old('address') }}</textarea>
                                        @error('address')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Doctor Fields -->
                                <div id="doctor-fields" style="display: none;" class="form-section">
                                    <h5>Doctor Information</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="speciality">Speciality</label>
                                                <input id="speciality" type="text"
                                                    class="form-control @error('speciality') is-invalid @enderror"
                                                    name="speciality" value="{{ old('speciality') }}">
                                                @error('speciality')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="license_no">License Number</label>
                                                <input id="license_no" type="text"
                                                    class="form-control @error('license_no') is-invalid @enderror"
                                                    name="license_no" value="{{ old('license_no') }}">
                                                @error('license_no')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="qualifications">Qualifications</label>
                                        <textarea id="qualifications"
                                            class="form-control @error('qualifications') is-invalid @enderror"
                                            name="qualifications" rows="2">{{ old('qualifications') }}</textarea>
                                        @error('qualifications')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn-register">
                                    Create Account
                                </button>

                                <div class="text-center mt-3">
                                    <p class="login-link">Already have an account? 
                                        <a href="{{ route('login') }}">Sign in here</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        * {
            box-sizing: border-box;
        }

        .register-container {
            min-height: calc(100vh - 140px);
            width: 60%;
            background: #f8f9fa;
            padding: 30px 15px;
        }

        .logo-icon {
            width: 60px;
            height: 60px;
            background: #20B2AA;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 24px;
            color: white;
        }

        .register-container h2 {
            font-size: 28px;
            font-weight: 600;
            color: #20B2AA;
            margin: 0 0 8px 0;
        }

        .subtitle {
            color: #666;
            font-size: 14px;
            margin: 0;
        }

        .register-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background: #20B2AA;
            color: white;
            padding: 18px;
            text-align: center;
            border: none;
        }

        .card-header h4 {
            font-size: 20px;
            font-weight: 600;
            margin: 0 0 5px 0;
        }

        .card-header p {
            font-size: 14px;
            margin: 0;
            opacity: 0.9;
        }

        .card-body {
            padding: 35px 40px;
        }

        .form-section {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .form-section:last-of-type {
            border-bottom: none;
            margin-bottom: 20px;
        }

        .form-section h5 {
            font-size: 16px;
            font-weight: 600;
            color: #20B2AA;
            margin: 0 0 15px 0;
        }

        .role-selection {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        .role-option {
            border: 2px solid #ddd;
            border-radius: 6px;
            padding: 0;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .role-option:hover {
            border-color: #20B2AA;
        }

        .role-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .role-option label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 25px;
            margin: 0;
            cursor: pointer;
            width: 100%;
        }

        .role-option i {
            font-size: 28px;
            color: #666;
            margin-bottom: 10px;
        }

        .role-option span {
            font-size: 15px;
            font-weight: 500;
            color: #333;
        }

        .role-option input[type="radio"]:checked + label i {
            color: #20B2AA;
        }

        .role-option input[type="radio"]:checked + label span {
            color: #20B2AA;
        }

        .role-option.active {
            border-color: #20B2AA;
            background: #E6F7F6;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 6px;
            display: block;
        }

        .form-control,
        select.form-control {
            display: block;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px 12px;
            font-size: 14px;
            transition: border-color 0.2s ease;
        }

        .form-control:focus,
        select.form-control:focus {
            border-color: #20B2AA;
            outline: none;
            box-shadow: 0 0 0 3px rgba(32, 178, 170, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 60px;
        }

        .btn-register {
            background: #20B2AA;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-register:hover {
            background: #178A84;
        }

        .login-link {
            font-size: 14px;
            color: #666;
            margin: 0;
        }

        .login-link a {
            color: #20B2AA;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .alert {
            border: none;
            border-radius: 4px;
            padding: 12px 15px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
            list-style: disc;
        }

        .alert li {
            font-size: 14px;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }

        /* Password toggle */
        .password-wrapper {
            position: relative;
        }
        .password-wrapper .form-control {
            padding-right: 42px; /* space for the eye icon */
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }
        .toggle-password:hover,
        .toggle-password:focus {
            color: #20B2AA;
            outline: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .register-container {
                padding: 20px 15px;
            }

            .register-container h2 {
                font-size: 24px;
            }

            .card-body {
                padding: 25px 20px;
            }

            .role-selection {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const patientRadio = document.getElementById('patient');
            const doctorRadio = document.getElementById('doctor');
            const patientFields = document.getElementById('patient-fields');
            const doctorFields = document.getElementById('doctor-fields');
            const roleOptions = document.querySelectorAll('.role-option');

            function toggleFields() {
                if (patientRadio && patientRadio.checked) {
                    patientFields.style.display = 'block';
                    doctorFields.style.display = 'none';
                } else if (doctorRadio && doctorRadio.checked) {
                    patientFields.style.display = 'none';
                    doctorFields.style.display = 'block';
                } else {
                    patientFields.style.display = 'none';
                    doctorFields.style.display = 'none';
                }

                roleOptions.forEach(option => {
                    const radio = option.querySelector('input[type="radio"]');
                    if (radio && radio.checked) {
                        option.classList.add('active');
                    } else {
                        option.classList.remove('active');
                    }
                });
            }

            if (patientRadio) patientRadio.addEventListener('change', toggleFields);
            if (doctorRadio) doctorRadio.addEventListener('change', toggleFields);

            roleOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const radio = this.querySelector('input[type="radio"]');
                    if (radio) {
                        radio.checked = true;
                        toggleFields();
                    }
                });
            });

            toggleFields();
        });

        // Password show/hide toggles
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = btn.querySelector('i');
                if (!input) return;

                const isText = input.type === 'text';
                input.type = isText ? 'password' : 'text';
                btn.setAttribute('aria-pressed', String(!isText));
                btn.setAttribute('aria-label', isText ? 'Show password' : 'Hide password');

                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        });
    </script>
@endsection