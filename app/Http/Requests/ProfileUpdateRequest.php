<?php

namespace App\Http\Requests;

use App\Models\User;
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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
        ];

        // Role-specific validation
        if ($this->user()->role === 'doctor') {
            $rules = array_merge($rules, [
                'speciality' => ['nullable', 'string', 'max:255'],
                'experience' => ['nullable', 'integer', 'min:0', 'max:50'],
                'qualifications' => ['nullable', 'string', 'max:500'],
            ]);
        }

        return $rules;
    }
}
