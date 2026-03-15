<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\ApiRequest;
use App\Rules\UniqueNameInCompany;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends ApiRequest
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
            "name" => "required|array",
            "name.en" => "required|array",
            "name.ar" => "required|array",
            'name.en.last' => 'required|string',
            'name.en.second' => 'required|string',
            'name.en.first' => 'required|string',
            'name.ar.first' => 'required|string',
            'name.ar.second' => 'required|string',
            'name.ar.last' => 'required|string',
            'companyId' => 'numeric|exists:companies,id',
            'name' => [
                'required',
                'array',
                new UniqueNameInCompany($this->input('companyId'), $this->id),
            ],
            'position' => 'required|array',
            'position.en' => 'required|string',
            'position.ar' => 'required|string',
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|unique:contacts,contact_email,' . $this->id,
            'phone1' => 'required|regex:/^(\+?[0-9]{1,4})?[-.\s]?(\(?[0-9]{1,3}?\))?[-.\s]?[0-9]{1,4}[-.\s]?[0-9]{1,4}[-.\s]?[0-9]{1,9}$/|min:7|max:15',
            'phone2' => 'nullable|regex:/^(\+?[0-9]{1,4})?[-.\s]?(\(?[0-9]{1,3}?\))?[-.\s]?[0-9]{1,4}[-.\s]?[0-9]{1,4}[-.\s]?[0-9]{1,9}$/|min:7|max:15',
            'address' => 'array',
            'address.en' => 'string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'address.ar' => 'string',

        ];
    }
}
