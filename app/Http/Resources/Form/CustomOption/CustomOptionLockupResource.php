<?php

namespace App\Http\Resources\Form\CustomOption;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomOptionLockupResource extends JsonResource
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
            "name" => $this->title,
            "isActive" => $this->is_active,
            "isDefault" => $this->is_default,
        ];
    }
}
