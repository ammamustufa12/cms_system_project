<?php

namespace App\Services;

use App\Models\FieldManager;
use App\Models\Field;
use App\Models\FieldGroup;
use App\Models\Category;
use App\Models\ContentType;

class UnifiedFieldService
{
    /**
     * Get all available field types from different sources
     */
    public static function getAllFieldTypes()
    {
        $fieldTypes = [];
        
        // 1. Field Managers (Custom Field Types)
        $fieldManagers = FieldManager::where('is_active', true)
            ->where('is_installed', true)
            ->get();
            
        foreach ($fieldManagers as $fm) {
            $fieldTypes['field_manager_' . $fm->id] = [
                'id' => 'field_manager_' . $fm->id,
                'name' => $fm->name,
                'type' => $fm->type,
                'description' => $fm->description,
                'source' => 'field_manager',
                'source_id' => $fm->id,
                'icon' => self::getFieldIcon($fm->type),
                'color' => self::getFieldColor($fm->type),
                'config' => $fm->field_config ?? [],
                'validation' => $fm->validation_rules ?? [],
                'category' => 'Custom Fields'
            ];
        }
        
        // 2. Fields (Individual Fields)
        $fields = Field::where('is_active', true)
            ->with('fieldGroup')
            ->get();
            
        foreach ($fields as $field) {
            $fieldTypes['field_' . $field->id] = [
                'id' => 'field_' . $field->id,
                'name' => $field->label,
                'type' => $field->type,
                'description' => $field->description,
                'source' => 'field',
                'source_id' => $field->id,
                'icon' => self::getFieldIcon($field->type),
                'color' => self::getFieldColor($field->type),
                'config' => $field->field_config ?? [],
                'validation' => $field->validation_rules ?? [],
                'category' => $field->fieldGroup ? $field->fieldGroup->name : 'Individual Fields'
            ];
        }
        
        // 3. Field Groups (Grouped Fields)
        $fieldGroups = FieldGroup::where('is_active', true)
            ->with('fields')
            ->get();
            
        foreach ($fieldGroups as $group) {
            $fieldTypes['field_group_' . $group->id] = [
                'id' => 'field_group_' . $group->id,
                'name' => $group->name . ' (Group)',
                'type' => 'field_group',
                'description' => $group->description,
                'source' => 'field_group',
                'source_id' => $group->id,
                'icon' => 'fas fa-layer-group',
                'color' => '#6c757d',
                'config' => [],
                'validation' => [],
                'category' => 'Field Groups',
                'fields' => $group->fields->map(function($field) {
                    return [
                        'id' => $field->id,
                        'name' => $field->label,
                        'type' => $field->type,
                        'config' => $field->field_config ?? [],
                        'validation' => $field->validation_rules ?? []
                    ];
                })->toArray()
            ];
        }
        
        // 4. Categories (Taxonomy Fields)
        $categories = Category::where('is_active', true)->get();
        
        foreach ($categories as $category) {
            $fieldTypes['category_' . $category->id] = [
                'id' => 'category_' . $category->id,
                'name' => $category->name . ' (Category)',
                'type' => 'category',
                'description' => $category->description,
                'source' => 'category',
                'source_id' => $category->id,
                'icon' => 'fas fa-tags',
                'color' => '#28a745',
                'config' => [
                    'category_id' => $category->id,
                    'multiple' => true,
                    'hierarchical' => true
                ],
                'validation' => [],
                'category' => 'Taxonomies'
            ];
        }
        
        // 5. Built-in Field Types
        $builtInTypes = FieldTypeService::getSupportedTypes();
        
        foreach ($builtInTypes as $type => $config) {
            $fieldTypes['builtin_' . $type] = [
                'id' => 'builtin_' . $type,
                'name' => $config['label'],
                'type' => $type,
                'description' => $config['description'],
                'source' => 'builtin',
                'source_id' => $type,
                'icon' => $config['icon'] ?? 'fas fa-cube',
                'color' => '#007bff',
                'config' => $config['options'] ?? [],
                'validation' => $config['validation'] ?? '',
                'category' => 'Built-in Types'
            ];
        }
        
        return $fieldTypes;
    }
    
    /**
     * Get field types grouped by category
     */
    public static function getFieldTypesByCategory()
    {
        $allTypes = self::getAllFieldTypes();
        $grouped = [];
        
        foreach ($allTypes as $type) {
            $category = $type['category'];
            if (!isset($grouped[$category])) {
                $grouped[$category] = [];
            }
            $grouped[$category][] = $type;
        }
        
        return $grouped;
    }
    
