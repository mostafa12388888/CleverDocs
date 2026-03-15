<?php

namespace App\Http\Resources\Distribution;

use App\Http\Resources\Form\CustomOption\CustomOptionListResource;
use App\Http\Resources\Form\CustomOption\InputOptionListResource;
use App\Http\Resources\Form\CustomOption\InputOptionResource;
use App\Http\Resources\User\CreatedByInfo;
use App\Http\Resources\User\UserContactResource;
use Illuminate\Http\Request;

use App\Enum\Authorization\PermissionEnum;
use App\Helpers\PermissionHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class DistributionListResource extends JsonResource
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
            "isActive" => $this->is_active,
            "title" => $this->title,
            "createdBy" => CreatedByInfo::make($this->createdBy),
            "updatedBy" => CreatedByInfo::make($this->updatedBy),
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "permissions" => [
                'canView'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_VIEW),
                'canCreate'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_CREATE, $this->created_by),
                'canEdit'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_EDIT, $this->created_by),
                'canDelete' => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_DELETE, $this->created_by),
            ],
        ];
    }
}
