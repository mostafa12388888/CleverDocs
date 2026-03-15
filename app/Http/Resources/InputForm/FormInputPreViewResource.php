<?php

namespace App\Http\Resources\InputForm;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormInputPreViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $styles = $this->styles ? ($this->styles) : [];
        $printDetails = $this->print_details ? json_decode($this->print_details) : [];

        //@TODO: later with align with frontend
//        $webFormat = [
//            'x' => $this->position_x,
//            'y' => $this->position_y,
//            'placeholder' => $this->placeholder,
//            'tooltip' => $this->tooltip,
//            'title' => json_decode($this->title),
//            'height' => $this->height,
//            'width' => $this->width,
//            'isMandatory' => $this->is_mondatory,
//        ];
//
//        if ($styles) {
//            $webFormat['inputStyles'] = $styles['inputStyles'] ?? [];
//            $webFormat['labelStyles'] = $styles['labelStyles'] ?? [];
//            $webFormat['borderStyles'] = $styles['borderStyles'] ?? [];
//        }

        return [
            'inputFormId' => $this->id,
            "inputTypeId" => $this->input_types_id,
            'templatesFormId' => $this->templates_forms_id,
            'width' => $this->width,
            'height' => $this->height,
            'positionY' => $this->position_y,
            'positionX' => $this->position_x,
            'title' => $this->title,
            'isMandatory' => $this->is_mandatory,
            'placeholder' => $this->placeholder,
            'tooltip' => $this->tooltip,
            'webFormat' => $styles,
            'printFormat' => $printDetails,
            'inputType' => $this?->TemplateType ?  InputTypeResource::make($this?->TemplateType) : null,
            'attachmentTemplateType' => $this?->TemplateType ?  InputTypeDetailsResource::make($this?->TemplateType) : null,
            "permissions" => [
                "canEdit"=>true,
                "canDelete"=> true
            ]
        ];    }
}
