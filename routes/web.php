<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MenuController;

use App\Http\Controllers\PageBuilderController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Admin\ContentTypeController;
use App\Http\Controllers\Admin\ContentItemController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\DataTypeController;
use App\Http\Controllers\ProfileController as OrganizeProfileController;
use App\Http\Controllers\FieldManagerController;
use App\Http\Controllers\FieldGroupController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\ProtectedController;




Route::get('/login', function () {
    return redirect()->route('twill.login');
})->name('login');

// Check if user is logged in
Route::get('/check-auth', function () {
    if (Auth::guard('twill_users')->check()) {
        return response()->json(['authenticated' => true, 'user' => Auth::guard('twill_users')->user()]);
    }
    return response()->json(['authenticated' => false]);
})->name('check.auth');

// Menu routes
Route::middleware(['web', 'twill.auth'])->prefix('admin')->group(function () {
    Route::resource('menu', MenuController::class);
});
Route::middleware(['web', 'twill.auth'])->prefix('admin')->group(function () {
    // Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::resource('users', UserController::class)->middleware('admin.only');


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
Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index')->middleware('admin.only');

// Show form to create new permission
Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create')->middleware('admin.only');

// Store new permission
Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store')->middleware('admin.only');

// Show single permission details
Route::get('/permissions/{id}', [PermissionController::class, 'show'])->name('permissions.show')->middleware('admin.only');

// Show form to edit permission
Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware('admin.only');

// Update permission
Route::put('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update')->middleware('admin.only');

// Delete permission
Route::delete('/permissions/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy')->middleware('admin.only');



Route::post('/page-builder/save', [PageBuilderController::class, 'save'])->name('page.builder.save');
Route::get('/page-builder', [PageBuilderController::class, 'index'])->name('page.builder');

// Config page route
Route::get('/config', [App\Http\Controllers\ConfigController::class, 'index'])->name('config.index');

// Setup page route
Route::get('/setup', [App\Http\Controllers\SetupController::class, 'index'])->name('setup.index');

// Setup Routes
Route::prefix('setup')->name('setup.')->group(function () {
    // Company Routes
    Route::resource('company', App\Http\Controllers\Setup\CompanyController::class);
    
    // Location Routes
    Route::resource('location', App\Http\Controllers\Setup\LocationController::class);
    
    // Department Routes
    Route::resource('department', App\Http\Controllers\Setup\DepartmentController::class);
    
    // Employee Routes
    Route::resource('employee', App\Http\Controllers\Setup\EmployeeController::class);
});

// Settings page route
Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');

// Active Area page route
Route::get('/active-area', [App\Http\Controllers\SettingsController::class, 'index'])->name('active-area.index');

// Active Area Menu Management Routes
Route::prefix('active-area/menu-management')->name('active-area.menu-management.')->group(function () {
    // Toolbar Menu
    Route::get('/toolbar', function () {
        return view('admin.menu.active-area.toolbar');
    })->name('toolbar');
    
    // Top Menu
    Route::get('/top-menu', function () {
        return view('admin.menu.active-area.top-menu');
    })->name('top-menu');
    
    // Breadcrumbs
    Route::get('/breadcrumbs', function () {
        return view('admin.menu.active-area.breadcrumbs');
    })->name('breadcrumbs');
    
    // Sidebar Left
    Route::get('/sidebar-left', function () {
        return view('admin.menu.active-area.sidebar-left');
    })->name('sidebar-left');
    
    // Sidebar Right
    Route::get('/sidebar-right', function () {
        return view('admin.menu.active-area.sidebar-right');
    })->name('sidebar-right');
    
    // Bottom Menu
    Route::get('/bottom-menu', function () {
        return view('admin.menu.active-area.bottom-menu');
    })->name('bottom-menu');
});

Route::resource('roles', RoleController::class)->middleware('admin.only');

// Organize Content Routes
Route::resource('industries', IndustryController::class)->names([
    'index' => 'admin.industries.index',
    'create' => 'admin.industries.create',
    'store' => 'admin.industries.store',
    'show' => 'admin.industries.show',
    'edit' => 'admin.industries.edit',
    'update' => 'admin.industries.update',
    'destroy' => 'admin.industries.destroy'
]);

Route::resource('data-types', DataTypeController::class)->names([
    'index' => 'admin.data-types.index',
    'create' => 'admin.data-types.create',
    'store' => 'admin.data-types.store',
    'show' => 'admin.data-types.show',
    'edit' => 'admin.data-types.edit',
    'update' => 'admin.data-types.update',
    'destroy' => 'admin.data-types.destroy'
])->parameters(['data-types' => 'dataType']);

Route::resource('profiles', ProfileController::class)->names([
    'index' => 'admin.profiles.index',
    'create' => 'admin.profiles.create',
    'store' => 'admin.profiles.store',
    'show' => 'admin.profiles.show',
    'edit' => 'admin.profiles.edit',
    'update' => 'admin.profiles.update',
    'destroy' => 'admin.profiles.destroy'
])->parameters(['profiles' => 'profile']);

// Field Manager Routes
Route::prefix('field-manager')->name('admin.field-manager.')->group(function () {
    Route::get('/', [FieldManagerController::class, 'index'])->name('index');
    Route::get('/install', [FieldManagerController::class, 'installFieldType'])->name('install');
    Route::post('/install', [FieldManagerController::class, 'store'])->name('store');
    Route::get('/search', [FieldManagerController::class, 'search'])->name('search');
    Route::get('/{fieldManager}', [FieldManagerController::class, 'show'])->name('show');
    Route::get('/{fieldManager}/details', [FieldManagerController::class, 'getDetails'])->name('details');
    Route::get('/{fieldManager}/edit', [FieldManagerController::class, 'edit'])->name('edit');
    Route::put('/{fieldManager}', [FieldManagerController::class, 'update'])->name('update');
    Route::delete('/{fieldManager}', [FieldManagerController::class, 'destroy'])->name('destroy');
    Route::post('/{fieldManager}/activate', [FieldManagerController::class, 'activate'])->name('activate');
    Route::post('/{fieldManager}/deactivate', [FieldManagerController::class, 'deactivate'])->name('deactivate');
    Route::post('/{fieldManager}/install', [FieldManagerController::class, 'install'])->name('install-field');
    Route::post('/{fieldManager}/uninstall', [FieldManagerController::class, 'uninstall'])->name('uninstall');
    
    // Bulk actions
    Route::post('/bulk-activate', [FieldManagerController::class, 'bulkActivate'])->name('bulk-activate');
    Route::post('/bulk-deactivate', [FieldManagerController::class, 'bulkDeactivate'])->name('bulk-deactivate');
    Route::delete('/bulk-delete', [FieldManagerController::class, 'bulkDelete'])->name('bulk-delete');
});

// Category Groups Routes
Route::prefix('category-groups')->name('admin.category-groups.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\CategoryGroupController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\Admin\CategoryGroupController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\Admin\CategoryGroupController::class, 'store'])->name('store');
    Route::get('/{categoryGroup}', [App\Http\Controllers\Admin\CategoryGroupController::class, 'show'])->name('show');
    Route::get('/{categoryGroup}/edit', [App\Http\Controllers\Admin\CategoryGroupController::class, 'edit'])->name('edit');
    Route::put('/{categoryGroup}', [App\Http\Controllers\Admin\CategoryGroupController::class, 'update'])->name('update');
    Route::delete('/{categoryGroup}', [App\Http\Controllers\Admin\CategoryGroupController::class, 'destroy'])->name('destroy');
    Route::post('/{categoryGroup}/toggle-status', [App\Http\Controllers\Admin\CategoryGroupController::class, 'toggleStatus'])->name('toggle-status');
});

// Workflow Routes
Route::prefix('workflow')->name('admin.workflow.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\WorkflowController::class, 'index'])->name('index');
});

