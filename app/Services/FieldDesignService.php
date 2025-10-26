<?php

namespace App\Services;

use App\Models\FieldManager;
use App\Models\ContentType;

class FieldDesignService
{
    /**
     * Get field design options
     */
    public static function getFieldDesignOptions()
    {
        return [
            'layouts' => [
                'single_column' => [
                    'name' => 'Single Column',
                    'description' => 'Fields arranged in a single column',
                    'icon' => 'ri-layout-column-line',
                    'class' => 'field-layout-single'
                ],
                'two_columns' => [
                    'name' => 'Two Columns',
                    'description' => 'Fields arranged in two columns',
                    'icon' => 'ri-layout-2-line',
                    'class' => 'field-layout-two'
                ],
                'three_columns' => [
                    'name' => 'Three Columns',
                    'description' => 'Fields arranged in three columns',
                    'icon' => 'ri-layout-3-line',
                    'class' => 'field-layout-three'
                ],
                'inline' => [
                    'name' => 'Inline',
                    'description' => 'Fields arranged inline',
                    'icon' => 'ri-layout-row-line',
                    'class' => 'field-layout-inline'
                ]
            ],
            'styles' => [
                'default' => [
                    'name' => 'Default',
                    'description' => 'Standard form styling',
                    'class' => 'field-style-default'
                ],
                'modern' => [
                    'name' => 'Modern',
                    'description' => 'Modern card-based styling',
                    'class' => 'field-style-modern'
                ],
                'minimal' => [
                    'name' => 'Minimal',
                    'description' => 'Clean minimal styling',
                    'class' => 'field-style-minimal'
                ],
                'colorful' => [
                    'name' => 'Colorful',
                    'description' => 'Colorful themed styling',
                    'class' => 'field-style-colorful'
                ]
            ],
            'sizes' => [
                'small' => [
                    'name' => 'Small',
                    'class' => 'field-size-small'
                ],
                'medium' => [
                    'name' => 'Medium',
                    'class' => 'field-size-medium'
                ],
                'large' => [
                    'name' => 'Large',
                    'class' => 'field-size-large'
                ]
            ],
            'animations' => [
                'none' => [
                    'name' => 'No Animation',
                    'class' => ''
                ],
                'fade' => [
                    'name' => 'Fade In',
                    'class' => 'field-animation-fade'
                ],
                'slide' => [
                    'name' => 'Slide In',
                    'class' => 'field-animation-slide'
                ],
                'bounce' => [
                    'name' => 'Bounce',
                    'class' => 'field-animation-bounce'
                ]
            ]
        ];
    }

    /**
     * Get content type design options
     */
    public static function getContentTypeDesignOptions()
    {
        return [
            'layouts' => [
                'form' => [
                    'name' => 'Form Layout',
                    'description' => 'Traditional form layout',
                    'icon' => 'ri-form-line',
                    'class' => 'content-type-form'
                ],
                'card' => [
                    'name' => 'Card Layout',
                    'description' => 'Card-based layout',
                    'icon' => 'ri-layout-2-line',
                    'class' => 'content-type-card'
                ],
                'wizard' => [
                    'name' => 'Wizard Layout',
                    'description' => 'Step-by-step wizard',
                    'icon' => 'ri-git-commit-line',
                    'class' => 'content-type-wizard'
                ],
                'tabs' => [
                    'name' => 'Tabs Layout',
                    'description' => 'Tabbed interface',
                    'icon' => 'ri-folder-line',
                    'class' => 'content-type-tabs'
                ]
            ],
            'themes' => [
                'light' => [
                    'name' => 'Light Theme',
                    'class' => 'theme-light'
                ],
                'dark' => [
                    'name' => 'Dark Theme',
                    'class' => 'theme-dark'
                ],
                'blue' => [
                    'name' => 'Blue Theme',
                    'class' => 'theme-blue'
                ],
                'green' => [
                    'name' => 'Green Theme',
                    'class' => 'theme-green'
                ]
            ],
            'spacing' => [
                'compact' => [
                    'name' => 'Compact',
                    'class' => 'spacing-compact'
                ],
                'normal' => [
                    'name' => 'Normal',
                    'class' => 'spacing-normal'
                ],
                'relaxed' => [
                    'name' => 'Relaxed',
                    'class' => 'spacing-relaxed'
                ]
            ]
        ];
    }

