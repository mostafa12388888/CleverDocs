<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\CompanyAbout\UserListResource;
use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use App\Enum\Authorization\PermissionEnum;
use App\Enum\Company\AvatarEnum;
use App\Helpers\PermissionHelper;
use App\Http\Resources\FileResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            "companyId" => $this->company_id,
            'name' => $this->name ? json_decode($this->name) : null,
            'position' => $this->position ? json_decode($this->position) : null,
            "isAvatar"=>$this->avatar_id ? true : false,
            "avatar"=>$this->avatar_id? AvatarEnum::findById($this->avatar_id): null,
            "image" =>$this->imageFile?  FileResource::make($this->imageFile) : null,
            'email' => $this->contact_email,
            'address' => $this->address ? json_decode($this->address) : null,
            'phone1' => $this->phone1,
            'phone2' => $this->phone2,
            'isKeyContact'=>$this->is_key_contact,
            "company"=>[
                 "id"=>$this->company_id,
                "name"=>$this->company?->name,
            ],
            "user"=>$this->user?[
                 "id"=>$this->user?->id,
                 "email"=>$this->user?->email,
                 "isActive"=>$this->user?->is_active,
                 "code"=>$this->user?->code,
            ]:null,
            "role"=>$this->user?->role ? [
                "id"=>$this->user?->role?->id,
                "name"=>json_decode($this->user?->role?->name),
            ] : null,
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
