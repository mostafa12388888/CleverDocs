<?php

namespace App\Http\Resources\Distribution;

use App\Http\Resources\Form\CustomOption\CustomOptionListResource;
use App\Http\Resources\Form\ProjectNamesResource;
use App\Http\Resources\User\CreatedByInfo;
use App\Http\Resources\User\UserContactResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistributionListDetailsResource extends JsonResource
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
            "title" => $this->title,
            "project"=>ProjectNamesResource::make($this->project),
            'contactsActions' => ContactActionResource::collection($this->contactsActions),
            "createdBy" => CreatedByInfo::make($this->createdBy),
            "updatedBy" => CreatedByInfo::make($this->updatedBy),
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "permissions" => [
                "canEdit" => true,
                "canDelete" => true
            ]
        ];
    }
}