    /**
     * Generate field HTML with design
     */
    public static function generateFieldHtml($fieldKey, $field, $design = [])
    {
        $fieldName = $field['name'] ?? $field['label'] ?? ucfirst(str_replace('_', ' ', $fieldKey));
        $fieldType = $field['type'] ?? 'text';
        $isRequired = $field['required'] ?? false;
        $requiredLabel = $isRequired ? ' <span class="text-danger">*</span>' : '';
        
        // Get design options
        $layout = $design['layout'] ?? 'single_column';
        $style = $design['style'] ?? 'default';
        $size = $design['size'] ?? 'medium';
        $animation = $design['animation'] ?? 'none';
        
        $designOptions = self::getFieldDesignOptions();
        $layoutClass = $designOptions['layouts'][$layout]['class'] ?? '';
        $styleClass = $designOptions['styles'][$style]['class'] ?? '';
        $sizeClass = $designOptions['sizes'][$size]['class'] ?? '';
        $animationClass = $designOptions['animations'][$animation]['class'] ?? '';
        
        $html = '<div class="field-wrapper ' . $layoutClass . ' ' . $styleClass . ' ' . $sizeClass . ' ' . $animationClass . '">';
        $html .= '<label class="field-label">' . $fieldName . $requiredLabel . '</label>';
        
        switch ($fieldType) {
            case 'text':
            case 'email':
            case 'url':
            case 'tel':
            case 'number':
                $html .= '<input type="' . $fieldType . '" class="field-input" name="' . $fieldKey . '" placeholder="Enter ' . strtolower($fieldName) . '">';
                break;
            case 'textarea':
                $rows = $field['options']['rows'] ?? 3;
                $html .= '<textarea class="field-textarea" name="' . $fieldKey . '" rows="' . $rows . '" placeholder="Enter ' . strtolower($fieldName) . '"></textarea>';
                break;
            case 'select':
                $html .= '<select class="field-select" name="' . $fieldKey . '">';
                $html .= '<option value="">Select ' . strtolower($fieldName) . '</option>';
                if (isset($field['options']['choices'])) {
                    foreach ($field['options']['choices'] as $choice) {
                        $html .= '<option value="' . $choice . '">' . $choice . '</option>';
                    }
                }
                $html .= '</select>';
                break;
            case 'checkbox':
                $html .= '<div class="field-checkbox">';
                $html .= '<input type="checkbox" class="field-checkbox-input" name="' . $fieldKey . '">';
                $html .= '<label class="field-checkbox-label">' . $fieldName . '</label>';
                $html .= '</div>';
                break;
            case 'file':
            case 'image':
                $html .= '<input type="file" class="field-file" name="' . $fieldKey . '" accept="' . ($fieldType === 'image' ? 'image/*' : '*') . '">';
                break;
            case 'date':
                $html .= '<input type="date" class="field-date" name="' . $fieldKey . '">';
                break;
            case 'datetime-local':
                $html .= '<input type="datetime-local" class="field-datetime" name="' . $fieldKey . '">';
                break;
            default:
                $html .= '<input type="text" class="field-input" name="' . $fieldKey . '" placeholder="Enter ' . strtolower($fieldName) . '">';
                break;
        }
        
        if (isset($field['description'])) {
            $html .= '<div class="field-description">' . $field['description'] . '</div>';
        }
        
        $html .= '</div>';
        
        return $html;
    }

