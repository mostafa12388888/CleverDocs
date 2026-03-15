<?php

namespace App\Http\Resources\CompanyAbout;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLookUpPaginateResource extends JsonResource
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
            "contactName" => json_decode($this->contact_name),
            "contact_id" => $this->contact_id,
            "username" => $this->email,
        ];
    }
}