// Field Groups Routes
Route::resource('field-groups', FieldGroupController::class)->names([
    'index' => 'admin.field-groups.index',
    'create' => 'admin.field-groups.create',
    'store' => 'admin.field-groups.store',
    'show' => 'admin.field-groups.show',
    'edit' => 'admin.field-groups.edit',
    'update' => 'admin.field-groups.update',
    'destroy' => 'admin.field-groups.destroy'
]);

Route::post('/field-groups/{fieldGroup}/activate', [FieldGroupController::class, 'activate'])->name('admin.field-groups.activate');
Route::post('/field-groups/{fieldGroup}/deactivate', [FieldGroupController::class, 'deactivate'])->name('admin.field-groups.deactivate');

// Fields Routes
Route::resource('fields', FieldController::class)->names([
    'index' => 'admin.fields.index',
    'create' => 'admin.fields.create',
    'store' => 'admin.fields.store',
    'show' => 'admin.fields.show',
    'edit' => 'admin.fields.edit',
    'update' => 'admin.fields.update',
    'destroy' => 'admin.fields.destroy'
]);

Route::post('/fields/{field}/activate', [FieldController::class, 'activate'])->name('admin.fields.activate');
Route::post('/fields/{field}/deactivate', [FieldController::class, 'deactivate'])->name('admin.fields.deactivate');
Route::post('/fields/{field}/copy', [FieldController::class, 'copy'])->name('admin.fields.copy');

