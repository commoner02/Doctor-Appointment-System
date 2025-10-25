
<header class="bg-white shadow-sm border-b border-gray-200 ">
    <div class="max-w-7xl p-3 mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-2">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-heartbeat text-white text-lg"></i>
                    </div>
                    <h1 class="text-xl font-bold text-primary-600">DocTime</h1>
                </a>
            </div>

            <!-- Profile Section -->
            <div class="flex items-center space-x-2">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none">
                            <div class="w-6 h-6 bg-primary-500 rounded-full flex items-center justify-center text-white font-semibold text-xs">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden md:block font-medium text-sm">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-1 w-44 bg-white rounded-md shadow-lg border border-gray-200 py-1">
                            <div class="px-3 py-2 border-b border-gray-100">
                                <p class="text-xs font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}"
                                class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-user mr-2"></i>Edit Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block px-3 py-2 text-sm text-red-600 hover:bg-gray-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex space-x-2">
                        <a href="{{ route('login') }}"
                            class="px-3 py-1 text-xs font-medium text-primary-600 hover:text-primary-700">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-3 py-1 text-xs font-medium bg-primary-500 text-white rounded hover:bg-primary-600">
                            Register
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>

<!-- Alpine.js for dropdown -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>