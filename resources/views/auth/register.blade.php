<div class="registration-container">
    <div class="registration-header">
        <h2 class="registration-title">Create Your Account</h2>
        <p class="registration-subtitle">Join our healthcare platform</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="registration-form">
        @csrf
        
        <!-- Role Selection Card -->
        <div class="role-selection-card">
            <h3 class="section-title">Choose Your Role</h3>
            <div class="role-options">
                <div class="role-option">
                    <input type="radio" id="patient" name="role" value="patient" class="role-radio" 
                           {{ old('role') == 'patient' ? 'checked' : '' }}>
                    <label for="patient" class="role-label">
                        <div class="role-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <div class="role-content">
                            <span class="role-title">Patient</span>
                            <span class="role-description">Book appointments and manage health records</span>
                        </div>
                    </label>
                </div>
                
                <div class="role-option">
                    <input type="radio" id="doctor" name="role" value="doctor" class="role-radio" 
                           {{ old('role') == 'doctor' ? 'checked' : '' }}>
                    <label for="doctor" class="role-label">
                        <div class="role-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M9 12l2 2 4-4"></path>
                                <path d="M21 12c.552 0 1-.448 1-1V8c0-.552-.448-1-1-1h-1V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v1H2c-.552 0-1 .448-1 1v3c0 .552.448 1 1 1h1v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-1h1z"></path>
                            </svg>
                        </div>
                        <div class="role-content">
                            <span class="role-title">Doctor</span>
                            <span class="role-description">Manage patients and provide medical care</span>
                        </div>
                    </label>
                </div>
            </div>
            @error('role')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Basic User Information -->
        <div class="form-section">
            <h3 class="section-title">Account Information</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="name" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Full Name
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" 
                           class="form-input @error('name') is-invalid @enderror" 
                           placeholder="Enter your full name" required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        Email Address
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                           class="form-input @error('email') is-invalid @enderror" 
                           placeholder="Enter your email address" required>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <circle cx="12" cy="16" r="1"></circle>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        Password
                    </label>
                    <input id="password" type="password" name="password" 
                           class="form-input @error('password') is-invalid @enderror" 
                           placeholder="Create a password" required>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <circle cx="12" cy="16" r="1"></circle>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        Confirm Password
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" 
                           class="form-input" placeholder="Confirm your password" required>
                </div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="form-section">
            <h3 class="section-title">Personal Information</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="phone" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        Phone Number
                    </label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" 
                           class="form-input @error('phone') is-invalid @enderror" 
                           placeholder="Enter your phone number" required>
                    @error('phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="date_of_birth" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        Date of Birth
                    </label>
                    <input id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" 
                           class="form-input @error('date_of_birth') is-invalid @enderror" required>
                    @error('date_of_birth')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Add Gender Field -->
            <div class="form-row">
                <div class="form-group">
                    <label for="gender" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                            <line x1="9" y1="9" x2="9.01" y2="9"></line>
                            <line x1="15" y1="9" x2="15.01" y2="9"></line>
                        </svg>
                        Gender
                    </label>
                    <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <!-- Empty div for grid alignment -->
                </div>
            </div>

            <div class="form-group">
                <label for="address" class="form-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    Address
                </label>
                <textarea id="address" name="address" class="form-textarea @error('address') is-invalid @enderror" 
                         placeholder="Enter your complete address" rows="3" required>{{ old('address') }}</textarea>
                @error('address')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Doctor Specific Fields -->
        <div id="doctor-fields" class="form-section doctor-section" 
             style="display: {{ old('role') == 'doctor' ? 'block' : 'none' }};">
            <h3 class="section-title">Medical Information</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="department_id" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        </svg>
                        Department
                    </label>
                    <select id="department_id" name="department_id" 
                            class="form-select @error('department_id') is-invalid @enderror">
                        <option value="" disabled selected>Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" 
                                    {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="specialty" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                        Specialty
                    </label>
                    <input id="specialty" type="text" name="specialty" value="{{ old('specialty') }}" 
                           class="form-input @error('specialty') is-invalid @enderror" 
                           placeholder="Enter your medical specialty">
                    @error('specialty')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="form-actions">
            <button type="submit" class="submit-btn">
                <span class="btn-text">Create Account</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M5 12h14m-7-7l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </form>
</div>

<style>
.registration-container {
    max-width: 600px;
    margin: 2rem auto;
    padding: 2rem;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.registration-header {
    text-align: center;
    margin-bottom: 2rem;
}

.registration-title {
    font-size: 1.875rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.registration-subtitle {
    color: #6b7280;
    font-size: 1rem;
}

.role-selection-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.role-options {
    display: grid;
    gap: 1rem;
    grid-template-columns: 1fr 1fr;
}

@media (max-width: 640px) {
    .role-options {
        grid-template-columns: 1fr;
    }
}

.role-option {
    position: relative;
}

.role-radio {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.role-label {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    background: #ffffff;
}

.role-label:hover {
    border-color: #3b82f6;
    background: #f0f9ff;
}

.role-radio:checked + .role-label {
    border-color: #3b82f6;
    background: #eff6ff;
}

.role-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e0f2fe;
    border-radius: 50%;
    color: #0369a1;
}

.role-radio:checked + .role-label .role-icon {
    background: #3b82f6;
    color: #ffffff;
}

.role-content {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.role-title {
    font-weight: 600;
    color: #374151;
}

.role-description {
    font-size: 0.875rem;
    color: #6b7280;
}

.form-section {
    margin-bottom: 2rem;
}

.doctor-section {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 1.5rem;
    background: #fafafa;
    opacity: 0;
    max-height: 0;
    overflow: hidden;
    transition: all 0.3s ease-in-out;
}

.doctor-section.show {
    opacity: 1;
    max-height: 500px;
}

.form-row {
    display: grid;
    gap: 1rem;
    grid-template-columns: 1fr 1fr;
}

@media (max-width: 640px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-input,
.form-select,
.form-textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.875rem;
    transition: border-color 0.2s, box-shadow 0.2s;
    background: #ffffff;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-input.is-invalid,
.form-select.is-invalid,
.form-textarea.is-invalid {
    border-color: #ef4444;
}

.form-textarea {
    resize: vertical;
    min-height: 80px;
}

.error-message {
    color: #ef4444;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.form-actions {
    margin-top: 2rem;
}

.submit-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    background: #3b82f6;
    color: #ffffff;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.2s;
}

.submit-btn:hover {
    background: #2563eb;
}

.submit-btn:active {
    transform: translateY(1px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleRadios = document.querySelectorAll('input[name="role"]');
    const doctorFields = document.getElementById('doctor-fields');
    const departmentSelect = document.getElementById('department_id');
    const specialtyInput = document.getElementById('specialty');

    // Initialize doctor fields visibility based on old input
    if (document.querySelector('input[name="role"]:checked')?.value === 'doctor') {
        doctorFields.style.display = 'block';
        doctorFields.classList.add('show');
        departmentSelect.setAttribute('required', 'required');
        specialtyInput.setAttribute('required', 'required');
    }

    // Handle role selection
    roleRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'doctor') {
                doctorFields.style.display = 'block';
                setTimeout(() => {
                    doctorFields.classList.add('show');
                }, 10);
                departmentSelect.setAttribute('required', 'required');
                specialtyInput.setAttribute('required', 'required');
            } else {
                doctorFields.classList.remove('show');
                setTimeout(() => {
                    doctorFields.style.display = 'none';
                }, 300);
                departmentSelect.removeAttribute('required');
                specialtyInput.removeAttribute('required');
            }
        });
    });

    // Handle gender field visibility for patients
    const genderField = document.getElementById('gender').parentElement;
    
    roleRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'doctor') {
                genderField.style.display = 'none';
                document.getElementById('gender').removeAttribute('required');
            } else {
                genderField.style.display = 'block';
                document.getElementById('gender').setAttribute('required', 'required');
            }
        });
    });

    // Initialize gender field visibility
    const selectedRole = document.querySelector('input[name="role"]:checked')?.value;
    if (selectedRole === 'doctor') {
        genderField.style.display = 'none';
        document.getElementById('gender').removeAttribute('required');
    }

    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0) {
            if (value.length <= 3) {
                value = value;
            } else if (value.length <= 6) {
                value = value.slice(0, 3) + '-' + value.slice(3);
            } else {
                value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
            }
        }
        e.target.value = value;
    });
});
</script>