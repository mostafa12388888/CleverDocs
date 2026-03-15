<?php

namespace App\Http\Resources\Workflow;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkflowSlotsDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'index' => $this->index,
            'shape' => $this->shape,
            'title' => $this->title ? json_decode($this->title) : null,
            'description' => $this->description ? json_decode($this->description) : null,
            'sla' => [
                'type' => $this->sla_unit,
                'value' => $this->sla_value,
            ],
            'isAutoDecision' => $this->is_auto_decision,
            'position' => $this->position ? json_decode($this->position) : null,
            'autoClose' => $this->auto_close,
            'status' => $this->status,
            'approvalMethod' => $this->approval_method,
            'isOfficialSignature' => $this->is_official_signature,
            'signatureInputId' => $this->signature_input_id,
            'uiInfo' => $this->ui_info ? json_decode($this->ui_info) : null,
//            'branches' => WorkflowBranchesDetailsResource::collection($this->branches),

        ];
    }
}
