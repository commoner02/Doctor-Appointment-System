<section class="space-y-6">
    <header class="mb-6">
        <h2 class="text-lg font-medium text-red-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-red-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
        @csrf
        @method('delete')

        <div class="bg-red-50 border border-red-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                </div>

                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        {{ __('Are you sure you want to delete your account?') }}
                    </h3>

                    <div class="mt-2 text-sm text-red-700">
                        <p>
                            {{ __('Please enter your password to confirm you would like to permanently delete your account.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

            <x-text-input id="password" name="password" type="password"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                placeholder="{{ __('Password') }}" autocomplete="current-password" />

            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-danger-button
                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="fas fa-trash mr-2"></i>
                {{ __('Delete Account') }}
            </x-danger-button>
        </div>
    </form>
</section>