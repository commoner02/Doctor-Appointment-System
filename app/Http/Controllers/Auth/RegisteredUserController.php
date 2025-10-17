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
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // Base validation rules (no full name field; we'll compose it)
        $rules = [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:patient,doctor'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
        ];

        // Add conditional validation based on role
        if ($request->role === 'patient') {
            $rules = array_merge($rules, [
                'gender' => ['required', 'in:Male,Female,Other'],
                'date_of_birth' => ['required', 'date'],
                'blood_group' => ['required', 'string'],
                'address' => ['required', 'string'],
            ]);
        } elseif ($request->role === 'doctor') {
            $rules = array_merge($rules, [
                'speciality' => ['required', 'string'],
                'license_no' => ['required', 'string'],
                'qualifications' => ['required', 'string'],
            ]);
        }

        $request->validate($rules);

        try {
            DB::beginTransaction();

            $composedName = trim($request->first_name.' '.$request->last_name);
            $user = User::create([
                'name' => $composedName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'is_verified' => $request->role === 'patient' ? true : false,
            ]);

            if ($request->role === 'patient') {
                Patient::create([
                    'user_id' => $user->id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'gender' => $request->gender,
                    'phone' => $request->phone,
                    'date_of_birth' => $request->date_of_birth,
                    'blood_group' => $request->blood_group,
                    'address' => $request->address,
                ]);
            } else {
                Doctor::create([
                    'user_id' => $user->id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'speciality' => $request->speciality,
                    'phone' => $request->phone,
                    'license_no' => $request->license_no,
                    'qualifications' => $request->qualifications,
                ]);
            }

            DB::commit();

            event(new Registered($user));
            Auth::login($user);

            // Redirect based on role
            if ($user->role === 'patient') {
                return redirect()->route('patient.dashboard')->with('success', 'Registration successful!');
            } else {
                return redirect()->route('guest.waiting')->with('success', 'Registration successful! Please wait for admin verification.');
            }

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Registration failed. Please try again.'])->withInput();
        }
    }
}