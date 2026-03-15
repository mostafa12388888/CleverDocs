<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id' => $this->id,
            'name' => $this->name ? json_decode($this->name) : null,
            'email' => $this->contact_email,
            "company"=>$this->company?CompanySummaryResource::make($this->company):null,
        ];;
    }
}
