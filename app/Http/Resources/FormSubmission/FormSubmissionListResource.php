<?php

namespace App\Http\Resources\FormSubmission;

use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormSubmissionListResource extends JsonResource
{

    private static $inputTypes = [];
    public static function setInputTypes($inputTypes){
        self::$inputTypes = $inputTypes;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $SubmissionValues = $this->submissionValues;

        $submissionValuesGroupedByInputType = $SubmissionValues->mapToGroups(function($value){
            return [$value->TemplateInput->input_types_id => $value];
        });

        $inputTypesGroupedById = self::$inputTypes->groupBy('id');
        $submissionValues = [];
        foreach($inputTypesGroupedById as $inputTypeId=> $inputType){
            $values = $submissionValuesGroupedByInputType[$inputTypeId] ?? null;
            if (!$values) {
                $submissionValues[] = [
                    'inputTypeId' => $inputTypeId,
                    'templateInputId' => null,
                    'value' => null];
                continue;
            }

            $submissionValues[] = [
                'templateInputId' => $values[0]?->template_input_id ?? null,
                'inputTypeId' =>  $inputTypeId ?? null,
                'inputTypeKey' =>  $values[0]?->input_key ?? null,
                'typeEntity' => $values[0]?->type_entity ?? null,
                'value' => $this->_resolveRelationData($values[0]) ?? null,
            ];
        }

        return [
            'submissionId'=>$this->id,
            "hasVersion" => $this->where('submissions_id', $this->id)->exists(),
            'templatesFormProjectId'=>$this->templates_form_project_id,
            'status'=>$this->status,
            'createdBy' => new CreatedByInfo($this->createdBy),
            'updatedBy' => new CreatedByInfo($this->updatedBy),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'fomValues' => $submissionValues,
        ];
    }
    private function _resolveRelationData($valueModel)
{
    if (!$valueModel) return null;

    switch ($valueModel->type_entity) {

        case 'contact':
            return json_decode($valueModel?->contact?->name, true);

        case 'company':
            return $valueModel?->company?->name;

        case 'customList':
            return $valueModel?->customList?->title;

        default:
            return json_decode($valueModel->value)->value ?? null;
    }
}

}
