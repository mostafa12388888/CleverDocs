<?php

namespace App\Http\Resources\Form;

use Illuminate\Http\Request;
use App\Http\Resources\InputForm\FormInputPreViewResource;
use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Resources\Json\JsonResource;

class FormPreViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'mainData'=> [
                'name'=> json_decode($this->name),
                'layout'    => $this->layout,
                'status' => $this->status,
                'primary' => $this->primary,
                'projects' => $this->projects,
                'version' => $this->version,
                "symbol"=>$this->symbol,
                'mainCreatedAt' => $this->mainTemplate?->created_at,
                'mainCreatedBy' => new CreatedByInfo($this->mainTemplate?->createdBy),
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
                'updatedBy' => new CreatedByInfo($this->mainTemplate?->updatedBy),
            ],
                'inputs' => FormInputPreViewResource::collection($this->templateInputs),
                "permissions" => [
                    "canEdit"=>true,
                    "canDelete"=> true
                ]
            ];

    }
}
