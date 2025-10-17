<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                @auth
                    @if(auth()->user()->isPatient())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('patient.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('doctor.browse') }}">Find Doctors</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('patient.appointments') }}">My Appointments</a>
                        </li>
                    @endif

                    @if(auth()->user()->isDoctor())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('doctor.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('doctor.appointments') }}">Appointments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('doctor.chambers') }}">Chambers</a>
                        </li>
                    @endif

                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.patients') }}">Patients</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.doctors') }}">Doctors</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.appointments') }}">Appointments</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar {
        padding: 12px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .navbar-nav {
        align-items: center;
        gap: 15px;
    }

    .nav-link {
        font-weight: 500;
        color: #666 !important;
        padding: 8px 16px !important;
        border-radius: 4px;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .nav-link:hover {
        background-color: #20B2AA;
        color: white !important;
    }

    .nav-link.active {
        background-color: #20B2AA;
        color: white !important;
    }

    /* Mobile responsive */
    @media (max-width: 991.98px) {
        .navbar-nav {
            text-align: center;
            margin-top: 15px;
            gap: 8px;
        }

        .nav-link {
            margin: 3px 0;
            padding: 6px 12px !important;
            font-size: 13px;
        }
    }
</style>