<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequestUpdate extends FormRequest
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
           'companyData' => 'required|array',
            "companyData.name" => "required|array",
            'companyData.name.en' => 'required|string',
            'companyData.name.ar' => 'required|string',
            'companyData.field' => 'Numeric|exists:input_options,id',
            'companyData.logoId' => 'nullable|Numeric|exists:files,id',
            'companyData.email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|unique:companies,email,' . $this->id,
            'companyData.phone1' => 'required|regex:/^(\+?[0-9]{1,4})?[-.\s]?(\(?[0-9]{1,3}?\))?[-.\s]?[0-9]{1,4}[-.\s]?[0-9]{1,4}[-.\s]?[0-9]{1,9}$/|min:7|max:15',
            'companyData.phone2' => 'regex:/^(\+?[0-9]{1,4})?[-.\s]?(\(?[0-9]{1,3}?\))?[-.\s]?[0-9]{1,4}[-.\s]?[0-9]{1,4}[-.\s]?[0-9]{1,9}$/|min:7|max:15',
            'companyData.address' => 'array',
            'companyData.address.en' => 'string',
            'companyData.address.ar' => 'string',
            'companyData.taxNo' => 'Numeric',
            'companyData.vatNo' => 'Numeric',
            'companyData.vatPercent' => 'Numeric',
            'companyData.taxPercentage' => 'Numeric',
            'companyData.registration' => 'Numeric',
        ];
    }
}
