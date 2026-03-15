<?php

namespace App\Http\Resources\CompanyAbout;

use App\Http\Resources\User\CreatedByInfoV2;
use App\Http\Resources\User\UpdatedByInfoV2;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enum\Authorization\PermissionEnum;
use App\Helpers\PermissionHelper;
class UserListResource extends JsonResource
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
            "code" => $this->code,
            "email" => $this->email,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "createdBy" => $this?->created_by_id ? CreatedByInfoV2::make($this) : null,
            "updatedBy" => $this?->updated_by_id ?  UpdatedByInfoV2::make($this) : null,
            "company"   => $this->company_name ? [
                "id" => $this->company_id,
                "name" => json_decode($this->company_name)
            ] : null,
            "contact"   => $this->contact_name ? [
                "id" => $this->contact_id,
                "name" => json_decode($this->contact_name),
                "position" => $this->contact_position ? json_decode($this->contact_position) : null
            ] : null,
            "role"        => $this->role_name ? [
                "id" => $this->role_id,
                "name" => json_decode($this->role_name)
            ] : null,
            "permissions" => [
                'canView'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_VIEW),
                'canCreate'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_CREATE, $this->created_by),
                'canEdit'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_EDIT, $this->created_by),
                'canDelete' => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_DELETE, $this->created_by),
            ],

        ];
    }
}