// Bulk actions
Route::post('/fields/bulk-activate', [FieldController::class, 'bulkActivate'])->name('admin.fields.bulk-activate');
Route::post('/fields/bulk-deactivate', [FieldController::class, 'bulkDeactivate'])->name('admin.fields.bulk-deactivate');
Route::delete('/fields/bulk-delete', [FieldController::class, 'bulkDelete'])->name('admin.fields.bulk-delete');

// Content type routes
Route::resource('content-types', App\Http\Controllers\Admin\ContentTypeController::class);

Route::prefix('content-types/{contentType}')->name('content-types.')->group(function () {
    // Content Type Fields
    Route::get('/manage-fields', [App\Http\Controllers\Admin\ContentTypeController::class, 'manageFields'])->name('manage-fields');
    Route::get('/add-field', [App\Http\Controllers\Admin\ContentTypeController::class, 'addField'])->name('add-field');
    Route::post('/store-field', [App\Http\Controllers\Admin\ContentTypeController::class, 'storeField'])->name('store-field');
    Route::get('/field/{fieldKey}/edit', [App\Http\Controllers\Admin\ContentTypeController::class, 'editField'])->name('edit-field');
    Route::put('/field/{fieldKey}', [App\Http\Controllers\Admin\ContentTypeController::class, 'updateField'])->name('update-field');
    Route::delete('/field/{fieldKey}', [App\Http\Controllers\Admin\ContentTypeController::class, 'deleteField'])->name('delete-field');
    Route::get('/reorder-fields', [App\Http\Controllers\Admin\ContentTypeController::class, 'reorderFields'])->name('reorder-fields');
    
    // Unified Field Management
    Route::post('/add-field-unified', [App\Http\Controllers\Admin\ContentTypeController::class, 'addFieldToContentType'])->name('add-field-unified');
    Route::delete('/remove-field-unified', [App\Http\Controllers\Admin\ContentTypeController::class, 'removeFieldFromContentType'])->name('remove-field-unified');
    Route::put('/update-field-unified', [App\Http\Controllers\Admin\ContentTypeController::class, 'updateFieldInContentType'])->name('update-field-unified');

    // Layout Designer
    Route::get('/layout-builder', [App\Http\Controllers\Admin\ContentTypeController::class, 'layoutBuilder'])->name('layout-builder');
    Route::get('/preview-layout/{template?}', [App\Http\Controllers\Admin\ContentTypeController::class, 'previewLayout'])->name('preview-layout');
    Route::get('/field-blocks', [App\Http\Controllers\Admin\ContentTypeController::class, 'getFieldBlocks'])->name('field-blocks');
    
        // Visual Builders
        Route::get('/grapes-builder', [App\Http\Controllers\Admin\ContentTypeController::class, 'grapesBuilder'])->name('grapes-builder');
        Route::get('/vvveb-builder', [App\Http\Controllers\Admin\ContentTypeController::class, 'vvvebBuilder'])->name('vvveb-builder');
        Route::get('/simple-builder', [App\Http\Controllers\Admin\ContentTypeController::class, 'simpleBuilder'])->name('simple-builder');
        Route::get('/professional-builder', [App\Http\Controllers\Admin\ContentTypeController::class, 'professionalBuilder'])->name('professional-builder');
        Route::get('/working-builder', [App\Http\Controllers\Admin\ContentTypeController::class, 'workingBuilder'])->name('working-builder');
        Route::get('/advanced-builder', [App\Http\Controllers\Admin\ContentTypeController::class, 'advancedBuilder'])->name('advanced-builder');
        
        // Field & Content Type Designer
        Route::get('/field-designer', [App\Http\Controllers\Admin\ContentTypeController::class, 'fieldDesigner'])->name('field-designer');
        Route::get('/content-type-designer', [App\Http\Controllers\Admin\ContentTypeController::class, 'contentTypeDesigner'])->name('content-type-designer');
        Route::post('/save-field-design', [App\Http\Controllers\Admin\ContentTypeController::class, 'saveFieldDesign'])->name('save-field-design');
        Route::post('/save-content-type-design', [App\Http\Controllers\Admin\ContentTypeController::class, 'saveContentTypeDesign'])->name('save-content-type-design');
    Route::post('/save-layout', [App\Http\Controllers\Admin\ContentTypeController::class, 'saveLayout'])->name('save-layout');
    Route::get('/load-layout', [App\Http\Controllers\Admin\ContentTypeController::class, 'loadLayout'])->name('load-layout');
    Route::get('/layouts', [App\Http\Controllers\Admin\ContentTypeController::class, 'getLayouts'])->name('layouts');
    Route::delete('/layouts/{layoutId}', [App\Http\Controllers\Admin\ContentTypeController::class, 'deleteLayout'])->name('delete-layout');
    Route::post('/layouts/{layoutId}/set-default', [App\Http\Controllers\Admin\ContentTypeController::class, 'setDefaultLayout'])->name('set-default-layout');

    // Content Item
    Route::resource('items', App\Http\Controllers\Admin\ContentItemController::class)
        ->names([
            'index' => 'content-items.index',
            'create' => 'content-items.create',
            'store' => 'content-items.store',
            'show' => 'content-items.show',
            'edit' => 'content-items.edit',
            'update' => 'content-items.update',
            'destroy' => 'content-items.destroy'
        ]);

    // Bulk operations
    Route::post('items/bulk-action', [App\Http\Controllers\Admin\ContentItemController::class, 'bulkAction'])->name('content-items.bulk-action');
    Route::post('items/bulk-publish', [App\Http\Controllers\Admin\ContentItemController::class, 'bulkPublish'])->name('content-items.bulk-publish');
    Route::post('items/bulk-delete', [App\Http\Controllers\Admin\ContentItemController::class, 'bulkDelete'])->name('content-items.bulk-delete');
    Route::post('items/bulk-archive', [App\Http\Controllers\Admin\ContentItemController::class, 'bulkArchive'])->name('content-items.bulk-archive');


        // Field Management
        Route::get('fields', [App\Http\Controllers\Admin\ContentTypeController::class, 'manageFields'])->name('fields');
        Route::post('fields', [App\Http\Controllers\Admin\ContentTypeController::class, 'saveFields'])->name('fields.save');

        // Export/Import
        Route::get('export', [App\Http\Controllers\Admin\ContentTypeController::class, 'export'])->name('export');
        Route::post('import', [App\Http\Controllers\Admin\ContentTypeController::class, 'import'])->name('import');
    });

    // Categories Routes
    Route::get('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/categories/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'show'])->name('admin.categories.show');
    Route::get('/categories/{category}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    Route::post('/categories/{category}/toggle-status', [App\Http\Controllers\Admin\CategoryController::class, 'toggleStatus'])->name('admin.categories.toggle-status');
    Route::get('/categories/{category}/children', [App\Http\Controllers\Admin\CategoryController::class, 'getChildren'])->name('admin.categories.children');

});

