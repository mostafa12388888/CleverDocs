<?php

namespace App\Http\Resources\InputForm;

use App\Http\Resources\InputForm\InputTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormInputDetailsResource extends JsonResource
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

        return [
            "id"=>$this->id,
            "inputTypeId" => $this->input_types_id,
            'width' => $this->width,
            'height' => $this->height,
            'positionY' => $this->position_y,
            'positionX' => $this->position_x,
            'tooltip' => $this->tooltip,
            'placeholder' => $this->placeholder,
            'title' => $this->title,
            'isMandatory' => $this->is_mondatory,
            'webFormat' => $styles,
            'printFormat' => $printDetails,
            'inputType' => $this?->TemplateType ?  InputTypeResource::make($this?->TemplateType) : null,
        ];
    }
}
