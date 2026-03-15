<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\FileResource;
use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Enum\Authorization\PermissionEnum;
use App\Helpers\PermissionHelper;
class CompanyDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $keyContact = $this->keyContact->first();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'field'=>$this->field ? [
                "name"=>$this->field->title,
                "id"=>$this->field->id,
            ]:null,
            'email' => $this->email,
            'phone1' => $this->phone1,
            'phone2' => $this->phone2,
            'address' => json_decode($this->address),
            'taxNo' => $this->tax,
            'taxPercent' => $this->tax_percentage,
            'vatNo' => $this->vat,
            'vatPercent' => $this->vat_percentage,
            "logo" => $this->logoFile ? FileResource::make($this->logoFile) : null,
            "registration" => $this->registration,
            "createdBy" => $this->createdBy,
            "updatedBy" => $this->updatedBy, "createdBy" => CreatedByInfo::make($this->createdBy),
            "createdAt"=>$this->created_at,
            "updatedAt"=>$this->updated_at,
            'keyContact' =>  $keyContact ? [
                'id' => $keyContact->id,
                'name' => $keyContact->name ? json_decode($keyContact->name) : null,
            ]: null,
            "permissions" => [
                'canView'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_VIEW),
                'canCreate'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_CREATE, $this->created_by),
                'canEdit'   => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_EDIT, $this->created_by),
                'canDelete' => PermissionHelper::isAuthAllowedTo(PermissionEnum::ROLE_DELETE, $this->created_by),
            ]
        ];
    }
}
