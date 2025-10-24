
@auth
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="container-fluid px-4">
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavigation">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('dashboard*') ? 'active' : '' }}" 
                       href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </li>

                @if(auth()->user()->role === 'patient')
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('patient.doctors*') ? 'active' : '' }}"
                           href="{{ route('patient.doctors') }}">
                            <i class="fas fa-user-md me-2"></i>Find Doctors
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('patient.appointments*') ? 'active' : '' }}"
                           href="{{ route('patient.appointments') }}">
                            <i class="fas fa-calendar-alt me-2"></i>My Appointments
                        </a>
                    </li>
                @endif

                @if(auth()->user()->role === 'doctor')
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('doctor.appointments*') ? 'active' : '' }}"
                           href="{{ route('doctor.appointments') }}">
                            <i class="fas fa-calendar-check me-2"></i>Appointments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('doctor.chambers*') ? 'active' : '' }}"
                           href="{{ route('doctor.chambers') }}">
                            <i class="fas fa-clinic-medical me-2"></i>Chambers
                        </a>
                    </li>
                @endif

                @if(auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-users-cog me-2"></i>Admin Panel
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<style>
    .nav-link.active {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
    }
</style>
@endauth