<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;

class CompanyRequest extends ApiRequest
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
            'companyData.email' => 'required|regex:/(.+)@(.+)\.(.+)/i|email|unique:companies,email,' . $this->id,
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


            "keyContact.name" => "required|array",
            "keyContact.name.en" => "required|array",
            "keyContact.name.ar" => "required|array",
            'keyContact.name.en.last' => 'required|string',
            'keyContact.name.en.second' => 'required|string',
            'keyContact.name.en.first' => 'required|string',
            'keyContact.name.ar.first' => 'required|string',
            'keyContact.name.ar.second' => 'required|string',
            'keyContact.name.ar.last' => 'required|string',

            'keyContact.position' => 'required|array',
            'keyContact.position.en' => 'required|string',
            'keyContact.position.ar' => 'required|string',
            'keyContact.email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|unique:contacts,contact_email,' . $this->id,
            'keyContact.phone1' => 'required|regex:/^(\+?[0-9]{1,4})?[-.\s]?(\(?[0-9]{1,3}?\))?[-.\s]?[0-9]{1,4}[-.\s]?[0-9]{1,4}[-.\s]?[0-9]{1,9}$/|min:7|max:15',
            'keyContact.phone2' => 'nullable|regex:/^(\+?[0-9]{1,4})?[-.\s]?(\(?[0-9]{1,3}?\))?[-.\s]?[0-9]{1,4}[-.\s]?[0-9]{1,4}[-.\s]?[0-9]{1,9}$/|min:7|max:15',
            'keyContact.address' => 'array',
            'keyContact.address.en' => 'string',
            'keyContact.address.ar' => 'string',
            'keyContact.image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            "projectId" => "nullable|exists:projects,id|numeric"

        ];
    }
}
