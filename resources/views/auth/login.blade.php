
@extends('layouts.guest')

@section('content')
    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-7 col-lg-5">
                    <!-- Logo Section -->
                    <div class="text-center mb-4">
                        <div class="logo-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h2>DocTime</h2>
                        <p class="subtitle">Healthcare Management System</p>
                    </div>

                    <!-- Login Card -->
                    <div class="login-card">
                        <div class="card-header">
                            <h4>Sign In</h4>
                            <p>Enter your credentials to continue</p>
                        </div>

                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                        name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="password-wrapper">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" placeholder="Enter your password" required>
                                        <button type="button" class="toggle-password" id="togglePasswordBtn" aria-label="Show password" aria-pressed="false">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember me
                                    </label>
                                </div>

                                <button type="submit" class="btn-login">
                                    Sign In
                                </button>

                                <div class="text-center mt-3">
                                    <p>Don't have an account?
                                        <a href="{{ route('register') }}">Create one here</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .login-container {
            min-height: 100vh; /* Changed from calc(100vh - 140px) */
            background: #f8f9fa;
            padding: 40px 20px;
            display: flex;
            align-items: center;
            width: 100%;
        }

        /* Optional: ensure no extra padding on main from layout */
        main {
            padding-bottom: 0 !important;
        }

        .logo-icon {
            width: 60px;
            height: 60px;
            background: #20B2AA;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 24px;
            color: white;
        }

        .login-container h2 {
            font-size: 28px;
            font-weight: 600;
            color: #20B2AA;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #666;
            font-size: 14px;
            margin: 0;
        }

        .login-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .card-header {
            background: #20B2AA;
            color: white;
            padding: 18px;
            text-align: center;
        }

        .card-header h4 {
            font-size: 20px;
            font-weight: 600;
            margin: 0 0 5px 0;
        }

        .card-header p {
            font-size: 14px;
            margin: 0;
            opacity: 0.9;
        }

        .card-body {
            padding: 28px 32px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 6px;
            display: block;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px 12px;
            font-size: 14px;
            width: 100%;
            transition: border-color 0.2s ease;
        }

        .form-control:focus {
            border-color: #20B2AA;
            outline: none;
            box-shadow: 0 0 0 2px rgba(32, 178, 170, 0.1);
        }

        .form-check-label {
            font-size: 14px;
            color: #666;
        }

        .btn-login {
            background: #20B2AA;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            margin: 8px 0 18px;
            transition: background-color 0.2s ease;
        }

        .btn-login:hover {
            background: #178A84;
        }

        .text-center p {
            font-size: 14px;
            color: #666;
            margin: 0;
        }

        .text-center a {
            color: #20B2AA;
            text-decoration: none;
            font-weight: 500;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        .alert {
            border: none;
            border-radius: 4px;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }

        /* Password toggle */
        .password-wrapper {
            position: relative;
        }
        .password-wrapper .form-control {
            padding-right: 42px;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }
        .toggle-password:hover,
        .toggle-password:focus {
            color: #20B2AA;
            outline: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                padding: 20px 15px;
            }

            .card-body {
                padding: 22px 20px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('password');
            const btn = document.getElementById('togglePasswordBtn');
            if (!input || !btn) return;

            const icon = btn.querySelector('i');
            btn.addEventListener('click', () => {
                const show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        });
    </script>
@endsection