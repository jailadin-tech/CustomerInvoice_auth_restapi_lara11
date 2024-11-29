<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BulkStoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        if (!isset($user) || !$user->tokenCan('create')) {
            abort(403, 'You are not authorized to perform this action.');
        }

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
            '*.customerId' => ['required', 'integer'],
            '*.amount' => ['required', 'numeric'],
            '*.status' => ['required', Rule::in(['B', 'P', 'V', 'b', 'p', 'v'])],
            '*.billedDate' => ['required', 'date_format:Y-m-d H:i:s'],
            '*.paidDate' => ['date_format:Y-m-d H:i:s', 'nullable'],
        ];
    }
    public function prepareForValidation()
    {
        $data = [];
        // Set values to orginal db colmn names from Manipulated keys
        foreach ($this->toArray() as $obj) {
            $obj['customer_id'] = $obj['customerId'];
            $obj['billed_date'] = $obj['billedDate'];
            $obj['paid_date'] = $obj['paidDate'];
            $data[] = $obj;
        }
        $this->merge($data);
    }
}
