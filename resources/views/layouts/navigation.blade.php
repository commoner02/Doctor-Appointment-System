@if(auth()->check())
    @if(auth()->user()->role === 'admin')
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center space-x-8">
                    <a href="{{ route('admin.dashboard') }}"
                        class="py-4 px-1 border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.patients') }}"
                        class="py-4 px-1 border-b-2 {{ request()->routeIs('admin.patients*') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                        Patients
                    </a>
                    <a href="{{ route('admin.doctors') }}"
                        class="py-4 px-1 border-b-2 {{ request()->routeIs('admin.doctors*') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                        Doctors
                    </a>
                    <a href="{{ route('admin.appointments') }}"
                        class="py-4 px-1 border-b-2 {{ request()->routeIs('admin.appointments*') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                        Appointments
                    </a>
                    <a href="{{ route('admin.chambers') }}"
                        class="py-4 px-1 border-b-2 {{ request()->routeIs('admin.chambers*') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                        Chambers
                    </a>
                </div>
            </div>
        </nav>
    @elseif(auth()->user()->role === 'doctor')
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center space-x-8">
                    <a href="{{ route('doctor.dashboard') }}"
                        class="py-4 px-1 border-b-2 {{ request()->routeIs('doctor.dashboard') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                        Dashboard
                    </a>
                    <a href="{{ route('doctor.chambers') }}"
                        class="py-4 px-1 border-b-2 {{ request()->routeIs('doctor.chambers*') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                        My Chambers
                    </a>
                    <a href="{{ route('doctor.appointments') }}"
                        class="py-4 px-1 border-b-2 {{ request()->routeIs('doctor.appointments*') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                        Appointments
                    </a>
                </div>
            </div>
        </nav>
    @elseif(auth()->user()->role === 'patient')
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center space-x-8">
                    <a href="{{ route('patient.dashboard') }}"
                        class="py-4 px-1 border-b-2 {{ request()->routeIs('patient.dashboard') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                        Dashboard
                    </a>
                    <a href="{{ route('patient.doctors') }}"
                        class="py-4 px-1 border-b-2 {{ request()->routeIs('patient.doctors*') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                        Find Doctors
                    </a>
                    <a href="{{ route('patient.appointments') }}"
                        class="py-4 px-1 border-b-2 {{ request()->routeIs('patient.appointments*') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                        My Appointments
                    </a>
                </div>
            </div>
        </nav>
    @endif
@endif