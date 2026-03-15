<?php

namespace App\Http\Resources\CompanyAbout;

use App\Http\Resources\company\ContactResource;
use App\Http\Resources\User\CreatedByInfo;
use App\Http\Resources\User\UserContactSummaryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrivateInBoxResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->subject) {
            $subject = json_decode($this->subject, true);
            $this->subject = $subject['subject'] ?? $subject;
        }
        return [
            "id" => $this->id,
            "message" => $this->message,
            "type" => [
                "en" => trans('permission.' . $this->type, [], "en"),
                "ar" => trans('permission.' . $this->type, [], "ar")
            ],
            "project" => $this->project ? [
                "id" => $this->project?->id,
                "name" => json_decode($this->project?->name),
                "wbs" => [
                    "id" => $this->project->wbs->id,
                    "title" => json_decode($this->project->wbs->title),
                ],
            ] : null,
            "status" => $this->status,
            'moduleName'   => json_decode($this->module_name),
            'mainFormModelId'   => $this->main_template_form_model_id,
            'mainFormTitle'   => json_decode($this->main_template_form_title),
            'mainFormId'   => $this->main_template_form_id,
            'templateFormVersionName'   => json_decode(json_decode($this->templates_form_name)),
            'templateFormVersionId'   => $this->templates_form_version_id ?? $this->templates_form_version_id,
            'mainWorkflowId'   => $this->main_workflow_id,
            'subject'   => $this->type=="form"?json_decode($this->subject):$this->subject,
            "typeId" => $this->typeId,
            "createdAt" => $this->created_at,
            "createdBy" => CreatedByInfo::make($this->createdBy),
        ];
    }
}
