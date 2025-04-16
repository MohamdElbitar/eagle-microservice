<?php

namespace App\Http\Requests\Customers;

use Illuminate\Foundation\Http\FormRequest;

class AddMarkupsRequest extends FormRequest
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
            'types'                 => 'nullable|array',

            'types.*.markup'        => 'required|decimal:2',
            'types.*.currency'      => 'nullable|string|size:3|exclude_if:types.*.value_type,percentage',
            'types.*.value_type'    => 'required|in:amount,percentage',
            'types.*.item_type_id'  => 'required|integer',

        ];
    }
}
