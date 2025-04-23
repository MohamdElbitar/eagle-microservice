<?php

namespace App\Http\Requests\Customers;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'name'          => 'sometimes|string|max:255',
            'phone'         => 'nullable|string|max:20',
            'country'       => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:255',
            'zip'           => 'nullable|string|max:20',
            'state'         => 'nullable|string|max:255',
            'address'       => 'nullable|string|max:500',
            'website'       => 'nullable|url|max:255',
            'status'        => 'nullable|in:active,inactive',
            'currency'      => 'nullable|string|max:10',
            'balance'       => 'nullable|numeric',
            'balance_date'  => 'nullable|date',
            'cr'            => 'nullable|string',
            'vat'           => 'nullable|string',
            'license'       => 'nullable|string',

            // قبول خصائص جديدة
            'new_attributes'            => 'nullable|array',
            'new_attributes.*.name'     => 'required|string|max:255',
            'new_attributes.*.type'     => 'required|string|in:string,integer,date,boolean',
            'new_attributes.*.value'    => 'required|string|max:255',
        ];
    }
}
