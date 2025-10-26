<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\AuthHelper;

class ProtectedController extends Controller
{
    /**
     * Show a protected page that requires authentication
     */
    public function index()
    {
        // Check if user is authenticated
        if ($redirect = AuthHelper::requireAuth()) {
            return $redirect;
        }

        // User is authenticated, show the page
        return view('protected.index');
    }

    /**
     * Show an admin-only page
     */
    public function adminOnly()
    {
        // Check if user is admin
        if ($redirect = AuthHelper::requireAdmin()) {
            return $redirect;
        }

        // User is admin, show the page
        return view('protected.admin');
    }

    /**
     * Show a page that requires specific role
     */
    public function roleRequired()
    {
        // Check if user is authenticated
        if ($redirect = AuthHelper::requireAuth()) {
            return $redirect;
        }

        // Check if user has specific role
        if (!AuthHelper::hasRole('editor')) {
            abort(403, 'Access denied. Editor role required.');
        }

        // User has required role, show the page
        return view('protected.editor');
    }

    /**
     * Show a page that requires specific permission
     */
    public function permissionRequired()
    {
        // Check if user is authenticated
        if ($redirect = AuthHelper::requireAuth()) {
            return $redirect;
        }

        // Check if user has specific permission
        if (!AuthHelper::hasPermission('manage_users')) {
            abort(403, 'Access denied. Manage users permission required.');
        }

        // User has required permission, show the page
        return view('protected.users');
    }
}

