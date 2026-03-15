<?php

namespace App\Http\Resources\Distribution;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistributionListSummaryResource extends JsonResource
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
        ];;
    }
}
