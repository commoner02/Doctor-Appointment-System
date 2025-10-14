<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <!-- Logo/Brand -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="fas fa-heartbeat me-2"></i>HealthCare+
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                @auth
                    @if(auth()->user()->isPatient())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('patient.doctors') ? 'active' : '' }}"
                                href="{{ route('patient.doctors') }}">
                                <i class="fas fa-user-md me-1"></i>Find Doctors
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('patient.appointments') ? 'active' : '' }}"
                                href="{{ route('patient.appointments') }}">
                                <i class="fas fa-calendar-check me-1"></i>My Appointments
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->isDoctor())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('doctor.appointments') ? 'active' : '' }}"
                                href="{{ route('doctor.appointments') }}">
                                <i class="fas fa-calendar-alt me-1"></i>Appointments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('doctor.chambers') ? 'active' : '' }}"
                                href="{{ route('doctor.chambers') }}">
                                <i class="fas fa-building me-1"></i>Chambers
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-cog me-1"></i>Admin Panel
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- User Menu -->
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown">
                            <div class="avatar-circle me-2">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user me-2"></i>Profile
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
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i>Register
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    .avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .nav-link.active {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
    }

    .dropdown-menu {
        border: none;
        box-shadow: var(--card-shadow-lg);
        border-radius: 12px;
        padding: 0.5rem;
    }

    .dropdown-item {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: #f8fafc;
    }
</style>