<?php

namespace App\Http\Controllers;

use App\Models\FieldGroup;
use Illuminate\Http\Request;

class FieldGroupController extends Controller
{
    public function index()
    {
        $fieldGroups = FieldGroup::ordered()->paginate(10);
        return view('vendor.twill.organize_content.field_groups.index', compact('fieldGroups'));
    }

    public function create()
    {
        return view('vendor.twill.organize_content.field_groups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'source' => 'required|in:local,centralized,custom',
            'access_rights' => 'required|in:public,private,restricted',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        FieldGroup::create($data);

        return redirect()->route('admin.field-groups.index')
            ->with('success', 'Field group created successfully.');
    }

    public function show(FieldGroup $fieldGroup)
    {
        return view('vendor.twill.organize_content.field_groups.show', compact('fieldGroup'));
    }

    public function edit(FieldGroup $fieldGroup)
    {
        return view('vendor.twill.organize_content.field_groups.edit', compact('fieldGroup'));
    }

    public function update(Request $request, FieldGroup $fieldGroup)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'source' => 'required|in:local,centralized,custom',
            'access_rights' => 'required|in:public,private,restricted',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $fieldGroup->update($data);

        return redirect()->route('admin.field-groups.index')
            ->with('success', 'Field group updated successfully.');
    }

    public function destroy(FieldGroup $fieldGroup)
    {
        $fieldGroup->delete();

        return redirect()->route('admin.field-groups.index')
            ->with('success', 'Field group deleted successfully.');
    }

    public function activate(FieldGroup $fieldGroup)
    {
        $fieldGroup->update(['is_active' => true]);
        return redirect()->back()->with('success', 'Field group activated successfully.');
    }

    public function deactivate(FieldGroup $fieldGroup)
    {
        $fieldGroup->update(['is_active' => false]);
        return redirect()->back()->with('success', 'Field group deactivated successfully.');
    }
}

