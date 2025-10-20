
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
        }
        
        .auth-page {
            /* Special styling for auth pages - full height with no headers/footers */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .auth-page main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0;
        }
    </style>
</head>

<body class="{{ request()->routeIs('login') || request()->routeIs('register') ? 'auth-page' : '' }}">
    <div id="app">
        <!-- Navigation - hidden for login/register -->
        @unless (request()->routeIs('login') || request()->routeIs('register'))
            <nav class="navbar navbar-dark" style="background: #20B2AA; padding: 12px 0; border-bottom: 2px solid #178A84;">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}" style="font-size: 24px; font-weight: 600; color: white; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-heartbeat" style="font-size: 20px;"></i>
                        DocTime
                    </a>
                </div>
            </nav>
        @endunless

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer - hidden for login/register -->
        @unless (request()->routeIs('login') || request()->routeIs('register'))
            <footer class="text-center" style="background: white; border-top: 1px solid #e9ecef; padding: 20px 0;">
                <div class="container">
                    <small style="color: #666; font-size: 14px;">© {{ date('Y') }} DocTime - Healthcare Management System</small>
                </div>
            </footer>
        @endunless
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>