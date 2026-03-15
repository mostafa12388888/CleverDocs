<?php

namespace App\Http\Resources\InputForm;

use App\Http\Resources\Form\CustomOption\CustomOptionDetailsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InputTypeDetailsResource extends JsonResource
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
            'type'=>$this->type,
            'category'=>$this->category,
            "customOptionsList"=>$this->CustomOptionList?CustomOptionDetailsResource::make($this->CustomOptionList):null,
        ];
    }
}
