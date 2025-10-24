<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Base validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'role' => ['required', 'string', 'in:patient,doctor'],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
            'address' => ['nullable', 'string', 'max:500'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ];

        // Role-specific validation
        if ($request->role === 'patient') {
            $rules = array_merge($rules, [
                'date_of_birth' => ['nullable', 'date', 'before:today'],
                'blood_group' => ['nullable', 'string', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
                'emergency_contact' => ['nullable', 'string', 'max:20'],
            ]);
        } elseif ($request->role === 'doctor') {
            $rules = array_merge($rules, [
                'speciality' => ['required', 'string', 'max:255'],
                'experience' => ['required', 'integer', 'min:0', 'max:50'],
                'qualifications' => ['required', 'string', 'max:500'],
                'license_number' => ['required', 'string', 'max:100', 'unique:doctors'],
                'bio' => ['nullable', 'string', 'max:1000'],
            ]);
        }

        $validatedData = $request->validate($rules);

        // Create user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'role' => $validatedData['role'],
            'password' => Hash::make($validatedData['password']),
            'status' => $validatedData['role'] === 'doctor' ? 'pending' : 'active', // Doctors need verification
        ]);

        // Create role-specific profile
        if ($user->role === 'patient') {
            Patient::create([
                'user_id' => $user->id,
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'] ?? null,
                'date_of_birth' => $validatedData['date_of_birth'] ?? null,
                'gender' => $validatedData['gender'] ?? null,
                'blood_group' => $validatedData['blood_group'] ?? null,
                'emergency_contact' => $validatedData['emergency_contact'] ?? null,
            ]);

            // Login patient immediately
            event(new Registered($user));
            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Account created successfully!');

        } elseif ($user->role === 'doctor') {
            Doctor::create([
                'user_id' => $user->id,
                'speciality' => $validatedData['speciality'],
                'experience' => $validatedData['experience'],
                'qualifications' => $validatedData['qualifications'],
                'license_number' => $validatedData['license_number'],
                'bio' => $validatedData['bio'] ?? null,
                'phone' => $validatedData['phone'],
                'verification_status' => 'pending',
            ]);

            event(new Registered($user));

            // Don't login doctor - redirect to pending verification page
            return redirect()->route('doctor.pending-verification')
                ->with('success', 'Registration successful! Please wait for admin verification.');
        }

        return redirect()->route('dashboard');
    }
}