<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    /**
     * Check if user is authenticated
     */
    public static function isAuthenticated()
    {
        return Auth::guard('twill_users')->check();
    }

    /**
     * Get authenticated user
     */
    public static function getUser()
    {
        return Auth::guard('twill_users')->user();
    }

    /**
     * Check if user is admin
     */
    public static function isAdmin()
    {
        $user = self::getUser();
        return $user && ($user->isSuperAdmin() || $user->hasRole('admin'));
    }

    /**
     * Check if user has specific role
     */
    public static function hasRole($role)
    {
        $user = self::getUser();
        return $user && $user->hasRole($role);
    }

    /**
     * Check if user has specific permission
     */
    public static function hasPermission($permission)
    {
        $user = self::getUser();
        return $user && $user->hasPermission($permission);
    }

    /**
     * Redirect to login if not authenticated
     */
    public static function requireAuth()
    {
        if (!self::isAuthenticated()) {
            return redirect()->route('twill.login');
        }
        return null;
    }

    /**
     * Redirect to login if not admin
     */
    public static function requireAdmin()
    {
        if (!self::isAdmin()) {
            return redirect()->route('twill.login');
        }
        return null;
    }
}

