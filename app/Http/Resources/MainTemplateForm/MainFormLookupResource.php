<?php

namespace App\Http\Resources\MainTemplateForm;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MainFormLookupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "name"=>json_decode($this?->name),
        ];
    }
}