    /**
     * Add a field to a content type
     */
    public static function addFieldToContentType($contentTypeId, $fieldTypeId, $fieldConfig = [])
    {
        $contentType = ContentType::findOrFail($contentTypeId);
        $fieldType = self::getFieldTypeById($fieldTypeId);
        
        if (!$fieldType) {
            throw new \Exception('Field type not found');
        }
        
        $fieldsSchema = $contentType->fields_schema ?? [];
        $fieldKey = $fieldConfig['field_key'] ?? self::generateFieldKey($fieldType['name']);
        
        // Generate field configuration based on field type
        $fieldSchema = self::generateFieldSchema($fieldType, $fieldConfig);
        
        $fieldsSchema[$fieldKey] = $fieldSchema;
        
        $contentType->update(['fields_schema' => $fieldsSchema]);
        
        return $fieldSchema;
    }
    
    /**
     * Get field type by ID
     */
    public static function getFieldTypeById($fieldTypeId)
    {
        $allTypes = self::getAllFieldTypes();
        return $allTypes[$fieldTypeId] ?? null;
    }
    
    /**
     * Generate field schema for content type
     */
    private static function generateFieldSchema($fieldType, $fieldConfig)
    {
        $schema = [
            'name' => $fieldConfig['name'] ?? $fieldType['name'],
            'type' => $fieldType['type'],
            'required' => $fieldConfig['required'] ?? false,
            'order' => $fieldConfig['order'] ?? 999,
            'description' => $fieldConfig['description'] ?? $fieldType['description'],
            'source' => $fieldType['source'],
            'source_id' => $fieldType['source_id'],
            'options' => array_merge($fieldType['config'], $fieldConfig['options'] ?? [])
        ];
        
        // Add validation rules
        if (!empty($fieldType['validation'])) {
            $schema['validation'] = $fieldType['validation'];
        }
        
        return $schema;
    }
    
    /**
     * Generate field key from name
     */
    private static function generateFieldKey($name)
    {
        return strtolower(str_replace([' ', '-', '_'], '_', $name));
    }
    
    /**
     * Get field icon based on type
     */
    private static function getFieldIcon($type)
    {
        $icons = [
            'text' => 'fas fa-font',
            'textarea' => 'fas fa-align-left',
            'number' => 'fas fa-hashtag',
            'email' => 'fas fa-envelope',
            'select' => 'fas fa-list',
            'checkbox' => 'fas fa-check-square',
            'radio' => 'fas fa-dot-circle',
            'file' => 'fas fa-file',
            'image' => 'fas fa-image',
            'date' => 'fas fa-calendar',
            'time' => 'fas fa-clock',
            'url' => 'fas fa-link',
            'password' => 'fas fa-lock',
            'category' => 'fas fa-tags',
            'field_group' => 'fas fa-layer-group'
        ];
        
        return $icons[$type] ?? 'fas fa-cube';
    }
    
    /**
     * Get field color based on type
     */
    private static function getFieldColor($type)
    {
        $colors = [
            'text' => '#007bff',
            'textarea' => '#28a745',
            'number' => '#ffc107',
            'email' => '#17a2b8',
            'select' => '#6f42c1',
            'checkbox' => '#fd7e14',
            'radio' => '#e83e8c',
            'file' => '#20c997',
            'image' => '#6c757d',
            'date' => '#dc3545',
            'time' => '#343a40',
            'url' => '#007bff',
            'password' => '#6c757d',
            'category' => '#28a745',
            'field_group' => '#6c757d'
        ];
        
        return $colors[$type] ?? '#007bff';
    }
    
    /**
     * Get available field types for content type
     */
    public static function getAvailableFieldTypesForContentType($contentTypeId)
    {
        $contentType = ContentType::findOrFail($contentTypeId);
        $existingFields = $contentType->fields_schema ?? [];
        $existingFieldKeys = array_keys($existingFields);
        
        $allTypes = self::getAllFieldTypes();
        $available = [];
        
        foreach ($allTypes as $type) {
            // Skip if field type is already used
            if (in_array($type['id'], $existingFieldKeys)) {
                continue;
            }
            
            $available[] = $type;
        }
        
        return $available;
    }
    
    /**
     * Remove field from content type
     */
    public static function removeFieldFromContentType($contentTypeId, $fieldKey)
    {
        $contentType = ContentType::findOrFail($contentTypeId);
        $fieldsSchema = $contentType->fields_schema ?? [];
        
        if (isset($fieldsSchema[$fieldKey])) {
            unset($fieldsSchema[$fieldKey]);
            $contentType->update(['fields_schema' => $fieldsSchema]);
            return true;
        }
        
        return false;
    }
    
    /**
     * Update field in content type
     */
    public static function updateFieldInContentType($contentTypeId, $fieldKey, $fieldConfig)
    {
        $contentType = ContentType::findOrFail($contentTypeId);
        $fieldsSchema = $contentType->fields_schema ?? [];
        
        if (isset($fieldsSchema[$fieldKey])) {
            $fieldsSchema[$fieldKey] = array_merge($fieldsSchema[$fieldKey], $fieldConfig);
            $contentType->update(['fields_schema' => $fieldsSchema]);
            return true;
        }
        
        return false;
    }
}
