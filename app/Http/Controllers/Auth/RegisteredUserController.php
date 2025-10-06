<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $departments = Department::all();
        return view('auth.register', compact('departments'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Common validation for all users
        $validationRules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:patient,doctor'],
            'phone' => ['required', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date'],
            'address' => ['required', 'string', 'max:500'],
        ];

        // Role-specific validation
        if ($request->role === 'patient') {
            $validationRules['gender'] = ['required', 'in:male,female,other'];
        }

        if ($request->role === 'doctor') {
            $validationRules['department_id'] = ['required', 'exists:departments,id'];
            $validationRules['specialty'] = ['required', 'string', 'max:100'];
            $validationRules['medical_license'] = ['required', 'string', 'max:100'];
            $validationRules['qualifications'] = ['required', 'string', 'max:1000'];
        }

        $request->validate($validationRules);

        // Determine user status
        $status = $request->role === 'patient' ? 'active' : 'pending';

        // Store registration data for doctors (for admin approval)
        $registrationData = null;
        if ($request->role === 'doctor') {
            $registrationData = [
                'department_id' => $request->department_id,
                'specialty' => $request->specialty,
                'medical_license' => $request->medical_license,
                'qualifications' => $request->qualifications,
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'address' => $request->address,
            ];
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $status,
            'registration_data' => $registrationData,
        ]);

        // Split name for patient record
        $nameParts = explode(' ', $request->name, 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';

        // Create patient record immediately for patients
        if ($request->role === 'patient') {
            Patient::create([
                'user_id' => $user->id,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'address' => $request->address,
            ]);

            event(new Registered($user));
            Auth::login($user);
            
            return redirect()->route('dashboard')->with('success', 'Patient account created successfully!');
        }

        // For doctors - just create user, wait for admin approval
        if ($request->role === 'doctor') {
            event(new Registered($user));
            
            return redirect()->route('login')->with('success', 'Doctor application submitted! Please wait for admin approval.');
        }

        return redirect('/');
    }
}