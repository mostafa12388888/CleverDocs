<?php

namespace App\Http\Resources\Form;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplatesFormProjectsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'templatesFormProjectId' => $this->id,
            "project"=>$this->project?ProjectDetailsResource::make($this->project):null,
        ];
    }
}
