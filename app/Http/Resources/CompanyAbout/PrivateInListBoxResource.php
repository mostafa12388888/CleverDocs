<?php

namespace App\Http\Resources\CompanyAbout;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Enum\Authorization\PermissionEnum;
use App\Helpers\PermissionHelper;
class PrivateInListBoxResource extends JsonResource
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
            "userId" => $this->user_id,
            "contactId" => $this->contact_id,
            "message" => $this->message,
            "type" => $request->type,
            "typeId" => $request->typeId,
            "permissions" => [
                'canView'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_VIEW),
                'canCreate'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_CREATE, $this->created_by),
                'canEdit'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_EDIT, $this->created_by),
                'canDelete' => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_DELETE, $this->created_by),
            ],

        ];
    }
}
