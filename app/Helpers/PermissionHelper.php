<?php

namespace App\Helpers;
use App\Enum\Authorization\PermissionEnum;

class PermissionHelper
{

    /**
     * @param mixed $permission
     * @param int|null $createdBy
     * @param mixed|null $user
     * @return bool
     */
    public static function isAuthAllowedTo(mixed $permission, ?int $createdBy = null, mixed $user = null): bool
    {
        if(!$user) $user = auth()->user();

        if(!$user) return false;

        if (($user->isSuperAdmin()) && !in_array($permission, self::_nonAdminPermissions())) return true;

        if(!$createdBy && $permission && !$user->isSuperAdmin() ) return $user->can($permission);

        if(!$permission && $createdBy) return $createdBy == $user->id;

        if(!$permission && !$createdBy) return true;

        return $user->can($permission) && $createdBy == $user->id;
    }

    /**
     * @param array $permissions
     * @param int|null $createdBy
     * @return bool
     */
    public static function userCanDoOneOfPermissions(array $permissions, ?int $createdBy = null): bool
    {
        foreach ($permissions as $permission) {
            if (self::isAuthAllowedTo($permission, $createdBy)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return array
     */
    private static function _nonAdminPermissions(): array
    {
        return [

        ];
    }

}
