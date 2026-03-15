<?php

namespace App\Http\Resources\InputForm\Show;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\InputForm\Show\PrintInputResource;
class InputFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'inputFormId' => $this->id,
            'inputTypeId' => $this->input_types_id,
            'templatesFormId' => $this->templates_forms_id,
            'width' => $this->width,
            'height' => $this->height,
            'positionY' => $this->position_y,
            'positionX' => $this->position_x,
            'customTitle' => $this->custom_title,
            'title' =>json_decode( $this->title),
            'isMondatory' => $this->is_mondatory,
            'style' => $this->styles,
            'type' => $this->type,
            'attchmentTemplateType'=> new InputTypeResource($this->TemplateType),
            'printFormat' => PrintInputResource::collection($this->PrintFormat),

        ];
    }
}
