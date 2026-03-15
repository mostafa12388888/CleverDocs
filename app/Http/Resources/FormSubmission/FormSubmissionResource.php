<?php

namespace App\Http\Resources\FormSubmission;

use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormSubmissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'submissionId'=>$this->id,
            "hasVersion" => $this->where('submissions_id', $this->id)->exists(),
            'templatesFormProjectId'=>$this->templates_form_project_id,
            'formVersionId'=>$this->templateFormProject?->templates_form_id,
            'status'=>$this->status,
            "createdBy" => new CreatedByInfo($this->createdBy),
            "updatedBy" => new CreatedByInfo($this->updatedBy),
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            'inputsValues' => FormSubmissionValueResource::collection($this->whenLoaded('submissionValues')),
        ];
    }
}
