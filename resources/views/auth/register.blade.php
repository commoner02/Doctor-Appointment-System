<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - HealthCare+</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 600px;
            margin: 2rem auto;
        }
        
        .role-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .role-card:hover {
            border-color: #007bff;
            background-color: #f8f9ff;
        }
        
        .role-card.selected {
            border-color: #007bff;
            background-color: #e7f3ff;
        }
        
        .doctor-fields {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 1rem;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="register-card p-4">
            <!-- Header -->
            <div class="text-center mb-4">
                <h2 class="fw-bold">Create Your Account</h2>
                <p class="text-muted">Join HealthCare+ Platform</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Role Selection -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Choose Your Role</label>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="role-card" data-role="patient">
                                <input type="radio" name="role" value="patient" id="patient" class="d-none" 
                                       {{ old('role') == 'patient' ? 'checked' : '' }} required>
                                <div class="text-center">
                                    <div class="fs-1 mb-2">👤</div>
                                    <h6>Patient</h6>
                                    <small class="text-muted">Book appointments and manage health</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="role-card" data-role="doctor">
                                <input type="radio" name="role" value="doctor" id="doctor" class="d-none"
                                       {{ old('role') == 'doctor' ? 'checked' : '' }}>
                                <div class="text-center">
                                    <div class="fs-1 mb-2">👨‍⚕️</div>
                                    <h6>Doctor</h6>
                                    <small class="text-muted">Provide medical care and consultation</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @error('role')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Basic Information -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ old('name') }}" placeholder="Enter your full name" required>
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email') }}" placeholder="Enter your email" required>
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Create a password" required>
                        @error('password')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" 
                               name="password_confirmation" placeholder="Confirm password" required>
                    </div>
                </div>

                <!-- Personal Details -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" 
                               value="{{ old('phone') }}" placeholder="Your phone number" required>
                        @error('phone')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" 
                               value="{{ old('date_of_birth') }}" required>
                        @error('date_of_birth')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Gender Field for Patients -->
                <div class="row g-3 mb-3" id="patient-fields">
                    <div class="col-md-6">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3" 
                              placeholder="Enter your complete address" required>{{ old('address') }}</textarea>
                    @error('address')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Doctor Specific Fields -->
                <div id="doctor-fields" class="doctor-fields">
                    <h5 class="mb-3">Professional Information</h5>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="department_id" class="form-label">Department</label>
                            <select class="form-select" id="department_id" name="department_id">
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" 
                                            {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="specialty" class="form-label">Specialty</label>
                            <input type="text" class="form-control" id="specialty" name="specialty" 
                                   value="{{ old('specialty') }}" placeholder="Your medical specialty">
                            @error('specialty')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Medical License and Qualifications -->
                    <div class="mb-3">
                        <label for="medical_license" class="form-label">Medical License Number</label>
                        <input type="text" class="form-control" id="medical_license" name="medical_license" 
                               value="{{ old('medical_license') }}" placeholder="Enter your medical license number">
                        @error('medical_license')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="qualifications" class="form-label">Qualifications</label>
                        <textarea class="form-control" id="qualifications" name="qualifications" rows="3" 
                                  placeholder="List your medical qualifications and degrees">{{ old('qualifications') }}</textarea>
                        @error('qualifications')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn btn-primary btn-lg">
                        Create Account
                    </button>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="mb-0">Already have an account? 
                        <a href="{{ route('login') }}" class="text-decoration-none">Sign in here</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleCards = document.querySelectorAll('.role-card');
            const doctorFields = document.getElementById('doctor-fields');
            const patientFields = document.getElementById('patient-fields');
            const genderField = document.getElementById('gender');
            const departmentField = document.getElementById('department_id');
            const specialtyField = document.getElementById('specialty');
            const medicalLicenseField = document.getElementById('medical_license');

            // Handle role selection
            roleCards.forEach(card => {
                card.addEventListener('click', function() {
                    const role = this.dataset.role;
                    const radio = document.getElementById(role);
                    
                    // Clear previous selections
                    roleCards.forEach(c => c.classList.remove('selected'));
                    document.querySelectorAll('input[name="role"]').forEach(r => r.checked = false);
                    
                    // Select current role
                    this.classList.add('selected');
                    radio.checked = true;
                    
                    // Show/hide fields based on role
                    if (role === 'doctor') {
                        doctorFields.style.display = 'block';
                        patientFields.style.display = 'none';
                        departmentField.required = true;
                        specialtyField.required = true;
                        medicalLicenseField.required = true;
                        genderField.required = false;
                    } else {
                        doctorFields.style.display = 'none';
                        patientFields.style.display = 'block';
                        departmentField.required = false;
                        specialtyField.required = false;
                        medicalLicenseField.required = false;
                        genderField.required = true;
                    }
                });
            });

            // Initialize on page load - select patient by default
            const patientCard = document.querySelector('.role-card[data-role="patient"]');
            if (patientCard) {
                patientCard.click();
            }
        });
    </script>
</body>
</html>