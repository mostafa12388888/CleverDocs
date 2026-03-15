<?php

namespace App\Http\Resources\Form;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InputTypeLookupCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "type" => $this->type,
            "key" => $this->key,
            "customListId" => $this->custom_option_list_id,
            "entity" => $this->entity,
            "optionsType" => $this->options_type,
        ];
    }
}
