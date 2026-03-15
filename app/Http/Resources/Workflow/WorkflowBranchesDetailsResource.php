<?php

namespace App\Http\Resources\Workflow;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkflowBranchesDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'title' => $this->title ? json_decode($this->title) : null,
            'isDefault' => $this->is_default,
            'condition' => $this->condition_input_id ? [
                'operator' => $this->condition_operator,
                'inputId' => $this->condition_input_id,
                'inputValue' => $this->condition_input_value,
            ] : null,

        ];
    }
}