// Config Menu Management Routes
Route::prefix('admin/config/menu-management')->name('config.menu-management.')->group(function () {
    // Toolbar Menu
    Route::get('/toolbar', function () {
        return view('admin.menu.config.toolbar');
    })->name('toolbar');
    
    // Top Menu
    Route::get('/top-menu', function () {
        return view('admin.menu.config.top-menu');
    })->name('top-menu');
    
    // Breadcrumbs
    Route::get('/breadcrumbs', function () {
        return view('admin.menu.config.breadcrumbs');
    })->name('breadcrumbs');
    
    // Sidebar Left
    Route::get('/sidebar-left', function () {
        return view('admin.menu.config.sidebar-left');
    })->name('sidebar-left');
    
    // Sidebar Right
    Route::get('/sidebar-right', function () {
        return view('admin.menu.config.sidebar-right');
    })->name('sidebar-right');
    
    // Bottom Menu
    Route::get('/bottom-menu', function () {
        return view('admin.menu.config.bottom-menu');
    })->name('bottom-menu');
});

// Setup Menu Management Routes
Route::prefix('admin/setup/menu-management')->name('setup.menu-management.')->group(function () {
    // Toolbar Menu
    Route::get('/toolbar', function () {
        return view('admin.menu.setup.toolbar');
    })->name('toolbar');
    
    // Top Menu
    Route::get('/top-menu', function () {
        return view('admin.menu.setup.top-menu');
    })->name('top-menu');
    
    // Breadcrumbs
    Route::get('/breadcrumbs', function () {
        return view('admin.menu.setup.breadcrumbs');
    })->name('breadcrumbs');
    
    // Sidebar Left
    Route::get('/sidebar-left', function () {
        return view('admin.menu.setup.sidebar-left');
    })->name('sidebar-left');
    
    // Sidebar Right
    Route::get('/sidebar-right', function () {
        return view('admin.menu.setup.sidebar-right');
    })->name('sidebar-right');
    
    // Bottom Menu
    Route::get('/bottom-menu', function () {
        return view('admin.menu.setup.bottom-menu');
    })->name('bottom-menu');
});

