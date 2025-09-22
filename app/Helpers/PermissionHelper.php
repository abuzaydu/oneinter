<?php

namespace App\Helpers;

class PermissionHelper
{
    public static function can($permission)
    {
        $user = auth()->user();
        return $user && $user->hasPermission($permission);
    }

    public static function canAny($permissions)
    {
        $user = auth()->user();
        return $user && $user->hasAnyPermission($permissions);
    }

    public static function canAll($permissions)
    {
        $user = auth()->user();
        return $user && $user->hasAllPermissions($permissions);
    }
} 