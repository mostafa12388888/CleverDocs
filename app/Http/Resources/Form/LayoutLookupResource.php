<?php

namespace App\Http\Resources\Form;

use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Http\Resources\Json\JsonResource;

class LayoutLookupResource extends JsonResource
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
            "subject" => Helper::isJson($this->subject) ? json_decode($this->subject) : null,
            "type" => $this->type,
        ];
    }
}