// Field Manager Routes
Route::prefix('admin/field-manager')->name('field-manager.')->group(function () {
    Route::get('/{slug}', [App\Http\Controllers\Admin\FieldManagerController::class, 'index'])->name('index');
    Route::post('/{slug}/create-field', [App\Http\Controllers\Admin\FieldManagerController::class, 'createField'])->name('create-field');
    Route::put('/{slug}/update-field/{fieldKey}', [App\Http\Controllers\Admin\FieldManagerController::class, 'updateField'])->name('update-field');
    Route::delete('/{slug}/delete-field/{fieldKey}', [App\Http\Controllers\Admin\FieldManagerController::class, 'deleteField'])->name('delete-field');
    Route::post('/{slug}/duplicate-field/{fieldKey}', [App\Http\Controllers\Admin\FieldManagerController::class, 'duplicateField'])->name('duplicate-field');
    Route::post('/{slug}/reorder-fields', [App\Http\Controllers\Admin\FieldManagerController::class, 'reorderFields'])->name('reorder-fields');
    Route::post('/{slug}/save-field-groups', [App\Http\Controllers\Admin\FieldManagerController::class, 'saveFieldGroups'])->name('save-field-groups');
    Route::post('/{slug}/save-visibility-rules', [App\Http\Controllers\Admin\FieldManagerController::class, 'saveVisibilityRules'])->name('save-visibility-rules');
    Route::post('/{slug}/generate-migration', [App\Http\Controllers\Admin\FieldManagerController::class, 'generateMigration'])->name('generate-migration');
    Route::get('/{slug}/export', [App\Http\Controllers\Admin\FieldManagerController::class, 'exportFields'])->name('export');
    Route::post('/{slug}/import', [App\Http\Controllers\Admin\FieldManagerController::class, 'importFields'])->name('import');
    Route::get('/{slug}/statistics', [App\Http\Controllers\Admin\FieldManagerController::class, 'getStatistics'])->name('statistics');
    Route::post('/{slug}/preview-field', [App\Http\Controllers\Admin\FieldManagerController::class, 'previewField'])->name('preview-field');
    Route::get('/{slug}/field-type-options', [App\Http\Controllers\Admin\FieldManagerController::class, 'getFieldTypeOptions'])->name('field-type-options');
    Route::post('/{slug}/validate-field-config', [App\Http\Controllers\Admin\FieldManagerController::class, 'validateFieldConfig'])->name('validate-field-config');
});

