<?php

namespace App\Http\Resources\Form;

use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use App\Enum\Authorization\PermissionEnum;
use App\Helpers\PermissionHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class InputTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $customOptionList=$this->CustomOptionList;
        return [
            "id" => $this->id,
            "title" => $this->title,
            "type" => $this->type,
            "key" => $this->key,
            "customList" =>$customOptionList?[
            "id" => $this->custom_option_list_id,
            "title" => $customOptionList?->title
            ]:null,
            "entity" => $this->entity,
            "optionsType" => $this->options_type,
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
