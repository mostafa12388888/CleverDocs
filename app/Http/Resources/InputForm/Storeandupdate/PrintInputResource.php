<?php

namespace App\Http\Resources\InputForm\Storeandupdate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrintInputResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
        [
            'printInputId' => $this->id,
            'templateInputId' => $this->template_input_id,
            'printFormatId' => $this->print_format_id,
            'position' => $this->position,
            'style' => $this->styles,
            'hide' => $this->hide,
            'width' => $this->width,
            'height' => $this->height,
            'customTitle' => $this->custom_title,
        ];
    }
}
