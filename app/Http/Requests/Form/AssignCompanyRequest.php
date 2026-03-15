<?php

namespace App\Http\Requests\Form;

use Illuminate\Foundation\Http\FormRequest;

class AssignCompanyRequest extends FormRequest
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
            "projectIds"=>"required|array",
            "projectIds.*"=> "numeric|exists:projects,id",
            "companyIds"=>"required|array",
            "companyIds.*"=>"numeric|exists:companies,id",
        ];
    }
}
