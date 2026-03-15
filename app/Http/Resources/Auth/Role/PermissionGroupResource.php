<?php

namespace App\Http\Resources\Auth\Role;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {

        return [
            'name' => [
                'en' => trans('permission.' . $this['name'], [], 'en'),
                'ar' => trans('permission.' . $this['name'], [], 'ar'),
            ],
            'permissions' => $this->_translatePermissions($this["permissions"]),
        ];
    }

    private function _translatePermissions($permissions): array
    {
        $result = [];

        foreach ($permissions as $permission) {
            $result[] = [
                'name' => [
                    'en' => trans("permission.$permission", [], 'en'),
                    'ar' => trans("permission.$permission", [], 'ar'),
                ],
                'value' => $permission,
            ];
        }

        return $result;
    }
}
