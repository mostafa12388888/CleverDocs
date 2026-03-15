<?php

namespace App\Http\Requests\Forms;


use App\Enum\Form\FormLayoutEnum;
use App\Enum\Form\FormStatusEnum;
use App\Http\Requests\ApiRequest;
use ReflectionException;
use App\Rules\ExistsNotSoftDeleted;


class StoreUpdateFormRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     * @throws ReflectionException
     */
    public function rules(): array
    {
        return [
            'mainData'=>'required|array',
            "mainData.projectIds.*"=> "required|exists:projects,id",
            "mainData.moduleId"=> "required|integer|exists:modules,id",
            "mainData.name" => "required|array",
            "mainData.name.en" => "required|string",
            "mainData.name.ar" => "required|string",
            "mainData.layout" => "required|string|in:". implode(",", FormLayoutEnum::getLocalConstants()),
            "mainData.status" => "required|string|in:". implode(",", FormStatusEnum::getLocalConstants()),
            "mainData.primary" => "required|boolean",
            "mainData.symbol" => "required|string",

           //------------------------- inputs ----------------------//
            'inputs'=>'required|array',
'inputs.*.inputTypeId' => [
        'required',
        'integer',
        'exists:input_types,id',
        new ExistsNotSoftDeleted('input_types'),
    ],
            //---- webFormat
            "inputs.*.webFormat"=> "required|array|min:1",
            "inputs.*.webFormat.x" => "required|integer",
            "inputs.*.webFormat.y" => "required|integer",
            "inputs.*.webFormat.tooltip" => "string",
            "inputs.*.webFormat.placeholder" => "nullable|string",
            "inputs.*.webFormat.height" => "required|integer",
            "inputs.*.webFormat.width" => "required|integer",
            "inputs.*.webFormat.isMandatory" => "required|integer",
            "inputs.*.webFormat.inputStyles" => "nullable|array",
            "inputs.*.webFormat.labelStyles" => "nullable|array",
            "inputs.*.webFormat.borderStyles" => "nullable|array",

            //---- printFormat
            "inputs.*.printFormat"=> "required|array|min:1",
            "inputs.*.printFormat.x" => "required|integer",
            "inputs.*.printFormat.y" => "required|integer",
            "inputs.*.printFormat.height" => "required|integer",
            "inputs.*.printFormat.hide" => "required|boolean",
            "inputs.*.printFormat.width" => "required|integer",
            "inputs.*.printFormat.styles.inputStyles" => "nullable|array",
            "inputs.*.printFormat.styles.labelStyles" => "nullable|array",
            "inputs.*.printFormat.styles.borderStyles" => "nullable|array",
        ];
    }
}
