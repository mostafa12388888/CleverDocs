<?php

namespace App\Http\Resources\InputForm;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InputTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            'title' =>$this->title,
             "key"=>$this->key,
            'type'=>$this->type,
            'subType' => $this->sub_type,
            'category'=>$this->category,
            'optionsType' => $this->options_type,
            'customListOptionsId' => $this->custom_option_list_id,
            'entity' => $this->entity,

        ];
    }
}
