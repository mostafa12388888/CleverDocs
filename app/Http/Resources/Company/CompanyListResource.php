<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enum\Authorization\PermissionEnum;
use App\Helpers\PermissionHelper;
use App\Http\Resources\User\CreatedByInfo;

class CompanyListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $field = $this->field;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'field' => $field ? [
                "name" => $field->title,
                "id" => $field->id,
            ] : null,
            'email' => $this->email,
            'phone1' => $this->phone1,
            'phone2' => $this->phone2,
            'address' => json_decode($this->address),
            'taxNo' => $this->tax,
            'taxPercent' => $this->tax_percentage,
            "registration" => $this->registration,
            'vatNo' => $this->vat,
            'vatPercent' => $this->vat_percentage,
            'logo' => $this->logoFile ?  FileResource::make($this->logoFile) : null,
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
