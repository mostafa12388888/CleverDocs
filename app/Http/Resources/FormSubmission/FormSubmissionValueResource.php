<?php

namespace App\Http\Resources\FormSubmission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormSubmissionValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public
    function toArray(Request $request): array
    {
        if ($this->value) {
            $value = json_decode($this->value, true);
            $this->value = $value['value'] ?? $value;
        }

         return [
           'templateInputId'=>$this->template_input_id,
           "isDefault"=> $this->is_default,
           'inputKey'=> $this->input_key,
            'typeEntity'=>$this->type_entity,
            'value'=>$this->_resolveRelationData($this) ?? $this->value
        ];
    }
     private function _resolveRelationData($valueModel)
{
    if (!$valueModel) return null;
    switch ($valueModel->type_entity) {

        case 'contact':
            return ["companyId"=>$valueModel?->contact->company_id,"contact"=>json_decode($valueModel?->contact->name),"value"=>($valueModel?->value),"entity"=> "contact"];

        case 'company':
            return ["value"=>$valueModel?->value,"entity"=> "company"];

        case 'customList':
            return ["value"=>$valueModel?->value,"entity"=> "customList"];

        default:
            return ($valueModel->value) ?? null;
    }
}
}
