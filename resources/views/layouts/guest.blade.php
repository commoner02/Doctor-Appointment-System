<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DocTime') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navigation */
        .navbar {
            background: #20B2AA !important;
            padding: 12px 0;
            border-bottom: 2px solid #178A84;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: 600;
            color: white !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-brand:hover {
            color: rgba(255, 255, 255, 0.9) !important;
            text-decoration: none;
        }

        .navbar-brand i {
            font-size: 20px;
        }

        /* Main Content */
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }

        /* Footer */
        footer {
            background: white;
            border-top: 1px solid #e9ecef;
            padding: 20px 0;
            margin-top: auto;
        }

        footer small {
            color: #666;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 20px;
            }

            .navbar-brand i {
                font-size: 18px;
            }

            main {
                padding: 15px 0;
            }

            footer {
                padding: 15px 0;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Navigation -->
        <nav class="navbar navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-heartbeat"></i>
                    DocTime
                </a>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="text-center">
            <div class="container">
                <small>© {{ date('Y') }} DocTime - Healthcare Management System</small>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>