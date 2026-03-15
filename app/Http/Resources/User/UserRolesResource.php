<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRolesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name"=>json_decode($this->name),
            "id"=>$this->id,
            "createdAt"=>$this->created_at,
            "updatedAt"=>$this->updated_at,
        ];
    }
}
