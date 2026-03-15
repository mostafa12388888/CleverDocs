<?php

namespace App\Http\Requests\FormSubmission;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\ApiRequest;


class FormSubmissionRequest extends ApiRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
//            'formProjectId' => 'required|integer',
            'formVersionId' => 'required|integer|exists:templates_forms,id',
            'projectId' => 'required|integer|exists:projects,id',
            'status' => 'required|string',
            'parentSubmissionId' => 'nullable|integer|exists:form_submissions,id',
            'inputsValues' => 'array',
            'inputsValues.*.templateInputId' => 'required|integer',
            'inputsValues.*.value' => 'nullable',
            "inputsValues.*.inputKey"=>"required|string|exists:input_types,key",
            "inputsValues.*.isDefault"=>"boolean",
        ];
    }
}
