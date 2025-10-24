
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - DocTime</title>
    
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
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <!-- Logo/Brand -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-primary-500">DocTime</h1>
            <p class="text-gray-600 mt-2">Create New Password</p>
        </div>

        <!-- Reset Password Form -->
        <div class="bg-white rounded-lg shadow-sm p-8">
            <h2 class="text-2xl font-bold text-gray-900 text-center mb-6">Reset Password</h2>
            
            <p class="text-sm text-gray-600 text-center mb-6">
                Enter your new password below to complete the reset process.
            </p>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address (Hidden/Display) -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                               class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                               placeholder="Enter new password">
                        <button type="button" onclick="togglePassword('password')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i id="password-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters long</p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                               class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                               placeholder="Confirm new password">
                        <button type="button" onclick="togglePassword('password_confirmation')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i id="password_confirmation-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reset Password Button -->
                <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                    Reset Password
                </button>

                <!-- Back to Login -->
                <div class="text-center text-sm">
                    <p class="text-gray-600">
                        Remember your password? 
                        <a href="{{ route('login') }}" class="text-primary-500 hover:text-primary-600 font-medium">
                            Back to Sign In
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Security Note -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-shield-alt text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs text-blue-700">
                        <strong>Security Note:</strong> Choose a strong password that includes uppercase letters, lowercase letters, numbers, and special characters.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome for Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strengthIndicator = document.getElementById('strength-indicator');
            
            if (password.length === 0) return;
            
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500'];
            const labels = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
            
            if (!strengthIndicator) {
                const indicator = document.createElement('div');
                indicator.id = 'strength-indicator';
                indicator.className = 'mt-2';
                document.getElementById('password').parentNode.appendChild(indicator);
            }
            
            document.getElementById('strength-indicator').innerHTML = `
                <div class="flex items-center space-x-2">
                    <div class="flex-1 h-2 bg-gray-200 rounded-full">
                        <div class="${colors[strength-1]} h-2 rounded-full transition-all duration-300" style="width: ${(strength/5)*100}%"></div>
                    </div>
                    <span class="text-xs text-gray-600">${labels[strength-1]}</span>
                </div>
            `;
        });

        // Real-time password confirmation matching
        document.getElementById('password_confirmation').addEventListener('input', function(e) {
            const password = document.getElementById('password').value;
            const confirmation = e.target.value;
            
            if (confirmation.length === 0) return;
            
            const field = e.target;
            if (password === confirmation) {
                field.classList.remove('border-red-300');
                field.classList.add('border-green-300');
            } else {
                field.classList.remove('border-green-300');
                field.classList.add('border-red-300');
            }
        });
    </script>
</body>
</html>
