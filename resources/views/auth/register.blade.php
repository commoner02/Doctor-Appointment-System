
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register · DocTime</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-lg">

        <div class="text-center mb-4">
            <h1 class="text-2xl font-semibold text-primary-600">DocTime</h1>
            <p class="text-sm text-gray-600 mt-1">Quick Registration — Patient or Doctor</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4">
            @if (session('status'))
                <div class="mb-3 text-sm text-green-700 bg-green-50 px-3 py-2 rounded">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-2">
                @csrf

                <div class="flex gap-3 justify-center text-sm">
                    <label class="inline-flex items-center gap-2">
                        <input type="radio" name="role" value="patient" {{ old('role', 'patient') === 'patient' ? 'checked' : '' }} />
                        Patient
                    </label>
                    <label class="inline-flex items-center gap-2">
                        <input type="radio" name="role" value="doctor" {{ old('role') === 'doctor' ? 'checked' : '' }} />
                        Doctor
                    </label>
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Full name</label>
                    <input name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 border rounded" />
                    @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Email</label>
                        <input name="email" type="email" value="{{ old('email') }}" required
                            class="w-full px-3 py-2 border rounded" />
                        @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Phone</label>
                        <input name="phone" value="{{ old('phone') }}" class="w-full px-3 py-2 border rounded" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Gender</label>
                        <select name="gender" class="w-full px-3 py-2 border rounded">
                            <option value="">—</option>
                            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Address</label>
                        <input name="address" value="{{ old('address') }}" class="w-full px-3 py-2 border rounded" />
                    </div>
                </div>

                <div id="patient-fields" style="display:none">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Date of birth</label>
                            <input name="date_of_birth" type="date" value="{{ old('date_of_birth') }}"
                                class="w-full px-3 py-2 border rounded" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Blood group</label>
                            <select name="blood_group" class="w-full px-3 py-2 border rounded">
                                <option value="">—</option>
                                <option {{ old('blood_group') === 'A+' ? 'selected' : '' }}>A+</option>
                                <option {{ old('blood_group') === 'A-' ? 'selected' : '' }}>A-</option>
                                <option {{ old('blood_group') === 'B+' ? 'selected' : '' }}>B+</option>
                                <option {{ old('blood_group') === 'B-' ? 'selected' : '' }}>B-</option>
                                <option {{ old('blood_group') === 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option {{ old('blood_group') === 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option {{ old('blood_group') === 'O+' ? 'selected' : '' }}>O+</option>
                                <option {{ old('blood_group') === 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="doctor-fields" style="display:none">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Speciality</label>
                            <input name="speciality" value="{{ old('speciality') }}"
                                class="w-full px-3 py-2 border rounded" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Experience (yrs)</label>
                            <input name="experience" type="number" min="0" max="60" value="{{ old('experience') }}"
                                class="w-full px-3 py-2 border rounded" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Qualifications</label>
                        <input name="qualifications" value="{{ old('qualifications') }}"
                            class="w-full px-3 py-2 border rounded" />
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">License #</label>
                        <input name="license_number" value="{{ old('license_number') }}" placeholder="BMA-12345"
                            class="w-full px-3 py-2 border rounded" />
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input id="regPassword" name="password" type="password" required
                            class="w-full px-3 py-2 border rounded pr-14" />
                        <button type="button" id="regTogglePwd"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-gray-600 px-2 py-1 rounded">Show</button>
                    </div>
                    @error('password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Confirm Password</label>
                    <div class="relative">
                        <input id="regPasswordConfirmation" name="password_confirmation" type="password" required
                            class="w-full px-3 py-2 border rounded pr-14" />
                        <button type="button" id="regToggleConfirmPwd"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-gray-600 px-2 py-1 rounded">Show</button>
                    </div>
                    @error('password_confirmation') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <button type="submit"
                        class="w-full py-2 bg-primary-500 hover:bg-primary-600 text-white rounded">Create
                        account</button>
                </div>

                <p class="text-center text-xs text-gray-600">Have an account? <a href="{{ route('login') }}"
                        class="text-primary-600">Sign in</a></p>
            </form>
        </div>
    </div>

    <script>
        (function () {
            function toggleFields(role) {
                document.getElementById('patient-fields').style.display = role === 'patient' ? 'block' : 'none';
                document.getElementById('doctor-fields').style.display = role === 'doctor' ? 'block' : 'none';
            }

            document.addEventListener('DOMContentLoaded', function () {
                const sel = document.querySelector('input[name="role"]:checked')?.value || 'patient';
                toggleFields(sel);
                document.querySelectorAll('input[name="role"]').forEach(r => r.addEventListener('change', e => toggleFields(e.target.value)));

                const t1 = document.getElementById('regTogglePwd'), p1 = document.getElementById('regPassword');
                if (t1 && p1) t1.addEventListener('click', function () { if (p1.type === 'password') { p1.type = 'text'; this.textContent = 'Hide' } else { p1.type = 'password'; this.textContent = 'Show' } });

                const t2 = document.getElementById('regToggleConfirmPwd'), p2 = document.getElementById('regPasswordConfirmation');
                if (t2 && p2) t2.addEventListener('click', function () { if (p2.type === 'password') { p2.type = 'text'; this.textContent = 'Hide' } else { p2.type = 'password'; this.textContent = 'Show' } });
            });
        })();
    </script>
</body>

</html>