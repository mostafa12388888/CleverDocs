<?php

namespace App\Http\Resources\Form;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\CreatedByInfo;
use App\Enum\Authorization\PermissionEnum;
use App\Helpers\PermissionHelper;
class WBSListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'createdBy' => CreatedByInfo::make($this->createdBy),
            'updatedBy' => CreatedByInfo::make($this->updatedBy),
            'title' => json_decode($this->title),
            "hasProject" => $this->projects_count> 0 ? true : false,
            "projectCount" => $this->projects_count,
            'parentId' => $this->w_b_s_id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            "projectCount"=>$this->projects_count,
            'child' => !is_null($this->chiles) ? WBSListResource::collection($this->chiles) : null,
            "permissions" => [
                'canView'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::WBS_VIEW),
                'canEdit'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::WBS_UPDATE, $this->created_by),
                'canDelete' => PermissionHelper::isAuthAllowedTo(PermissionEnum::WBS_DELETE, $this->created_by),
            ],
        ];
    }
}
