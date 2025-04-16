<?php

namespace App\Http\Requests\TravelAgencies;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTravelAgencyRequest extends FormRequest
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
            'name'          => "nullable|string|unique:travel_agencies,name,{$this->travel_agency}",
            'company_name'  => "nullable|string|unique:travel_agencies,company_name,{$this->travel_agency}",
            'email'         => "nullable|email|unique:travel_agencies,email,{$this->travel_agency}",
            'iate_code'     => "nullable|alpha|size:3|unique:travel_agencies,iate_code,{$this->travel_agency}",
            'status'        => 'nullable|string|in:pending,active,suspended',
            'description'   => 'nullable|string',
        ];
    }
}
