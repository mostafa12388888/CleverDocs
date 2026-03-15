<?php

namespace App\Http\Resources\Workflow;

use App\Http\Resources\Form\ProjectNamesResource;
use Illuminate\Http\Request;
use App\Enum\Authorization\PermissionEnum;
use App\Helpers\PermissionHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class MainWorkflowListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'mainId' => $this->id,
            'project' => ProjectNamesResource::make($this->project),
            'workflow' => new WorkflowListResource($this->lastVersion),
            "permissions" => [
                'canView'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_VIEW),
                'canCreate'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_CREATE, $this->created_by),
                'canEdit'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_EDIT, $this->created_by),
                'canDelete' => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_DELETE, $this->created_by),
            ],
        ];
    }
}
