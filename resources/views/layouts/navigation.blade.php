
@auth
<nav class="bg-primary-500 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex space-x-8 h-14">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium text-white hover:bg-primary-600 rounded-md {{ request()->routeIs('dashboard') ? 'bg-primary-600' : '' }}">
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </a>

            @if(auth()->user()->role === 'patient')
                <a href="{{ route('patient.doctors') }}" class="flex items-center px-3 py-2 text-sm font-medium text-white hover:bg-primary-600 rounded-md {{ request()->routeIs('patient.doctors*') ? 'bg-primary-600' : '' }}">
                    <i class="fas fa-user-md mr-2"></i>Find Doctors
                </a>
                <a href="{{ route('patient.appointments') }}" class="flex items-center px-3 py-2 text-sm font-medium text-white hover:bg-primary-600 rounded-md {{ request()->routeIs('patient.appointments*') ? 'bg-primary-600' : '' }}">
                    <i class="fas fa-calendar-alt mr-2"></i>My Appointments
                </a>
            @endif

            @if(auth()->user()->role === 'doctor')
                <a href="{{ route('doctor.chambers') }}" class="flex items-center px-3 py-2 text-sm font-medium text-white hover:bg-primary-600 rounded-md {{ request()->routeIs('doctor.chambers*') ? 'bg-primary-600' : '' }}">
                    <i class="fas fa-clinic-medical mr-2"></i>Chambers
                </a>
                <a href="{{ route('doctor.appointments') }}" class="flex items-center px-3 py-2 text-sm font-medium text-white hover:bg-primary-600 rounded-md {{ request()->routeIs('doctor.appointments*') ? 'bg-primary-600' : '' }}">
                    <i class="fas fa-calendar-check mr-2"></i>Appointments
                </a>
            @endif

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.patients') }}" class="flex items-center px-3 py-2 text-sm font-medium text-white hover:bg-primary-600 rounded-md {{ request()->routeIs('admin.patients*') ? 'bg-primary-600' : '' }}">
                    <i class="fas fa-users mr-2"></i>Patients
                </a>
                <a href="{{ route('admin.doctors') }}" class="flex items-center px-3 py-2 text-sm font-medium text-white hover:bg-primary-600 rounded-md {{ request()->routeIs('admin.doctors*') ? 'bg-primary-600' : '' }}">
                    <i class="fas fa-user-md mr-2"></i>Doctors
                </a>
                <a href="{{ route('admin.appointments') }}" class="flex items-center px-3 py-2 text-sm font-medium text-white hover:bg-primary-600 rounded-md {{ request()->routeIs('admin.appointments*') ? 'bg-primary-600' : '' }}">
                    <i class="fas fa-calendar-check mr-2"></i>Appointments
                </a>
                <a href="{{ route('admin.chambers') }}" class="flex items-center px-3 py-2 text-sm font-medium text-white hover:bg-primary-600 rounded-md {{ request()->routeIs('admin.chambers*') ? 'bg-primary-600' : '' }}">
                    <i class="fas fa-clinic-medical mr-2"></i>Chambers
                </a>
            @endif
        </div>
    </div>
</nav>
@endauth