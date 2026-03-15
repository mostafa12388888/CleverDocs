<?php

namespace App\Http\Resources\InputForm\Show;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InputOption extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'=>$this->title,
            'isDefault'=>$this->is_default,
            'isActive'=>$this->is_active,
        ];
    }
}
