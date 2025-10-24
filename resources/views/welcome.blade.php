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
    
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#20b2aa',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gradient-to-br from-primary-50 to-white font-sans">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white/80 backdrop-blur-sm shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-heartbeat text-white text-xl"></i>
                        </div>
                        <h1 class="text-3xl font-bold text-primary-600">DocTime</h1>
                    </div>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 font-medium">
                            Dashboard
                        </a>
                    @else
                        <div class="flex space-x-3">
                            <a href="{{ route('login') }}" class="px-6 py-2 text-primary-600 hover:text-primary-700 font-medium">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="px-6 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 font-medium">
                                Get Started
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <main class="flex-1 flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="text-center">
                    <div class="mb-8">
                        <div class="w-20 h-20 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl mx-auto mb-6 flex items-center justify-center">
                            <i class="fas fa-heartbeat text-white text-3xl"></i>
                        </div>
                        <h1 class="text-5xl font-bold text-gray-900 mb-6">
                            Your Health, <span class="text-primary-500">Simplified</span>
                        </h1>
                        <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                            Connect with verified doctors, book appointments easily, and manage your healthcare journey all in one place.
                        </p>
                    </div>

                    @guest
                        <div class="flex justify-center space-x-4 mb-12">
                            <a href="{{ route('register') }}?role=patient" class="px-8 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 font-semibold text-lg transition duration-200">
                                <i class="fas fa-user mr-2"></i>Register as Patient
                            </a>
                            <a href="{{ route('register') }}?role=doctor" class="px-8 py-3 bg-white text-primary-600 border-2 border-primary-500 rounded-lg hover:bg-primary-50 font-semibold text-lg transition duration-200">
                                <i class="fas fa-user-md mr-2"></i>Register as Doctor
                            </a>
                        </div>
                    @endguest

                    <!-- Features -->
                    <div class="grid md:grid-cols-3 gap-8 mt-16">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-primary-100 rounded-xl mx-auto mb-4 flex items-center justify-center">
                                <i class="fas fa-search text-primary-600 text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Find Doctors</h3>
                            <p class="text-gray-600">Search and connect with verified healthcare professionals in your area.</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-primary-100 rounded-xl mx-auto mb-4 flex items-center justify-center">
                                <i class="fas fa-calendar-check text-primary-600 text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Easy Booking</h3>
                            <p class="text-gray-600">Book appointments with just a few clicks and manage your schedule.</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-primary-100 rounded-xl mx-auto mb-4 flex items-center justify-center">
                                <i class="fas fa-shield-alt text-primary-600 text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Secure & Reliable</h3>
                            <p class="text-gray-600">Your health data is protected with enterprise-grade security.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="text-center text-gray-500">
                    <p>&copy; {{ date('Y') }} DocTime. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>