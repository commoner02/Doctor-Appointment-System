
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify Email - DocTime</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 500: '#20b2aa', 600: '#0d9488' }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <!-- Logo/Brand -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-primary-500">DocTime</h1>
            <p class="text-gray-600 mt-2">Verify Your Email</p>
        </div>

        <!-- Verification Form -->
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-envelope text-yellow-600 text-2xl"></i>
            </div>
            
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Check Your Email</h2>
            
            <p class="text-gray-600 mb-6">
                We've sent a verification link to your email address. Please click the link to verify your account.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-sm text-green-600 bg-green-50 p-3 rounded-lg">
                    A new verification link has been sent to your email address.
                </div>
            @endif

            <div class="space-y-3">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-200">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>
