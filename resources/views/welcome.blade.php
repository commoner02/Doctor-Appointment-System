<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DocTime - Healthcare Management</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-primary-50 to-white font-sans">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white/80 backdrop-blur-sm shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-heartbeat text-white text-sm"></i>
                        </div>
                        <h1 class="text-xl font-bold text-primary-600">DocTime</h1>
                    </div>

                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 font-medium">
                            Dashboard
                        </a>
                    @else
                        <div class="flex space-x-3">
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 text-primary-600 hover:text-primary-700 font-medium">
                                Login
                            </a>
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 font-medium">
                                Get Started
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <main class="flex-1 flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center">
                    <div class="mb-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-heartbeat text-white text-xl"></i>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-3">
                            Your Health, <span class="text-primary-500">Simplified</span>
                        </h1>
                        <p class="text-base text-gray-600 mb-4 max-w-xl mx-auto">
                            Connect with verified doctors, book appointments easily, and manage your healthcare journey
                            all in one place.
                        </p>
                    </div>

                    @guest
                        <div class="flex justify-center space-x-3 mb-6">
                            <a href="{{ route('register') }}?role=patient"
                                class="px-5 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 font-semibold transition duration-200">
                                <i class="fas fa-user mr-2"></i>Register as Patient
                            </a>
                            <a href="{{ route('register') }}?role=doctor"
                                class="px-5 py-2 bg-white text-primary-600 border-2 border-primary-500 rounded-lg hover:bg-primary-50 font-semibold transition duration-200">
                                <i class="fas fa-user-md mr-2"></i>Register as Doctor
                            </a>
                        </div>
                    @endguest

                    <!-- Features -->
                    <div class="grid md:grid-cols-3 gap-6 mt-12">
                        <div
                            class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow duration-300 border border-gray-100">
                            <div
                                class="w-12 h-12 bg-primary-100 rounded-xl mx-auto mb-4 flex items-center justify-center">
                                <i class="fas fa-search text-primary-600 text-xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Find Doctors</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">Search and connect with verified healthcare
                                professionals in your area.</p>
                        </div>
                        <div
                            class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow duration-300 border border-gray-100">
                            <div
                                class="w-12 h-12 bg-primary-100 rounded-xl mx-auto mb-4 flex items-center justify-center">
                                <i class="fas fa-calendar-check text-primary-600 text-xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Easy Booking</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">Book appointments with just a few clicks
                                and manage your schedule.</p>
                        </div>
                        <div
                            class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow duration-300 border border-gray-100">
                            <div
                                class="w-12 h-12 bg-primary-100 rounded-xl mx-auto mb-4 flex items-center justify-center">
                                <i class="fas fa-shield-alt text-primary-600 text-xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Secure & Reliable</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">Your health data is protected with
                                enterprise-grade security.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-auto">
    <div class="max-w-7xl mx-auto px-4 py-6 flex justify-between">
        <p class="text-sm text-gray-500 mb-2 sm:mb-0">DocTime | Your Healthcare Partner</p>
        <div class="text-sm text-gray-500">
            © {{ date('Y') }} All Rights Reserved.
        </div>
    </div>
</footer>
    </div>
</body>

</html>