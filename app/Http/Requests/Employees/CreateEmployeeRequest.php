<?php

namespace App\Http\Requests\Employees;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CreateEmployeeRequest extends FormRequest
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
            'code' => 'required|string|max:50|unique:employees,code',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'work_email' => 'nullable|email|unique:employees,work_email',
            'job_position' => 'nullable|string|max:255',
            'direct_manager' => 'nullable|exists:employees,id',
            'department_id' => 'nullable|integer|exists:departments,id',
            'create_account' => 'nullable|boolean',
            'password' => 'nullable|string|min:6|required_if:create_account,true',

            // Accept existing attributes
            'attributes' => 'nullable|array',
            'attributes.*.id' => [
                'required',
                'integer',
                Rule::exists('attributes', 'id'),
            ],
            'attributes.*.value' => 'required_with:attributes.*.id|string|max:255',

            // Accept new attributes
            'new_attributes' => 'nullable|array',
            'new_attributes.*.name' => 'required|string|max:255|unique:attributes,name',
            'new_attributes.*.type' => 'required|string|in:string,integer,date,boolean',
            'new_attributes.*.value' => 'required|string|max:255',
        ];
    }
}
