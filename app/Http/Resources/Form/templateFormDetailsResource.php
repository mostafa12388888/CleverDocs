<?php

namespace App\Http\Resources\Form;

use Illuminate\Http\Request;
use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Resources\Json\JsonResource;

class templateFormDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => json_decode($this->name),
            'layout'    => $this->layout,
            'status' => $this->status,
            'primary' => $this->primary,
            'projects' => $this->projects,
            'version' => $this->version,
            'symbol' => $this->symbol, //@TODO: add migration for this in database, and in fillable array
            'mainCreatedAt' => $this->mainTemplate?->created_at,
            'mainCreatedBy' => new CreatedByInfo($this->mainTemplate?->createdBy),
            'updatedAt' => $this->created_at,
            'updatedBy' => new CreatedByInfo($this->createdBy),
            "projects"=>TemplatesFormProjectsResource::collection($this->templatesFormProjects),
            "permissions" => [
                "canEdit"=>true,
                "canDelete"=> true
            ]
        ];
    }
}
