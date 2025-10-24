<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'DocTime - Healthcare Management')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional CSS -->
    @stack('styles')
</head>

<body class="bg-gray-50">
    <div id="app" class="min-vh-100 d-flex flex-column">
        <!-- Header -->
        @include('layouts.header')

        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Main Content -->
        <main class="flex-grow-1 py-4">
            <!-- Page Header -->
            @hasSection('page-header')
            <div class="container-fluid px-4 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1 text-gray-900">@yield('page-title')</h1>
                        <p class="text-muted mb-0">@yield('page-description')</p>
                    </div>
                    <div>
                        @yield('page-actions')
                    </div>
                </div>
            </div>
            @endif

            <!-- Flash Messages -->
            @if(session('success'))
            <div class="container-fluid px-4 mb-4">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="container-fluid px-4 mb-4">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
            @endif

            <!-- Page Content -->
            <div class="container-fluid px-4">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        @include('layouts.footer')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Additional JS -->
    @stack('scripts')
</body>

</html>