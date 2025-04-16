<?php

namespace App\Http\Requests\Customers\Contract;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContractRequest extends FormRequest
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
            'subject'       => 'nullable|string',
            'description'   => 'nullable|string',
            'from_date'     => 'nullable|date',
            'to_date'       => 'nullable|date',

            'fp_id' => 'nullable|exists:customers,id',

            'sp_name'           => 'nullable|string',
            'sp_address'        => 'nullable|string',
            'sp_cr'             => 'nullable|string',
            'sp_vat'            => 'nullable|string',
            'sp_representative' => 'nullable|string',

            'fp_departments.*'                          => 'nullable|array',
            'fp_departments.*.department_id'            => 'nullable|exists:departments,id',
            'fp_departments.*.department_manager_id'    => 'nullable|exists:employee,id',
            'fp_departments.*.department_in_charge_id'  => 'nullable|exists:employee,id',

            'sp_departments.*'                  => 'nullable|array',
            'sp_departments.*.department_name'  => 'nullable|exists:departments,id',

            'sp_departments.*.department_manager.*'     => 'nullable|array',
            'sp_departments.*.department_manager.*.department_manager_name'    => 'nullable|exists:departments,id',
            'sp_departments.*.department_manager.*.department_manager_email'   => 'nullable|exists:departments,id',
            'sp_departments.*.department_manager.*.department_manager_phone'   => 'nullable|exists:departments,id',

            'sp_departments.*.deparment_in_charge.*'    => 'nullable|array',
            'sp_departments.*.deparment_in_charge.*.department_in_charge_name'    => 'nullable|exists:departments,id',
            'sp_departments.*.deparment_in_charge.*.department_in_charge_email'   => 'nullable|exists:departments,id',
            'sp_departments.*.deparment_in_charge.*.department_in_charge_phone'   => 'nullable|exists:departments,id',

            'credit_limit'  => 'nullable|numeric',
            'payment_terms' => 'nullable|in:mid_month,end_of_month',
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @param  string|null  $key
     * @param  mixed  $default
     * @return array
     */
    public function validated($key = null, $default = null): array
    {
        $validated = parent::validated($key, $default);

        if (isset($validated['contract_number'])) {
            $validated['contract_number'] = 'CN-' . now()->format('YmdHis') . '-' . rand(1000, 9999);
        }

        return $validated;
    }
}
