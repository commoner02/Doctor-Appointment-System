
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - DocTime</title>
    
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            500: '#20b2aa',
                            600: '#0d9488',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen py-6">
    <div class="max-w-2xl mx-auto px-4">
        <!-- Logo/Brand -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-primary-500">DocTime</h1>
            <p class="text-gray-600 mt-2">Join Our Healthcare Platform</p>
        </div>

        <!-- Registration Form -->
        <div class="bg-white rounded-lg shadow-sm p-8">
            <h2 class="text-2xl font-bold text-gray-900 text-center mb-8">Create Account</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Role Selection -->
                <div class="border-b pb-6">
                    <label class="block text-lg font-medium text-gray-900 mb-4">I want to register as:</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex flex-col items-center p-6 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors" onclick="showFields('patient')">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="radio" name="role" value="patient" {{ old('role', 'patient') === 'patient' ? 'checked' : '' }}
                                   class="mb-2 text-primary-500 focus:ring-primary-500">
                            <span class="text-lg font-medium text-gray-900">Patient</span>
                            <span class="text-sm text-gray-500 text-center mt-1">Book appointments and manage health records</span>
                        </label>
                        
                        <label class="flex flex-col items-center p-6 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors" onclick="showFields('doctor')">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <input type="radio" name="role" value="doctor" {{ old('role') === 'doctor' ? 'checked' : '' }}
                                   class="mb-2 text-primary-500 focus:ring-primary-500">
                            <span class="text-lg font-medium text-gray-900">Doctor</span>
                            <span class="text-sm text-gray-500 text-center mt-1">Manage patients and chambers</span>
                        </label>
                    </div>
                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="Enter your full name">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="your.email@example.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="+8801XXXXXXXXX">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                            <select id="gender" name="gender" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea id="address" name="address" rows="2"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                  placeholder="Enter your complete address">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Patient Specific Fields -->
                <div id="patient-fields" style="display: none;">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Patient Information</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                            <input id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('date_of_birth')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="blood_group" class="block text-sm font-medium text-gray-700 mb-1">Blood Group</label>
                            <select id="blood_group" name="blood_group"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">Select Blood Group</option>
                                <option value="A+" {{ old('blood_group') === 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ old('blood_group') === 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ old('blood_group') === 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ old('blood_group') === 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ old('blood_group') === 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ old('blood_group') === 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ old('blood_group') === 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ old('blood_group') === 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                            @error('blood_group')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="emergency_contact" class="block text-sm font-medium text-gray-700 mb-1">Emergency Contact</label>
                        <input id="emergency_contact" type="tel" name="emergency_contact" value="{{ old('emergency_contact') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                               placeholder="Emergency contact number">
                        @error('emergency_contact')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Doctor Specific Fields -->
                <div id="doctor-fields" style="display: none;">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Professional Information</h3>
                    <div class="space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="speciality" class="block text-sm font-medium text-gray-700 mb-1">Speciality *</label>
                                <select id="speciality" name="speciality" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Select Speciality</option>
                                    <option value="Cardiology" {{ old('speciality') === 'Cardiology' ? 'selected' : '' }}>Cardiology</option>
                                    <option value="Dermatology" {{ old('speciality') === 'Dermatology' ? 'selected' : '' }}>Dermatology</option>
                                    <option value="Neurology" {{ old('speciality') === 'Neurology' ? 'selected' : '' }}>Neurology</option>
                                    <option value="Orthopedics" {{ old('speciality') === 'Orthopedics' ? 'selected' : '' }}>Orthopedics</option>
                                    <option value="Pediatrics" {{ old('speciality') === 'Pediatrics' ? 'selected' : '' }}>Pediatrics</option>
                                    <option value="Gynecology & Obstetrics" {{ old('speciality') === 'Gynecology & Obstetrics' ? 'selected' : '' }}>Gynecology & Obstetrics</option>
                                    <option value="Internal Medicine" {{ old('speciality') === 'Internal Medicine' ? 'selected' : '' }}>Internal Medicine</option>
                                    <option value="Ophthalmology" {{ old('speciality') === 'Ophthalmology' ? 'selected' : '' }}>Ophthalmology</option>
                                    <option value="Psychiatry" {{ old('speciality') === 'Psychiatry' ? 'selected' : '' }}>Psychiatry</option>
                                    <option value="General Medicine" {{ old('speciality') === 'General Medicine' ? 'selected' : '' }}>General Medicine</option>
                                </select>
                                @error('speciality')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="experience" class="block text-sm font-medium text-gray-700 mb-1">Experience (Years) *</label>
                                <input id="experience" type="number" name="experience" value="{{ old('experience') }}" min="0" max="50" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Years of experience">
                                @error('experience')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="qualifications" class="block text-sm font-medium text-gray-700 mb-1">Qualifications *</label>
                            <input id="qualifications" type="text" name="qualifications" value="{{ old('qualifications') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="MBBS, MD, FCPS, etc.">
                            @error('qualifications')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="license_number" class="block text-sm font-medium text-gray-700 mb-1">Medical License Number *</label>
                            <input id="license_number" type="text" name="license_number" value="{{ old('license_number') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="BMA License Number">
                            @error('license_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Professional Bio</label>
                            <textarea id="bio" name="bio" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                      placeholder="Brief description about your practice and expertise">{{ old('bio') }}</textarea>
                            @error('bio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Account Security</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                            <input id="password" type="password" name="password" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="Minimum 8 characters">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password *</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="Re-enter password">
                        </div>
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="flex items-start">
                        <input type="checkbox" name="terms" required
                               class="mt-1 mr-3 text-primary-500 focus:ring-primary-500">
                        <span class="text-sm text-gray-700">
                            I agree to the <a href="#" class="text-primary-500 hover:text-primary-600">Terms and Conditions</a> 
                            and <a href="#" class="text-primary-500 hover:text-primary-600">Privacy Policy</a>
                        </span>
                    </label>
                    @error('terms')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white font-medium py-3 px-4 rounded-lg transition duration-200">
                        Create Account
                    </button>
                </div>

                <!-- Sign In Link -->
                <div class="text-center text-sm">
                    <p class="text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-primary-500 hover:text-primary-600 font-medium">Sign in</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Show/hide role-specific fields
        function showFields(role) {
            const patientFields = document.getElementById('patient-fields');
            const doctorFields = document.getElementById('doctor-fields');
            
            if (role === 'patient') {
                patientFields.style.display = 'block';
                doctorFields.style.display = 'none';
            } else if (role === 'doctor') {
                patientFields.style.display = 'none';
                doctorFields.style.display = 'block';
            }
        }

        // Initialize form based on old input or default
        document.addEventListener('DOMContentLoaded', function() {
            const checkedRole = document.querySelector('input[name="role"]:checked');
            if (checkedRole) {
                showFields(checkedRole.value);
            }
        });

        // Handle role change
        document.querySelectorAll('input[name="role"]').forEach(radio => {
            radio.addEventListener('change', function() {
                showFields(this.value);
            });
        });
    </script>
</body>
</html>