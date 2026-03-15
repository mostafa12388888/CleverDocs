<?php

namespace App\Http\Resources\Form;

use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use App\Enum\Authorization\PermissionEnum;
use App\Helpers\PermissionHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
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
            "name" => $this->name,
            "order" => $this->order,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "createdBy" => new CreatedByInfo($this->createdBy),
            'updatedBy' => new CreatedByInfo($this->updatedBy),
            "permissions" => [
                'canView'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_VIEW),
                'canCreate'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_CREATE, $this->created_by),
                'canEdit'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_EDIT, $this->created_by),
                'canDelete' => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_DELETE, $this->created_by),
            ],
        ];
    }
}
