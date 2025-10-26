<?php

namespace App\Services;

use App\Models\ContentType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class FieldManagerService
{
    /**
     * Create a new field for content type
     */
    public static function createField(ContentType $contentType, array $fieldData): array
    {
        $fieldsSchema = $contentType->fields_schema ?? [];
        
        // Generate unique field key
        $fieldKey = self::generateFieldKey($fieldData['name'], $fieldsSchema);
        
        // Prepare field configuration
        $fieldConfig = [
            'name' => $fieldData['name'],
            'label' => $fieldData['label'],
            'type' => $fieldData['type'],
            'required' => $fieldData['required'] ?? false,
            'description' => $fieldData['description'] ?? '',
            'options' => $fieldData['options'] ?? [],
            'group' => $fieldData['group'] ?? 'basic',
            'order' => count($fieldsSchema) + 1,
            'visibility' => $fieldData['visibility'] ?? 'always',
            'validation_rules' => $fieldData['validation_rules'] ?? [],
            'created_at' => now()->toISOString()
        ];

        // Add field to schema
        $fieldsSchema[$fieldKey] = $fieldConfig;

        // Update content type
        $contentType->update([
            'fields_schema' => $fieldsSchema
        ]);

        return [
            'success' => true,
            'field_key' => $fieldKey,
            'field_config' => $fieldConfig
        ];
    }

    /**
     * Update existing field
     */
    public static function updateField(ContentType $contentType, string $fieldKey, array $fieldData): array
    {
        $fieldsSchema = $contentType->fields_schema ?? [];

        if (!isset($fieldsSchema[$fieldKey])) {
            return [
                'success' => false,
                'message' => 'Field not found'
            ];
        }

        // Update field configuration
        $fieldsSchema[$fieldKey] = array_merge($fieldsSchema[$fieldKey], [
            'name' => $fieldData['name'],
            'label' => $fieldData['label'],
            'type' => $fieldData['type'],
            'required' => $fieldData['required'] ?? false,
            'description' => $fieldData['description'] ?? '',
            'options' => $fieldData['options'] ?? [],
            'group' => $fieldData['group'] ?? 'basic',
            'visibility' => $fieldData['visibility'] ?? 'always',
            'validation_rules' => $fieldData['validation_rules'] ?? [],
            'updated_at' => now()->toISOString()
        ]);

        // Update content type
        $contentType->update([
            'fields_schema' => $fieldsSchema
        ]);

        return [
            'success' => true,
            'field_config' => $fieldsSchema[$fieldKey]
        ];
    }

    /**
     * Delete field
     */
    public static function deleteField(ContentType $contentType, string $fieldKey): array
    {
        $fieldsSchema = $contentType->fields_schema ?? [];

        if (!isset($fieldsSchema[$fieldKey])) {
            return [
                'success' => false,
                'message' => 'Field not found'
            ];
        }

        // Remove field from schema
        unset($fieldsSchema[$fieldKey]);

        // Reorder remaining fields
        $fieldsSchema = self::reorderFields($fieldsSchema);

        // Update content type
        $contentType->update([
            'fields_schema' => $fieldsSchema
        ]);

        return [
            'success' => true,
            'message' => 'Field deleted successfully'
        ];
    }

    /**
     * Duplicate field
     */
    public static function duplicateField(ContentType $contentType, string $fieldKey): array
    {
        $fieldsSchema = $contentType->fields_schema ?? [];

        if (!isset($fieldsSchema[$fieldKey])) {
            return [
                'success' => false,
                'message' => 'Field not found'
            ];
        }

        $originalField = $fieldsSchema[$fieldKey];
        $newFieldKey = self::generateFieldKey($originalField['name'] . '_copy', $fieldsSchema);

        // Create duplicate field
        $fieldsSchema[$newFieldKey] = array_merge($originalField, [
            'name' => $originalField['name'] . ' (Copy)',
            'label' => $originalField['label'] . ' (Copy)',
            'order' => count($fieldsSchema) + 1,
            'created_at' => now()->toISOString(),
            'updated_at' => null
        ]);

        // Update content type
        $contentType->update([
            'fields_schema' => $fieldsSchema
        ]);

        return [
            'success' => true,
            'field_key' => $newFieldKey,
            'field_config' => $fieldsSchema[$newFieldKey]
        ];
    }

    /**
     * Reorder fields
     */
    public static function reorderFields(array $fieldsSchema): array
    {
        $orderedFields = [];
        $order = 1;

        foreach ($fieldsSchema as $fieldKey => $fieldConfig) {
            $orderedFields[$fieldKey] = array_merge($fieldConfig, [
                'order' => $order++
            ]);
        }

        return $orderedFields;
    }

    /**
     * Generate unique field key
     */
    private static function generateFieldKey(string $name, array $existingFields): string
    {
        $fieldKey = Str::slug($name, '_');
        $counter = 1;
        $originalFieldKey = $fieldKey;

        while (array_key_exists($fieldKey, $existingFields)) {
            $fieldKey = $originalFieldKey . '_' . $counter;
            $counter++;
        }

        return $fieldKey;
    }

    /**
     * Get field groups for content type
     */
    public static function getFieldGroups(ContentType $contentType): array
    {
        $fieldGroups = $contentType->field_groups ?? [];
        
        if (empty($fieldGroups)) {
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
     * Save field groups
     */
    public static function saveFieldGroups(ContentType $contentType, array $fieldGroups): array
    {
        $contentType->update([
            'field_groups' => $fieldGroups
        ]);

        return [
            'success' => true,
            'message' => 'Field groups saved successfully'
        ];
    }

    /**
     * Get field visibility rules
     */
    public static function getVisibilityRules(ContentType $contentType): array
    {
        return $contentType->visibility_rules ?? [];
    }

    /**
     * Save field visibility rules
     */
    public static function saveVisibilityRules(ContentType $contentType, array $visibilityRules): array
    {
        $contentType->update([
            'visibility_rules' => $visibilityRules
        ]);

        return [
            'success' => true,
            'message' => 'Visibility rules saved successfully'
        ];
    }

    /**
     * Generate migration for content type
     */
    public static function generateMigration(ContentType $contentType): array
    {
        $fieldsSchema = $contentType->fields_schema ?? [];

        if (empty($fieldsSchema)) {
            return [
                'success' => false,
                'message' => 'No fields defined for this content type'
            ];
        }

        $migrationContent = self::buildMigrationContent($contentType, $fieldsSchema);
        $migrationFileName = date('Y_m_d_His') . '_create_' . $contentType->slug . '_table.php';
        $migrationPath = database_path('migrations/' . $migrationFileName);

        file_put_contents($migrationPath, $migrationContent);

        return [
            'success' => true,
            'message' => 'Migration generated successfully',
            'file_name' => $migrationFileName,
            'file_path' => $migrationPath
        ];
    }

    /**
     * Build migration content
     */
    private static function buildMigrationContent(ContentType $contentType, array $fieldsSchema): string
    {
        $className = 'Create' . Str::studly($contentType->slug) . 'Table';
        $tableName = $contentType->slug;

        $fields = '';
        foreach ($fieldsSchema as $fieldKey => $field) {
            $fields .= self::generateMigrationField($fieldKey, $field) . "\n            ";
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

    /**
     * Generate migration field
     */
    private static function generateMigrationField(string $fieldKey, array $field): string
    {
        $nullable = $field['required'] ? '' : '->nullable()';

        switch ($field['type']) {
            case 'text':
            case 'email':
            case 'url':
            case 'password':
                return "\$table->string('{$fieldKey}'){$nullable};";
                
            case 'textarea':
            case 'wysiwyg':
            case 'code':
                return "\$table->text('{$fieldKey}'){$nullable};";
                
            case 'number':
            case 'slider':
            case 'rating':
                return "\$table->integer('{$fieldKey}'){$nullable};";
                
            case 'boolean':
            case 'toggle':
                return "\$table->boolean('{$fieldKey}')->default(false);";
                
            case 'date':
                return "\$table->date('{$fieldKey}'){$nullable};";
                
            case 'datetime':
            case 'time':
                return "\$table->datetime('{$fieldKey}'){$nullable};";
                
            case 'file':
            case 'image':
                return "\$table->string('{$fieldKey}'){$nullable};";
                
            case 'gallery':
            case 'select':
            case 'checkbox':
            case 'radio':
            case 'repeater':
            case 'relation':
            case 'tags':
            case 'map':
                return "\$table->json('{$fieldKey}'){$nullable};";
                
            default:
                return "\$table->string('{$fieldKey}'){$nullable};";
        }
    }

    /**
     * Export field configuration
     */
    public static function exportFields(ContentType $contentType): array
    {
        $exportData = [
            'content_type' => [
                'name' => $contentType->name,
                'slug' => $contentType->slug,
                'description' => $contentType->description,
                'icon' => $contentType->icon,
                'color' => $contentType->color
            ],
            'field_groups' => $contentType->field_groups ?? [],
            'fields_schema' => $contentType->fields_schema ?? [],
            'visibility_rules' => $contentType->visibility_rules ?? [],
            'exported_at' => now()->toISOString(),
            'version' => '1.0'
        ];

        return $exportData;
    }

    /**
     * Import field configuration
     */
    public static function importFields(ContentType $contentType, array $importData): array
    {
        // Validate import data
        if (!isset($importData['fields_schema']) || !is_array($importData['fields_schema'])) {
            return [
                'success' => false,
                'message' => 'Invalid field configuration format'
            ];
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

        // Update content type
        $contentType->update([
            'fields_schema' => $existingFields,
            'field_groups' => $importData['field_groups'] ?? $contentType->field_groups,
            'visibility_rules' => $importData['visibility_rules'] ?? $contentType->visibility_rules,
            'icon' => $importData['content_type']['icon'] ?? $contentType->icon,
            'color' => $importData['content_type']['color'] ?? $contentType->color
        ]);

        return [
            'success' => true,
            'message' => 'Field configuration imported successfully',
            'imported_fields' => count($importedFields)
        ];
    }

    /**
     * Validate field configuration
     */
    public static function validateField(array $fieldData): array
    {
        $errors = [];

        // Required fields
        if (empty($fieldData['name'])) {
            $errors[] = 'Field name is required';
        }

        if (empty($fieldData['label'])) {
            $errors[] = 'Field label is required';
        }

        if (empty($fieldData['type'])) {
            $errors[] = 'Field type is required';
        }

        // Validate field type
        $fieldTypes = FieldTypeService::getSupportedTypes();
        if (!isset($fieldTypes[$fieldData['type']])) {
            $errors[] = 'Invalid field type';
        }

        // Validate options based on field type
        if (isset($fieldData['options']) && is_array($fieldData['options'])) {
            $fieldType = $fieldTypes[$fieldData['type']] ?? null;
            if ($fieldType) {
                $optionErrors = self::validateFieldOptions($fieldData['type'], $fieldData['options'], $fieldType['options'] ?? []);
                $errors = array_merge($errors, $optionErrors);
            }
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Validate field options
     */
    private static function validateFieldOptions(string $fieldType, array $options, array $expectedOptions): array
    {
        $errors = [];

        foreach ($expectedOptions as $optionKey => $optionConfig) {
            if (isset($optionConfig['required']) && $optionConfig['required'] && !isset($options[$optionKey])) {
                $errors[] = "Option '{$optionKey}' is required for field type '{$fieldType}'";
            }
        }

        return $errors;
    }

    /**
     * Get field statistics
     */
    public static function getFieldStatistics(ContentType $contentType): array
    {
        $fieldsSchema = $contentType->fields_schema ?? [];
        $fieldGroups = $contentType->field_groups ?? [];

        $stats = [
            'total_fields' => count($fieldsSchema),
            'required_fields' => 0,
            'field_types' => [],
            'field_groups' => [],
            'visibility_rules' => count($contentType->visibility_rules ?? [])
        ];

        foreach ($fieldsSchema as $field) {
            if ($field['required'] ?? false) {
                $stats['required_fields']++;
            }

            $fieldType = $field['type'] ?? 'unknown';
            $stats['field_types'][$fieldType] = ($stats['field_types'][$fieldType] ?? 0) + 1;

            $group = $field['group'] ?? 'basic';
            $stats['field_groups'][$group] = ($stats['field_groups'][$group] ?? 0) + 1;
        }

        return $stats;
    }
}
