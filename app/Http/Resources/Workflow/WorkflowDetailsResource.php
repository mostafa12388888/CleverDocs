<?php

namespace App\Http\Resources\Workflow;

use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkflowDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "mainWorkflowId" => $this->main_workflow_id,
            'version' => $this->version,
            'title' => json_decode($this->title),
            'sla' => [
                'type' => $this->sla_unit,
                'value' => $this->sla_value,
            ],
            'mainFormId' => $this->main_form_id,
            'isAutoClose' => $this->is_auto_close,
            'isActive' => $this->is_active,
            'distributionGroups' => $this->distributionGroups ?? [],
            'slots' => WorkflowSlotsDetailsResource::collection($this->workflowSlots),
            'watchers' => $this?->watchers?->pluck('id') ?? [],
            'escalations' => $this->escalationConditions->map(function ($escalation) {
                return [
                    'type' => $escalation->type,
                    'slotIndex' => $escalation->slot_index,
                    'isSlaExceeded' => $escalation->is_sla_exceeded,
                    'isBeforeSlaExceeded' => $escalation->is_before_sla_exceeded,
                    'isAfterSlaExceeded' => $escalation->is_after_sla_exceeded,
                    'beforeSla' => [
                        'type' => $escalation->before_sla_type,
                        'value' => $escalation->before_sla_value,
                    ],
                    'afterSla' => [
                        'type' => $escalation->after_sla_type,
                        'value' => $escalation->after_sla_value,
                    ],
                ];
            }),
            'assignees' => $this->assignees ?? [],
            'createdBy' => new CreatedByInfo($this->createdBy),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

        ];
    }
}
