<?php

namespace App\Http\Resources\Form\Show;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplateInput extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'templates_forms_id'=>$this->templates_forms_id,
            'input_types_id'=>$this->input_types_id,
            'width'=>$this->width,
            'height'=>$this->height,
            'position_y'=>$this->position_y,
            'position_x'=>$this->position_x,
            'custom_title'=>$this->custom_title,
            'title'=>$this->title,
            'is_mondatory'=>$this->is_mondatory,
            'styles'=>$this->styles,
            'id'=>$this->id,

        ];
    }
}
