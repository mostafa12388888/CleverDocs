<?php

namespace App\Http\Resources\Form\CustomOption;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InputOptionListResource extends JsonResource
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
            "name" =>json_decode( $this->title),
            "isActive" => $this->is_active,
            "listId" => $this->custom_option_list_id,
            "isDefault" => $this->is_default,
            "isDefaultList" => $this->is_default_list,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at
        ];
    }
}
