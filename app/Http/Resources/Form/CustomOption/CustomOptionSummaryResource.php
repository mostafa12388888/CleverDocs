<?php

namespace App\Http\Resources\Form\CustomOption;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomOptionSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->title) {
            $title = json_decode($this->title, true);
            $this->title = $title['title'] ?? $title;
        }
        return [
            "id" => $this->id,
            "name" => $this->title,
            "permissions" => [
                "canEdit"=>true,
                "canDelete"=> true
            ]
        ];;
    }
}
