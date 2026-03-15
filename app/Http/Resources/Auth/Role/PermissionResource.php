<?php

namespace App\Http\Resources\Auth\Role;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
            'en' => trans('permission.' . $this->resource, [], 'en'),
            'ar' => trans('permission.' . $this->resource, [], 'ar'),
        ],
        'value' => $this->resource,
    ];
}

}
