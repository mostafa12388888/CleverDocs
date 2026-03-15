<?php

namespace App\Http\Resources\Form\CustomOption;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\CreatedByInfo;

class CustomOptionDetailsResource extends JsonResource
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
            "name"=>$this->title,
            "key"=>$this->key,
            "isDefault"=>$this->is_default,
            "isActive" => $this->is_active,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "createdBy" => CreatedByInfo::make($this->createdBy),
            "updatedBy" => CreatedByInfo::make($this->updatedBy),
            "inputOptions" => $this->inputOption?InputOptionPreviewResource::collection($this->inputOption):[12],

        ];
    }
}
