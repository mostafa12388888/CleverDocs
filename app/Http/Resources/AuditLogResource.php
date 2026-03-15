<?php

namespace App\Http\Resources;

use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuditLogResource extends JsonResource
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
            'action' => $this->action,
            'user' => new CreatedByInfo($this->user),
            'oldData' => $this->old_values,
            'newData' => $this->new_values,
            'oldRelatedData' => $this->old_related_data,
            'newRelatedData' => $this->new_related_data,
            'createdAt' => $this->created_at,
        ];
    }


}
