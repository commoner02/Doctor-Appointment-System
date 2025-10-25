<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input id="name" name="name" type="text"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                value="{{ old('name', auth()->user()->name) }}" required autofocus autocomplete="name">
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" name="email" type="email"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                value="{{ old('email', auth()->user()->email) }}" required autocomplete="username">
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
            <input id="phone" name="phone" type="text"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                value="{{ old('phone', auth()->user()->phone) }}" autocomplete="tel">
            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Address -->
        <div>
            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
            <input id="address" name="address" type="text"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                value="{{ old('address', auth()->user()->patient?->address ?? auth()->user()->doctor?->address) }}"
                autocomplete="address">
            @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Gender -->
        <div>
            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
            <select id="gender" name="gender"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                <option value="">Select gender</option>
                <option value="male" {{ old('gender', auth()->user()->patient?->gender ?? auth()->user()->doctor?->gender) === 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', auth()->user()->patient?->gender ?? auth()->user()->doctor?->gender) === 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ old('gender', auth()->user()->patient?->gender ?? auth()->user()->doctor?->gender) === 'other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('gender') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        @if(auth()->user()->role === 'doctor')
            <!-- Doctor-specific fields -->
            <div class="border-t pt-4">
                <h4 class="text-md font-medium text-gray-900 mb-3">Doctor Information</h4>

                <!-- Speciality -->
                <div>
                    <label for="speciality" class="block text-sm font-medium text-gray-700">Speciality</label>
                    <input id="speciality" name="speciality" type="text"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                        value="{{ old('speciality', auth()->user()->doctor?->speciality) }}">
                    @error('speciality') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Experience -->
                <div class="mt-3">
                    <label for="experience" class="block text-sm font-medium text-gray-700">Experience (years)</label>
                    <input id="experience" name="experience" type="number" min="0" max="60"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                        value="{{ old('experience', auth()->user()->doctor?->experience) }}">
                    @error('experience') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Qualifications -->
                <div class="mt-3">
                    <label for="qualifications" class="block text-sm font-medium text-gray-700">Qualifications</label>
                    <input id="qualifications" name="qualifications" type="text"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                        value="{{ old('qualifications', auth()->user()->doctor?->qualifications) }}">
                    @error('qualifications') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Verification Status (read-only) -->
                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700">Verification Status</label>
                    <div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm">
                        {{ ucfirst(auth()->user()->doctor?->verification_status ?? 'Pending') }}
                    </div>
                </div>
            </div>
        @endif

        @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
            <div class="border-t pt-4">
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('resent'))
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
        @endif

        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="fas fa-save mr-2"></i>
                Save
            </button>

            @if (session('status') === 'profile-information-updated')
                <div class="text-sm text-green-600 font-medium">
                    Profile updated successfully.
                </div>
            @endif
        </div>
    </form>
</section>