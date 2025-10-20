
<!DOCTYPE html>
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

<body class="font-inter bg-gray-900 text-gray-100">
    <!-- Hero Section -->
    <section class="min-h-screen flex items-center justify-center bg-gray-900 px-4">
        <div class="text-center max-w-3xl">
            <div class="w-24 h-24 bg-primary rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-heartbeat text-white text-5xl"></i>
            </div>

            <h1 class="text-5xl md:text-6xl font-bold mb-4 text-white">DocTime</h1>
            <p class="text-xl text-gray-400 mb-10">
                Connect with verified doctors and manage your health appointments
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('login') }}" 
                   class="bg-primary text-white font-medium py-4 px-10 rounded-lg hover:bg-primary-light transition-colors">
                    Sign In
                </a>
                <a href="{{ route('register') }}" 
                   class="bg-gray-800 text-white font-medium py-4 px-10 rounded-lg hover:bg-gray-700 transition-colors">
                    Get Started
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gray-800 px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-white mb-16">How It Works</h2>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- For Patients -->
                <div class="bg-gray-900 p-8 rounded-lg text-center">
                    <div class="w-16 h-16 bg-primary rounded-lg flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-user text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">For Patients</h3>
                    <p class="text-gray-400">
                        Find verified doctors, book appointments, and manage your health records easily.
                    </p>
                </div>

                <!-- For Doctors -->
                <div class="bg-gray-900 p-8 rounded-lg text-center">
                    <div class="w-16 h-16 bg-primary rounded-lg flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-user-md text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">For Doctors</h3>
                    <p class="text-gray-400">
                        Manage chambers, schedule appointments, and maintain your professional profile.
                    </p>
                </div>

                <!-- For Admins -->
                <div class="bg-gray-900 p-8 rounded-lg text-center">
                    <div class="w-16 h-16 bg-primary rounded-lg flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-cog text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">For Admins</h3>
                    <p class="text-gray-400">
                        Oversee the platform, verify doctors, and ensure quality healthcare services.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-gray-900 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold text-primary mb-2">500+</div>
                    <div class="text-gray-400">Verified Doctors</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-primary mb-2">10K+</div>
                    <div class="text-gray-400">Happy Patients</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-primary mb-2">50K+</div>
                    <div class="text-gray-400">Appointments</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-primary mb-2">99%</div>
                    <div class="text-gray-400">Satisfaction</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-950 py-12 px-4 text-center">
        <div class="max-w-6xl mx-auto">
            <div class="text-2xl font-bold mb-4 text-white">
                <i class="fas fa-heartbeat text-primary mr-2"></i>DocTime
            </div>
            <p class="text-gray-400 mb-6">Your trusted healthcare partner</p>

            <div class="flex justify-center