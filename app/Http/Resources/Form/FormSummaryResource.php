<?php

namespace App\Http\Resources\Form;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'version' => $this->version,
            'name' => json_decode($this->name),
            'canAddSubmission' => $this->status=='active'?true:false,
            "permissions" => [
                "canEdit"=>true,
                "canDelete"=> true
            ]

        ];
    }
}
