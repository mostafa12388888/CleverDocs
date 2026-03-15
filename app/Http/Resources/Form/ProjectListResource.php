<?php

namespace App\Http\Resources\Form;

use App\Http\Resources\Company\ContactLookupResource;
use App\Http\Resources\FileResource;
use App\Http\Resources\Form\CustomOption\InputOptionListResource;
use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enum\Authorization\PermissionEnum;
use App\Helpers\PermissionHelper;
class ProjectListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $inputOption=$this->inputOption;
        $country=$this->country;
        return [
            "id" => $this->id,
            "userAssignId" => $this->user_id,
            'name' => json_decode($this->name),
            'description' => $this->description,
            'company' => $this->company ? ["id" => $this->company?->id, "name" => $this->company?->name] : null,
            'contact' => $this->contact ? ContactLookupResource::make($this->contact) : null,
            'referenceNo' => (int)$this->reference_number,
            'status' => $this->status,
            'projectType' => $inputOption ? [
                "id"=>$inputOption->id,
                "name" =>$inputOption->title,
            ] : null,
            'country' => $country ? [
                "id"=>$country->id,
                "name" =>$country->title,
            ] : null,
            'contractValue' => $this->contract_value,
            'order' => $this->order,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'wbs' => !is_null($this->wbs) ? [
                'id' => $this->wbs->id,
                'title' => json_decode($this->wbs->title),
            ] : null,
            "logo" => $this->logoFile ? FileResource::make($this->logoFile) : null,
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
