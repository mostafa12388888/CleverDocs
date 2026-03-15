<?php

namespace App\Http\Resources\Workflow;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkflowFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "mainWorkflowId" => $this->id,
            "lastWorkflowId" => $this->lastVersion?->id,
            "workflowTitle" =>json_decode( $this->lastVersion?->title),
            "mainFormId" => $this->lastVersion?->mainForm?->id,
            "lastFormId" => $this->lastVersion?->mainForm?->lastVersion?->id,
            "formName" => json_decode($this->lastVersion?->mainForm?->lastVersion?->name),
            "hasSignature" => $this->lastVersion?->mainForm?->lastVersion?->hasOfficialSignature()?true:false,
        ];
    }
}