    /**
     * Generate content type HTML with design
     */
    public static function generateContentTypeHtml($contentType, $design = [])
    {
        $fields = is_array($contentType->fields_schema) ? $contentType->fields_schema : json_decode($contentType->fields_schema, true) ?? [];
        
        // Get design options
        $layout = $design['layout'] ?? 'form';
        $theme = $design['theme'] ?? 'light';
        $spacing = $design['spacing'] ?? 'normal';
        
        $designOptions = self::getContentTypeDesignOptions();
        $layoutClass = $designOptions['layouts'][$layout]['class'] ?? '';
        $themeClass = $designOptions['themes'][$theme]['class'] ?? '';
        $spacingClass = $designOptions['spacing'][$spacing]['class'] ?? '';
        
        $html = '<div class="content-type-wrapper ' . $layoutClass . ' ' . $themeClass . ' ' . $spacingClass . '">';
        
        if ($layout === 'card') {
            $html .= '<div class="content-type-card">';
            $html .= '<div class="card-header">';
            $html .= '<h4 class="card-title">' . $contentType->name . '</h4>';
            $html .= '<p class="card-subtitle">' . ($contentType->description ?? '') . '</p>';
            $html .= '</div>';
            $html .= '<div class="card-body">';
        } elseif ($layout === 'wizard') {
            $html .= '<div class="content-type-wizard">';
            $html .= '<div class="wizard-header">';
            $html .= '<h4>' . $contentType->name . '</h4>';
            $html .= '<div class="wizard-steps">';
            $html .= '<div class="step active">Step 1</div>';
            $html .= '<div class="step">Step 2</div>';
            $html .= '<div class="step">Step 3</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="wizard-content">';
        } elseif ($layout === 'tabs') {
            $html .= '<div class="content-type-tabs">';
            $html .= '<div class="tab-header">';
            $html .= '<h4>' . $contentType->name . '</h4>';
            $html .= '<div class="tab-nav">';
            $html .= '<button class="tab-btn active">Basic Info</button>';
            $html .= '<button class="tab-btn">Details</button>';
            $html .= '<button class="tab-btn">Settings</button>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="tab-content">';
        } else {
            $html .= '<div class="content-type-form">';
            $html .= '<div class="form-header">';
            $html .= '<h4>' . $contentType->name . '</h4>';
            $html .= '<p>' . ($contentType->description ?? '') . '</p>';
            $html .= '</div>';
            $html .= '<div class="form-body">';
        }
        
        foreach ($fields as $fieldKey => $field) {
            $html .= self::generateFieldHtml($fieldKey, $field, $design);
        }
        
        if ($layout === 'card') {
            $html .= '</div>'; // card-body
            $html .= '<div class="card-footer">';
            $html .= '<button type="submit" class="btn btn-primary">Save</button>';
            $html .= '<button type="button" class="btn btn-secondary">Cancel</button>';
            $html .= '</div>';
            $html .= '</div>'; // card
        } elseif ($layout === 'wizard') {
            $html .= '</div>'; // wizard-content
            $html .= '<div class="wizard-footer">';
            $html .= '<button type="button" class="btn btn-secondary">Previous</button>';
            $html .= '<button type="button" class="btn btn-primary">Next</button>';
            $html .= '</div>';
            $html .= '</div>'; // wizard
        } elseif ($layout === 'tabs') {
            $html .= '</div>'; // tab-content
            $html .= '</div>'; // tabs
        } else {
            $html .= '</div>'; // form-body
            $html .= '<div class="form-footer">';
            $html .= '<button type="submit" class="btn btn-primary">Save</button>';
            $html .= '<button type="button" class="btn btn-secondary">Cancel</button>';
            $html .= '</div>';
            $html .= '</div>'; // form
        }
        
        $html .= '</div>'; // content-type-wrapper
        
        return $html;
    }

