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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user();
        $rules = [];

        // Always validate name if provided
        $rules['name'] = ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/', 'min:2'];

        // Only validate email if it's different from current email
        if ($this->input('email') !== $user->email) {
            $rules['email'] = [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|yahoo\.com)$/',
                Rule::unique(User::class)->ignore($user->id),
            ];
        } else {
            // If email is the same, just basic validation without unique check
            $rules['email'] = [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|yahoo\.com)$/',
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'Name should only contain letters and spaces',
            'email.regex' => 'Email must be from gmail.com, outlook.com, or yahoo.com',
        ];
    }
}
