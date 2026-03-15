<?php

namespace App\Http\Resources\Form\Show;

use App\Http\Resources\Form\WBSDetailsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'projectId' => $this->id,
            'projectStatus' => $this->project_status,
            'concat' => $this->contact,
            'projectMangerCompany' => $this->project_manager_company,
            'projectType' => $this->project_type,
            'country' => $this->country,
            'contactValue' => $this->contract_value,
            'description' => $this->description,
            'referenceNumber' => $this->reference_number,
            'order' => $this->order,
            'name' =>json_decode( $this->name),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'wbs' => new WBSDetailsResource($this->wbs),
        ];
    }
}
