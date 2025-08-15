<?php
// app/Services/FieldTypeService.php

namespace App\Services;

use App\Models\ContentType;

class FieldTypeService
{
    public static function getSupportedTypes(): array
    {
        return [
            'text' => [
                'label' => 'Text Input',
                'icon' => '📝',
                'description' => 'Single line text input',
                'validation' => 'string|max:255',
                'component' => 'TextInput',
                'options' => [
                    'max_length' => ['type' => 'number', 'default' => 255, 'label' => 'Max Length'],
                    'placeholder' => ['type' => 'text', 'default' => '', 'label' => 'Placeholder'],
                    'default_value' => ['type' => 'text', 'default' => '', 'label' => 'Default Value']
                ]
            ],
            
            'textarea' => [
                'label' => 'Textarea',
                'icon' => '📄',
                'description' => 'Multi-line text input',
                'validation' => 'string',
                'component' => 'TextareaInput',
                'options' => [
                    'rows' => ['type' => 'number', 'default' => 4, 'label' => 'Number of Rows'],
                    'max_length' => ['type' => 'number', 'default' => null, 'label' => 'Max Length'],
                    'placeholder' => ['type' => 'text', 'default' => '', 'label' => 'Placeholder']
                ]
            ],
            
            'number' => [
                'label' => 'Number',
                'icon' => '🔢',
                'description' => 'Numeric input',
                'validation' => 'numeric',
                'component' => 'NumberInput',
                'options' => [
                    'min' => ['type' => 'number', 'default' => null, 'label' => 'Minimum Value'],
                    'max' => ['type' => 'number', 'default' => null, 'label' => 'Maximum Value'],
                    'step' => ['type' => 'number', 'default' => 1, 'label' => 'Step Value'],
                    'decimal_places' => ['type' => 'number', 'default' => 0, 'label' => 'Decimal Places']
                ]
            ],
            
            'email' => [
                'label' => 'Email',
                'icon' => '📧',
                'description' => 'Email address input',
                'validation' => 'email',
                'component' => 'EmailInput',
                'options' => [
                    'placeholder' => ['type' => 'text', 'default' => 'user@example.com', 'label' => 'Placeholder']
                ]
            ],
            
            'url' => [
                'label' => 'URL',
                'icon' => '🔗',
                'description' => 'Website URL input',
                'validation' => 'url',
                'component' => 'UrlInput',
                'options' => [
                    'placeholder' => ['type' => 'text', 'default' => 'https://example.com', 'label' => 'Placeholder']
                ]
            ],
            
            'date' => [
                'label' => 'Date',
                'icon' => '📅',
                'description' => 'Date picker',
                'validation' => 'date',
                'component' => 'DatePicker',
                'options' => [
                    'format' => ['type' => 'select', 'default' => 'Y-m-d', 'options' => [
                        'Y-m-d' => 'YYYY-MM-DD',
                        'd/m/Y' => 'DD/MM/YYYY',
                        'm/d/Y' => 'MM/DD/YYYY'
                    ], 'label' => 'Date Format'],
                    'min_date' => ['type' => 'date', 'default' => null, 'label' => 'Minimum Date'],
                    'max_date' => ['type' => 'date', 'default' => null, 'label' => 'Maximum Date']
                ]
            ],
            
            'datetime' => [
                'label' => 'Date & Time',
                'icon' => '🕐',
                'description' => 'Date and time picker',
                'validation' => 'date',
                'component' => 'DateTimePicker',
                'options' => [
                    'format' => ['type' => 'select', 'default' => 'Y-m-d H:i', 'options' => [
                        'Y-m-d H:i' => 'YYYY-MM-DD HH:MM',
                        'd/m/Y H:i' => 'DD/MM/YYYY HH:MM'
                    ], 'label' => 'DateTime Format']
                ]
            ],
            
            'select' => [
                'label' => 'Select Dropdown',
                'icon' => '📋',
                'description' => 'Dropdown selection',
                'validation' => 'string',
                'component' => 'SelectInput',
                'options' => [
                    'options' => ['type' => 'key_value', 'default' => [], 'label' => 'Options (Key => Value)'],
                    'multiple' => ['type' => 'boolean', 'default' => false, 'label' => 'Allow Multiple Selection'],
                    'placeholder' => ['type' => 'text', 'default' => 'Select an option', 'label' => 'Placeholder']
                ]
            ],
            
            'radio' => [
                'label' => 'Radio Buttons',
                'icon' => '🔘',
                'description' => 'Radio button selection',
                'validation' => 'string',
                'component' => 'RadioInput',
                'options' => [
                    'options' => ['type' => 'key_value', 'default' => [], 'label' => 'Options (Key => Value)'],
                    'inline' => ['type' => 'boolean', 'default' => false, 'label' => 'Display Inline']
                ]
            ],
            
            'checkbox' => [
                'label' => 'Checkbox',
                'icon' => '☑️',
                'description' => 'Checkbox input',
                'validation' => 'boolean',
                'component' => 'CheckboxInput',
                'options' => [
                    'label_text' => ['type' => 'text', 'default' => 'Yes', 'label' => 'Checkbox Label'],
                    'default_checked' => ['type' => 'boolean', 'default' => false, 'label' => 'Default Checked']
                ]
            ],
            
            'image' => [
                'label' => 'Image Upload',
                'icon' => '🖼️',
                'description' => 'Image file upload',
                'validation' => 'image|max:2048',
                'component' => 'ImageUpload',
                'options' => [
                    'max_size' => ['type' => 'number', 'default' => 2048, 'label' => 'Max Size (KB)'],
                    'allowed_types' => ['type' => 'multi_select', 'default' => ['jpg', 'jpeg', 'png', 'gif'], 
                                      'options' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'], 'label' => 'Allowed Types'],
                    'max_width' => ['type' => 'number', 'default' => null, 'label' => 'Max Width (px)'],
                    'max_height' => ['type' => 'number', 'default' => null, 'label' => 'Max Height (px)']
                ]
            ],
            
            'file' => [
                'label' => 'File Upload',
                'icon' => '📁',
                'description' => 'General file upload',
                'validation' => 'file|max:5120',
                'component' => 'FileUpload',
                'options' => [
                    'max_size' => ['type' => 'number', 'default' => 5120, 'label' => 'Max Size (KB)'],
                    'allowed_types' => ['type' => 'multi_select', 'default' => ['pdf', 'doc', 'docx', 'txt'], 
                                      'options' => ['pdf', 'doc', 'docx', 'txt', 'xls', 'xlsx', 'zip', 'rar'], 'label' => 'Allowed Types']
                ]
            ],
            
            'rich_text' => [
                'label' => 'Rich Text Editor',
                'icon' => '📝',
                'description' => 'WYSIWYG text editor',
                'validation' => 'string',
                'component' => 'RichTextEditor',
                'options' => [
                    'toolbar' => ['type' => 'multi_select', 'default' => ['bold', 'italic', 'underline', 'link'], 
                                'options' => ['bold', 'italic', 'underline', 'strike', 'link', 'image', 'list', 'code'], 'label' => 'Toolbar Options'],
                    'max_length' => ['type' => 'number', 'default' => null, 'label' => 'Max Length']
                ]
            ],
            
            'color' => [
                'label' => 'Color Picker',
                'icon' => '🎨',
                'description' => 'Color selection input',
                'validation' => 'string',
                'component' => 'ColorPicker',
                'options' => [
                    'format' => ['type' => 'select', 'default' => 'hex', 'options' => [
                        'hex' => 'HEX (#ffffff)',
                        'rgb' => 'RGB (255,255,255)',
                        'rgba' => 'RGBA (255,255,255,1)'
                    ], 'label' => 'Color Format'],
                    'default_color' => ['type' => 'color', 'default' => '#000000', 'label' => 'Default Color']
                ]
            ],
            
            'repeater' => [
                'label' => 'Repeater',
                'icon' => '🔄',
                'description' => 'Repeatable group of fields',
                'validation' => 'array',
                'component' => 'RepeaterInput',
                'options' => [
                    'sub_fields' => ['type' => 'repeater_fields', 'default' => [], 'label' => 'Sub Fields'],
                    'min_items' => ['type' => 'number', 'default' => 0, 'label' => 'Minimum Items'],
                    'max_items' => ['type' => 'number', 'default' => null, 'label' => 'Maximum Items'],
                    'add_button_text' => ['type' => 'text', 'default' => 'Add Item', 'label' => 'Add Button Text']
                ]
            ]
        ];
    }
    
    public static function getFieldType(string $type): ?array
    {
        $types = self::getSupportedTypes();
        return $types[$type] ?? null;
    }
    
    public static function getValidationRule(string $type, array $options = []): string
    {
        $fieldType = self::getFieldType($type);
        if (!$fieldType) {
            return 'string';
        }
        
        $baseValidation = $fieldType['validation'];
        
        // Add custom validation based on options
        switch ($type) {
            case 'text':
                if (isset($options['max_length'])) {
                    $baseValidation .= '|max:' . $options['max_length'];
                }
                break;
                
            case 'number':
                if (isset($options['min'])) {
                    $baseValidation .= '|min:' . $options['min'];
                }
                if (isset($options['max'])) {
                    $baseValidation .= '|max:' . $options['max'];
                }
                break;
                
            case 'image':
                if (isset($options['max_size'])) {
                    $baseValidation .= '|max:' . $options['max_size'];
                }
                if (isset($options['allowed_types'])) {
                    $baseValidation .= '|mimes:' . implode(',', $options['allowed_types']);
                }
                break;
                
            case 'file':
                if (isset($options['max_size'])) {
                    $baseValidation .= '|max:' . $options['max_size'];
                }
                if (isset($options['allowed_types'])) {
                    $baseValidation .= '|mimes:' . implode(',', $options['allowed_types']);
                }
                break;
                
            case 'select':
                if (isset($options['options']) && is_array($options['options'])) {
                    $baseValidation .= '|in:' . implode(',', array_keys($options['options']));
                }
                break;
        }
        
        return $baseValidation;
    }
    
    public static function renderFieldInput(string $type, string $fieldName, $value = null, array $options = []): string
    {
        $fieldType = self::getFieldType($type);
        if (!$fieldType) {
            return self::renderTextInput($fieldName, $value, $options);
        }
        
        $method = 'render' . ucfirst($fieldType['component']);
        
        if (method_exists(self::class, $method)) {
            return self::$method($fieldName, $value, $options);
        }
        
        return self::renderTextInput($fieldName, $value, $options);
    }
    
    // Input Rendering Methods
    private static function renderTextInput(string $fieldName, $value, array $options): string
    {
        $placeholder = $options['placeholder'] ?? '';
        $maxLength = $options['max_length'] ?? '';
        $maxLengthAttr = $maxLength ? "maxlength=\"{$maxLength}\"" : '';
        
        return "<input type=\"text\" name=\"field_data[{$fieldName}]\" value=\"" . htmlspecialchars($value ?? '') . "\" placeholder=\"{$placeholder}\" {$maxLengthAttr} class=\"form-control\">";
    }
    
    private static function renderTextareaInput(string $fieldName, $value, array $options): string
    {
        $rows = $options['rows'] ?? 4;
        $placeholder = $options['placeholder'] ?? '';
        $maxLength = $options['max_length'] ?? '';
        $maxLengthAttr = $maxLength ? "maxlength=\"{$maxLength}\"" : '';
        
        return "<textarea name=\"field_data[{$fieldName}]\" rows=\"{$rows}\" placeholder=\"{$placeholder}\" {$maxLengthAttr} class=\"form-control\">" . htmlspecialchars($value ?? '') . "</textarea>";
    }
    
    private static function renderNumberInput(string $fieldName, $value, array $options): string
    {
        $min = isset($options['min']) ? "min=\"{$options['min']}\"" : '';
        $max = isset($options['max']) ? "max=\"{$options['max']}\"" : '';
        $step = isset($options['step']) ? "step=\"{$options['step']}\"" : 'step="1"';
        
        return "<input type=\"number\" name=\"field_data[{$fieldName}]\" value=\"" . htmlspecialchars($value ?? '') . "\" {$min} {$max} {$step} class=\"form-control\">";
    }
    
    private static function renderEmailInput(string $fieldName, $value, array $options): string
    {
        $placeholder = $options['placeholder'] ?? 'user@example.com';
        
        return "<input type=\"email\" name=\"field_data[{$fieldName}]\" value=\"" . htmlspecialchars($value ?? '') . "\" placeholder=\"{$placeholder}\" class=\"form-control\">";
    }
    
    private static function renderDatePicker(string $fieldName, $value, array $options): string
    {
        $minDate = isset($options['min_date']) ? "min=\"{$options['min_date']}\"" : '';
        $maxDate = isset($options['max_date']) ? "max=\"{$options['max_date']}\"" : '';
        
        return "<input type=\"date\" name=\"field_data[{$fieldName}]\" value=\"" . htmlspecialchars($value ?? '') . "\" {$minDate} {$maxDate} class=\"form-control\">";
    }
    
    private static function renderSelectInput(string $fieldName, $value, array $options): string
    {
        $selectOptions = $options['options'] ?? [];
        $multiple = $options['multiple'] ?? false;
        $placeholder = $options['placeholder'] ?? 'Select an option';
        
        $multipleAttr = $multiple ? 'multiple' : '';
        $nameAttr = $multiple ? "field_data[{$fieldName}][]" : "field_data[{$fieldName}]";
        
        $html = "<select name=\"{$nameAttr}\" {$multipleAttr} class=\"form-control\">";
        
        if (!$multiple) {
            $html .= "<option value=\"\">{$placeholder}</option>";
        }
        
        foreach ($selectOptions as $key => $label) {
            $selected = '';
            if ($multiple) {
                $selected = (is_array($value) && in_array($key, $value)) ? 'selected' : '';
            } else {
                $selected = ($value == $key) ? 'selected' : '';
            }
            
            $html .= "<option value=\"{$key}\" {$selected}>{$label}</option>";
        }
        
        $html .= "</select>";
        
        return $html;
    }
    
    private static function renderCheckboxInput(string $fieldName, $value, array $options): string
    {
        $labelText = $options['label_text'] ?? 'Yes';
        $checked = $value ? 'checked' : '';
        
        return "
            <div class=\"form-check\">
                <input type=\"hidden\" name=\"field_data[{$fieldName}]\" value=\"0\">
                <input type=\"checkbox\" name=\"field_data[{$fieldName}]\" value=\"1\" {$checked} class=\"form-check-input\" id=\"{$fieldName}\">
                <label class=\"form-check-label\" for=\"{$fieldName}\">
                    {$labelText}
                </label>
            </div>";
    }
    
    private static function renderImageUpload(string $fieldName, $value, array $options): string
    {
        $maxSize = $options['max_size'] ?? 2048;
        $allowedTypes = $options['allowed_types'] ?? ['jpg', 'jpeg', 'png', 'gif'];
        $accept = 'image/' . implode(',image/', $allowedTypes);
        
        $preview = '';
        if ($value) {
            $preview = "<div class=\"current-image mb-2\">
                <img src=\"{$value}\" alt=\"Current image\" style=\"max-width: 200px; max-height: 200px;\">
                <p class=\"small text-muted\">Current image</p>
            </div>";
        }
        
        return "
            {$preview}
            <input type=\"file\" name=\"field_data[{$fieldName}]\" accept=\"{$accept}\" class=\"form-control\">
            <small class=\"text-muted\">Max size: {$maxSize}KB. Allowed: " . implode(', ', $allowedTypes) . "</small>";
    }
    
    private static function renderFileUpload(string $fieldName, $value, array $options): string
    {
        $maxSize = $options['max_size'] ?? 5120;
        $allowedTypes = $options['allowed_types'] ?? ['pdf', 'doc', 'docx'];
        $accept = '.' . implode(',.', $allowedTypes);
        
        $preview = '';
        if ($value) {
            $fileName = basename($value);
            $preview = "<div class=\"current-file mb-2\">
                <a href=\"{$value}\" target=\"_blank\" class=\"btn btn-sm btn-outline-primary\">
                    📄 {$fileName}
                </a>
                <p class=\"small text-muted\">Current file</p>
            </div>";
        }
        
        return "
            {$preview}
            <input type=\"file\" name=\"field_data[{$fieldName}]\" accept=\"{$accept}\" class=\"form-control\">
            <small class=\"text-muted\">Max size: {$maxSize}KB. Allowed: " . implode(', ', $allowedTypes) . "</small>";
    }
    
    private static function renderColorPicker(string $fieldName, $value, array $options): string
    {
        $defaultColor = $options['default_color'] ?? '#000000';
        $currentValue = $value ?? $defaultColor;
        
        return "
            <div class=\"input-group\">
                <input type=\"color\" name=\"field_data[{$fieldName}]\" value=\"{$currentValue}\" class=\"form-control form-control-color\">
                <input type=\"text\" value=\"{$currentValue}\" class=\"form-control\" readonly>
            </div>";
    }
}

// Additional Helper Class for Page Builder Integration
class PageBuilderService
{
    public static function generateFieldBlocks(ContentType $contentType): array
    {
        $blocks = [];
        $fieldsSchema = $contentType->getFieldsArray();
        
        foreach ($fieldsSchema as $fieldName => $fieldConfig) {
            $fieldType = FieldTypeService::getFieldType($fieldConfig['type']);
            
            $blocks[] = [
                'id' => "{$contentType->slug}-{$fieldName}",
                'label' => "{$fieldType['icon']} {$fieldConfig['label']}",
                'category' => $contentType->name . ' Fields',
                'content' => self::generateFieldHTML($fieldName, $fieldConfig),
                'attributes' => [
                    'data-field' => $fieldName,
                    'data-field-type' => $fieldConfig['type'],
                    'data-content-type' => $contentType->slug
                ]
            ];
        }
        
        return $blocks;
    }
    
