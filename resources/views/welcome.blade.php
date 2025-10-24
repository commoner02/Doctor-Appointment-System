<!DOCTYPE html
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DocTime') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-inter bg-white text-gray-900">
    <!-- Hero Section -->
    <section class="py-16 md:py-20 px-4 bg-gradient-to-b from-primary-bg to-white">
        <div class="text-center max-w-2xl mx-auto">
            <div class="w-20 h-20 bg-primary rounded-xl flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-heartbeat text-white text-3xl"></i>
            </div>

            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900">DocTime</h1>
            <p class="text-lg md:text-xl text-gray-600 mb-8">
                Connect with verified doctors and manage your health appointments
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('login') }}" 
                   class="bg-primary text-black-500 font-medium py-3 px-8 rounded-lg hover:bg-primary-dark transition-colors text-base">
                    Sign In
                </a>
                <a href="{{ route('register') }}" 
                   class="border-2 border-primary text-primary font-medium py-3 px-8 rounded-lg hover:bg-primary hover:text-white transition-colors text-base">
                    Get Started
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 px-4 bg-white">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-12">How It Works</h2>

            <div class="grid md:grid-cols-3 gap-6">
                <!-- For Patients -->
                <div class="bg-primary-bg p-6 rounded-lg text-center">
                    <div class="w-16 h-16 bg-primary rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">For Patients</h3>
                    <p class="text-gray-600 text-base">
                        Find verified doctors and book appointments easily.
                    </p>
                </div>

                <!-- For Doctors -->
                <div class="bg-primary-bg p-6 rounded-lg text-center">
                    <div class="w-16 h-16 bg-primary rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-md text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">For Doctors</h3>
                    <p class="text-gray-600 text-base">
                        Manage chambers and schedule appointments.
                    </p>
                </div>

                <!-- For Admins -->
                <div class="bg-primary-bg p-6 rounded-lg text-center">
                    <div class="w-16 h-16 bg-primary rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-cog text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">For Admins</h3>
                    <p class="text-gray-600 text-base">
                        Oversee the platform and verify doctors.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 px-4 bg-gray-50">
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-primary mb-2">500+</div>
                    <div class="text-gray-600 text-sm md:text-base">Verified Doctors</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-primary mb-2">10K+</div>
                    <div class="text-gray-600 text-sm md:text-base">Happy Patients</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-primary mb-2">50K+</div>
                    <div class="text-gray-600 text-sm md:text-base">Appointments</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-primary mb-2">99%</div>
                    <div class="text-gray-600 text-sm md:text-base">Satisfaction</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-8 px-4 text-center">
        <div class="max-w-5xl mx-auto">
            <div class="text-xl font-bold mb-3 text-gray-900">
                <i class="fas fa-heartbeat text-primary mr-2"></i>DocTime
            </div>
            <p class="text-gray-600 text-sm mb-4">Your trusted healthcare partner</p>

            <div class="flex justify-center gap-3 mb-4">
                <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 hover:bg-primary hover:text-white transition-colors">
                    <i class="fab fa-facebook-f text-sm"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 hover:bg-primary hover:text-white transition-colors">
                    <i class="fab fa-twitter text-sm"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 hover:bg-primary hover:text-white transition-colors">
                    <i class="fab fa-linkedin-in text-sm"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 hover:bg-primary hover:text-white transition-colors">
                    <i class="fab fa-instagram text-sm"></i>
                </a>
            </div>

            <p class="text-gray-500 text-sm">© {{ date('Y') }} DocTime. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>