<?php

namespace App\Http\Resources\CompanyAbout;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrivateInBoxUnReadCounterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "unRead" => isset($this['count'])
                ? (int) $this['count']
                : (int) $this->count(),

        ];
    }
}
