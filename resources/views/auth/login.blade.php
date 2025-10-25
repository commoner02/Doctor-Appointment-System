
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login · DocTime</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
        <div class="text-center mb-4">
            <h1 class="text-2xl font-semibold text-primary-600">DocTime</h1>
            <p class="text-sm text-gray-600 mt-1">Sign in to manage appointments</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4">
            @if (session('status'))
                <div class="mb-3 text-sm text-green-700 bg-green-50 px-3 py-2 rounded">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-3 text-sm text-red-700 bg-red-50 px-3 py-2 rounded">
                    Invalid credentials. Please check your email and password.
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-3">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-primary-200 focus:border-primary-500" />
                    @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" required
                            class="w-full px-3 py-2 border rounded pr-14 focus:ring-2 focus:ring-primary-200 focus:border-primary-500" />
                        <button type="button" id="loginTogglePwd"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-gray-600 px-2 py-1 rounded">
                            Show
                        </button>
                    </div>
                    @error('password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit"
                    class="w-full py-2 text-sm rounded bg-primary-500 hover:bg-primary-600 text-white font-medium">
                    Sign In
                </button>

                <div class="mt-3 text-center text-xs text-gray-600">
                    <p>Don't have an account? <a href="{{ route('register') }}" class="text-primary-600">Register</a>
                    </p>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="block mt-1 text-primary-600">Forgot password?</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('loginTogglePwd');
            const pwd = document.getElementById('password');
            if (!toggle || !pwd) return;
            toggle.addEventListener('click', function () {
                if (pwd.type === 'password') { pwd.type = 'text'; this.textContent = 'Hide'; }
                else { pwd.type = 'password'; this.textContent = 'Show'; }
            });
        });
    </script>
</body>

</html>