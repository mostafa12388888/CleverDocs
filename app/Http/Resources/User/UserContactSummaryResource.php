<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Company\CompanySummaryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserContactSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'contactId' => $this->id,
            'name' => $this->name ? json_decode($this->name) : null,
            "company" => CompanySummaryResource::make($this->company),

        ];
    }
}
