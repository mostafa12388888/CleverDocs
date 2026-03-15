<?php

namespace App\Http\Requests\Form;

use Illuminate\Foundation\Http\FormRequest;

class projectUpdateRequest extends FormRequest
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
            "name" => "required|array", //1
            "name.en" => "required|string", //1
            "name.ar" => "required|string", //1
            "referenceNumber" => 'unique:projects,reference_number,' . $this->id,
            "description" => "string",
            "contractValue" => "numeric",
            "countryId" => "numeric",
            "companyId" => "numeric|exists:companies,id",
            "contactId" => "numeric|exists:contacts,id",
            "wbsId" => "required|numeric|exists:w_b_s,id", //1
            "status" => "required|boolean", //1
            "projectTypeId" => "numeric:exists:input_options,id",//foreign key optionList
            "logoId" => "nullable|numeric|exists:files,id",
        ];
    }
}
