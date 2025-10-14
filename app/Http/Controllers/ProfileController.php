<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Load role-specific data
        if ($user->isPatient()) {
            $user->load('patient');
        } elseif ($user->isDoctor()) {
            $user->load('doctor');
        }

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update role-specific information
        if ($user->isPatient() && $user->patient) {
            $user->patient->update([
                'first_name' => $request->first_name ?? $user->patient->first_name,
                'last_name' => $request->last_name ?? $user->patient->last_name,
                'phone' => $request->phone ?? $user->patient->phone,
                'gender' => $request->gender ?? $user->patient->gender,
                'date_of_birth' => $request->date_of_birth ?? $user->patient->date_of_birth,
                'blood_group' => $request->blood_group ?? $user->patient->blood_group,
                'address' => $request->address ?? $user->patient->address,
            ]);
        } elseif ($user->isDoctor() && $user->doctor) {
            $user->doctor->update([
                'first_name' => $request->first_name ?? $user->doctor->first_name,
                'last_name' => $request->last_name ?? $user->doctor->last_name,
                'phone' => $request->phone ?? $user->doctor->phone,
                'speciality' => $request->speciality ?? $user->doctor->speciality,
                'license_no' => $request->license_no ?? $user->doctor->license_no,
                'qualifications' => $request->qualifications ?? $user->doctor->qualifications,
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
