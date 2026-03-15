<?php

namespace App\Http\Requests\Distribution;

use Illuminate\Foundation\Http\FormRequest;

class DistributionListRequest extends FormRequest
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
            "isActive"=>"required|boolean",
            "contactsActions" => "required|array",
            "contactsActions.*.id" => "required|exists:contacts,id",
            "contactsActions.*.actionId" => "required|exists:input_options,id",
            "title"=>"required|array",
            "projectId"=>"required|integer|exists:projects,id"
        ];
    }
}
