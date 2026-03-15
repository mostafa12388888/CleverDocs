<?php

namespace App\Http\Resources\Form;

use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormListResource extends JsonResource
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
            'status' => $this->status,
            'primary' => $this->Primary,
            'layout' => $this->layout,
            "symbol"=>$this->symbol,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'createdBy' => new CreatedByInfo($this->createdBy),
            'updatedBy' => new CreatedByInfo($this->updatedBy),
            'canDelete' => !$this->submissions()->exists(),
            "permissions" => [
                "canEdit"=>true,
                "canDelete"=> true
            ]

//            'submissions' => $this->submissions
        ];
    }
}
