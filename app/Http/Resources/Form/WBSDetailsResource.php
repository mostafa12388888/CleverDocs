<?php

namespace App\Http\Resources\Form;
use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enum\Authorization\PermissionEnum;
use App\Helpers\PermissionHelper;
class WBSDetailsResource extends JsonResource
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
            "createdBy" => is_null($this->createdBy)?null:CreatedByInfo::make($this->createdBy),
            "updatedBy" =>is_null($this->updatedBy)?null: CreatedByInfo::make($this->updatedBy),
            'title' => is_null($this->title)?null:json_decode($this->title),
            'wbsId' => $this->id,
            "projectCount"=>$this->projects_count,
            'child' => !is_null($this->chiles)?WBSListResource::collection($this->chiles):null,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            "permissions" => [
                'canView'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_VIEW),
                'canCreate'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_CREATE, $this->created_by),
                'canEdit'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_EDIT, $this->created_by),
                'canDelete' => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_DELETE, $this->created_by),
            ],
        ];
    }
}
