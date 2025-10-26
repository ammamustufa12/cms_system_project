<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use App\Models\DataType;
use App\Models\Profile;
use App\Models\CategoryGroup;
use App\Models\Category;
use App\Models\FieldGroup;
use App\Models\FieldManager;

class WorkflowController extends Controller
{
    public function index()
    {
        // Get counts for each step
        $workflowSteps = [
            [
                'title' => 'Industries',
                'description' => 'Define business industries and sectors',
                'route' => 'admin.industries.index',
                'count' => Industry::count(),
                'icon' => 'ri-building-line',
                'color' => 'primary',
                'status' => Industry::count() > 0 ? 'completed' : 'pending'
            ],
            [
                'title' => 'Data Types',
                'description' => 'Define data structure and validation rules',
                'route' => 'admin.data-types.index',
                'count' => DataType::count(),
                'icon' => 'ri-database-2-line',
                'color' => 'info',
                'status' => DataType::count() > 0 ? 'completed' : 'pending'
            ],
            [
                'title' => 'Profiles',
                'description' => 'Create user profiles and types',
                'route' => 'admin.profiles.index',
                'count' => Profile::count(),
                'icon' => 'ri-user-line',
                'color' => 'success',
                'status' => Profile::count() > 0 ? 'completed' : 'pending'
            ],
            [
                'title' => 'Category Groups',
                'description' => 'Organize content with category groups',
                'route' => 'admin.category-groups.index',
                'count' => CategoryGroup::count(),
                'icon' => 'ri-folder-line',
                'color' => 'warning',
                'status' => CategoryGroup::count() > 0 ? 'completed' : 'pending'
            ],
            [
                'title' => 'Categories',
                'description' => 'Create hierarchical categories',
                'route' => 'admin.categories.index',
                'count' => Category::count(),
                'icon' => 'ri-list-check',
                'color' => 'secondary',
                'status' => Category::count() > 0 ? 'completed' : 'pending'
            ],
            [
                'title' => 'Field Types',
                'description' => 'Install and manage field types',
                'route' => 'admin.field-manager.install',
                'count' => FieldManager::count(),
                'icon' => 'ri-download-line',
                'color' => 'danger',
                'status' => FieldManager::count() > 0 ? 'completed' : 'pending'
            ],
            [
                'title' => 'Field Groups',
                'description' => 'Organize fields into groups',
                'route' => 'admin.field-groups.index',
                'count' => FieldGroup::count(),
                'icon' => 'ri-folder-settings-line',
                'color' => 'dark',
                'status' => FieldGroup::count() > 0 ? 'completed' : 'pending'
            ],
            [
                'title' => 'Fields',
                'description' => 'Manage individual content fields',
                'route' => 'admin.fields.index',
                'count' => 0, // This would need to be implemented
                'icon' => 'ri-list-check-2',
                'color' => 'primary',
                'status' => 'pending'
            ]
        ];

        $completedSteps = collect($workflowSteps)->where('status', 'completed')->count();
        $totalSteps = count($workflowSteps);
        $progressPercentage = ($completedSteps / $totalSteps) * 100;

        return view('admin.workflow.index', compact('workflowSteps', 'completedSteps', 'totalSteps', 'progressPercentage'));
    }
}

