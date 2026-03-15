<?php

namespace App\Http\Resources\Form;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MainFormWithLastVersionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "mainFormId" => $this?->mainFormId,
            "formVersionId"  => $this->formVersionId,
            // "status" => $this?->status,
            "name" => $this->name ? json_decode($this->name) : null,
        ];
    }
}
