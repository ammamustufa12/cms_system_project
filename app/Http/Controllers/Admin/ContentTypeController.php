<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentType;
use App\Services\FieldTypeService;
use App\Services\UnifiedFieldService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ContentTypeController extends Controller
{
    public function index()
    {
        $contentTypes = ContentType::with(['contentItems' => function ($query) {
            $query->select('content_type_id')
                ->selectRaw('count(*) as items_count')
                ->groupBy('content_type_id');
        }])->get();

        return view('vendor.twill.content-types.index', compact('contentTypes'));
    }

    public function create()
    {
        $fieldTypes = FieldTypeService::getSupportedTypes();
        return view('vendor.twill.content-types.create', compact('fieldTypes'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:content_types,slug',
                'description' => 'nullable|string'
            ]);

            // Generate slug if not provided
            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['name']);
            }

            // Check if slug is unique
            if (ContentType::where('slug', $validated['slug'])->exists()) {
                return back()->withErrors(['slug' => 'This slug is already taken.'])->withInput();
            }

            $contentType = ContentType::create([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'],
                'status' => $request->input('status', 'active')
            ]);

            return redirect()->route('content-types.index')
                ->with('success', 'Content type created successfully!');

        } catch (\Exception $e) {
            Log::error('Content Type creation failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to create content type. Please try again.'])->withInput();
        }
    }

    public function edit($slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $fieldTypes = FieldTypeService::getSupportedTypes();
        return view('vendor.twill.content-types.edit', compact('fieldTypes', 'contentType'));
    }

    public function update(Request $request, $contentType)
    {
        $contentType = ContentType::find($contentType);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:content_types,slug,' . $contentType->id,
            'description' => 'nullable|string'
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        $contentType->update($validated);

        return redirect()->route('content-types.index')->with('success', 'Content type updated successfully');
    }

    // public function destroy($id)
    // {
    //     $contentType = ContentType::findOrFail($id);

    //     // Delete all associated content items first (like ContentItem deletes associated files)
    //     $contentItems = $contentType->contentItems;
    //     foreach ($contentItems as $item) {
    //         // Delete associated files for each content item
    //         $this->deleteAssociatedFiles($item);
    //         $item->delete();
    //     }

    //     // Delete the content type
    //     $contentType->delete();

    //     return redirect()->route('content-types.index')
    //         ->with('success', 'Content type deleted successfully!');
    // }

    public function destroy($id)
    {
        $contentType = ContentType::findOrFail($id);

        // Delete associated files for all items of this ContentType
        $this->deleteAssociatedFiles($contentType);

        // Delete all associated content items
        $contentType->contentItems()->delete();

        // Delete the content type
        $contentType->delete();

        return redirect()->route('content-types.index')
            ->with('success', 'Content type deleted successfully!');
    }


    // public function manageFields($slug)
    // {
    //     $contentType = ContentType::where('slug', $slug)->firstOrFail();
    //     // $fieldsSchema = $contentType->fields_schema ?? [];
    //     $fieldTypes = FieldTypeService::getSupportedTypes();
    //     $fieldsSchema = json_decode($contentType->fields_schema, true) ?? [];
    //     return view('vendor.twill.content-types.manage-fields.index', compact('contentType', 'fieldsSchema', 'fieldTypes', 'slug'));
    // }

    public function manageFields($slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        
        // Get all available field types from unified service
        $allFieldTypes = UnifiedFieldService::getAllFieldTypes();
        $fieldTypesByCategory = UnifiedFieldService::getFieldTypesByCategory();
        $availableFieldTypes = UnifiedFieldService::getAvailableFieldTypesForContentType($contentType->id);
        
        // Create legacy fieldTypes array for backward compatibility
        $fieldTypes = [];
        foreach ($allFieldTypes as $fieldType) {
            $fieldTypes[$fieldType['type']] = [
                'label' => $fieldType['name'],
                'icon' => $fieldType['icon'],
                'description' => $fieldType['description']
            ];
        }
        
        $fieldsSchema = $contentType->fields_schema ?? []; // Already an array thanks to cast
        
        // Get field groups for organization
        $fieldGroups = $this->getFieldGroups($contentType);
        
        // Get field visibility rules
        $visibilityRules = $this->getVisibilityRules($contentType);

        return view('vendor.twill.content-types.manage-fields.index', compact(
            'contentType', 
            'fieldsSchema', 
            'allFieldTypes',
            'fieldTypesByCategory',
            'availableFieldTypes',
            'fieldTypes', // Legacy compatibility
            'fieldGroups',
            'visibilityRules',
            'slug'
        ));
    }

    public function addField($slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $allFieldTypes = UnifiedFieldService::getAllFieldTypes();
        $fieldTypesByCategory = UnifiedFieldService::getFieldTypesByCategory();
        $availableFieldTypes = UnifiedFieldService::getAvailableFieldTypesForContentType($contentType->id);
        
        return view('vendor.twill.content-types.manage-fields.create', compact(
            'contentType', 
            'allFieldTypes',
            'fieldTypesByCategory',
            'availableFieldTypes'
        ));
    }
    
    /**
     * Add field to content type using unified service
     */
    public function addFieldToContentType(Request $request, $contentType)
    {
        // Debug logging
        \Log::info('Add Field Request', [
            'contentType' => $contentType,
            'request_data' => $request->all(),
            'headers' => $request->headers->all()
        ]);
        
        // Also log to console for debugging
        error_log('Add Field Request: ' . json_encode([
            'contentType' => $contentType,
            'request_data' => $request->all()
        ]));
        
        $contentType = ContentType::where('slug', $contentType)->firstOrFail();
        
        $validated = $request->validate([
            'field_type_id' => 'required|string',
            'field_name' => 'required|string|max:255',
            'field_key' => 'nullable|string|max:255',
            'required' => 'nullable|boolean',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'options' => 'nullable|string' // Changed from array to string since we're sending JSON
        ]);
        
        try {
            // Decode JSON options
            $options = [];
            if (!empty($validated['options'])) {
                $options = json_decode($validated['options'], true) ?? [];
            }
            
            $fieldSchema = UnifiedFieldService::addFieldToContentType(
                $contentType->id,
                $validated['field_type_id'],
                [
                    'name' => $validated['field_name'],
                    'field_key' => $validated['field_key'],
                    'required' => $validated['required'] ?? false,
                    'description' => $validated['description'],
                    'order' => $validated['order'] ?? 999,
                    'options' => $options
                ]
            );
            
            return response()->json([
                'success' => true,
                'message' => 'Field added successfully!',
                'field' => $fieldSchema
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add field: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Remove field from content type
     */
    public function removeFieldFromContentType(Request $request, $contentType)
    {
        $contentType = ContentType::where('slug', $contentType)->firstOrFail();
        
        $validated = $request->validate([
            'field_key' => 'required|string'
        ]);
        
        try {
            $removed = UnifiedFieldService::removeFieldFromContentType(
                $contentType->id,
                $validated['field_key']
            );
            
            if ($removed) {
                return response()->json([
                    'success' => true,
                    'message' => 'Field removed successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Field not found!'
                ], 404);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove field: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update field in content type
     */
    public function updateFieldInContentType(Request $request, $contentType)
    {
        $contentType = ContentType::where('slug', $contentType)->firstOrFail();
        
        $validated = $request->validate([
            'field_key' => 'required|string',
            'field_config' => 'required|array'
        ]);
        
        try {
            $updated = UnifiedFieldService::updateFieldInContentType(
                $contentType->id,
                $validated['field_key'],
                $validated['field_config']
            );
            
            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Field updated successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Field not found!'
                ], 404);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update field: ' . $e->getMessage()
            ], 500);
        }
    }
    // public function storeField(Request $request, $slug)
    // {
    //     $contentType = ContentType::where('slug', $slug)->firstOrFail();

    //     $validated = $request->validate([
    //         'field_name' => 'required|string|max:255',
    //         'field_label' => 'required|string|max:255',
    //         'field_type' => 'required|string',
    //         'required' => 'boolean',
    //         'description' => 'nullable|string',
    //         'options' => 'nullable|array'
    //     ]);

    //     // Get current fields schema (already array due to cast)
    //     $fieldsSchema = $contentType->fields_schema ?? [];

    //     // Generate field key
    //     $fieldKey = Str::slug($validated['field_name'], '_');

    //     // Ensure unique field key
    //     $counter = 1;
    //     $originalFieldKey = $fieldKey;

    //     $fieldsSchema = json_decode($contentType->fields_schema, true) ?? [];

    //    while (array_key_exists($fieldKey, $fieldsSchema)) {
    //         $fieldKey = $originalFieldKey . '_' . $counter;
    //         $counter++;
    //     }

    //     // Add new field to schema
    //     $fieldsSchema[$fieldKey] = [
    //         'name' => $validated['field_name'],
    //         'label' => $validated['field_label'],
    //         'type' => $validated['field_type'],
    //         'required' => $validated['required'] ?? false,
    //         'description' => $validated['description'] ?? '',
    //         'options' => $validated['options'] ?? [],
    //         'order' => count($fieldsSchema) + 1
    //     ];

    //     // Update content type (cast will handle JSON conversion)
    //     $contentType->update([
    //         'fields_schema' => $fieldsSchema
    //     ]);

    //     return redirect()->route('content-types.manage-fields', $slug)
    //                     ->with('success', 'Field added successfully!');

    // }

    // public function storeField(Request $request, $slug)
    // {
    //     $contentType = ContentType::where('slug', $slug)->firstOrFail();

    //     $validated = $request->validate([
    //         'field_name' => 'required|string|max:255',
    //         'field_label' => 'required|string|max:255',
    //         'field_type' => 'required|string',
    //         'required' => 'boolean',
    //         'description' => 'nullable|string',
    //         'options' => 'nullable|array'
    //     ]);

    //     // Get current fields schema (already array due to cast)
    //     $fieldsSchema = $contentType->fields_schema ?? [];

    //     // Generate field key
    //     $fieldKey = Str::slug($validated['field_name'], '_');

    //     // Ensure unique field key
    //     $counter = 1;
    //     $originalFieldKey = $fieldKey;

    //     while (array_key_exists($fieldKey, $fieldsSchema)) {
    //         $fieldKey = $originalFieldKey . '_' . $counter;
    //         $counter++;
    //     }

    //     // Add new field to schema
    //     $fieldsSchema[$fieldKey] = [
    //         'name' => $validated['field_name'],
    //         'label' => $validated['field_label'],
    //         'type' => $validated['field_type'],
    //         'required' => $validated['required'] ?? false,
    //         'description' => $validated['description'] ?? '',
    //         'options' => $validated['options'] ?? [],
    //         'order' => count($fieldsSchema) + 1
    //     ];

    //     // Update content type (cast handles JSON conversion)
    //     $contentType->update([
    //         'fields_schema' => $fieldsSchema
    //     ]);

    //     return redirect()->route('content-types.manage-fields', $slug)
    //         ->with('success', 'Field added successfully!');
    // }


    public function storeField(Request $request, $slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'field_name' => 'required|string|max:255',
            'field_label' => 'required|string|max:255',
            'field_type' => 'required|string',
            'required' => 'boolean',
            'description' => 'nullable|string',
            'options' => 'nullable|array'
        ]);

        // Decode JSON to array
        $fieldsSchema = json_decode($contentType->fields_schema, true) ?? [];

        // Generate unique field key
        $fieldKey = Str::slug($validated['field_name'], '_');
        $counter = 1;
        $originalFieldKey = $fieldKey;
        while (array_key_exists($fieldKey, $fieldsSchema)) {
            $fieldKey = $originalFieldKey . '_' . $counter;
            $counter++;
        }

        // Add new field
        $fieldsSchema[$fieldKey] = [
            'name' => $validated['field_name'],
            'label' => $validated['field_label'],
            'type' => $validated['field_type'],
            'required' => $validated['required'] ?? false,
            'description' => $validated['description'] ?? '',
            'options' => $validated['options'] ?? [],
            'order' => count($fieldsSchema) + 1
        ];

        // Encode back to JSON
        $contentType->update([
            'fields_schema' => json_encode($fieldsSchema)
        ]);

        return redirect()->route('content-types.manage-fields', $slug)
            ->with('success', 'Field added successfully!');
    }


    // public function editField($slug, $fieldKey)
    // {
    //     $contentType = ContentType::where('slug', $slug)->firstOrFail();
    //     // $fieldsSchema = json_decode($contentType->fields_schema, true) ?? [];
    //     $fieldsSchema = $contentType->fields_schema ?? []; 

    //     if (!array_key_exists($fieldKey, $fieldsSchema)) {
    //         abort(404, 'Field not found');
    //     }

    //     $field = $fieldsSchema[$fieldKey];
    //     $fieldTypes = FieldTypeService::getSupportedTypes();

    //     return view('vendor.twill.content-types.manage-fields.edit', compact('contentType', 'field', 'fieldKey', 'fieldTypes', 'slug'));
    // }

    public function editField($slug, $fieldKey)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $fieldsSchema = is_array($contentType->fields_schema) ? $contentType->fields_schema : json_decode($contentType->fields_schema, true) ?? [];

        if (!isset($fieldsSchema[$fieldKey])) {
            abort(404, 'Field not found');
        }

        $field = $fieldsSchema[$fieldKey];
        $fieldTypes = FieldTypeService::getSupportedTypes();

        return view(
            'vendor.twill.content-types.manage-fields.edit',
            compact('contentType', 'field', 'fieldKey', 'fieldTypes', 'slug')
        );
    }


    public function updateField(Request $request, $slug, $fieldKey)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $fieldsSchema = json_decode($contentType->fields_schema, true) ?? [];

        if (!array_key_exists($fieldKey, $fieldsSchema)) {
            abort(404, 'Field not found');
        }

        $validated = $request->validate([
            'field_name' => 'required|string|max:255',
            'field_label' => 'required|string|max:255',
            'field_type' => 'required|string',
            'required' => 'boolean',
            'description' => 'nullable|string',
            'options' => 'nullable|array'
        ]);

        // Update field in schema
        $fieldsSchema[$fieldKey] = array_merge($fieldsSchema[$fieldKey], [
            'name' => $validated['field_name'],
            'label' => $validated['field_label'],
            'type' => $validated['field_type'],
            'required' => $validated['required'] ?? false,
            'description' => $validated['description'] ?? '',
            'options' => $validated['options'] ?? [],
            'updated_at' => now()->toISOString()
        ]);

        // Update content type
        $contentType->update([
            'fields_schema' => json_encode($fieldsSchema)
        ]);

        return redirect()->route('content-types.manage-fields', $slug)
            ->with('success', 'Field updated successfully!');
    }

    public function deleteField($slug, $fieldKey)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $fieldsSchema = json_decode($contentType->fields_schema, true) ?? [];

        if (!array_key_exists($fieldKey, $fieldsSchema)) {
            abort(404, 'Field not found');
        }

        // Remove field from schema
        unset($fieldsSchema[$fieldKey]);

        // Update content type
        $contentType->update([
            'fields_schema' => json_encode($fieldsSchema)
        ]);

        return redirect()->route('content-types.manage-fields', $slug)
            ->with('success', 'Field deleted successfully!');
    }


    // public function previewLayout($slug)
    // {
    //     $contentType = ContentType::where('slug', $slug)->firstOrFail();
    //     $fieldsSchema = json_decode($contentType->fields_schema, true) ?? [];

    //     // Sort fields by order
    //     uasort($fieldsSchema, function ($a, $b) {
    //         return ($a['order'] ?? 0) - ($b['order'] ?? 0);
    //     });

    //     return view('vendor.twill.content-types.preview', compact('contentType', 'fieldsSchema'));
    // }

    public function generateMigration($slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $fieldsSchema = json_decode($contentType->fields_schema, true) ?? [];

        if (empty($fieldsSchema)) {
            return redirect()->back()->with('error', 'No fields defined for this content type.');
        }

        // Generate migration content
        $migrationContent = $this->generateMigrationContent($contentType, $fieldsSchema);

        // Save migration file
        $migrationFileName = date('Y_m_d_His') . '_create_' . $contentType->slug . '_table.php';
        $migrationPath = database_path('migrations/' . $migrationFileName);

        file_put_contents($migrationPath, $migrationContent);

        return redirect()->back()->with('success', 'Migration generated successfully: ' . $migrationFileName);
    }

    private function generateMigrationContent($contentType, $fieldsSchema)
    {
        $className = 'Create' . Str::studly($contentType->slug) . 'Table';
        $tableName = $contentType->slug;

        $fields = '';
        foreach ($fieldsSchema as $fieldKey => $field) {
            $fields .= $this->generateMigrationField($fieldKey, $field) . "\n            ";
        }

        return "<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class {$className} extends Migration
{
    public function up()
    {
        Schema::create('{$tableName}', function (Blueprint \$table) {
            \$table->id();
            {$fields}
            \$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('{$tableName}');
    }
}";
    }

    private function generateMigrationField($fieldKey, $field)
    {
        $nullable = $field['required'] ? '' : '->nullable()';

        switch ($field['type']) {
            case 'text':
            case 'email':
                return "\$table->string('{$fieldKey}'){$nullable};";
            case 'textarea':
            case 'wysiwyg':
                return "\$table->text('{$fieldKey}'){$nullable};";
            case 'number':
                return "\$table->integer('{$fieldKey}'){$nullable};";
            case 'boolean':
                return "\$table->boolean('{$fieldKey}')->default(false);";
            case 'date':
                return "\$table->date('{$fieldKey}'){$nullable};";
            case 'datetime':
                return "\$table->datetime('{$fieldKey}'){$nullable};";
            case 'file':
            case 'image':
                return "\$table->string('{$fieldKey}'){$nullable};";
            case 'gallery':
            case 'select':
            case 'checkbox':
            case 'repeater':
            case 'relation':
                return "\$table->json('{$fieldKey}'){$nullable};";
            default:
                return "\$table->string('{$fieldKey}'){$nullable};";
        }
    }
    private function deleteAssociatedFiles(ContentType $contentType)
    {
        $contentItems = $contentType->contentItems;

        foreach ($contentItems as $item) {
            $fieldData = is_string($item->field_data)
                ? json_decode($item->field_data, true)
                : ($item->field_data ?? []);

            if (!is_array($fieldData)) continue;

            foreach ($fieldData as $fieldKey => $value) {
                if (is_array($value)) {
                    if (isset($value[0]['path'])) {
                        // Gallery
                        foreach ($value as $file) {
                            if (isset($file['path'])) {
                                Storage::disk('public')->delete($file['path']);
                            }
                        }
                    } elseif (isset($value['path'])) {
                        // Single file
                        Storage::disk('public')->delete($value['path']);
                    }
                }
            }
        }
    }



    public function layoutBuilder($slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $fieldsSchema = is_array($contentType->fields_schema)
            ? $contentType->fields_schema
            : json_decode($contentType->fields_schema, true) ?? [];

        // Generate sample data for preview
        $sampleData = $this->generateSampleContentData($fieldsSchema);

        return view('vendor.twill.content-types.layout-builder', compact(
            'contentType',
            'fieldsSchema',
            'sampleData'
        ));
    }
    /**
     * Save layout configuration from GrapesJS
     */
    // public function saveLayout(Request $request, $slug)
    // {
    //     $contentType = ContentType::where('slug', $slug)->firstOrFail();

    //     $validated = $request->validate([
    //         'html' => 'required|string',
    //         'css' => 'nullable|string',
    //         'components' => 'nullable|array',
    //         'layout_name' => 'nullable|string|max:255'
    //     ]);

    //     // Update layout config
    //     $layoutConfig = $contentType->layout_config ?? [];
    //     $layoutConfig['templates'] = $layoutConfig['templates'] ?? [];

    //     $templateName = $validated['layout_name'] ?? 'default';

    //     $layoutConfig['templates'][$templateName] = [
    //         'html' => $validated['html'],
    //         'css' => $validated['css'],
    //         'components' => $validated['components'],
    //         'created_at' => now()->toISOString(),
    //         'created_by' => auth('twill_users')->id()
    //     ];

    //     $layoutConfig['active_template'] = $templateName;

    //     $contentType->update([
    //         'layout_config' => $layoutConfig
    //     ]);

    //     if ($request->ajax()) {
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Layout saved successfully!'
    //         ]);
    //     }
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Layout template saved successfully!'
    //     ]);
    // }





    /**
     * Preview content type layout with sample data
     */
    public function previewLayout($slug, $template = 'default')
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $fieldsSchema = is_array($contentType->fields_schema)
            ? $contentType->fields_schema
            : json_decode($contentType->fields_schema, true) ?? [];

        $layoutConfig = $contentType->layout_config ?? [];
        $templates = $layoutConfig['templates'] ?? [];

        if (!isset($templates[$template])) {
            abort(404, 'Template not found');
        }

        $templateData = $templates[$template];
        $sampleData = $this->generateSampleContentData($fieldsSchema);

        // Process template with sample data
        $html = $this->processTemplateVariables($templateData['html'], $sampleData);
        $css = $templateData['css'] ?? '';

        return view('vendor.twill.content-types.preview-layout', compact(
            'contentType',
            'html',
            'css',
            'sampleData',
            'template'
        ));
    }


    public function getFieldBlocks($slug)
    {
        try {
            $contentType = ContentType::where('slug', $slug)->firstOrFail();

            // Get fields schema - handle both array and JSON string
            $fieldsSchema = $contentType->fields_schema;
            if (is_string($fieldsSchema)) {
                $fieldsSchema = json_decode($fieldsSchema, true) ?? [];
            }

            if (empty($fieldsSchema)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No fields defined for this content type',
                    'blocks' => []
                ]);
            }

            $blocks = [];

            // Sort fields by order
            uasort($fieldsSchema, function ($a, $b) {
                return ($a['order'] ?? 0) - ($b['order'] ?? 0);
            });

            // Generate blocks for each field
            foreach ($fieldsSchema as $fieldKey => $field) {
                $fieldType = $field['type'] ?? 'text';
                $fieldLabel = $field['label'] ?? $field['name'] ?? $fieldKey;

                $blocks[] = [
                    'id' => "field-{$fieldKey}",
                    'label' => $fieldLabel,
                    'category' => 'Content Fields',
                    'content' => $this->generateFieldHtml($fieldKey, $field),
                    'attributes' => [
                        'class' => 'content-field',
                        'data-field-type' => $fieldType,
                        'data-field-key' => $fieldKey,
                        'title' => $field['description'] ?? "Drag to add {$fieldLabel}"
                    ]
                ];
            }

            // Add a special block for displaying all fields
            $blocks[] = [
                'id' => 'all-fields-block',
                'label' => 'All Fields Layout',
                'category' => 'Content Fields',
                'content' => $this->generateAllFieldsHtml($fieldsSchema),
                'attributes' => [
                    'class' => 'content-all-fields',
                    'data-field-type' => 'composite',
                    'title' => 'Complete content layout with all fields'
                ]
            ];

            // Add meta fields
            $blocks[] = [
                'id' => 'meta-title',
                'label' => 'Title',
                'category' => 'Meta Fields',
                'content' => '<h1 class="content-title">{{title}}</h1>',
                'attributes' => [
                    'class' => 'meta-field',
                    'data-field-type' => 'title'
                ]
            ];

            $blocks[] = [
                'id' => 'meta-date',
                'label' => 'Created Date',
                'category' => 'Meta Fields',
                'content' => '<div class="content-date"><small>Created: {{created_at}}</small></div>',
                'attributes' => [
                    'class' => 'meta-field',
                    'data-field-type' => 'date'
                ]
            ];

            return response()->json([
                'success' => true,
                'blocks' => $blocks,
                'content_type' => [
                    'name' => $contentType->name,
                    'slug' => $contentType->slug,
                    'field_count' => count($fieldsSchema)
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading field blocks: ' . $e->getMessage(), [
                'content_type_slug' => $slug,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error loading field blocks: ' . $e->getMessage(),
                'blocks' => []
            ], 500);
        }
    }

    /**
     * Generate HTML for different field types
     */
    private function generateFieldHtml($fieldKey, $field)
    {
        $placeholder = "{{" . $fieldKey . "}}";
        $label = $field['label'] ?? $field['name'] ?? $fieldKey;
        $fieldType = $field['type'] ?? 'text';

        // Add styling classes based on field type
        $wrapperClass = "field-wrapper field-{$fieldType}";

        switch ($fieldType) {
            case 'text':
            case 'email':
                return "
                <div class='{$wrapperClass}'>
                    <label class='field-label'>{$label}</label>
                    <p class='field-value text-field'>{$placeholder}</p>
                </div>";

            case 'textarea':
                return "
                <div class='{$wrapperClass}'>
                    <label class='field-label'>{$label}</label>
                    <div class='field-content textarea-field'>{$placeholder}</div>
                </div>";

            case 'wysiwyg':
                return "
                <div class='{$wrapperClass}'>
                    <label class='field-label'>{$label}</label>
                    <div class='field-content wysiwyg-field' data-wysiwyg='true'>{$placeholder}</div>
                </div>";

            case 'image':
                return "
                <div class='{$wrapperClass}'>
                    <label class='field-label'>{$label}</label>
                    <div class='field-image-container'>
                        <img src='{$placeholder}' alt='{$label}' class='field-image img-fluid' 
                             onerror='this.src=\"https://via.placeholder.com/400x300/e9ecef/6c757d?text=Image+Preview\"' />
                    </div>
                </div>";

            case 'gallery':
                return "
                <div class='{$wrapperClass}'>
                    <label class='field-label'>{$label}</label>
                    <div class='field-gallery' data-gallery='true'>{$placeholder}</div>
                </div>";

            case 'date':
                return "
                <div class='{$wrapperClass}'>
                    <label class='field-label'>{$label}</label>
                    <time class='field-date' datetime='{$placeholder}'>{$placeholder}</time>
                </div>";

            case 'number':
                return "
                <div class='{$wrapperClass}'>
                    <label class='field-label'>{$label}</label>
                    <span class='field-number badge bg-primary'>{$placeholder}</span>
                </div>";

            case 'select':
            case 'radio':
                return "
                <div class='{$wrapperClass}'>
                    <label class='field-label'>{$label}</label>
                    <span class='field-selection badge bg-secondary'>{$placeholder}</span>
                </div>";

            case 'checkbox':
                if (($field['options']['multiple'] ?? false)) {
                    return "
                    <div class='{$wrapperClass}'>
                        <label class='field-label'>{$label}</label>
                        <div class='field-checkbox-list'>{$placeholder}</div>
                    </div>";
                } else {
                    return "
                    <div class='{$wrapperClass}'>
                        <label class='field-label'>{$label}</label>
                        <span class='field-checkbox-single'>{$placeholder}</span>
                    </div>";
                }

            case 'boolean':
                return "
                <div class='{$wrapperClass}'>
                    <label class='field-label'>{$label}</label>
                    <span class='field-boolean badge bg-success'>{$placeholder}</span>
                </div>";

            case 'file':
                return "
                <div class='{$wrapperClass}'>
                    <label class='field-label'>{$label}</label>
                    <div class='field-file'>
                        <i class='ri-file-line'></i>
                        <span>{$placeholder}</span>
                    </div>
                </div>";

            default:
                return "
                <div class='{$wrapperClass}'>
                    <label class='field-label'>{$label}</label>
                    <div class='field-default'>{$placeholder}</div>
                </div>";
        }
    }

    /**
     * Generate HTML for all fields layout
     */
    private function generateAllFieldsHtml($fieldsSchema)
    {
        $html = '<div class="content-layout-wrapper">';
        $html .= '<div class="container-fluid">';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-8 main-content">';

        // Title first
        $html .= '<h1 class="content-title mb-4">{{title}}</h1>';

        // Add fields in order
        foreach ($fieldsSchema as $fieldKey => $field) {
            $html .= $this->generateFieldHtml($fieldKey, $field);
        }

        $html .= '</div>';
        $html .= '<div class="col-md-4 sidebar-content">';
        $html .= '<div class="content-meta">';
        $html .= '<h5>Content Information</h5>';
        $html .= '<p><small>Created: {{created_at}}</small></p>';
        $html .= '<p><small>Status: {{status}}</small></p>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }



    private function generateSampleContentData($fieldsSchema, $count = 3)
    {
        $sampleItems = [];

        for ($i = 1; $i <= $count; $i++) {
            $item = [
                'id' => $i,
                'title' => "Sample Content Item {$i}",
                'slug' => "sample-content-{$i}",
                'created_at' => now()->subDays(rand(1, 30))->format('Y-m-d H:i:s'),
                'status' => $i === 1 ? 'published' : 'draft'
            ];

            foreach ($fieldsSchema as $fieldKey => $field) {
                $item[$fieldKey] = $this->generateSampleFieldValue($field, $i);
            }

            $sampleItems[] = (object) $item;
        }

        return $sampleItems;
    }
    private function generateSampleFieldValue($field, $index)
    {
        switch ($field['type']) {
            case 'text':
                return "Sample " . ($field['label'] ?? $field['name']) . " {$index}";

            case 'email':
                return "sample{$index}@example.com";

            case 'textarea':
            case 'wysiwyg':
                return "This is sample content for " . ($field['label'] ?? $field['name']) . ". Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";

            case 'number':
                return rand(10, 1000);

            case 'date':
                return now()->subDays(rand(1, 365))->format('Y-m-d');

            case 'datetime':
                return now()->subDays(rand(1, 365))->format('Y-m-d H:i:s');

            case 'image':
                return "https://picsum.photos/400/300?random={$index}";

            case 'gallery':
                return [
                    "https://picsum.photos/300/200?random=" . ($index * 10 + 1),
                    "https://picsum.photos/300/200?random=" . ($index * 10 + 2),
                    "https://picsum.photos/300/200?random=" . ($index * 10 + 3)
                ];

            case 'boolean':
                return $index % 2 === 0;

            case 'select':
                if (isset($field['options']['options_list'])) {
                    $options = array_keys($field['options']['options_list']);
                    return $options[array_rand($options)];
                }
                return "Option {$index}";

            case 'checkbox':
                if ($field['options']['multiple'] ?? false) {
                    return ["option1", "option3"];
                }
                return $index % 2 === 0;

            default:
                return "Sample value {$index}";
        }
    }
    private function processTemplateVariables($html, $data)
    {
        if (empty($data)) {
            return $html;
        }

        // Use the first item for single item preview
        $item = is_array($data) ? $data[0] : $data;

        foreach ((array) $item as $key => $value) {
            $placeholder = "{{" . $key . "}}";

            if (is_array($value)) {
                if ($key === 'gallery' || (isset($value[0]) && is_string($value[0]) && strpos($value[0], 'http') === 0)) {
                    // Handle gallery
                    $galleryHtml = '<div class="gallery-grid">';
                    foreach ($value as $imageUrl) {
                        $galleryHtml .= "<img src='{$imageUrl}' alt='Gallery Image' class='gallery-item' />";
                    }
                    $galleryHtml .= '</div>';
                    $value = $galleryHtml;
                } else {
                    $value = implode(', ', $value);
                }
            } elseif (is_bool($value)) {
                $value = $value ? 'Yes' : 'No';
            }

            $html = str_replace($placeholder, $value, $html);
        }

        return $html;
    }

    /**
     * Get field groups for content type
     */
    private function getFieldGroups(ContentType $contentType): array
    {
        $fieldGroups = $contentType->field_groups ?? [];
        
        if (empty($fieldGroups)) {
            // Create default groups
            $fieldGroups = [
                'basic' => [
                    'name' => 'Basic Fields',
                    'description' => 'Essential content fields',
                    'icon' => 'fas fa-cube',
                    'color' => '#007bff',
                    'order' => 1
                ],
                'media' => [
                    'name' => 'Media Fields',
                    'description' => 'Images, videos, and files',
                    'icon' => 'fas fa-images',
                    'color' => '#28a745',
                    'order' => 2
                ],
                'advanced' => [
                    'name' => 'Advanced Fields',
                    'description' => 'Complex field types',
                    'icon' => 'fas fa-cogs',
                    'color' => '#ffc107',
                    'order' => 3
                ]
            ];
        }

        return $fieldGroups;
    }

    /**
     * Get field visibility rules
     */
    private function getVisibilityRules(ContentType $contentType): array
    {
        return $contentType->visibility_rules ?? [];
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

        $contentType->update([
            'field_groups' => $validated['field_groups']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Field groups saved successfully!'
        ]);
    }

    /**
     * Save field visibility rules
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

        $contentType->update([
            'visibility_rules' => $validated['visibility_rules']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Visibility rules saved successfully!'
        ]);
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
            $contentType->update([
                'field_groups' => $validated['field_groups']
            ]);
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
     * Duplicate field
     */
    public function duplicateField(Request $request, $slug, $fieldKey)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $fieldsSchema = $contentType->fields_schema ?? [];

        if (!isset($fieldsSchema[$fieldKey])) {
            return response()->json([
                'success' => false,
                'message' => 'Field not found'
            ], 404);
        }

        $originalField = $fieldsSchema[$fieldKey];
        $newFieldKey = $fieldKey . '_copy_' . time();
        
        // Create duplicate field
        $fieldsSchema[$newFieldKey] = array_merge($originalField, [
            'name' => $originalField['name'] . ' (Copy)',
            'label' => $originalField['label'] . ' (Copy)',
            'order' => count($fieldsSchema) + 1
        ]);

        $contentType->update([
            'fields_schema' => $fieldsSchema
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Field duplicated successfully!',
            'new_field_key' => $newFieldKey
        ]);
    }

    /**
     * Export field configuration
     */
    public function exportFields($slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        
        $exportData = [
            'content_type' => [
                'name' => $contentType->name,
                'slug' => $contentType->slug,
                'description' => $contentType->description
            ],
            'field_groups' => $contentType->field_groups ?? [],
            'fields_schema' => $contentType->fields_schema ?? [],
            'visibility_rules' => $contentType->visibility_rules ?? [],
            'exported_at' => now()->toISOString()
        ];

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

        // Validate import data structure
        if (!isset($importData['fields_schema']) || !is_array($importData['fields_schema'])) {
            return back()->withErrors(['import_file' => 'Invalid field configuration format']);
        }

        // Merge with existing fields
        $existingFields = $contentType->fields_schema ?? [];
        $importedFields = $importData['fields_schema'];
        
        // Add prefix to avoid conflicts
        $prefix = 'imported_' . time() . '_';
        foreach ($importedFields as $fieldKey => $fieldConfig) {
            $newFieldKey = $prefix . $fieldKey;
            $existingFields[$newFieldKey] = $fieldConfig;
        }

        $contentType->update([
            'fields_schema' => $existingFields,
            'field_groups' => $importData['field_groups'] ?? $contentType->field_groups,
            'visibility_rules' => $importData['visibility_rules'] ?? $contentType->visibility_rules
        ]);

        return redirect()->route('content-types.manage-fields', $slug)
            ->with('success', 'Field configuration imported successfully!');
    }

    /**
     * Show GrapesJS Visual Builder
     */
    public function grapesBuilder($slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        
        // Get all available field types from unified service
        $allFieldTypes = UnifiedFieldService::getAllFieldTypes();
        $fieldTypesByCategory = UnifiedFieldService::getFieldTypesByCategory();
        
        // Create legacy fieldTypes array for backward compatibility
        $fieldTypes = [];
        foreach ($allFieldTypes as $fieldType) {
            $fieldTypes[$fieldType['type']] = [
                'label' => $fieldType['name'],
                'icon' => $fieldType['icon'],
                'description' => $fieldType['description']
            ];
        }
        
        $fieldGroups = $this->getFieldGroups($contentType);
        
        // No additional variables needed for standalone view

        return view('vendor.twill.content-types.grapes-builder-standalone', compact(
            'contentType',
            'fieldTypes',
            'fieldGroups'
        ));
    }

    public function vvvebBuilder($slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $fieldTypes = FieldTypeService::getSupportedTypes();
        $fieldGroups = $this->getFieldGroups($contentType);

        return view('vendor.twill.content-types.vvveb-builder', compact(
            'contentType',
            'fieldTypes',
            'fieldGroups'
        ));
    }

    public function simpleBuilder($slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $fieldTypes = FieldTypeService::getSupportedTypes();
        $fieldGroups = $this->getFieldGroups($contentType);

        return view('vendor.twill.content-types.simple-builder', compact(
            'contentType',
            'fieldTypes',
            'fieldGroups'
        ));
    }


    /**
     * Save layout from GrapesJS
     */
    public function saveLayout(Request $request, $slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'html' => 'required|string',
            'css' => 'required|string',
            'set_as_default' => 'boolean'
        ]);

        $layoutConfig = $contentType->layout_config ?? [];
        
        // Create new layout
        $layoutId = 'layout_' . time();
        $layoutConfig[$layoutId] = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'html' => $validated['html'],
            'css' => $validated['css'],
            'created_at' => now()->toISOString(),
            'is_default' => $validated['set_as_default'] ?? false
        ];

        // If this is set as default, unset other defaults
        if ($validated['set_as_default']) {
            foreach ($layoutConfig as $key => $layout) {
                $layoutConfig[$key]['is_default'] = false;
            }
            $layoutConfig[$layoutId]['is_default'] = true;
        }

        $contentType->update([
            'layout_config' => $layoutConfig
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Layout saved successfully!',
            'layout_id' => $layoutId
        ]);
    }

    /**
     * Load layout for GrapesJS
     */
    public function loadLayout(Request $request, $slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $layoutConfig = $contentType->layout_config ?? [];
        
        // Find default layout or first layout
        $defaultLayout = null;
        foreach ($layoutConfig as $layout) {
            if ($layout['is_default'] ?? false) {
                $defaultLayout = $layout;
                break;
            }
        }
        
        if (!$defaultLayout && !empty($layoutConfig)) {
            $defaultLayout = reset($layoutConfig);
        }

        if ($defaultLayout) {
            return response()->json([
                'html' => $defaultLayout['html'] ?? '',
                'css' => $defaultLayout['css'] ?? ''
            ]);
        }

        return response()->json([
            'html' => '',
            'css' => ''
        ]);
    }

    /**
     * Get layout list
     */
    public function getLayouts($slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $layoutConfig = $contentType->layout_config ?? [];
        
        $layouts = [];
        foreach ($layoutConfig as $layoutId => $layout) {
            $layouts[] = [
                'id' => $layoutId,
                'name' => $layout['name'],
                'description' => $layout['description'],
                'is_default' => $layout['is_default'] ?? false,
                'created_at' => $layout['created_at'] ?? null
            ];
        }

        return response()->json($layouts);
    }

    /**
     * Delete layout
     */
    public function deleteLayout(Request $request, $slug, $layoutId)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $layoutConfig = $contentType->layout_config ?? [];
        
        if (isset($layoutConfig[$layoutId])) {
            unset($layoutConfig[$layoutId]);
            
            $contentType->update([
                'layout_config' => $layoutConfig
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Layout deleted successfully!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Layout not found!'
        ], 404);
    }

    /**
     * Set default layout
     */
    public function setDefaultLayout(Request $request, $slug, $layoutId)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $layoutConfig = $contentType->layout_config ?? [];
        
        if (isset($layoutConfig[$layoutId])) {
            // Unset all other defaults
            foreach ($layoutConfig as $key => $layout) {
                $layoutConfig[$key]['is_default'] = false;
            }
            
            // Set this as default
            $layoutConfig[$layoutId]['is_default'] = true;
            
            $contentType->update([
                'layout_config' => $layoutConfig
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Default layout updated successfully!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Layout not found!'
        ], 404);
    }
    
    /**
     * Professional Builder
     */
    public function professionalBuilder($slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        
        // Get fields schema
        $fieldsSchema = is_array($contentType->fields_schema) ? $contentType->fields_schema : [];
        
        // Generate sample data for preview
        $sampleData = $this->generateSampleData($fieldsSchema);
        
        return view('vendor.twill.content-types.professional-builder', compact('contentType', 'fieldsSchema', 'sampleData'));
    }
    
    /**
     * Working Builder
     */
    public function workingBuilder($slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        
        // Get fields schema
        $fieldsSchema = is_array($contentType->fields_schema) ? $contentType->fields_schema : [];
        
        // Generate sample data for preview
        $sampleData = $this->generateSampleData($fieldsSchema);
        
        return view('vendor.twill.content-types.working-builder', compact('contentType', 'fieldsSchema', 'sampleData'));
    }

    public function advancedBuilder($slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        
        // Get fields schema
        $fieldsSchema = is_array($contentType->fields_schema) ? $contentType->fields_schema : [];
        
        // Generate sample data for preview
        $sampleData = $this->generateSampleData($fieldsSchema);
        
        return view('vendor.twill.content-types.advanced-builder', compact('contentType', 'fieldsSchema', 'sampleData'));
    }
    
    /**
     * Generate sample data for preview
     */
    private function generateSampleData($fieldsSchema)
    {
        $sampleData = [];
        
        if (empty($fieldsSchema) || !is_array($fieldsSchema)) {
            return $sampleData;
        }
        
        foreach ($fieldsSchema as $fieldKey => $field) {
            // Skip if field is not an array
            if (!is_array($field)) {
                continue;
            }
            
            try {
                $fieldType = $field['type'] ?? 'text';
                
                switch ($fieldType) {
                case 'text':
                case 'textarea':
                    $sampleData[$fieldKey] = 'Sample ' . ucfirst(str_replace('_', ' ', $fieldKey));
                    break;
                    
                case 'email':
                    $sampleData[$fieldKey] = 'sample@example.com';
                    break;
                    
                case 'number':
                    $sampleData[$fieldKey] = rand(1, 100);
                    break;
                    
                case 'date':
                    $sampleData[$fieldKey] = date('Y-m-d');
                    break;
                    
                case 'datetime':
                    $sampleData[$fieldKey] = date('Y-m-d H:i:s');
                    break;
                    
                case 'time':
                    $sampleData[$fieldKey] = date('H:i');
                    break;
                    
                case 'boolean':
                case 'toggle':
                    $sampleData[$fieldKey] = true;
                    break;
                    
                case 'select':
                case 'radio':
                    $options = $field['options'] ?? [];
                    if (!empty($options)) {
                        // Handle both array of objects and array of strings
                        if (is_array($options) && count($options) > 0) {
                            $firstOption = $options[0];
                            if (is_array($firstOption) && isset($firstOption['value'])) {
                                $sampleData[$fieldKey] = $firstOption['value'];
                            } else {
                                $sampleData[$fieldKey] = is_string($firstOption) ? $firstOption : 'Option 1';
                            }
                        } else {
                            $sampleData[$fieldKey] = 'Option 1';
                        }
                    } else {
                        $sampleData[$fieldKey] = 'Option 1';
                    }
                    break;
                    
                case 'multiselect':
                case 'checkbox':
                    $options = $field['options'] ?? [];
                    if (!empty($options) && is_array($options)) {
                        $selectedOptions = [];
                        $maxSelections = min(2, count($options));
                        
                        for ($i = 0; $i < $maxSelections; $i++) {
                            $option = $options[$i];
                            if (is_array($option) && isset($option['value'])) {
                                $selectedOptions[] = $option['value'];
                            } else {
                                $selectedOptions[] = is_string($option) ? $option : "Option " . ($i + 1);
                            }
                        }
                        $sampleData[$fieldKey] = $selectedOptions;
                    } else {
                        $sampleData[$fieldKey] = ['Option 1', 'Option 2'];
                    }
                    break;
                    
                case 'image':
                case 'media':
                    $sampleData[$fieldKey] = 'https://via.placeholder.com/400x300?text=Sample+Image';
                    break;
                    
                case 'gallery':
                    $sampleData[$fieldKey] = [
                        'https://via.placeholder.com/400x300?text=Image+1',
                        'https://via.placeholder.com/400x300?text=Image+2',
                        'https://via.placeholder.com/400x300?text=Image+3'
                    ];
                    break;
                    
                case 'wysiwyg':
                case 'rich_text':
                    $sampleData[$fieldKey] = '<p>This is a sample rich text content with <strong>bold</strong> and <em>italic</em> formatting.</p>';
                    break;
                    
                case 'code':
                    $sampleData[$fieldKey] = 'console.log("Hello World");';
                    break;
                    
                case 'color':
                    $sampleData[$fieldKey] = '#007bff';
                    break;
                    
                case 'url':
                    $sampleData[$fieldKey] = 'https://example.com';
                    break;
                    
                case 'password':
                    $sampleData[$fieldKey] = '********';
                    break;
                    
                case 'tags':
                    $sampleData[$fieldKey] = ['tag1', 'tag2', 'tag3'];
                    break;
                    
                case 'repeater':
                    $repeaterFields = $field['fields'] ?? [];
                    $repeaterData = [];
                    for ($i = 0; $i < 2; $i++) {
                        $item = [];
                        foreach ($repeaterFields as $repFieldKey => $repField) {
                            $item[$repFieldKey] = 'Sample ' . ucfirst(str_replace('_', ' ', $repFieldKey)) . ' ' . ($i + 1);
                        }
                        $repeaterData[] = $item;
                    }
                    $sampleData[$fieldKey] = $repeaterData;
                    break;
                    
                case 'slider':
                    $min = $field['min'] ?? 0;
                    $max = $field['max'] ?? 100;
                    $sampleData[$fieldKey] = rand($min, $max);
                    break;
                    
                case 'rating':
                    $sampleData[$fieldKey] = rand(3, 5);
                    break;
                    
                case 'map':
                    $sampleData[$fieldKey] = [
                        'lat' => 40.7128,
                        'lng' => -74.0060,
                        'address' => 'New York, NY, USA'
                    ];
                    break;
                    
                case 'relation':
                    $sampleData[$fieldKey] = [
                        'id' => 1,
                        'name' => 'Sample Related Item',
                        'slug' => 'sample-related-item'
                    ];
                    break;
                    
                default:
                    $sampleData[$fieldKey] = 'Sample ' . ucfirst(str_replace('_', ' ', $fieldKey));
                    break;
                }
            } catch (\Exception $e) {
                // Log the error and provide a default value
                \Log::warning("Error generating sample data for field {$fieldKey}: " . $e->getMessage());
                $sampleData[$fieldKey] = 'Sample ' . ucfirst(str_replace('_', ' ', $fieldKey));
            }
        }
        
        return $sampleData;
    }

    /**
     * Field Designer
     */
    public function fieldDesigner()
    {
        $fieldTypes = FieldTypeService::getSupportedTypes();
        $designOptions = \App\Services\FieldDesignService::getFieldDesignOptions();
        
        return view('vendor.twill.designer.field-designer', compact('fieldTypes', 'designOptions'));
    }


    /**
     * Content Type Designer
     */
    public function contentTypeDesigner()
    {
        $contentTypes = ContentType::where('status', 'active')->get();
        $designOptions = \App\Services\FieldDesignService::getContentTypeDesignOptions();
        
        return view('vendor.twill.designer.content-type-designer', compact('contentTypes', 'designOptions'));
    }

    /**
     * Save Field Design
     */
    public function saveFieldDesign(Request $request)
    {
        $validated = $request->validate([
            'field_type' => 'required|string',
            'design' => 'required|array',
            'preview_html' => 'required|string'
        ]);

        // Here you would save the field design to database
        // For now, we'll just return success
        
        return response()->json([
            'success' => true,
            'message' => 'Field design saved successfully!',
            'design' => $validated['design']
        ]);
    }

    /**
     * Save Content Type Design
     */
    public function saveContentTypeDesign(Request $request)
    {
        $validated = $request->validate([
            'content_type_id' => 'required|integer',
            'design' => 'required|array',
            'preview_html' => 'required|string'
        ]);

        $contentType = ContentType::findOrFail($validated['content_type_id']);
        
        // Update content type with design
        $contentType->update([
            'style_config' => $validated['design']
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Content type design saved successfully!',
            'design' => $validated['design']
        ]);
    }
}
