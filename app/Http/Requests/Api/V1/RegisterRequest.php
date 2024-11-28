<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:3'],
            'phone_no' => ['nullable', 'digits:10']
        ];
    }
    public function messages()
    {
        return [
            'name.requied' => 'User name should be given',
            'name.min' => 'Name length should be min 3 characters',
            'email.required' => 'Email need to enter',
            'email.email' => 'Valid email id should be provided',
            'email.unique' => 'Email already taken',
            'phone_no.numaric' => 'Valid phone number should enter',
            'password.required' => 'Passwornd is required',
            'password.min' => 'Password Min 3 character needed'
        ];
    }
}
