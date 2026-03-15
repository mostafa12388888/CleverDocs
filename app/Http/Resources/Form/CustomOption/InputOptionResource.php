<?php

namespace App\Http\Resources\Form\CustomOption;

use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Enum\Authorization\PermissionEnum;
use App\Helpers\PermissionHelper;

class InputOptionResource extends JsonResource
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
            "name" => $this->title,
            "isActive" => $this->is_active,
            "listId" => $this->custom_option_list_id,
            "isDefault" => $this->is_default,
            "isDefaultList" => $this->is_default_list,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "createdBy" => CreatedByInfo::make($this->createdBy),
            "updatedBy" => CreatedByInfo::make($this->updatedBy),
            "permissions" => [
                'canView'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_VIEW),
                'canCreate'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_CREATE, $this->created_by),
                'canEdit'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_EDIT, $this->created_by),
                'canDelete' => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_DELETE, $this->created_by),
            ],
        ];
    }
}
