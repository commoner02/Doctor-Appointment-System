<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            color: white;
        }

        .auth-buttons {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            margin: 1rem 0;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-custom {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            margin: 0 10px;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-custom:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
            text-decoration: none;
        }

        .logo {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <!-- Auth Buttons -->
    <div class="auth-buttons">
        @auth
            <a href="{{ url('/dashboard') }}" class="btn-custom">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn-custom"
                    style="background: rgba(220, 53, 69, 0.8); border-color: rgba(220, 53, 69, 0.8);">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn-custom">Log in</a>
            <a href="{{ route('register') }}" class="btn-custom">Register</a>
        @endauth
    </div>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="logo">🏥 HealthCare+</div>
                    <h1 class="display-4 fw-bold mb-4">
                        Your Health, Our Priority
                    </h1>
                    <p class="lead mb-4">
                        Modern healthcare management system connecting patients with qualified doctors.
                        Book appointments, manage health records, and get the care you deserve.
                    </p>

                    <div class="d-flex flex-wrap gap-3 mb-5">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg px-4 py-2">
                                Go to Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-lg px-4 py-2">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4 py-2">
                                Get Started
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4 py-2">
                                Sign In
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="feature-card text-center">
                                <div style="font-size: 3rem; margin-bottom: 1rem;">👨‍⚕️</div>
                                <h5>Find Doctors</h5>
                                <p>Connect with qualified healthcare professionals</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-card text-center">
                                <div style="font-size: 3rem; margin-bottom: 1rem;">📅</div>
                                <h5>Book Appointments</h5>
                                <p>Schedule visits at your convenience</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-card text-center">
                                <div style="font-size: 3rem; margin-bottom: 1rem;">📋</div>
                                <h5>Health Records</h5>
                                <p>Manage your medical history securely</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-card text-center">
                                <div style="font-size: 3rem; margin-bottom: 1rem;">💬</div>
                                <h5>24/7 Support</h5>
                                <p>Get help whenever you need it</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-white py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-12 mb-5">
                    <h2 class="fw-bold text-dark">Why Choose HealthCare+?</h2>
                    <p class="text-muted">Experience healthcare like never before</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center"
                        style="width: 80px; height: 80px; font-size: 2rem;">
                        🔒
                    </div>
                    <h5 class="mt-3">Secure & Private</h5>
                    <p class="text-muted">Your health data is encrypted and protected with industry-leading security
                        measures.</p>
                </div>

                <div class="col-md-4 text-center mb-4">
                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center"
                        style="width: 80px; height: 80px; font-size: 2rem;">
                        ⚡
                    </div>
                    <h5 class="mt-3">Fast & Reliable</h5>
                    <p class="text-muted">Quick appointment booking and instant notifications keep you informed.</p>
                </div>

                <div class="col-md-4 text-center mb-4">
                    <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center"
                        style="width: 80px; height: 80px; font-size: 2rem;">
                        🌟
                    </div>
                    <h5 class="mt-3">User Friendly</h5>
                    <p class="text-muted">Intuitive interface designed for patients, doctors, and healthcare providers.
                    </p>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12 text-center">
                    @auth
                        <h4 class="mb-3">Welcome back, {{ auth()->user()->name }}!</h4>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg me-3">
                            Go to Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-lg">
                                Logout
                            </button>
                        </form>
                    @else
                        <h4 class="mb-3">Ready to get started?</h4>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3">
                            Create Account
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                            Login Now
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h6>HealthCare+ &copy; {{ date('Y') }}</h6>
                    <p class="mb-0">Modern Healthcare Management System</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">
                        Built with Laravel & Bootstrap
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>