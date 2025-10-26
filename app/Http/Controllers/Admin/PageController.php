<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of pages
     */
    public function index()
    {
        $pages = Page::orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(15);
        return view('vendor.twill.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new page
     */
    public function create()
    {
        return view('vendor.twill.pages.create');
    }

    /**
     * Store a newly created page
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'featured_image' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
            'is_homepage' => 'boolean',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            
            // Ensure slug is unique
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Page::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // If this is set as homepage, unset other homepages
        if ($validated['is_homepage'] ?? false) {
            Page::where('is_homepage', true)->update(['is_homepage' => false]);
        }

        $page = Page::create($validated);

        return redirect()->route('pages.index')->with('success', 'Page created successfully!');
    }

    /**
     * Display the specified page
     */
    public function show(Page $page)
    {
        return view('vendor.twill.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the page
     */
    public function edit(Page $page)
    {
        return view('vendor.twill.pages.edit', compact('page'));
    }

    /**
     * Update the specified page
     */
    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'featured_image' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
            'is_homepage' => 'boolean',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            
            // Ensure slug is unique (excluding current page)
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Page::where('slug', $validated['slug'])->where('id', '!=', $page->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // If this is set as homepage, unset other homepages
        if ($validated['is_homepage'] ?? false) {
            Page::where('is_homepage', true)->where('id', '!=', $page->id)->update(['is_homepage' => false]);
        }

        $page->update($validated);

        return redirect()->route('pages.index')->with('success', 'Page updated successfully!');
    }

    /**
     * Remove the specified page
     */
    public function destroy(Page $page)
    {
        // Don't allow deleting homepage
        if ($page->is_homepage) {
            return redirect()->route('pages.index')->with('error', 'Cannot delete homepage!');
        }

        $page->delete();
        return redirect()->route('pages.index')->with('success', 'Page deleted successfully!');
    }

    /**
     * Toggle page status
     */
    public function toggleStatus(Page $page)
    {
        $newStatus = $page->status === 'published' ? 'draft' : 'published';
        $page->update(['status' => $newStatus]);
        
        return redirect()->route('pages.index')->with('success', "Page status changed to {$newStatus}!");
    }

    /**
     * Set as homepage
     */
    public function setHomepage(Page $page)
    {
        // Unset current homepage
        Page::where('is_homepage', true)->update(['is_homepage' => false]);
        
        // Set new homepage
        $page->update(['is_homepage' => true, 'status' => 'published']);
        
        return redirect()->route('pages.index')->with('success', 'Homepage updated successfully!');
    }

    /**
     * Preview page
     */
    public function preview(Page $page)
    {
        return view('vendor.twill.pages.preview', compact('page'));
    }

    /**
     * Advanced Page Builder
     */
    public function advancedBuilder(Page $page)
    {
        return view('vendor.twill.pages.advanced-builder', compact('page'));
    }

    /**
     * Professional Page Builder
     */
    public function professionalBuilder(Page $page)
    {
        return view('vendor.twill.pages.professional-builder', compact('page'));
    }

    /**
     * Working Page Builder
     */
    public function workingBuilder(Page $page)
    {
        return view('vendor.twill.pages.working-builder', compact('page'));
    }

    /**
     * GrapesJS Page Builder
     */
    public function grapesBuilder(Page $page)
    {
        return view('vendor.twill.pages.grapes-builder', compact('page'));
    }

    /**
     * Save page builder content
     */
    public function saveBuilderContent(Request $request, Page $page)
    {
        $validated = $request->validate([
            'builder_content' => 'nullable|string',
            'builder_type' => 'required|string|in:advanced,professional,working,grapes',
            'css_content' => 'nullable|string',
            'js_content' => 'nullable|string'
        ]);

        // Update page with builder content
        $page->update([
            'content' => $validated['builder_content'] ?? $page->content,
            'custom_fields' => array_merge($page->custom_fields ?? [], [
                'builder_type' => $validated['builder_type'],
                'css_content' => $validated['css_content'] ?? '',
                'js_content' => $validated['js_content'] ?? '',
                'last_built_at' => now()
            ])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Page content saved successfully!',
            'page' => $page->fresh()
        ]);
    }

    /**
     * Main Page Builder
     */
    public function pageBuilder(Page $page)
    {
        $contentTypes = \App\Services\ContentTypePageBuilderService::getContentTypesForPageBuilder();
        
        return view('vendor.twill.pages.page-builder', compact('page', 'contentTypes'));
    }

    /**
     * Save Page Builder Content
     */
    public function savePageBuilder(Request $request, Page $page)
    {
        $validated = $request->validate([
            'builder_content' => 'required|string',
            'builder_type' => 'required|string',
            'css_content' => 'nullable|string',
            'js_content' => 'nullable|string'
        ]);

        $page->update([
            'content' => $validated['builder_content'],
            'custom_fields' => array_merge($page->custom_fields ?? [], [
                'builder_type' => $validated['builder_type'],
                'css_content' => $validated['css_content'] ?? '',
                'js_content' => $validated['js_content'] ?? '',
                'last_built_at' => now()
            ])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Page saved successfully!',
            'page' => $page->fresh()
        ]);
    }
}
