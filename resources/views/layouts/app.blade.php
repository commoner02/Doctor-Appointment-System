<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'DocTime - Healthcare Management')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --primary: #20B2AA;
            --primary-dark: #178A84;
            --primary-light: #4DCBC2;
            --primary-bg: #E6F7F6;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }

        .main-content {
            flex: 1;
            padding: 20px 0;
            min-height: calc(100vh - 200px);
        }

        /* Cards */
        .card {
            border: 1px solid #ddd;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            background: white;
        }

        .card-header {
            background: var(--primary-bg);
            border-bottom: 1px solid #ddd;
            padding: 15px 20px;
            border-radius: 6px 6px 0 0;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .card-body {
            padding: 20px;
        }

        /* Buttons */
        .btn {
            border-radius: 4px;
            font-weight: 500;
            padding: 8px 16px;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-secondary {
            background: #6c757d;
            border-color: #6c757d;
        }

        .btn-success {
            background: var(--primary-light);
            border-color: var(--primary-light);
        }

        .btn-success:hover {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            border-color: var(--primary);
        }

        /* Forms */
        .form-control,
        .form-select {
            border-radius: 4px;
            border: 1px solid #ddd;
            padding: 8px 12px;
            font-size: 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(32, 178, 170, 0.1);
        }

        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .input-group-text {
            background: var(--primary-bg);
            border-color: #ddd;
            color: var(--primary-dark);
        }

        /* Tables */
        .table {
            background: white;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 0;
        }

        .table thead th {
            background: var(--primary-bg);
            border-bottom: 1px solid #ddd;
            font-weight: 600;
            color: var(--primary-dark);
            padding: 12px;
            font-size: 14px;
        }

        .table tbody td {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 4px;
            padding: 12px 15px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: var(--primary-bg);
            color: var(--primary-dark);
            border-left: 4px solid var(--primary);
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        .alert-info {
            background: var(--primary-bg);
            color: var(--primary-dark);
            border-left: 4px solid var(--primary-light);
        }

        /* Badges */
        .badge {
            font-size: 11px;
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 10px;
        }

        .badge.bg-primary {
            background: var(--primary) !important;
        }

        .badge.bg-success {
            background: var(--primary-light) !important;
        }

        /* Navigation active state */
        .nav-link.active {
            background-color: var(--primary) !important;
            color: white !important;
        }

        /* Pagination */
        .pagination .page-link {
            color: var(--primary);
            border: 1px solid #ddd;
            border-radius: 4px;
            margin: 0 2px;
        }

        .pagination .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
        }

        .pagination .page-link:hover {
            color: var(--primary-dark);
            background: var(--primary-bg);
            border-color: var(--primary);
        }

        /* Dropdowns */
        .dropdown-menu {
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            padding: 8px 16px;
            font-size: 14px;
        }

        .dropdown-item:hover {
            background: var(--primary-bg);
            color: var(--primary-dark);
        }

        /* Breadcrumbs */
        .breadcrumb {
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px 15px;
            margin-bottom: 20px;
        }

        .breadcrumb-item.active {
            color: var(--primary-dark);
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        /* Progress bars */
        .progress {
            background: #e9ecef;
            border-radius: 4px;
        }

        .progress-bar {
            background: var(--primary);
        }

        /* Loading states */
        .spinner-border {
            color: var(--primary);
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* List groups */
        .list-group-item {
            border-color: #ddd;
        }

        .list-group-item.active {
            background: var(--primary);
            border-color: var(--primary);
        }

        /* Modals */
        .modal-header {
            background: var(--primary-bg);
            color: var(--primary-dark);
            border-bottom: 1px solid #ddd;
        }

        .modal-footer {
            border-top: 1px solid #ddd;
        }

        /* Navs and tabs */
        .nav-tabs .nav-link {
            color: #666;
            border: 1px solid transparent;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-dark);
            background: white;
            border-color: #ddd #ddd white;
        }

        .nav-pills .nav-link.active {
            background: var(--primary);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .main-content {
                padding: 15px 0;
            }

            .card-body {
                padding: 15px;
            }

            .card-header {
                padding: 12px 15px;
            }

            .table thead th,
            .table tbody td {
                padding: 8px;
                font-size: 13px;
            }

            .btn {
                padding: 6px 12px;
                font-size: 14px;
            }
        }

        /* Print styles */
        @media print {
            .main-content {
                padding: 0;
            }

            .card {
                box-shadow: none;
                border: 1px solid #ddd;
            }

            .btn {
                display: none;
            }
        }

        /* Utility classes */
        .text-primary {
            color: var(--primary) !important;
        }

        .bg-primary {
            background: var(--primary) !important;
        }

        .border-primary {
            border-color: var(--primary) !important;
        }

        /* Focus states */
        .btn:focus,
        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(32, 178, 170, 0.15);
        }

        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
    </style>
</head>

<body>
    <!-- Header -->
    @include('layouts.header')

    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Highlight active page in navigation
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && (currentPath === href || currentPath.startsWith(href + '/'))) {
                    link.classList.add('active');
                }
            });

            // Auto-hide success alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert-success, .alert-info');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 500);
                }, 5000);
            });

            // Form submission loading states
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn && !submitBtn.disabled) {
                        const originalText = submitBtn.innerHTML;
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

                        // Re-enable after 10 seconds as fallback
                        setTimeout(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        }, 10000);
                    }
                });
            });

            // Confirm delete actions
            const deleteButtons = document.querySelectorAll('[data-confirm-delete]');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                        e.preventDefault();
                    }
                });
            });

            // Auto-resize textareas
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                textarea.addEventListener('input', function () {
                    this.style.height = 'auto';
                    this.style.height = this.scrollHeight + 'px';
                });
            });

            // Tooltip initialization
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Popover initialization
            const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
        });

        // Global loading overlay functions
        window.showLoading = function () {
            const overlay = document.createElement('div');
            overlay.className = 'loading-overlay';
            overlay.innerHTML = '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>';
            overlay.id = 'global-loading';
            document.body.appendChild(overlay);
        };

        window.hideLoading = function () {
            const overlay = document.getElementById('global-loading');
            if (overlay) {
                overlay.remove();
            }
        };

        // AJAX setup for Laravel
        window.axios = window.axios || {};
        if (window.axios.defaults) {
            window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

            const token = document.head.querySelector('meta[name="csrf-token"]');
            if (token) {
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
            }
        }
    </script>

    @stack('scripts')
</body>

</html>