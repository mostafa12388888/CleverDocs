<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enum\Authorization\PermissionEnum;
use App\Helpers\PermissionHelper;

class ComponentResource extends JsonResource
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
            "title" => $this->title,
            "colorRecord" => $this->color_record,
            "formId" => $this->form_id,
            "dashboardId" => $this->dashboard_id,
            "groupBy" => $this->group_by,
            "chartType" => $this->chart_type,
            "countBy" => $this->count_by,
            "isPrivate" => $this->is_private,
            "createdBy" => CreatedByInfo::make($this->createdBy),
            "updatedBy" => CreatedByInfo::make($this->updatedBy),
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "permissions" => [
                'canView'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::COMPONENT_VIEW),
                'canCreate'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::COMPONENT_CREATE, $this->created_by),
                'canEdit'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::COMPONENT_UPDATE, $this->created_by),
                'canDelete' => PermissionHelper::isAuthAllowedTo(PermissionEnum::COMPONENT_DELETE, $this->created_by),
            ],
        ];
    }
}
