<?php

namespace App\Services;

use App\Models\ContentType;
use App\Models\ContentItem;

class ContentTypePageBuilderService
{
    /**
     * Get all content types formatted for page builders
     */
    public static function getContentTypesForPageBuilder()
    {
        $contentTypes = ContentType::where('status', 'active')->get();
        $formattedTypes = [];

        foreach ($contentTypes as $contentType) {
            $formattedTypes[] = [
                'id' => $contentType->id,
                'name' => $contentType->name,
                'slug' => $contentType->slug,
                'description' => $contentType->description,
                'icon' => $contentType->icon ?? 'ri-file-text-line',
                'color' => $contentType->color ?? '#007bff',
                'fields_count' => count(is_array($contentType->fields_schema) ? $contentType->fields_schema : json_decode($contentType->fields_schema, true) ?? []),
                'preview_html' => self::generatePreviewHtml($contentType),
                'component_html' => self::generateComponentHtml($contentType)
            ];
        }

        return $formattedTypes;
    }

    /**
     * Generate preview HTML for content type
     */
    private static function generatePreviewHtml(ContentType $contentType)
    {
        $fields = is_array($contentType->fields_schema) ? $contentType->fields_schema : json_decode($contentType->fields_schema, true) ?? [];
        $previewFields = array_slice($fields, 0, 3, true); // Show first 3 fields

        $html = '<div class="content-type-preview">';
        $html .= '<div class="preview-header">';
        $html .= '<h6>' . $contentType->name . '</h6>';
        $html .= '<small class="text-muted">' . count($fields) . ' fields</small>';
        $html .= '</div>';
        $html .= '<div class="preview-content">';

        foreach ($previewFields as $fieldKey => $field) {
            $fieldName = $field['name'] ?? $field['label'] ?? ucfirst(str_replace('_', ' ', $fieldKey));
            $fieldType = $field['type'] ?? 'text';
            
            $html .= '<div class="preview-field">';
            $html .= '<label>' . $fieldName . ':</label>';
            
            switch ($fieldType) {
                case 'text':
                case 'email':
                case 'url':
                    $html .= '<input type="' . $fieldType . '" class="form-control form-control-sm" placeholder="Enter ' . strtolower($fieldName) . '">';
                    break;
                case 'textarea':
                    $html .= '<textarea class="form-control form-control-sm" rows="2" placeholder="Enter ' . strtolower($fieldName) . '"></textarea>';
                    break;
                case 'select':
                    $html .= '<select class="form-select form-select-sm"><option>Select ' . strtolower($fieldName) . '</option></select>';
                    break;
                case 'checkbox':
                    $html .= '<div class="form-check"><input type="checkbox" class="form-check-input"><label class="form-check-label">' . $fieldName . '</label></div>';
                    break;
                case 'file':
                case 'image':
                    $html .= '<input type="file" class="form-control form-control-sm">';
                    break;
                default:
                    $html .= '<input type="text" class="form-control form-control-sm" placeholder="Enter ' . strtolower($fieldName) . '">';
                    break;
            }
            
            $html .= '</div>';
        }

        if (count($fields) > 3) {
            $html .= '<div class="preview-more">';
            $html .= '<small class="text-muted">+ ' . (count($fields) - 3) . ' more fields</small>';
            $html .= '</div>';
        }

        $html .= '</div></div>';

        return $html;
    }

    /**
     * Generate component HTML for content type
     */
    private static function generateComponentHtml(ContentType $contentType)
    {
        $fields = is_array($contentType->fields_schema) ? $contentType->fields_schema : json_decode($contentType->fields_schema, true) ?? [];
        
        $html = '<div class="content-type-component" data-content-type="' . $contentType->slug . '">';
        $html .= '<div class="component-header">';
        $html .= '<h4>' . $contentType->name . '</h4>';
        $html .= '<p class="text-muted">' . ($contentType->description ?? 'Content type component') . '</p>';
        $html .= '</div>';
        $html .= '<div class="component-content">';

        foreach ($fields as $fieldKey => $field) {
            $fieldName = $field['name'] ?? $field['label'] ?? ucfirst(str_replace('_', ' ', $fieldKey));
            $fieldType = $field['type'] ?? 'text';
            $isRequired = $field['required'] ?? false;
            $requiredLabel = $isRequired ? ' <span class="text-danger">*</span>' : '';
            
            $html .= '<div class="mb-3">';
            $html .= '<label class="form-label">' . $fieldName . $requiredLabel . '</label>';
            
            switch ($fieldType) {
                case 'text':
                case 'email':
                case 'url':
                case 'tel':
                case 'number':
                    $html .= '<input type="' . $fieldType . '" class="form-control" name="' . $fieldKey . '" placeholder="Enter ' . strtolower($fieldName) . '">';
                    break;
                case 'textarea':
                    $rows = $field['options']['rows'] ?? 3;
                    $html .= '<textarea class="form-control" name="' . $fieldKey . '" rows="' . $rows . '" placeholder="Enter ' . strtolower($fieldName) . '"></textarea>';
                    break;
                case 'select':
                    $html .= '<select class="form-select" name="' . $fieldKey . '">';
                    $html .= '<option value="">Select ' . strtolower($fieldName) . '</option>';
                    if (isset($field['options']['choices'])) {
                        foreach ($field['options']['choices'] as $choice) {
                            $html .= '<option value="' . $choice . '">' . $choice . '</option>';
                        }
                    }
                    $html .= '</select>';
                    break;
                case 'checkbox':
                    $html .= '<div class="form-check">';
                    $html .= '<input type="checkbox" class="form-check-input" name="' . $fieldKey . '">';
                    $html .= '<label class="form-check-label">' . $fieldName . '</label>';
                    $html .= '</div>';
                    break;
                case 'file':
                case 'image':
                    $html .= '<input type="file" class="form-control" name="' . $fieldKey . '" accept="' . ($fieldType === 'image' ? 'image/*' : '*') . '">';
                    break;
                case 'date':
                    $html .= '<input type="date" class="form-control" name="' . $fieldKey . '">';
                    break;
                case 'datetime-local':
                    $html .= '<input type="datetime-local" class="form-control" name="' . $fieldKey . '">';
                    break;
                default:
                    $html .= '<input type="text" class="form-control" name="' . $fieldKey . '" placeholder="Enter ' . strtolower($fieldName) . '">';
                    break;
            }
            
            if (isset($field['description'])) {
                $html .= '<div class="form-text">' . $field['description'] . '</div>';
            }
            
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '<div class="component-actions">';
        $html .= '<button type="button" class="btn btn-primary btn-sm">Save Content</button>';
        $html .= '<button type="button" class="btn btn-outline-secondary btn-sm">Cancel</button>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Get content type by slug
     */
    public static function getContentTypeBySlug($slug)
    {
        return ContentType::where('slug', $slug)->first();
    }

    /**
     * Save content type data
     */
    public static function saveContentTypeData($contentTypeSlug, $data)
    {
        $contentType = self::getContentTypeBySlug($contentTypeSlug);
        if (!$contentType) {
            return false;
        }

        $contentItem = ContentItem::create([
            'content_type_id' => $contentType->id,
            'title' => $data['title'] ?? 'Untitled',
            'field_data' => $data,
            'status' => 'draft'
        ]);

        return $contentItem;
    }
}
