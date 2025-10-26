<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryGroupController extends Controller
{
    public function index()
    {
        $categoryGroups = CategoryGroup::withCount('categories')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('vendor.twill.organize_content.category-groups.index', compact('categoryGroups'));
    }

    public function create()
    {
        return view('vendor.twill.organize_content.category-groups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'nullable|string|max:255|unique:category_groups,slug',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'icon' => 'nullable|string|max:255'
        ]);

        $data = $request->all();
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        CategoryGroup::create($data);

        return redirect()->route('admin.category-groups.index')
            ->with('success', 'Category group created successfully.');
    }

    public function show(CategoryGroup $categoryGroup)
    {
        $categoryGroup->load('categories');
        return view('vendor.twill.organize_content.category-groups.show', compact('categoryGroup'));
    }

    public function edit(CategoryGroup $categoryGroup)
    {
        return view('vendor.twill.organize_content.category-groups.edit', compact('categoryGroup'));
    }

    public function update(Request $request, CategoryGroup $categoryGroup)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'nullable|string|max:255|unique:category_groups,slug,' . $categoryGroup->id,
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'icon' => 'nullable|string|max:255'
        ]);

        $data = $request->all();
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $categoryGroup->update($data);

        return redirect()->route('admin.category-groups.index')
            ->with('success', 'Category group updated successfully.');
    }

    public function destroy(CategoryGroup $categoryGroup)
    {
        try {
            \Log::info('Deleting category group: ' . $categoryGroup->id . ' - ' . $categoryGroup->name);
            $categoryGroup->delete();
            \Log::info('Category group deleted successfully: ' . $categoryGroup->id);

            return redirect()->route('admin.category-groups.index')
                ->with('success', 'Category group deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting category group: ' . $e->getMessage());
            return redirect()->route('admin.category-groups.index')
                ->with('error', 'Error deleting category group: ' . $e->getMessage());
        }
    }

    public function toggleStatus(CategoryGroup $categoryGroup)
    {
        $categoryGroup->update(['is_active' => !$categoryGroup->is_active]);

        $status = $categoryGroup->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Category group {$status} successfully.");
    }
}

