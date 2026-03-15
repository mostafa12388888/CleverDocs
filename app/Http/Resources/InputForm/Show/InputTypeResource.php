<?php

namespace App\Http\Resources\InputForm\Show;

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
        return  [
            'title' =>json_decode( $this->title),
            'type'=>$this->type,
            'subType' => $this->sub_type,
            'category'=>$this->category,
            'customOptionsList'=>CustomOptionsList::collection($this->customOption),
        ];
    }
}
