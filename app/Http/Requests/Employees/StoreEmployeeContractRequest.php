<?php

namespace App\Http\Requests\Employees;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeContractRequest extends FormRequest
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
            // 'employee_id'     => ['required', 'exists:employees,id'],
            'national_number' => ['required', 'string', 'unique:employee_contracts,national_number'],
            'religion'        => ['nullable', 'string'],
            'nationality'     => ['nullable', 'string', 'max:3'],
            'address'         => ['nullable', 'string'],
            'salary'          => ['required', 'numeric', 'min:0'],
            'contract_start_date' => ['required', 'date'],
            'contract_end_date'   => ['nullable', 'date', 'after:contract_start_date'],
            'status'          => ['nullable', 'string', 'in:active,inactive,terminated'],
            'employment_type' => ['required', 'string', 'in:full-time,part-time'],
            'work_mode'       => ['required', 'string', 'in:hybrid,remote,onsite'],

            'attributes'                => ['nullable', 'array'],
            'attributes.*.attribute_id' => ['nullable', 'exists:attributes,id'], // Allow null for new attributes
            'attributes.*.name'         => ['nullable', 'string', 'max:255'], // For new attributes
            'attributes.*.type'         => ['nullable', 'string', 'in:string,number,boolean,date'], // Type control
            'attributes.*.value'        => ['nullable', 'string'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'employee_id.required'     => 'يجب تحديد الموظف المرتبط بالعقد.',
            'employee_id.exists'       => 'الموظف المحدد غير موجود.',
            'national_number.required' => 'الرقم الوطني مطلوب.',
            'national_number.unique'   => 'الرقم الوطني مسجل مسبقًا.',
            'salary.required'          => 'يجب تحديد قيمة الراتب.',
            'salary.numeric'           => 'الراتب يجب أن يكون رقمًا صحيحًا.',
            'contract_start_date.required' => 'يجب تحديد تاريخ بداية العقد.',
            'contract_end_date.after'  => 'يجب أن يكون تاريخ نهاية العقد بعد تاريخ البداية.',
            'attributes.array'         => 'يجب أن تكون الخصائص في شكل قائمة.',
            'attributes.*.attribute_id.exists'   => 'إحدى الخصائص المحددة غير موجودة.',
            'attributes.*.name.required_without' => 'يجب تحديد اسم الخاصية إذا لم يتم تحديد معرف الخاصية.',
            'attributes.*.type.in'     => 'نوع الخاصية غير صالح.',
        ];
    }
}
