<?php

namespace App\Http\Resources\CompanyAbout;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrivateInBoxLookupResource extends JsonResource
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
            "userId" => $this->user_id,
            "contactId" => $this->contact_id,
            "message" => $this->message,
        ];;
    }
}
