<?php

namespace App\Http\Resources\Form\CustomOption;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\CreatedByInfo;

class InputOptionPreviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "name" => $this->title,
            "isActive" => $this->is_active,
            "listId" => $this->custom_option_list_id,
            "isDefault" => $this->is_default,
            "isDefaultList" => $this->is_default_list,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "createdBy" => CreatedByInfo::make($this->createdBy),
            "updatedBy" => CreatedByInfo::make($this->updatedBy),
        ];
    }
}