    private static function generateFieldHTML(string $fieldName, array $fieldConfig): string
    {
        $className = "field-{$fieldConfig['type']} content-field";
        
        switch ($fieldConfig['type']) {
            case 'text':
                return "<span data-field=\"{$fieldName}\" class=\"{$className}\">{{{{$fieldName}}}}</span>";
                
            case 'textarea':
                return "<div data-field=\"{$fieldName}\" class=\"{$className}\">{{{{$fieldName}}}}</div>";
                
            case 'rich_text':
                return "<div data-field=\"{$fieldName}\" class=\"{$className} rich-content\">{{{{$fieldName}}}}</div>";
                
            case 'image':
                return "<img data-field=\"{$fieldName}\" src=\"{{{{$fieldName}}}}\" alt=\"{$fieldConfig['label']}\" class=\"{$className}\">";
                
            case 'date':
                return "<time data-field=\"{$fieldName}\" class=\"{$className}\">{{{{$fieldName}}}}</time>";
                
            case 'email':
                return "<a data-field=\"{$fieldName}\" href=\"mailto:{{{{$fieldName}}}}\" class=\"{$className}\">{{{{$fieldName}}}}</a>";
                
            case 'url':
                return "<a data-field=\"{$fieldName}\" href=\"{{{{$fieldName}}}}\" class=\"{$className}\" target=\"_blank\">{{{{$fieldName}}}}</a>";
                
            case 'file':
                return "<a data-field=\"{$fieldName}\" href=\"{{{{$fieldName}}}}\" class=\"{$className}\" download>📄 Download {$fieldConfig['label']}</a>";
                
            case 'color':
                return "<span data-field=\"{$fieldName}\" class=\"{$className}\" style=\"background-color: {{{{$fieldName}}}};\">{{{{$fieldName}}}}</span>";
                
            case 'number':
                return "<span data-field=\"{$fieldName}\" class=\"{$className} number\">{{{{$fieldName}}}}</span>";
                
            case 'select':
            case 'radio':
                return "<span data-field=\"{$fieldName}\" class=\"{$className}\">{{{{$fieldName}}}}</span>";
                
            case 'checkbox':
                return "<span data-field=\"{$fieldName}\" class=\"{$className} boolean\">{{{{$fieldName}}}}</span>";
                
            case 'repeater':
                return "<div data-field=\"{$fieldName}\" class=\"{$className} repeater-content\">{{{{$fieldName}}}}</div>";
                
            default:
                return "<span data-field=\"{$fieldName}\" class=\"{$className}\">{{{{$fieldName}}}}</span>";
        }
    }
}