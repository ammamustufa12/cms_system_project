<?php

namespace App\Http\Controllers;

use App\Models\FieldManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FieldManagerController extends Controller
{
    public function index()
    {
        $fieldTypes = FieldManager::ordered()->paginate(10);
        return view('vendor.twill.organize_content.field_manager.index', compact('fieldTypes'));
    }

    public function installFieldType()
    {
        $fieldTypes = FieldManager::ordered()->get();
        return view('vendor.twill.organize_content.field_manager.install', compact('fieldTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:50',
            'source' => 'required|in:local,centralized,custom',
            'version' => 'nullable|string|max:20',
            'author' => 'nullable|string|max:255',
            'install_instructions' => 'nullable|string',
            'install_file' => 'nullable|file|mimes:zip|max:10240' // 10MB max
        ]);

        $data = $request->except('install_file');
        
        // Handle file upload
        if ($request->hasFile('install_file')) {
            $file = $request->file('install_file');
            $fileName = time() . '_' . Str::slug($request->name) . '.zip';
            $filePath = $file->storeAs('field_types', $fileName, 'public');
            $data['install_file_path'] = $filePath;
            $data['is_installed'] = true;
        }

        FieldManager::create($data);

        return redirect()->route('admin.field-manager.install')
            ->with('success', 'Field type created successfully.');
    }

    public function show(FieldManager $fieldManager)
    {
        return view('vendor.twill.organize_content.field_manager.show', compact('fieldManager'));
    }

    public function edit(FieldManager $fieldManager)
    {
        return view('vendor.twill.organize_content.field_manager.edit', compact('fieldManager'));
    }

    public function update(Request $request, FieldManager $fieldManager)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:50',
            'source' => 'required|in:local,centralized,custom',
            'version' => 'nullable|string|max:20',
            'author' => 'nullable|string|max:255',
            'install_instructions' => 'nullable|string',
            'is_active' => 'boolean',
            'install_file' => 'nullable|file|mimes:zip|max:10240' // 10MB max
        ]);

        $data = $request->except('install_file');
        
        // Handle file upload
        if ($request->hasFile('install_file')) {
            // Delete old file if exists
            if ($fieldManager->install_file_path && Storage::disk('public')->exists($fieldManager->install_file_path)) {
                Storage::disk('public')->delete($fieldManager->install_file_path);
            }
            
            $file = $request->file('install_file');
            $fileName = time() . '_' . Str::slug($request->name) . '.zip';
            $filePath = $file->storeAs('field_types', $fileName, 'public');
            $data['install_file_path'] = $filePath;
            $data['is_installed'] = true;
        }
        
        // Handle checkbox for is_active
        $data['is_active'] = $request->has('is_active');

        $fieldManager->update($data);

        return redirect()->route('admin.field-manager.index')
            ->with('success', 'Field type updated successfully.');
    }

    public function destroy(FieldManager $fieldManager)
    {
        // Delete associated file if exists
        if ($fieldManager->install_file_path && Storage::disk('public')->exists($fieldManager->install_file_path)) {
            Storage::disk('public')->delete($fieldManager->install_file_path);
        }

        $fieldManager->delete();

        return redirect()->route('admin.field-manager.index')
            ->with('success', 'Field type deleted successfully.');
    }

    public function activate(FieldManager $fieldManager)
    {
        $fieldManager->update(['is_active' => true]);
        return redirect()->back()->with('success', 'Field type activated successfully.');
    }

    public function deactivate(FieldManager $fieldManager)
    {
        $fieldManager->update(['is_active' => false]);
        return redirect()->back()->with('success', 'Field type deactivated successfully.');
    }

    public function install(FieldManager $fieldManager)
    {
        $fieldManager->update(['is_installed' => true]);
        return redirect()->back()->with('success', 'Field type installed successfully.');
    }

    public function uninstall(FieldManager $fieldManager)
    {
        $fieldManager->update(['is_installed' => false]);
        return redirect()->back()->with('success', 'Field type uninstalled successfully.');
    }

    /**
     * Get field type details for AJAX requests
     */
    public function getDetails(FieldManager $fieldManager)
    {
        return response()->json([
            'id' => $fieldManager->id,
            'name' => $fieldManager->name,
            'description' => $fieldManager->description,
            'type' => $fieldManager->type,
            'source' => $fieldManager->source,
            'version' => $fieldManager->version,
            'author' => $fieldManager->author,
            'is_active' => $fieldManager->is_active,
            'is_installed' => $fieldManager->is_installed,
            'field_config' => $fieldManager->field_config,
            'validation_rules' => $fieldManager->validation_rules,
            'source_badge' => $fieldManager->source_badge,
            'status_badge' => $fieldManager->status_badge
        ]);
    }

    /**
     * Bulk activate field types
     */
    public function bulkActivate(Request $request)
    {
        $request->validate([
            'field_ids' => 'required|array',
            'field_ids.*' => 'exists:field_managers,id'
        ]);

        FieldManager::whereIn('id', $request->field_ids)
            ->update(['is_active' => true]);

        return redirect()->back()->with('success', 'Selected field types activated successfully.');
    }

    /**
     * Bulk deactivate field types
     */
    public function bulkDeactivate(Request $request)
    {
        $request->validate([
            'field_ids' => 'required|array',
            'field_ids.*' => 'exists:field_managers,id'
        ]);

        FieldManager::whereIn('id', $request->field_ids)
            ->update(['is_active' => false]);

        return redirect()->back()->with('success', 'Selected field types deactivated successfully.');
    }

    /**
     * Bulk delete field types
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'field_ids' => 'required|array',
            'field_ids.*' => 'exists:field_managers,id'
        ]);

        $fieldTypes = FieldManager::whereIn('id', $request->field_ids)->get();
        
        foreach ($fieldTypes as $fieldType) {
            // Delete associated file if exists
            if ($fieldType->install_file_path && Storage::disk('public')->exists($fieldType->install_file_path)) {
                Storage::disk('public')->delete($fieldType->install_file_path);
            }
            $fieldType->delete();
        }

        return redirect()->back()->with('success', 'Selected field types deleted successfully.');
    }

    /**
     * Search field types
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $fieldTypes = FieldManager::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orWhere('type', 'like', "%{$query}%")
            ->ordered()
            ->paginate(10);

        return view('vendor.twill.organize_content.field_manager.index', compact('fieldTypes'));
    }
}

