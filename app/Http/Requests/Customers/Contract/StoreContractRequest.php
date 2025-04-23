<?php

namespace App\Http\Requests\Customers\Contract;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractRequest extends FormRequest
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
            'subject'       => 'required|string',
            'description'   => 'nullable|string',
            'from_date'     => 'required|date',
            'to_date'       => 'required|date',

            'fp_departments.*'                          => 'required|array',
            'fp_departments.*.department_manager_id'    => 'required|exists:employees,id',
            'fp_departments.*.department_in_charge_id'  => 'required|exists:employees,id',
            'fp_departments.*.party-type'               => 'required|in:first-party,second-party',


            'customer_id' => 'required|exists:customers,id',

            'sp_departments.*'                          => 'required|array',
            'sp_departments.*.department_manager_id'    => 'required|exists:customer_employees,id',
            'sp_departments.*.department_in_charge_id'  => 'required|exists:customer_employees,id',
            'sp_departments.*.party-type'               => 'required|in:first-party,second-party',

            'credit_limit'  => 'required|numeric',
            'payment_terms' => 'required|in:month,half_month',
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
        $validated['contract_number'] = 'CN-' . now()->format('YmdHis') . '-' . rand(1000, 9999);

        return $validated;
    }
}
