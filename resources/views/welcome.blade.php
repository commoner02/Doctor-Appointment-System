<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'HealthCare+') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --light: #f8fafc;
            --dark: #2d3748;
            --muted: #718096;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--light);
        }

        .hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            min-height: 60vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 40%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: rotate(15deg);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .logo {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            backdrop-filter: blur(10px);
        }

        .logo i {
            font-size: 2rem;
            color: white;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-hero {
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary-hero {
            background: white;
            color: var(--primary);
            border: 2px solid white;
        }

        .btn-primary-hero:hover {
            background: transparent;
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-hero {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-outline-hero:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-2px);
        }

        .features {
            padding: 4rem 0;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            text-align: center;
            margin-bottom: 3rem;
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.5rem;
            color: white;
        }

        .feature-icon.patient {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .feature-icon.doctor {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .feature-icon.admin {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .feature-text {
            color: var(--muted);
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .stats {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 3rem 0;
            color: white;
        }

        .stat-card {
            text-align: center;
            padding: 1.5rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        .footer {
            background: var(--dark);
            color: white;
            padding: 2rem 0;
            text-align: center;
        }

        .footer-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .footer-logo {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .footer-text {
            color: #a0aec0;
            font-size: 0.9rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-link {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: var(--primary);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .hero {
                min-height: 50vh;
                padding: 2rem 0;
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn-hero {
                width: 100%;
                max-width: 250px;
            }
            
            .features {
                padding: 3rem 0;
            }
            
            .section-title {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center hero-content">
                    <div class="logo">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    
                    <h1 class="hero-title">HealthCare+</h1>
                    <p class="hero-subtitle">
                        Connect with verified doctors and manage your health effortlessly
                    </p>
                    
                    <div class="cta-buttons">
                        <a href="{{ route('login') }}" class="btn-hero btn-primary-hero">
                            <i class="fas fa-sign-in-alt"></i>
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="btn-hero btn-outline-hero">
                            <i class="fas fa-user-plus"></i>
                            Get Started
                        </a>
                    </div>
                </div>
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
                        <div class="feature-icon patient">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3 class="feature-title">For Patients</h3>
                        <p class="feature-text">
                            Find verified doctors, book appointments, and manage your health records in one place.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon doctor">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h3 class="feature-title">For Doctors</h3>
                        <p class="feature-text">
                            Manage chambers, schedule appointments, and maintain your professional profile easily.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon admin">
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
                    <div class="stat-card">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Verified Doctors</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number">10K+</div>
                        <div class="stat-label">Happy Patients</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number">50K+</div>
                        <div class="stat-label">Appointments</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
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
            <div class="footer-content">
                <div class="footer-logo">
                    <i class="fas fa-heartbeat me-2"></i>HealthCare+
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
                
                <p class="footer-text mb-0">
                    © {{ date('Y') }} HealthCare+. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>