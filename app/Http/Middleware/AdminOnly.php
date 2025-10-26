<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (!Auth::guard('twill_users')->check()) {
            return redirect()->route('twill.login');
        }

        // Get the authenticated user
        $user = Auth::guard('twill_users')->user();
        
        // Check if user has admin role or is super admin
        if (!$user || (!$user->isSuperAdmin() && !$user->hasRole('admin'))) {
            abort(403, 'Access denied. Admin privileges required.');
        }

        return $next($request);
    }
}

