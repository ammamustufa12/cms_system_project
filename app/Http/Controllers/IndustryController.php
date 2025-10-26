<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use Illuminate\Http\Request;

class IndustryController extends Controller
{
    public function index()
    {
        $industries = Industry::ordered()->paginate(10);
        return view('vendor.twill.organize_content.industries.index', compact('industries'));
    }

    public function create()
    {
        return view('vendor.twill.organize_content.industries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        Industry::create($request->all());

        return redirect()->route('admin.industries.index')
            ->with('success', 'Industry created successfully.');
    }

    public function show(Industry $industry)
    {
        return view('vendor.twill.organize_content.industries.show', compact('industry'));
    }

    public function edit(Industry $industry)
    {
        return view('vendor.twill.organize_content.industries.edit', compact('industry'));
    }

    public function update(Request $request, Industry $industry)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $industry->update($request->all());

        return redirect()->route('admin.industries.index')
            ->with('success', 'Industry updated successfully.');
    }

    public function destroy(Industry $industry)
    {
        try {
            \Log::info('Deleting industry: ' . $industry->id . ' - ' . $industry->name);
            $industry->delete();
            \Log::info('Industry deleted successfully: ' . $industry->id);

            return redirect()->route('admin.industries.index')
                ->with('success', 'Industry deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting industry: ' . $e->getMessage());
            return redirect()->route('admin.industries.index')
                ->with('error', 'Error deleting industry: ' . $e->getMessage());
        }
    }
}
