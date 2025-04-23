<?php

namespace App\Http\Requests\TravelAgencies;

use Illuminate\Foundation\Http\FormRequest;

class CreateTravelAgencyRequest extends FormRequest
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
            'company_name'   => ['required', 'string'],
            'email'          => ['required', 'email', 'unique:travel_agencies,email'],
            'iate_code'      => ['required', 'string'],
            'description'    => ['nullable', 'string'],
            'plan_id'        => ['required', 'exists:plans,id'],

            // Admin user data
            'admin_name'     => ['required', 'string'],
            'admin_email'    => ['required', 'email', 'unique:users,email'],
            'admin_password' => ['required', 'string', 'min:6'],
        ];
    }
}
