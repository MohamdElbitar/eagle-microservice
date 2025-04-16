<?php

namespace App\Http\Requests\employees;

use App\Http\Requests\Users\CreateUserRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerEmployeeRequest extends CreateUserRequest
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
            'department_id' => 'required|integer|exists:departments,id',
            'user_id' => 'nullable|exists:users,id',
            // 'customer_id' => 'required|exists:customers,id',
            // 'role_in_customer' => 'required|string|max:50',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:customer_employees,email',
            'password' => 'nullable|min:6|confirmed'
        ];
    }

    public function validated($key = null, $default = null): array
    {
        return array_merge(parent::validated(), ['role_in_customer' => 'customer_employee']);
    }
}