    /**
     * Get CSS for field designs
     */
    public static function getFieldDesignCSS()
    {
        return '
        /* Field Layout Styles */
        .field-layout-single .field-wrapper { width: 100%; }
        .field-layout-two .field-wrapper { width: 48%; display: inline-block; margin-right: 2%; }
        .field-layout-three .field-wrapper { width: 31%; display: inline-block; margin-right: 2%; }
        .field-layout-inline .field-wrapper { display: inline-block; margin-right: 15px; }
        
        /* Field Style Styles */
        .field-style-default .field-wrapper {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background: #fff;
        }
        
        .field-style-modern .field-wrapper {
            margin-bottom: 20px;
            padding: 20px;
            border: none;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .field-style-minimal .field-wrapper {
            margin-bottom: 15px;
            padding: 10px;
            border: none;
            border-bottom: 1px solid #e9ecef;
            background: transparent;
        }
        
        .field-style-colorful .field-wrapper {
            margin-bottom: 20px;
            padding: 20px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        /* Field Size Styles */
        .field-size-small .field-input, .field-size-small .field-textarea, .field-size-small .field-select {
            padding: 8px 12px;
            font-size: 14px;
        }
        
        .field-size-medium .field-input, .field-size-medium .field-textarea, .field-size-medium .field-select {
            padding: 12px 16px;
            font-size: 16px;
        }
        
        .field-size-large .field-input, .field-size-large .field-textarea, .field-size-large .field-select {
            padding: 16px 20px;
            font-size: 18px;
        }
        
        /* Field Animation Styles */
        .field-animation-fade .field-wrapper {
            opacity: 0;
            animation: fadeIn 0.5s ease-in-out forwards;
        }
        
        .field-animation-slide .field-wrapper {
            transform: translateX(-20px);
            opacity: 0;
            animation: slideIn 0.5s ease-in-out forwards;
        }
        
        .field-animation-bounce .field-wrapper {
            animation: bounceIn 0.6s ease-in-out forwards;
        }
        
        @keyframes fadeIn {
            to { opacity: 1; }
        }
        
        @keyframes slideIn {
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }
        
        /* Content Type Layout Styles */
        .content-type-form {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .content-type-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .content-type-card .card-header {
            background: #f8f9fa;
            padding: 20px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .content-type-card .card-body {
            padding: 30px;
        }
        
        .content-type-card .card-footer {
            background: #f8f9fa;
            padding: 20px;
            border-top: 1px solid #dee2e6;
            text-align: right;
        }
        
        .content-type-wizard {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .wizard-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .wizard-steps {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        
        .wizard-steps .step {
            padding: 10px 20px;
            margin: 0 5px;
            background: #e9ecef;
            border-radius: 20px;
            font-size: 14px;
        }
        
        .wizard-steps .step.active {
            background: #007bff;
            color: white;
        }
        
        .content-type-tabs {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .tab-header {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
        }
        
        .tab-nav {
            display: flex;
            margin-top: 15px;
        }
        
        .tab-btn {
            padding: 10px 20px;
            border: none;
            background: transparent;
            border-bottom: 2px solid transparent;
            cursor: pointer;
        }
        
        .tab-btn.active {
            border-bottom-color: #007bff;
            color: #007bff;
        }
        
        /* Theme Styles */
        .theme-dark {
            background: #2d3748;
            color: #e2e8f0;
        }
        
        .theme-dark .field-wrapper {
            background: #4a5568;
            border-color: #718096;
        }
        
        .theme-blue {
            background: #ebf8ff;
        }
        
        .theme-blue .field-wrapper {
            border-color: #3182ce;
        }
        
        .theme-green {
            background: #f0fff4;
        }
        
        .theme-green .field-wrapper {
            border-color: #38a169;
        }
        
        /* Spacing Styles */
        .spacing-compact .field-wrapper {
            margin-bottom: 10px;
            padding: 10px;
        }
        
        .spacing-normal .field-wrapper {
            margin-bottom: 20px;
            padding: 15px;
        }
        
        .spacing-relaxed .field-wrapper {
            margin-bottom: 30px;
            padding: 25px;
        }
        ';
    }
}
