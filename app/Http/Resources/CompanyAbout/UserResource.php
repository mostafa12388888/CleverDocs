<?php

namespace App\Http\Resources\CompanyAbout;

use App\Http\Resources\Form\ProjectNamesResource;
use App\Http\Resources\Form\WbsProjectsResource;
use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "wbsProjects" => $this->projectsGroupedByWbs ? WbsProjectsResource::collection($this->projectsGroupedByWbs) : [],
            "company" => $this->company_name ? [
                "id" => $this->company_id,
                "name" => json_decode($this->company_name)
            ] : null,
            "contact" => $this->contact_name ? [
                "id" => $this->contact_id,
                "name" => json_decode($this->contact_name),
                "position" => $this->contact_position ? json_decode($this->contact_position) : null
            ] : null,
            "role" => $this->role_name ? [
                "id" => $this->role_id,
                "name" => json_decode($this->role_name)
            ] : null,
            "loginHistories" => $this->loginHistories?LoginHistoriesResource::collection($this->loginHistories):[],
            "createdBy" => CreatedByInfo::make($this->createdBy),
            "updatedBy" => CreatedByInfo::make($this->updatedBy),
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
        ];
    }
}
