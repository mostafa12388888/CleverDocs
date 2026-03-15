<?php

namespace App\Http\Resources\InputForm\Show;

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
            'templateFormId'=>$this->templates_form_id,
            'trintInputId' => $this->id,
            'templateInputId' => $this->template_input_id,
            'printFormatId' => $this->print_format_id,

            'attchmentTempalteInputAttch'=>$this->tempalte_input,
            
        ];
    }
}
