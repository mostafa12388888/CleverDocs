<?php

namespace App\Http\Resources\Form;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\CreatedByInfo;

class WBSLookupResource extends JsonResource
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
            'title' => json_decode($this->title),
            'parentId' => $this->w_b_s_id,
            'child' => !is_null($this->chiles) ? WBSLookupResource::collection($this->chiles) : null,

        ];
    }
}
