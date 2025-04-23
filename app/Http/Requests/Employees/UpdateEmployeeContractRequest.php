<?php

namespace App\Http\Requests\Employees;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeContractRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'national_number' => ['sometimes', 'string', 'unique:employee_contracts,national_number,' . $this->route('id')],
            'religion'        => ['nullable', 'string'],
            'nationality'     => ['nullable', 'string', 'max:3'],
            'address'         => ['nullable', 'string'],
            'salary'          => ['sometimes', 'numeric', 'min:0'],
            'contract_start_date' => ['nullable', 'date'],
            'contract_end_date'   => ['nullable', 'date', 'after_or_equal:contract_start_date'],
            'status' => ['nullable', Rule::in(['active', 'terminated', 'pending'])],
            'employment_type' => ['required', 'string', 'in:full-time,part-time'],
            'work_mode'       => ['required', 'string', 'in:hybrid,remote,onsite'],

            // Attributes: Support for existing and new attributes
            'attributes'                => ['nullable', 'array'],
            'attributes.*.attribute_id' => ['sometimes', 'exists:attributes,id'],
            'attributes.*.value'        => ['nullable', 'string'],

            // Allowing new attributes (if they don't exist in the system)
            'new_attributes'            => ['nullable', 'array'],
            'new_attributes.*.name'     => ['required_with:new_attributes', 'string', 'max:255'],
            'new_attributes.*.type'     => ['required_with:new_attributes', 'string', Rule::in(['text', 'number', 'boolean', 'date','string','integer'])],
            'new_attributes.*.value'    => ['nullable', 'string'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'national_number.unique'   => 'الرقم الوطني مسجل مسبقًا.',
            'salary.numeric'           => 'الراتب يجب أن يكون رقمًا صحيحًا.',
            'contract_end_date.after_or_equal' => 'يجب أن يكون تاريخ انتهاء العقد بعد تاريخ بدايته.',
            'status.in'                => 'حالة العقد غير صالحة.',

            // Attributes error messages
            'attributes.array'         => 'يجب أن تكون الخصائص في شكل قائمة.',
            'attributes.*.attribute_id.exists' => 'إحدى الخصائص المحددة غير موجودة.',

            // New Attributes messages
            'new_attributes.array'         => 'يجب أن تكون الخصائص الجديدة في شكل قائمة.',
            'new_attributes.*.name.required_with' => 'يجب إدخال اسم الخاصية الجديدة.',
            'new_attributes.*.type.required_with' => 'يجب تحديد نوع الخاصية الجديدة.',
            'new_attributes.*.type.in' => 'نوع الخاصية غير صالح.',
        ];
    }
}
