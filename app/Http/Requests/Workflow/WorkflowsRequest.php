<?php

namespace App\Http\Requests\Workflow;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class WorkflowsRequest extends ApiRequest
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

            "mainData.titleAr"=> "required|string",
            "mainData.titleEn" => "required|string",
            "mainData.AlertDays" => "required|integer",
            "mainData.changeDocStatus" => "required",
            "mainData.isChoice" => "required",
            "mainData.isActive" => "required",


            "workflowsData.*.templateInputId"=>"required|integer",
            "workflowsData.*.levelDurationType"=> "required",
            "workflowsData.*.description"=> "required|string",
            "workflowsData.*.types"=> "required",
            "workflowsData.*.approvalMethod"=> "required",
            "workflowsData.*.levelDurationValue"=> "required",
            "workflowsData.*.level"=>"required",
            "workflowsData.*.hasOfficialSignature"=>"required",
            "workflowsData.*.isChoice"=> "required",
        ];
    }
}
