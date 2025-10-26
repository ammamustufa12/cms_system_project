<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\FieldGroup;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index(Request $request)
    {
        $query = Field::with('fieldGroup')->ordered();
        
        // Filter by field group if selected
        if ($request->filled('field_group_id')) {
            $query->where('field_group_id', $request->field_group_id);
        }
        
        $fields = $query->paginate(10);
        $fieldGroups = FieldGroup::ordered()->get();
        $selectedFieldGroup = $request->field_group_id ? FieldGroup::find($request->field_group_id) : null;
        
        return view('vendor.twill.organize_content.fields.index', compact('fields', 'fieldGroups', 'selectedFieldGroup'));
    }

    public function create()
    {
        $fieldGroups = FieldGroup::ordered()->get();
        return view('vendor.twill.organize_content.fields.create', compact('fieldGroups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'alias' => 'required|string|max:255|unique:fields,alias',
            'type' => 'required|string|max:50',
            'field_group_id' => 'nullable|exists:field_groups,id',
            'description' => 'nullable|string',
            'viewable' => 'required|in:public,private,restricted',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'field_config' => 'nullable|array',
            'validation_rules' => 'nullable|array'
        ]);

        $data = $request->all();
        
        // Handle checkbox for is_active
        $data['is_active'] = $request->has('is_active');

        Field::create($data);

        return redirect()->route('admin.fields.index')
            ->with('success', 'Field created successfully.');
    }

    public function show(Field $field)
    {
        $fieldGroups = FieldGroup::ordered()->get();
        return view('vendor.twill.organize_content.fields.show', compact('field', 'fieldGroups'));
    }

    public function edit(Field $field)
    {
        $fieldGroups = FieldGroup::ordered()->get();
        return view('vendor.twill.organize_content.fields.edit', compact('field', 'fieldGroups'));
    }

    public function update(Request $request, Field $field)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'alias' => 'required|string|max:255|unique:fields,alias,' . $field->id,
            'type' => 'required|string|max:50',
            'field_group_id' => 'nullable|exists:field_groups,id',
            'description' => 'nullable|string',
            'viewable' => 'required|in:public,private,restricted',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'field_config' => 'nullable|array',
            'validation_rules' => 'nullable|array'
        ]);

        $data = $request->all();
        
        // Handle checkbox for is_active
        $data['is_active'] = $request->has('is_active');

        $field->update($data);

        return redirect()->route('admin.fields.index')
            ->with('success', 'Field updated successfully.');
    }

    public function destroy(Field $field)
    {
        $field->delete();

        return redirect()->route('admin.fields.index')
            ->with('success', 'Field deleted successfully.');
    }

    public function activate(Field $field)
    {
        $field->update(['is_active' => true]);
        return redirect()->back()->with('success', 'Field activated successfully.');
    }

    public function deactivate(Field $field)
    {
        $field->update(['is_active' => false]);
        return redirect()->back()->with('success', 'Field deactivated successfully.');
    }

    public function copy(Field $field)
    {
        $newField = $field->replicate();
        $newField->label = $field->label . ' (Copy)';
        $newField->alias = $field->alias . '_copy';
        $newField->save();

        return redirect()->route('admin.fields.index')
            ->with('success', 'Field copied successfully.');
    }

    public function bulkActivate(Request $request)
    {
        $request->validate([
            'field_ids' => 'required|array',
            'field_ids.*' => 'exists:fields,id'
        ]);

        Field::whereIn('id', $request->field_ids)->update(['is_active' => true]);

        return redirect()->route('admin.fields.index')
            ->with('success', count($request->field_ids) . ' field(s) activated successfully.');
    }

    public function bulkDeactivate(Request $request)
    {
        $request->validate([
            'field_ids' => 'required|array',
            'field_ids.*' => 'exists:fields,id'
        ]);

        Field::whereIn('id', $request->field_ids)->update(['is_active' => false]);

        return redirect()->route('admin.fields.index')
            ->with('success', count($request->field_ids) . ' field(s) deactivated successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'field_ids' => 'required|array',
            'field_ids.*' => 'exists:fields,id'
        ]);

        Field::whereIn('id', $request->field_ids)->delete();

        return redirect()->route('admin.fields.index')
            ->with('success', count($request->field_ids) . ' field(s) deleted successfully.');
    }
}

