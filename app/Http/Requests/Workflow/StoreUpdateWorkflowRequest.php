<?php

namespace App\Http\Requests\Workflow;


use App\Enum\Form\FormLayoutEnum;
use App\Enum\Form\FormStatusEnum;
use App\Http\Requests\ApiRequest;
use ReflectionException;

class StoreUpdateWorkflowRequest extends ApiRequest
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

        /***
        {
        "title":{
        "en":"title ",
        "ar":"عنوان"
        },
        "sla":{
        "type":"hours",
        "value":5
        },
        "mainFormId":1,
        "isAutoClose":true,
        "isActive":false,
        "distributionGroups":[
        1,
        2,
        3,
        4
        ]"slots":[
        {
        "index":1,
        "shape":"decision",
        "title":{
        "en":"",
        "ar":""
        },
        "description":{
        "en":"",
        "ar":""
        },
        "sla":{
        "type":"hours",
        "value":5
        },
        "isAutoDecision":true,
        "decisionType":"",
        "position":{
        "x":23213,
        "y":121232,
        "h":4342342
        },
        "autoClose":false,
        "**status":null,
        "level":1,
        "approvalMethod":1,
        "isOfficialSignature":false,
        "signatureInputId":null,
        "index":1,
        "branches":[
        {
        "title":{
        "en":"",
        "ar":""
        },
        "isDefault":true,
        "condition":{
        "operator":">",
        "inputId":1,
        "inputValue":"test"
        },
        "linkIndex":null,
        //| 0 => start
        }
        ]"assignees":[
        1,
        2,
        4
        ]
        }
        ],
        "watchers":[
        1,
        2,
        3
        ],
        "esclations":[
        {
        "type":"overall",
        "isOnReceived":true,
        "isSLAExceed":true,
        "isBeforeSLAExceed":true,
        "isAfterSLAExceed":true,
        "beforeSLA":{
        "type":"hours",
        "value":5
        },
        "afterSLA":{
        "type":"hours",
        "value":5
        }
        }
        ]
        }
         */
        return [
            "title" => "required|array",
            "title.en" => "required|string",
            "title.ar" => "required|string",
            'projectId'=>"required|integer|exists:projects,id",
            "sla" => "required|array",
            "sla.type" => "required|string",
            "sla.value" => "required|integer",
            "mainFormId" => "nullable|integer|exists:main_template_forms,id",
            "isAutoClose" => "required|boolean",
            "isActive" => "required|boolean",
            "distributionGroups" => "array",
            "distributionGroups.*" => "integer|exists:distribution_lists,id",
            "slots" => "required|array",
            "slots.*" => "required|array",
//            "slots.*.index" => "required",
        //slots.*.index should be  unique string in the slots array (datatype string)
            "slots.*.index" => "required|string|distinct",
            "slots.*.uiInfo" => "nullable|array",

            "slots.*.shape" => "required|string|in:start,end,decision,step",
            "slots.*.title" => "required|array",
            "slots.*.title.en" => "required|string",
            "slots.*.title.ar" => "required|string",
            "slots.*.description" => "required|array",
            "slots.*.description.en" => "required|string",
            "slots.*.description.ar" => "required|string",
            "slots.*.sla" => "required|array",
            "slots.*.sla.type" => "required|string",
            "slots.*.sla.value" => "required|integer",
            "slots.*.isAutoDecision" => "required|boolean",
            "slots.*.position" => "nullable|array",

            "slots.*.autoClose" => "required|boolean",
            "slots.*.status" => "nullable",
            "slots.*.approvalMethod" => "required|string|in:chosenApprove,allApprove,oneApprove",
            "slots.*.approvalTitle" => "nullable|integer|exists:input_options,id",
            "slots.*.isOfficialSignature" => "required|boolean",
            "slots.*.signatureInputId" => "nullable|integer",
            "slots.*.branches" => "nullable|array",
            "slots.*.branches.*" => "required|array",
            "slots.*.branches.*.title" => "required|array",
            "slots.*.branches.*.title.en" => "required|string",
            "slots.*.branches.*.title.ar" => "required|string",
            "slots.*.branches.*.isDefault" => "required|boolean",
            "slots.*.branches.*.condition" => "required|array",
            "slots.*.branches.*.condition.operator" => "required|string",
            "slots.*.branches.*.condition.inputId" => "required|integer",
            "slots.*.branches.*.condition.inputValue" => "required|string",
//            "slots.*.branches.*.linkIndex" => is nullable but if provided should be a string and exists in the slots array not in the slots database so i think we need to use other method tha nexists
            "slots.*.branches.*.linkIndex" => "nullable|string|in:".implode(',', array_column($this->input('slots'), 'index')),
            "slots.*.assignees" => "nullable|array",
            "slots.*.assignees.*" => "required|integer",
            "watchers" => "nullable|array",
            "watchers.*" => "required|integer|exists:users,id",
            "escalations" => "nullable|array",
            "escalations.*" => "nullable|array",
            "escalations.*.type" => "required|string",
            "escalations.*.isOnReceived" => "required|boolean",
            "escalations.*.isSLAExceed" => "required|boolean",
            "escalations.*.isBeforeSLAExceed" => "required|boolean",
            "escalations.*.isAfterSLAExceed" => "required|boolean",
            "escalations.*.beforeSLA" => "nullable|array",
            "escalations.*.beforeSLA.type" => "required|string",
            "escalations.*.beforeSLA.value" => "required|integer",
            "escalations.*.afterSLA" => "nullable|array",
            "escalations.*.afterSLA.type" => "required|string",
            "escalations.*.afterSLA.value" => "required|integer",
        ];
    }
}