// Page Management Routes
Route::prefix('admin/pages')->name('pages.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\PageController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\Admin\PageController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\Admin\PageController::class, 'store'])->name('store');
    Route::get('/{page}', [App\Http\Controllers\Admin\PageController::class, 'show'])->name('show');
    Route::get('/{page}/edit', [App\Http\Controllers\Admin\PageController::class, 'edit'])->name('edit');
    Route::put('/{page}', [App\Http\Controllers\Admin\PageController::class, 'update'])->name('update');
    Route::delete('/{page}', [App\Http\Controllers\Admin\PageController::class, 'destroy'])->name('destroy');
    Route::post('/{page}/toggle-status', [App\Http\Controllers\Admin\PageController::class, 'toggleStatus'])->name('toggle-status');
    Route::post('/{page}/set-homepage', [App\Http\Controllers\Admin\PageController::class, 'setHomepage'])->name('set-homepage');
    Route::get('/{page}/preview', [App\Http\Controllers\Admin\PageController::class, 'preview'])->name('preview');
    
    // Main Page Builder
    Route::get('/{page}/page-builder', [App\Http\Controllers\Admin\PageController::class, 'pageBuilder'])->name('page-builder');
    Route::post('/{page}/page-builder/save', [App\Http\Controllers\Admin\PageController::class, 'savePageBuilder'])->name('page-builder.save');
    
    // Page Builders
    Route::get('/{page}/advanced-builder', [App\Http\Controllers\Admin\PageController::class, 'advancedBuilder'])->name('advanced-builder');
    Route::get('/{page}/professional-builder', [App\Http\Controllers\Admin\PageController::class, 'professionalBuilder'])->name('professional-builder');
    Route::get('/{page}/working-builder', [App\Http\Controllers\Admin\PageController::class, 'workingBuilder'])->name('working-builder');
    Route::get('/{page}/grapes-builder', [App\Http\Controllers\Admin\PageController::class, 'grapesBuilder'])->name('grapes-builder');
    Route::post('/{page}/save-builder-content', [App\Http\Controllers\Admin\PageController::class, 'saveBuilderContent'])->name('save-builder-content');
});

// Preview route for page builder
Route::get('/preview/{previewId}', function ($previewId) {
    // Get preview content from localStorage (this will be handled by JavaScript)
    return view('preview', compact('previewId'));
})->name('preview');


// Protected routes examples
Route::get('/protected', [ProtectedController::class, 'index'])->name('protected.index');
Route::get('/admin-only', [ProtectedController::class, 'adminOnly'])->name('protected.admin');
Route::get('/editor-only', [ProtectedController::class, 'roleRequired'])->name('protected.editor');
Route::get('/users-management', [ProtectedController::class, 'permissionRequired'])->name('protected.users');

// Blog Routes
Route::prefix('blog')->name('blog.')->group(function () {
    // Public blog routes
    Route::get('/', function () {
        return view('blog.index');
    })->name('index');
    
    Route::get('/post/{slug}', function ($slug) {
        // Get post data from localStorage or database
        $posts = json_decode(request()->session()->get('blogPosts', '[]'), true);
        $post = collect($posts)->firstWhere('slug', $slug);
        
        if (!$post) {
            abort(404);
        }
        
        return view('blog.post', compact('post'));
    })->name('post');
    
    Route::get('/category/{slug}', function ($slug) {
        return view('blog.category', compact('slug'));
    })->name('category');
    
    Route::get('/search', function () {
        return view('blog.search');
    })->name('search');
});

// Admin Blog Routes
Route::middleware(['web', 'twill.auth'])->prefix('admin')->group(function () {
    // Blog Posts Management
    Route::get('/posts', function () {
        return view('vendor.twill.posts.index');
    })->name('posts.index');
    
    // Blog Categories Management  
    Route::get('/blog-categories', function () {
        return view('vendor.twill.categories.index');
    })->name('blog.categories.index');
    
    // Media Library Management
    Route::get('/media-library', function () {
        return view('vendor.twill.media-library.index');
    })->name('media-library.index');
    
    // Test route for media library
    Route::get('/test-media', function () {
        return 'Media Library Test Route Working!';
    });
});

// Test Media Library without authentication
Route::get('/test-media-library', function () {
    return view('vendor.twill.media-library.index');
});

Route::get('/', function () {
    return view('welcome');
});

