<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\PageBuilderController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;





Route::get('/login', function () {
    return redirect()->route('twill.login');
})->name('login');
Route::middleware(['web'])->prefix('admin')->group(function () {
    // Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::resource('users', UserController::class);
        // ✅ Dashboard route
    // Route::get('/', function () {
    //     return view('admin.dashboard'); // make sure this view exists
    // })->name('admin');

    // // Index - List all users
// Route::get('/users', [UserController::class, 'index'])->name('users.index');

// Create - Show form to create user
// Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

// Store - Save new user
// Route::post('/users', [UserController::class, 'store'])->name('users.store');

// Show - View user details (optional)
// Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

// Edit - Show form to edit user
// Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');

// Update - Save updated user
// Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

// Delete - Remove user
// Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');



Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity_logs.index');
Route::get('/activity-logs/{id}', [ActivityLogController::class, 'show'])->name('activity_logs.show');

// Route::get('/activity-logs', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('admin.activity_logs.index');
// Show profile page
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.show');

// Show profile settings page
 Route::get('/profile', [ProfileController::class, 'index'])->name('profile.show');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile_settings.index');
    Route::post('/profile/social-media', [ProfileController::class, 'socialmedia_store'])->name('profile.socialmedia_store');
    Route::post('/profile/store', [UserProfileController::class, 'store'])->name('profile.store');
// Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');  // Edit profile form
    // Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');   // Update profile
// List all permissions
Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');

// Show form to create new permission
Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');

// Store new permission
Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');

// Show single permission details
Route::get('/permissions/{id}', [PermissionController::class, 'show'])->name('permissions.show');

// Show form to edit permission
Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');

// Update permission
Route::put('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');

// Delete permission
Route::delete('/permissions/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');



// Change this line:
// Route::post('/page-builder/save', [PageBuilderController::class, 'save'])->name('page.builder.save');

// To:
Route::post('/page/save', [PageBuilderController::class, 'save'])->name('page.save');
Route::get('/page-builder', [PageBuilderController::class, 'index'])->name('page.builder');

Route::resource('roles', RoleController::class);

// List all roles
// Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');

// Show form to create a new role
// Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');

// Store new role
// Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');

// Show form to edit an existing role
// Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');

// Update existing role
// Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');

// Delete role
// Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');


});

Route::get('/', function () {
    return view('welcome');
});

