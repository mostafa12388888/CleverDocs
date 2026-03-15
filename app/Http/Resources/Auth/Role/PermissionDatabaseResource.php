<?php

namespace App\Http\Resources\Auth\Role;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionDatabaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => [
                'en' => trans('permission.' . $this->name, [], 'en'),
                'ar' => trans('permission.' . $this->name, [], 'ar'),
            ],
            'value' => $this->name,
        ];
    }
}
