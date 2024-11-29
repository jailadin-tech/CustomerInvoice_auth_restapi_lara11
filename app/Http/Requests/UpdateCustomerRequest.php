<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        if (!isset($user) || !$user->tokenCan('update')) {
            abort(403, 'You are not authorized to perform this action.');
        }

        return true;
    }

    public function rules(): array
    {
        if ($this->method() == "PUT") {
            return [
                'name' => ['required', 'min:3'],
                'email' => ['required', 'email'],
                'type' => ['required', Rule::in(['B', 'I', 'b', 'i'])],
                'address' => ['required'],
                'city' => ['required'],
                'state' => ['required'],
                'postalCode' => ['required']
            ];
        } else {
            return [
                'name' => ['sometimes', 'required', 'min:3'],
                'email' => ['sometimes', 'required', 'email'],
                'type' => ['sometimes', 'required', Rule::in(['B', 'I', 'b', 'i'])],
                'address' => ['sometimes', 'required'],
                'city' => ['sometimes', 'required'],
                'state' => ['sometimes', 'required'],
                'postalCode' => ['sometimes', 'required']
            ];
        }
    }
    public function prepareForValidation()
    {
        if (isset($this->postalCode)) {
            $this->merge([
                'postal_code' => $this->postalCode
            ]);
        }
    }
}
