<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::with(['categoryGroup', 'parent'])
            ->withCount('children');

        // Filter by category group
        if ($request->filled('category_group_id')) {
            $query->where('category_group_id', $request->category_group_id);
        }

        // Filter by parent category
        if ($request->filled('parent_id')) {
            $query->where('parent_id', $request->parent_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $categories = $query->orderBy('category_group_id')
            ->orderBy('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        $categoryGroups = CategoryGroup::active()->get();
        $parentCategories = Category::whereNull('parent_id')->get();

        return view('vendor.twill.organize_content.categories.index', compact('categories', 'categoryGroups', 'parentCategories'));
    }

    public function create()
    {
        $categoryGroups = CategoryGroup::active()->get();
        $parentCategories = Category::whereNull('parent_id')->get();

        return view('vendor.twill.organize_content.categories.create', compact('categoryGroups', 'parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'category_group_id' => 'required|exists:category_groups,id',
            'parent_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'icon' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500'
        ]);

        $data = $request->all();
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        $category->load(['categoryGroup', 'parent', 'children']);
        return view('vendor.twill.organize_content.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $categoryGroups = CategoryGroup::active()->get();
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();

        return view('vendor.twill.organize_content.categories.edit', compact('category', 'categoryGroups', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'category_group_id' => 'required|exists:category_groups,id',
            'parent_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'icon' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500'
        ]);

        $data = $request->all();
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        try {
            \Log::info('Deleting category: ' . $category->id . ' - ' . $category->name);
            $category->delete();
            \Log::info('Category deleted successfully: ' . $category->id);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting category: ' . $e->getMessage());
            return redirect()->route('admin.categories.index')
                ->with('error', 'Error deleting category: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);

        $status = $category->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Category {$status} successfully.");
    }

    public function getChildren(Category $category)
    {
        $children = $category->children()->with('categoryGroup')->get();
        
        return response()->json($children);
    }
}

