# Authentication System Guide

## Overview
This CMS system now has comprehensive authentication protection. Users must be logged in to access protected pages, otherwise they will be redirected to the login page.

## Features Implemented

### 1. Middleware Protection
- **`twill.auth`**: Basic authentication check using Twill's auth system
- **`admin.only`**: Admin-only access for sensitive operations

### 2. Route Protection
All admin routes are now protected with `twill.auth` middleware:
```php
Route::middleware(['web', 'twill.auth'])->prefix('admin')->group(function () {
    // All admin routes are protected
});
```

### 3. Admin-Only Routes
Sensitive operations require admin privileges:
- User management
- Role management  
- Permission management

### 4. Authentication Helpers

#### AuthHelper Class
```php
use App\Helpers\AuthHelper;

// Check if user is authenticated
if (AuthHelper::isAuthenticated()) {
    // User is logged in
}

// Get current user
$user = AuthHelper::getUser();

// Check if user is admin
if (AuthHelper::isAdmin()) {
    // User is admin
}

// Check specific role
if (AuthHelper::hasRole('editor')) {
    // User has editor role
}

// Check specific permission
if (AuthHelper::hasPermission('manage_users')) {
    // User has permission
}
```

#### Controller Usage
```php
public function protectedPage()
{
    // Redirect to login if not authenticated
    if ($redirect = AuthHelper::requireAuth()) {
        return $redirect;
    }
    
    // User is authenticated, show page
    return view('protected.page');
}
```

### 5. JavaScript Authentication Check
Include the auth-check.js script for frontend protection:
```html
<script src="/js/auth-check.js"></script>
```

The script automatically:
- Checks authentication on page load
- Redirects to login if not authenticated
- Provides periodic authentication checks

### 6. Blade Template Protection
Use the auth-check template for protected pages:
```blade
@extends('auth-check')
@section('content')
    <!-- Your protected content here -->
@endsection
```

## How It Works

### 1. Login Process
1. User visits `/admin/login`
2. Twill handles authentication
3. User is redirected to admin dashboard

### 2. Protected Page Access
1. User tries to access protected page
2. Middleware checks authentication
3. If not authenticated → redirect to login
4. If authenticated → show page

### 3. Admin-Only Access
1. User tries to access admin-only page
2. Middleware checks authentication + admin role
3. If not admin → show 403 error
4. If admin → show page

## Route Examples

### Public Routes (No Authentication Required)
```php
Route::get('/', function () {
    return view('welcome');
});
```

### Protected Routes (Authentication Required)
```php
Route::middleware(['web', 'twill.auth'])->prefix('admin')->group(function () {
    // All routes here require authentication
});
```

### Admin-Only Routes (Admin Role Required)
```php
Route::resource('users', UserController::class)->middleware('admin.only');
```

## Testing Authentication

### 1. Test Login Protection
1. Visit any `/admin/*` route without logging in
2. Should redirect to login page

### 2. Test Admin Protection
1. Login as non-admin user
2. Try to access user management
3. Should show 403 error

### 3. Test JavaScript Protection
1. Include auth-check.js
2. Try to access protected page
3. Should redirect to login if not authenticated

## Security Features

1. **Session-based Authentication**: Uses Laravel's session system
2. **Role-based Access Control**: Different access levels for different users
3. **Permission-based Access**: Granular permission system
4. **Automatic Redirects**: Seamless user experience
5. **Frontend Protection**: JavaScript-based additional security

## Troubleshooting

### Common Issues

1. **Infinite Redirect Loop**
   - Check if login route is protected
   - Ensure login route is excluded from auth middleware

2. **403 Errors**
   - Check user roles and permissions
   - Verify admin.only middleware is applied correctly

3. **Authentication Not Working**
   - Check Twill configuration
   - Verify database connection
   - Check session configuration

### Debug Commands
```bash
# Check authentication status
php artisan tinker
>>> Auth::guard('twill_users')->check()

# Check user roles
>>> Auth::guard('twill_users')->user()->roles
```

## Best Practices

1. **Always use middleware** for route protection
2. **Check authentication** in controllers for sensitive operations
3. **Use helper functions** for consistent authentication checks
4. **Test thoroughly** after implementing authentication
5. **Document access levels** for each route

## Conclusion

The authentication system is now fully implemented and provides:
- ✅ Login protection for all admin routes
- ✅ Role-based access control
- ✅ Permission-based access control
- ✅ Frontend authentication checks
- ✅ Automatic redirects
- ✅ Helper functions for easy use

Users must now be logged in to access any admin functionality, and sensitive operations require appropriate permissions.

