<?php

namespace App\Http\Resources\Form;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WbsProjectsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->wbs_id,
            'title' => json_decode($this->wbs_title),
            'projects' => $this->projects ?  ProjectNamesResource::collection($this->projects) : [],
        ];
    }
}
