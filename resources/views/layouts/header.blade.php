<header class="bg-white shadow-sm border-bottom">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center py-3">
            <!-- Left: Logo and Brand -->
            <div class="d-flex align-items-center">
                <a href="{{ route('home') }}" class="text-decoration-none d-flex align-items-center">
                    <div class="logo-container me-3">
                        <i class="fas fa-heartbeat text-primary"></i>
                    </div>
                    <h1 class="brand-name mb-0 text-primary fw-bold">DocTime</h1>
                </a>
            </div>

            <!-- Right: Profile Section -->
            <div class="header-actions">
                @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center" type="button"
                            id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar-circle me-2">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="d-none d-md-inline fw-medium">{{ auth()->user()->name }}</span>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li>
                                <div class="dropdown-header">
                                    <strong>{{ auth()->user()->name }}</strong>
                                    <small class="text-muted d-block">{{ ucfirst(auth()->user()->role) }}</small>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user me-2"></i>Profile Settings
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-1"></i>Register
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>

<style>
    .logo-container {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .logo-container i {
        color: white;
    }

    .brand-name {
        font-size: 1.75rem;
        letter-spacing: -0.025em;
    }

    .avatar-circle {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        padding: 0.5rem;
        min-width: 200px;
    }

    .dropdown-item {
        border-radius: 8px;
        padding: 0.5rem 1rem;
    }

    .dropdown-header {
        padding: 0.75rem 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 0.5rem;
    }
</style>