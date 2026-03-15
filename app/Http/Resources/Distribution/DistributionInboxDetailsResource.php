<?php

namespace App\Http\Resources\Distribution;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Form\CustomOption\CustomOptionSummaryResource;
use App\Http\Resources\User\CreatedByInfo;
class DistributionInboxDetailsResource extends JsonResource
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
            "priorityId" => $this->priority_id,
            "type" => [
                "en" => trans('permission.' . $this->type, [], "en"),
                "ar" => trans('permission.' . $this->type, [], "ar")
            ],
            "typeId" => $this->type_id,
            "userId" => $this->user_id,
            "message" => $this->message,
            "project"=>$this->project ? [
                "id"=>$this->project?->id,
                "name"=>json_decode($this->project?->name),
                "wbs"=>[
                    "id"=>$this->project->wbs->id,
                    "title"=>json_decode($this->project->wbs->title),
                ],
                ] : null,
            "status" => $this->status,
            "createdBy" => CreatedByInfo::make($this->createdBy),
            'priority' => CustomOptionSummaryResource::make($this->priority),
            "distributionList" => DistributionListSummaryResource::make($this->distributionList),
            'moduleName'   => json_decode($this->module_name),
            'ModelId'   => $this->main_template_form_model_id,
            'mainFormTitle'   => json_decode($this->main_template_form_title),
            'mainFormId'   => $this->main_template_form_id,
            'templateFormVersionName'   => json_decode(json_decode($this->templates_form_name)),
            'templateFormVersionId'   => $this->templates_form_version_id ?? $this->templates_form_version_id,
            'mainWorkflowId'   => $this->main_workflow_id,
            'subject'   => $this->type=="form"?json_decode($this->subject):$this->subject,
            "createdAt" => $this->created_at,
        ];
    }
}
