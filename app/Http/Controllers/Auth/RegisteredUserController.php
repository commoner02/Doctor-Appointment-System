<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|in:patient,doctor',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|confirmed|min:8',
            'speciality' => 'nullable|string|max:255',
            'license_no' => 'nullable|string|max:255',
            'qualifications' => 'nullable|string|max:2000',
            'gender' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|string|max:5',
            'address' => 'nullable|string|max:1000',
        ]);

        $user = User::create([
            'role' => $request->role,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'is_verified' => $request->role === 'doctor' ? false : true, // doctors start pending
            'password' => Hash::make($request->password),
        ]);

        if ($user->role === 'doctor') {
            Doctor::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'speciality' => $request->speciality,
                'license_no' => $request->license_no,
                'qualifications' => $request->qualifications,
                // removed is_verified here (it's on users table)
            ]);
        } else {
            Patient::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'blood_group' => $request->blood_group,
                'address' => $request->address,
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        if ($user->role === 'doctor') {
            return $user->is_verified
                ? redirect()->route('doctor.dashboard')
                : redirect()->route('doctor.pending');
        }

        return redirect()->route('dashboard');
    }
}