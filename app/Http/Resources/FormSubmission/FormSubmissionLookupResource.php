<?php

namespace App\Http\Resources\FormSubmission;

use App\Http\Resources\Form\ProjectNamesResource;
use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormSubmissionLookupResource extends JsonResource
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
            'status' => $this->status,
            'name' => $this->name,
            'layout' => $this->layout,
            'Primary' => $this->Primary,
            'version' => $this->version,
            'symbol' => $this->symbol,
            'key' => $this->key,
            'isDefault' => $this->is_default,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            'createdBy' => new CreatedByInfo($this->createdBy),
            'updatedBy' => new CreatedByInfo($this->updatedBy),
            "submissionValues" =>$this->submissionValues? FormSubmissionValueResource::collection($this->submissionValues):[],
            "project" => ProjectNamesResource::make($this->templateFormProject?->project) ?? null,


        ];
    }
}
