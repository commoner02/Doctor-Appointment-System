@extends('layouts.guest')

@section('title', 'Confirm Password')

@section('content')
    <div class="text-center mb-6">
        <div class="flex justify-center mb-4">
            <div
                class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-shield-alt text-white text-xl"></i>
            </div>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">Confirm Password</h2>
        <p class="text-gray-600 mt-1">Please confirm your password before continuing.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <div class="mt-1 relative">
                <input id="password"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-300 @enderror"
                    type="password" name="password" required autocomplete="current-password">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
            </div>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit"
                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <i class="fas fa-check text-primary-500 group-hover:text-primary-400"></i>
                </span>
                Confirm
            </button>
        </div>
    </form>
@endsection