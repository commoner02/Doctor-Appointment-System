<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $user = $this->user();
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ];

        // Add role-specific validation
        if ($user->isPatient()) {
            $rules = array_merge($rules, [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:20'],
                'gender' => ['required', 'in:Male,Female,Other'],
                'date_of_birth' => ['required', 'date'],
                'blood_group' => ['required', 'string'],
                'address' => ['required', 'string'],
            ]);
        } elseif ($user->isDoctor()) {
            $rules = array_merge($rules, [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:20'],
                'speciality' => ['required', 'string'],
                'license_no' => ['required', 'string'],
                'qualifications' => ['required', 'string'],
            ]);
        }

        return $rules;
    }
}
