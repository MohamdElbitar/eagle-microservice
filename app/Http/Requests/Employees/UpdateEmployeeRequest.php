<?php

namespace App\Http\Requests\Employees;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
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
            'code' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('employees', 'code')->ignore($this->route('employee')),
            ],
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'work_email' => [
                'nullable',
                'email',
                Rule::unique('employees', 'work_email')->ignore($this->route('employee')),
            ],
            'job_position' => 'nullable|string|max:255',
            'direct_manager' => 'nullable|exists:employees,id',
            'department' => 'nullable|string|max:255',

            'new_attributes' => 'nullable|array',
            'new_attributes.*.name' => 'required|string|max:255',
            'new_attributes.*.type' => 'required|string|in:string,integer,date,boolean',
            'new_attributes.*.value' => 'required|string|max:255',
        ];
    }
}
