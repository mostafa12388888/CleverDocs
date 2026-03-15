<?php

namespace App\Http\Resources\Workflow;

use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enum\Authorization\PermissionEnum;
use App\Helpers\PermissionHelper;
class WorkflowListResource extends JsonResource
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
            "projectId" => $this->mainWorkflow?->project_id,
            "title" => json_decode($this->title),
            "sla" => [
                "type" => $this->sla_unit,
                "value" => $this->sla_value
            ],
            "mainWorkflowId" => $this->main_workflow_id,
            "isAutoClose" => $this->is_auto_close,
            "isActive" => $this->is_active,
            //            "distributionGroups" => $this->distributionGroups,
            //            "slots" => $this->slots,
            //            "watchers" => $this->watchers,
            //            "escalations" => $this->escalations,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "createdBy" => $this->createdBy ? new CreatedByInfo($this->createdBy) : null,
            "updatedBy" => $this->updatedBy ? new CreatedByInfo($this->updatedBy) : null,
            "permissions" => [
                'canView'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_VIEW),
                'canCreate'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_CREATE, $this->created_by),
                'canEdit'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_EDIT, $this->created_by),
                'canDelete' => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_DELETE, $this->created_by),
            ],
        ];
    }
}
