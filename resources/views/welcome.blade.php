
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DocTime') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #20B2AA;
            --primary-dark: #178A84;
            --primary-light: #4DCBC2;
            --primary-bg: #E6F7F6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
        }

        /* Hero Section */
        .hero {
            background: var(--primary);
            color: white;
            padding: 60px 0;
            text-align: center;
        }

        .hero-logo {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .hero-logo i {
            font-size: 36px;
            color: white;
        }

        .hero-title {
            font-size: 48px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .hero-subtitle {
            font-size: 18px;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-hero {
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 16px;
        }

        .btn-hero-primary {
            background: white;
            color: var(--primary);
            border: 2px solid white;
        }

        .btn-hero-primary:hover {
            background: transparent;
            color: white;
            text-decoration: none;
        }

        .btn-hero-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-hero-secondary:hover {
            background: white;
            color: var(--primary);
            text-decoration: none;
        }

        /* Features Section */
        .features {
            padding: 60px 0;
            background: white;
        }

        .section-title {
            font-size: 32px;
            font-weight: 600;
            color: #333;
            text-align: center;
            margin-bottom: 50px;
        }

        .feature-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 30px 20px;
            text-align: center;
            transition: all 0.2s ease;
            height: 100%;
        }

        .feature-card:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
            color: white;
        }

        .feature-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }

        .feature-text {
            color: #666;
            line-height: 1.6;
            font-size: 15px;
        }

        /* Stats Section */
        .stats {
            background: var(--primary-bg);
            padding: 50px 0;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 16px;
            color: #666;
        }

        /* Footer */
        .footer {
            background: #333;
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        .footer-logo {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .footer-text {
            color: #ccc;
            margin-bottom: 20px;
        }

        .social-links {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-bottom: 20px;
        }

        .social-link {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: background 0.2s ease;
        }

        .social-link:hover {
            background: var(--primary);
            color: white;
        }

        .footer-bottom {
            color: #999;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero {
                padding: 40px 0;
            }

            .hero-title {
                font-size: 36px;
            }

            .hero-subtitle {
                font-size: 16px;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-hero {
                width: 100%;
                max-width: 250px;
            }

            .section-title {
                font-size: 28px;
            }

            .features {
                padding: 40px 0;
            }

            .stats {
                padding: 30px 0;
            }
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-logo">
                <i class="fas fa-heartbeat"></i>
            </div>

            <h1 class="hero-title">DocTime</h1>
            <p class="hero-subtitle">
                Connect with verified doctors and manage your health appointments
            </p>

            <div class="hero-buttons">
                <a href="{{ route('login') }}" class="btn-hero btn-hero-primary">
                    Sign In
                </a>
                <a href="{{ route('register') }}" class="btn-hero btn-hero-secondary">
                    Get Started
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <h2 class="section-title">How It Works</h2>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3 class="feature-title">For Patients</h3>
                        <p class="feature-text">
                            Find verified doctors, book appointments, and manage your health records easily.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h3 class="feature-title">For Doctors</h3>
                        <p class="feature-text">
                            Manage chambers, schedule appointments, and maintain your professional profile.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-cog"></i>
                        </div>
                        <h3 class="feature-title">For Admins</h3>
                        <p class="feature-text">
                            Oversee the platform, verify doctors, and ensure quality healthcare services.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Verified Doctors</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <div class="stat-number">10K+</div>
                        <div class="stat-label">Happy Patients</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <div class="stat-number">50K+</div>
                        <div class="stat-label">Appointments</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <div class="stat-number">99%</div>
                        <div class="stat-label">Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-logo">
                <i class="fas fa-heartbeat me-2"></i>DocTime
            </div>
            <p class="footer-text">
                Your trusted healthcare partner
            </p>

            <div class="social-links">
                <a href="#" class="social-link">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="social-link">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="social-link">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="#" class="social-link">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>

            <p class="footer-bottom">
                © {{ date('Y') }} DocTime. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>