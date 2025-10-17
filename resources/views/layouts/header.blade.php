<header class="main-header">
    <div class="container">
        <div class="header-content d-flex justify-content-between align-items-center">
            <!-- Left: DocTime Logo -->
            <div class="logo-section">
                <h1 class="logo">
                    <i class="fas fa-heartbeat"></i>
                    DocTime
                </h1>
            </div>

            <!-- Right: Profile Section -->
            <div class="profile-section">
                @auth
                    <div class="dropdown">
                        <button class="btn btn-profile dropdown-toggle" type="button" id="profileDropdown"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-user me-2"></i>{{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user me-2"></i>Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cog me-2"></i>Settings
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="auth-buttons">
                        <a href="{{ route('login') }}" class="btn btn-login">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-register">
                            Register
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>

<style>
    .main-header {
        background: #20B2AA;
        color: white;
        padding: 15px 0;
        border-bottom: 3px solid #178A84;
    }

    .header-content {
        min-height: 50px;
    }

    .logo {
        font-size: 28px;
        font-weight: 600;
        margin: 0;
        color: white;
    }

    .logo i {
        margin-right: 8px;
        color: white;
    }

    /* Profile Button */
    .btn-profile {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 8px 16px;
        font-size: 14px;
        border-radius: 4px;
    }

    .btn-profile:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border-color: rgba(255, 255, 255, 0.3);
    }

    /* Auth Buttons */
    .auth-buttons {
        display: flex;
        gap: 10px;
    }

    .btn-login {
        background: transparent;
        color: white;
        border: 1px solid white;
        padding: 8px 16px;
        font-size: 14px;
        border-radius: 4px;
        text-decoration: none;
    }

    .btn-login:hover {
        background: white;
        color: #20B2AA;
        text-decoration: none;
    }

    .btn-register {
        background: #178A84;
        color: white;
        border: 1px solid #178A84;
        padding: 8px 16px;
        font-size: 14px;
        border-radius: 4px;
        text-decoration: none;
    }

    .btn-register:hover {
        background: #0F6B66;
        border-color: #0F6B66;
        color: white;
        text-decoration: none;
    }

    /* Dropdown Menu */
    .dropdown-menu {
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border-radius: 4px;
    }

    .dropdown-item {
        padding: 10px 16px;
        font-size: 14px;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .main-header {
            padding: 12px 0;
        }

        .logo {
            font-size: 24px;
        }

        .btn-profile,
        .btn-login,
        .btn-register {
            font-size: 13px;
            padding: 6px 12px;
        }

        .auth-buttons {
            gap: 8px;
        }
    }

    @media (max-width: 480px) {
        .logo {
            font-size: 20px;
        }

        .btn-profile,
        .btn-login,
        .btn-register {
            font-size: 12px;
            padding: 5px 10px;
        }
    }
</style>