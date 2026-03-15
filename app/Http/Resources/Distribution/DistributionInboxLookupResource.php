<?php

namespace App\Http\Resources\Distribution;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistributionInboxLookupResource extends JsonResource
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
            "priorityId" => $this->priority_id,
            "type" => [
                "en" => trans('permission.' . $this->type, [], "en"),
                "ar" => trans('permission.' . $this->type, [], "ar")
            ],
        ];
    }
}
