<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentType;
use App\Services\FieldTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:content_types,slug',
            'description' => 'nullable|string'
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Process fields schema
        // $fieldsSchema = [];
        // foreach ($validated['fields'] as $index => $field) {
        //     $fieldName = Str::slug($field['name'], '_');

        //     $fieldsSchema[$fieldName] = [
        //         'type' => $field['type'],
        //         'label' => $field['label'],
        //         'required' => $field['required'] ?? false,
        //         'options' => $field['options'] ?? [],
        //         'order' => $index + 1
        //     ];
        // }

        $contentType = ContentType::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            // 'fields_schema' => $fieldsSchema,
            // 'layout_config' => [
            //     'list_view' => 'card',
            //     'detail_view' => 'full_width',
            //     'items_per_page' => 12,
            //     'columns' => 3
            // ],
            // 'style_config' => [
            //     'primary_color' => '#3498db',
            //     'secondary_color' => '#2c3e50',
            //     'font_family' => 'Inter, sans-serif'
            // ],
            // 'status' => 'active'
            'status' => $request->input('status', 'active')
        ]);

        // return redirect()->route('content-types.index', $contentType)
        //     ->with('success', 'Content type created successfully!');
        return redirect()->route('content-types.index')
            ->with('success', 'Content type created successfully!');
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
        $fieldTypes = FieldTypeService::getSupportedTypes();
        $fieldsSchema = $contentType->fields_schema ?? []; // Already an array thanks to cast

        return view('vendor.twill.content-types.manage-fields.index', compact('contentType', 'fieldsSchema', 'fieldTypes', 'slug'));
    }

    public function addField($slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $fieldTypes = FieldTypeService::getSupportedTypes();
        return view('vendor.twill.content-types.manage-fields.create', compact('contentType', 'fieldTypes'));
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
        $fieldsSchema = json_decode($contentType->fields_schema, true) ?? [];

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

    public function reorderFields(Request $request, $slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $fieldsSchema = json_decode($contentType->fields_schema, true) ?? [];

        $validated = $request->validate([
            'field_order' => 'required|array'
        ]);

        // Update field order
        foreach ($validated['field_order'] as $index => $fieldKey) {
            if (array_key_exists($fieldKey, $fieldsSchema)) {
                $fieldsSchema[$fieldKey]['order'] = $index + 1;
            }
        }

        // Update content type
        $contentType->update([
            'fields_schema' => json_encode($fieldsSchema)
        ]);

        return response()->json(['success' => true]);
    }

    public function previewLayout($slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        $fieldsSchema = json_decode($contentType->fields_schema, true) ?? [];

        // Sort fields by order
        uasort($fieldsSchema, function ($a, $b) {
            return ($a['order'] ?? 0) - ($b['order'] ?? 0);
        });

        return view('vendor.twill.content-types.preview', compact('contentType', 'fieldsSchema'));
    }

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
}
