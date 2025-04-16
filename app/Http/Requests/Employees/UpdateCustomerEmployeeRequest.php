<?php

namespace App\Http\Requests\employees;

use App\Http\Requests\Users\UpdateUserRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerEmployeeRequest extends UpdateUserRequest
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
            ...collect(parent::rules())->except('role'),
            'email' => 'nullable|string|email',
        ];
    }
}
