<?php

namespace App\Http\Requests\Customers;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCustomerRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'type' => 'required|string|in:b2b,individual,corporate',
            'city' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'status' => 'required|string|in:active,inactive',
            'currency' => 'nullable|string|max:10',
            'create_account' => 'nullable|boolean',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable|string|min:6|required_if:create_account,true',
            'group_id' => 'nullable|exists:customer_groups,id',

            // Lead Source and Salesperson (Reference from `employees` table)
            'lead_source_id' => 'nullable|exists:lead_sources,id', // Ensure lead source exists
            'salesperson' => 'nullable|exists:employees,id',

            'cr'        => 'nullable|string',
            'vat_id'       => 'nullable|string',
            'license'   => 'nullable|string',

            'attributes'        => 'nullable|array',
            'attributes.*.id'   => [
                'required',
                'integer',
                Rule::exists('customer_attributes', 'id'),
            ],
            'attributes.*.value' => 'required_with:attributes.*.id|string|max:255',


            'new_attributes'            => 'nullable|array',
            'new_attributes.*.name'     => 'required|string|max:255|unique:customer_attributes,name',
            'new_attributes.*.type'     => 'required|string|in:string,integer,date,boolean',
            'new_attributes.*.value'    => 'required|string|max:255',

             // Validation for markups (required only for B2B & Corporate)
             'markups'                  => 'nullable|array|required_if:type,b2b,corporate',
             'markups.*.item_type_id'   => 'required_with:markups|integer|exists:item_types,id',
             'markups.*.markup'         => 'required_with:markups|numeric|min:0',
             'markups.*.value_type'     => 'required_with:markups|string|in:amount,percentage',
             'markups.*.currency'       => 'nullable|string|max:10|required_if:markups.*.value_type,amount',
        ];
    }
}
