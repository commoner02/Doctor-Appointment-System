<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <!-- Logo/Brand -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            🏥 HealthCare+
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}" 
                       href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>

                @auth
                    @if(auth()->user()->isPatient())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('doctors.*') ? 'active' : '' }}" 
                               href="{{ route('doctors.browse') }}">
                                Find Doctors
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}" 
                               href="{{ route('appointments.my') }}">
                                My Appointments
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->isDoctor())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('doctor.appointments') ? 'active' : '' }}" 
                               href="{{ route('doctor.appointments') }}">
                                My Appointments
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Manage Users
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- User Menu -->
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                           data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user me-2"></i>Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>