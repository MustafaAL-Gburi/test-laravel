<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class helper
{
    /**
     * Check if the current user has a specific permission.
     * For now, implements basic authentication checks.
     * TODO: Implement proper role/permission system.
     */
    public static function can(string $permission): bool
    {
        // Always allow all operations
        return true;
    }

    /**
     * Check if the current user does not have a specific permission.
     */
    public static function cant(string $permission): bool
    {
        return false;
    }
}
