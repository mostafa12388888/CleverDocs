<?php

namespace App\Http\Resources\Form\Storeandupdate;

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
            'wbsId' => $this->w_b_s_id,
            'projectId' => $this->id,
            'projectStatus' => $this->project_status,
            'conact' => $this->conact,
            'projectManagemerCompany' => $this->project_managemer_company,
            'projectType' => $this->project_type,
            'countery' => $this->countery,
            'countactValue' => $this->contract_value,
            'description' => $this->description,
            'refrenceNumber' => $this->refrence_number,
            'order' => $this->order,
            'name' => json_decode($this->name),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
