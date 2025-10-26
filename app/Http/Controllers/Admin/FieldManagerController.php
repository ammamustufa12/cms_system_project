<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentType;
use App\Services\FieldManagerService;
use App\Services\FieldTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FieldManagerController extends Controller
{
    /**
     * Show field manager interface
     */
    public function index($slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $fieldTypes = FieldTypeService::getSupportedTypes();
        $fieldGroups = FieldManagerService::getFieldGroups($contentType);
        $visibilityRules = FieldManagerService::getVisibilityRules($contentType);
        $statistics = FieldManagerService::getFieldStatistics($contentType);

        // Variables required by the form layout
        $saveUrl = route('field-manager.store', $slug);
        $moduleName = 'field-manager';
        $customForm = false;

        return view('vendor.twill.field-manager.index', compact(
            'contentType',
            'fieldTypes',
            'fieldGroups',
            'visibilityRules',
            'statistics',
            'saveUrl',
            'moduleName',
            'customForm'
        ));
    }

    /**
     * Create new field
     */
    public function createField(Request $request, $slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'required' => 'boolean',
            'group' => 'nullable|string',
            'visibility' => 'nullable|string',
            'options' => 'nullable|array',
            'validation_rules' => 'nullable|array'
        ]);

        // Validate field configuration
        $validation = FieldManagerService::validateField($validated);
        if (!$validation['valid']) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validation['errors']
            ], 422);
        }

        $result = FieldManagerService::createField($contentType, $validated);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Field created successfully!',
                'field' => $result['field_config']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to create field'
        ], 500);
    }

    /**
     * Update existing field
     */
    public function updateField(Request $request, $slug, $fieldKey)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'required' => 'boolean',
            'group' => 'nullable|string',
            'visibility' => 'nullable|string',
            'options' => 'nullable|array',
            'validation_rules' => 'nullable|array'
        ]);

        // Validate field configuration
        $validation = FieldManagerService::validateField($validated);
        if (!$validation['valid']) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validation['errors']
            ], 422);
        }

        $result = FieldManagerService::updateField($contentType, $fieldKey, $validated);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Field updated successfully!',
                'field' => $result['field_config']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Failed to update field'
        ], 500);
    }

    /**
     * Delete field
     */
    public function deleteField(Request $request, $slug, $fieldKey)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        
        $result = FieldManagerService::deleteField($contentType, $fieldKey);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Field deleted successfully!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Failed to delete field'
        ], 500);
    }

    /**
     * Duplicate field
     */
    public function duplicateField(Request $request, $slug, $fieldKey)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        
        $result = FieldManagerService::duplicateField($contentType, $fieldKey);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Field duplicated successfully!',
                'field' => $result['field_config']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Failed to duplicate field'
        ], 500);
    }

    /**
     * Reorder fields
     */
    public function reorderFields(Request $request, $slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        
        $validated = $request->validate([
            'field_order' => 'required|array',
            'field_groups' => 'nullable|array'
        ]);

        $fieldsSchema = $contentType->fields_schema ?? [];
        
        // Update field order
        foreach ($validated['field_order'] as $index => $fieldKey) {
            if (isset($fieldsSchema[$fieldKey])) {
                $fieldsSchema[$fieldKey]['order'] = $index + 1;
            }
        }

        // Update field groups if provided
        if (isset($validated['field_groups'])) {
            FieldManagerService::saveFieldGroups($contentType, $validated['field_groups']);
        }

        $contentType->update([
            'fields_schema' => $fieldsSchema
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Field order updated successfully!'
        ]);
    }

    /**
     * Save field groups
     */
    public function saveFieldGroups(Request $request, $slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        
        $validated = $request->validate([
            'field_groups' => 'required|array',
            'field_groups.*.name' => 'required|string|max:255',
            'field_groups.*.description' => 'nullable|string',
            'field_groups.*.icon' => 'nullable|string',
            'field_groups.*.color' => 'nullable|string',
            'field_groups.*.order' => 'required|integer'
        ]);

        $result = FieldManagerService::saveFieldGroups($contentType, $validated['field_groups']);

        return response()->json($result);
    }

    /**
     * Save visibility rules
     */
    public function saveVisibilityRules(Request $request, $slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        
        $validated = $request->validate([
            'visibility_rules' => 'required|array',
            'visibility_rules.*.field' => 'required|string',
            'visibility_rules.*.condition' => 'required|string',
            'visibility_rules.*.value' => 'required|string',
            'visibility_rules.*.action' => 'required|string|in:show,hide,require'
        ]);

        $result = FieldManagerService::saveVisibilityRules($contentType, $validated['visibility_rules']);

        return response()->json($result);
    }

    /**
     * Generate migration
     */
    public function generateMigration(Request $request, $slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        
        $result = FieldManagerService::generateMigration($contentType);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Migration generated successfully!',
                'file_name' => $result['file_name']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Failed to generate migration'
        ], 500);
    }

    /**
     * Export field configuration
     */
    public function exportFields(Request $request, $slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        
        $exportData = FieldManagerService::exportFields($contentType);
        $filename = $contentType->slug . '_fields_' . date('Y-m-d_H-i-s') . '.json';
        
        return response()->json($exportData)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Content-Type', 'application/json');
    }

    /**
     * Import field configuration
     */
    public function importFields(Request $request, $slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        
        $validated = $request->validate([
            'import_file' => 'required|file|mimes:json|max:1024'
        ]);

        $file = $request->file('import_file');
        $content = file_get_contents($file->getPathname());
        $importData = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->withErrors(['import_file' => 'Invalid JSON file']);
        }

        $result = FieldManagerService::importFields($contentType, $importData);

        if ($result['success']) {
            return redirect()->route('field-manager.index', $slug)
                ->with('success', $result['message']);
        }

        return back()->withErrors(['import_file' => $result['message']]);
    }

    /**
     * Get field statistics
     */
    public function getStatistics($slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $statistics = FieldManagerService::getFieldStatistics($contentType);

        return response()->json($statistics);
    }

    /**
     * Preview field
     */
    public function previewField(Request $request, $slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        
        $validated = $request->validate([
            'field_type' => 'required|string',
            'field_config' => 'required|array'
        ]);

        $fieldType = FieldTypeService::getFieldType($validated['field_type']);
        if (!$fieldType) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid field type'
            ], 400);
        }

        // Generate preview HTML
        $previewHtml = $this->generateFieldPreview($validated['field_type'], $validated['field_config']);

        return response()->json([
            'success' => true,
            'preview_html' => $previewHtml
        ]);
    }

    /**
     * Generate field preview HTML
     */
    private function generateFieldPreview(string $fieldType, array $fieldConfig): string
    {
        $fieldName = 'preview_field';
        $fieldValue = $this->getSampleValue($fieldType);
        $options = $fieldConfig['options'] ?? [];

        return FieldTypeService::renderFieldInput($fieldType, $fieldName, $fieldValue, $options);
    }

    /**
     * Get sample value for field type
     */
    private function getSampleValue(string $fieldType): mixed
    {
        switch ($fieldType) {
            case 'text':
            case 'email':
            case 'url':
                return 'Sample text';
                
            case 'textarea':
            case 'wysiwyg':
            case 'code':
                return 'Sample content...';
                
            case 'number':
            case 'slider':
            case 'rating':
                return 5;
                
            case 'boolean':
            case 'toggle':
                return true;
                
            case 'date':
                return date('Y-m-d');
                
            case 'datetime':
            case 'time':
                return date('Y-m-d H:i:s');
                
            case 'select':
            case 'radio':
                return 'option1';
                
            case 'checkbox':
                return ['option1', 'option2'];
                
            case 'gallery':
            case 'repeater':
            case 'relation':
            case 'tags':
            case 'map':
                return [];
                
            default:
                return 'Sample value';
        }
    }

    /**
     * Get field type options
     */
    public function getFieldTypeOptions(Request $request, $slug)
    {
        $fieldType = $request->input('field_type');
        $fieldTypeConfig = FieldTypeService::getFieldType($fieldType);

        if (!$fieldTypeConfig) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid field type'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'options' => $fieldTypeConfig['options'] ?? []
        ]);
    }

    /**
     * Validate field configuration
     */
    public function validateFieldConfig(Request $request, $slug)
    {
        $validated = $request->validate([
            'field_config' => 'required|array'
        ]);

        $validation = FieldManagerService::validateField($validated['field_config']);

        return response()->json($validation);
    }
}
