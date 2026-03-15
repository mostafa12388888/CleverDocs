<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enum\Authorization\PermissionEnum;
use App\Helpers\PermissionHelper;
class DashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "title"=>$this->title,
            "settings"=>$this->settings,
            "isDefault"=>$this->is_default,
            "createdBy"=>CreatedByInfo::make($this->createdBy),
            "updatedBy"=>CreatedByInfo::make($this->updatedBy),
            "createdAt"=>$this->created_at,
            "updatedAt"=>$this->updated_at,
            "permissions" => [
                'canView'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::DASHBOARD_VIEW),
                'canCreate'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::DASHBOARD_CREATE, $this->created_by),
                'canEdit'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::DASHBOARD_UPDATE, $this->created_by),
                'canDelete' => PermissionHelper::isAuthAllowedTo(PermissionEnum::DASHBOARD_DELETE, $this->created_by),
            ],
        ];
    }
}
