<?php

namespace App\Services;

class FormRendererService
{
    public static function renderField($fieldKey, $field, $value = null, $errors = null)
    {
        $fieldName = $fieldKey;
        $fieldValue = $value ?? ($field['default_value'] ?? '');
        $hasError = $errors && $errors->has($fieldKey);
        $errorClass = $hasError ? 'is-invalid' : '';
        $required = $field['required'] ?? false;
        $requiredAttr = $required ? 'required' : '';
        $requiredLabel = $required ? '<span class="text-danger">*</span>' : '';
        
        $html = '<div class="mb-3">';
        $html .= '<label for="' . $fieldKey . '" class="form-label">' . $field['label'] . ' ' . $requiredLabel . '</label>';
        
        if (!empty($field['description'])) {
            $html .= '<div class="form-text mb-2">' . $field['description'] . '</div>';
        }
        
        $html .= self::renderFieldInput($fieldKey, $field, $fieldValue, $errorClass, $requiredAttr);
        
        if ($hasError) {
            $html .= '<div class="invalid-feedback">' . $errors->first($fieldKey) . '</div>';
        }
        
        $html .= '</div>';
        
        return $html;
    }

    private static function renderFieldInput($fieldKey, $field, $value, $errorClass, $requiredAttr)
    {
        $options = $field['options'] ?? [];
        
        switch ($field['type']) {
            case 'text':
                return self::renderTextInput($fieldKey, $field, $value, $errorClass, $requiredAttr);
                
            case 'email':
                return self::renderEmailInput($fieldKey, $field, $value, $errorClass, $requiredAttr);
                
            case 'textarea':
                return self::renderTextarea($fieldKey, $field, $value, $errorClass, $requiredAttr);
                
            case 'number':
                return self::renderNumberInput($fieldKey, $field, $value, $errorClass, $requiredAttr);
                
            case 'select':
                return self::renderSelect($fieldKey, $field, $value, $errorClass, $requiredAttr);
                
            case 'checkbox':
                return self::renderCheckbox($fieldKey, $field, $value, $errorClass, $requiredAttr);
                
            case 'radio':
                return self::renderRadio($fieldKey, $field, $value, $errorClass, $requiredAttr);
                
            case 'boolean':
                return self::renderBoolean($fieldKey, $field, $value, $errorClass, $requiredAttr);
                
            case 'date':
                return self::renderDate($fieldKey, $field, $value, $errorClass, $requiredAttr);
                
            case 'datetime':
                return self::renderDateTime($fieldKey, $field, $value, $errorClass, $requiredAttr);
                
            case 'file':
                return self::renderFile($fieldKey, $field, $value, $errorClass, $requiredAttr);
                
            case 'image':
                return self::renderImage($fieldKey, $field, $value, $errorClass, $requiredAttr);
                
            case 'gallery':
                return self::renderGallery($fieldKey, $field, $value, $errorClass, $requiredAttr);
                
            case 'wysiwyg':
                return self::renderWysiwyg($fieldKey, $field, $value, $errorClass, $requiredAttr);
                
            case 'repeater':
                return self::renderRepeater($fieldKey, $field, $value, $errorClass, $requiredAttr);
                
            default:
                return self::renderTextInput($fieldKey, $field, $value, $errorClass, $requiredAttr);
        }
    }

    private static function renderTextInput($fieldKey, $field, $value, $errorClass, $requiredAttr)
    {
        $options = $field['options'] ?? [];
        $placeholder = $options['placeholder'] ?? '';
        $maxLength = isset($options['max_length']) ? 'maxlength="' . $options['max_length'] . '"' : '';
        
        return '<input type="text" id="' . $fieldKey . '" name="' . $fieldKey . '" 
                class="form-control ' . $errorClass . '" 
                value="' . htmlspecialchars($value) . '" 
                placeholder="' . $placeholder . '" 
                ' . $maxLength . ' ' . $requiredAttr . '>';
    }

    private static function renderEmailInput($fieldKey, $field, $value, $errorClass, $requiredAttr)
    {
        $options = $field['options'] ?? [];
        $placeholder = $options['placeholder'] ?? 'Enter email address';
        
        return '<input type="email" id="' . $fieldKey . '" name="' . $fieldKey . '" 
                class="form-control ' . $errorClass . '" 
                value="' . htmlspecialchars($value) . '" 
                placeholder="' . $placeholder . '" ' . $requiredAttr . '>';
    }

    private static function renderTextarea($fieldKey, $field, $value, $errorClass, $requiredAttr)
    {
        $options = $field['options'] ?? [];
        $placeholder = $options['placeholder'] ?? '';
        $rows = $options['rows'] ?? 4;
        $maxLength = isset($options['max_length']) ? 'maxlength="' . $options['max_length'] . '"' : '';
        
        return '<textarea id="' . $fieldKey . '" name="' . $fieldKey . '" 
                class="form-control ' . $errorClass . '" 
                rows="' . $rows . '" 
                placeholder="' . $placeholder . '" 
                ' . $maxLength . ' ' . $requiredAttr . '>' . htmlspecialchars($value) . '</textarea>';
    }

    private static function renderNumberInput($fieldKey, $field, $value, $errorClass, $requiredAttr)
    {
        $options = $field['options'] ?? [];
        $min = isset($options['min']) ? 'min="' . $options['min'] . '"' : '';
        $max = isset($options['max']) ? 'max="' . $options['max'] . '"' : '';
        $step = $options['step'] ?? '1';
        
        return '<input type="number" id="' . $fieldKey . '" name="' . $fieldKey . '" 
                class="form-control ' . $errorClass . '" 
                value="' . $value . '" 
                step="' . $step . '" ' . $min . ' ' . $max . ' ' . $requiredAttr . '>';
    }

    private static function renderSelect($fieldKey, $field, $value, $errorClass, $requiredAttr)
    {
        $options = $field['options'] ?? [];
        $multiple = $options['multiple'] ?? false;
        $multipleAttr = $multiple ? 'multiple' : '';
        $nameAttr = $multiple ? $fieldKey . '[]' : $fieldKey;
        $selectedValues = $multiple && is_array($value) ? $value : [$value];
        
        $html = '<select id="' . $fieldKey . '" name="' . $nameAttr . '" 
                 class="form-select ' . $errorClass . '" ' . $multipleAttr . ' ' . $requiredAttr . '>';
        
        if (!$multiple) {
            $html .= '<option value="">Select an option</option>';
        }
        
        $optionsList = $options['options_list'] ?? [];
        foreach ($optionsList as $optionValue => $optionLabel) {
            $selected = in_array($optionValue, $selectedValues) ? 'selected' : '';
            $html .= '<option value="' . htmlspecialchars($optionValue) . '" ' . $selected . '>' 
                     . htmlspecialchars($optionLabel) . '</option>';
        }
        
        $html .= '</select>';
        
        if ($multiple) {
            $html .= '<div class="form-text">Hold Ctrl/Cmd to select multiple options</div>';
        }
        
        return $html;
    }

    private static function renderCheckbox($fieldKey, $field, $value, $errorClass, $requiredAttr)
    {
        $options = $field['options'] ?? [];
        $multiple = $options['multiple'] ?? false;
        
        if ($multiple) {
            $html = '<div class="checkbox-group">';
            $optionsList = $options['options_list'] ?? [];
            $selectedValues = is_array($value) ? $value : [];
            
            foreach ($optionsList as $optionValue => $optionLabel) {
                $checked = in_array($optionValue, $selectedValues) ? 'checked' : '';
                $html .= '<div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   name="' . $fieldKey . '[]" 
                                   value="' . htmlspecialchars($optionValue) . '" 
                                   id="' . $fieldKey . '_' . $optionValue . '" ' . $checked . '>
                            <label class="form-check-label" for="' . $fieldKey . '_' . $optionValue . '">
                                ' . htmlspecialchars($optionLabel) . '
                            </label>
                          </div>';
            }
            $html .= '</div>';
        } else {
            $checked = $value ? 'checked' : '';
            $html = '<div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                               name="' . $fieldKey . '" value="1" 
                               id="' . $fieldKey . '" ' . $checked . ' ' . $requiredAttr . '>
                        <label class="form-check-label" for="' . $fieldKey . '">
                            ' . $field['label'] . '
                        </label>
                     </div>';
        }
        
        return $html;
    }

    private static function renderRadio($fieldKey, $field, $value, $errorClass, $requiredAttr)
    {
        $options = $field['options'] ?? [];
        $optionsList = $options['options_list'] ?? [];
        
        $html = '<div class="radio-group">';
        foreach ($optionsList as $optionValue => $optionLabel) {
            $checked = $value == $optionValue ? 'checked' : '';
            $html .= '<div class="form-check">
                        <input class="form-check-input" type="radio" 
                               name="' . $fieldKey . '" 
                               value="' . htmlspecialchars($optionValue) . '" 
                               id="' . $fieldKey . '_' . $optionValue . '" ' . $checked . ' ' . $requiredAttr . '>
                        <label class="form-check-label" for="' . $fieldKey . '_' . $optionValue . '">
                            ' . htmlspecialchars($optionLabel) . '
                        </label>
                      </div>';
        }
        $html .= '</div>';
        
        return $html;
    }

    private static function renderBoolean($fieldKey, $field, $value, $errorClass, $requiredAttr)
    {
        $options = $field['options'] ?? [];
        $labelOn = $options['label_on'] ?? 'Yes';
        $labelOff = $options['label_off'] ?? 'No';
        $checked = $value ? 'checked' : '';
        
        return '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" 
                           name="' . $fieldKey . '" value="1" 
                           id="' . $fieldKey . '" ' . $checked . '>
                    <label class="form-check-label" for="' . $fieldKey . '">
                        ' . $labelOn . ' / ' . $labelOff . '
                    </label>
                </div>';
    }

    private static function renderDate($fieldKey, $field, $value, $errorClass, $requiredAttr)
    {
        $formattedValue = $value ? date('Y-m-d', strtotime($value)) : '';
        
        return '<input type="date" id="' . $fieldKey . '" name="' . $fieldKey . '" 
                class="form-control ' . $errorClass . '" 
                value="' . $formattedValue . '" ' . $requiredAttr . '>';
    }

    private static function renderDateTime($fieldKey, $field, $value, $errorClass, $requiredAttr)
    {
        $formattedValue = $value ? date('Y-m-d\TH:i', strtotime($value)) : '';
        
        return '<input type="datetime-local" id="' . $fieldKey . '" name="' . $fieldKey . '" 
                class="form-control ' . $errorClass . '" 
                value="' . $formattedValue . '" ' . $requiredAttr . '>';
    }

    private static function renderFile($fieldKey, $field, $value, $errorClass, $requiredAttr)
    {
        $options = $field['options'] ?? [];
        $acceptedTypes = '';
        if (isset($options['accepted_types']) && is_array($options['accepted_types'])) {
            $acceptedTypes = 'accept=".' . implode(',.' , $options['accepted_types']) . '"';
        }
        
        $html = '<input type="file" id="' . $fieldKey . '" name="' . $fieldKey . '" 
                 class="form-control ' . $errorClass . '" ' . $acceptedTypes . ' ' . $requiredAttr . '>';
        
        if ($value && isset($value['path'])) {
            $html .= '<div class="mt-2 p-2 bg-light rounded">
                        <small class="text-muted">Current file: </small>
                        <a href="' . asset('storage/' . $value['path']) . '" target="_blank" class="text-primary">
                            ' . ($value['original_name'] ?? 'File') . '
                        </a>
                        <small class="text-muted"> (' . self::formatFileSize($value['size'] ?? 0) . ')</small>
                      </div>';
        }
        
        return $html;
    }

    private static function renderImage($fieldKey, $field, $value, $errorClass, $requiredAttr)
    {
        $options = $field['options'] ?? [];
        $acceptedTypes = 'accept="image/*"';
        if (isset($options['accepted_types']) && is_array($options['accepted_types'])) {
            $acceptedTypes = 'accept=".' . implode(',.' , $options['accepted_types']) . '"';
        }
        
        $html = '<input type="file" id="' . $fieldKey . '" name="' . $fieldKey . '" 
                 class="form-control ' . $errorClass . '" ' . $acceptedTypes . ' ' . $requiredAttr . '>';
        
        if ($value && isset($value['path'])) {
            $html .= '<div class="mt-2">
                        <img src="' . asset('storage/' . $value['path']) . '" 
                             alt="Current image" 
                             class="img-thumbnail" 
                             style="max-width: 200px; max-height: 150px;">
                        <div class="mt-1">
                            <small class="text-muted">' . ($value['original_name'] ?? 'Image') . '</small>
                            <small class="text-muted"> (' . self::formatFileSize($value['size'] ?? 0) . ')</small>
                        </div>
                      </div>';
        }
        
        return $html;
    }

    private static function renderGallery($fieldKey, $field, $value, $errorClass, $requiredAttr)
    {
        $options = $field['options'] ?? [];
        $maxImages = isset($options['max_images']) ? 'data-max-images="' . $options['max_images'] . '"' : '';
        
        $html = '<input type="file" id="' . $fieldKey . '" name="' . $fieldKey . '[]" 
                 class="form-control ' . $errorClass . '" 
                 accept="image/*" multiple ' . $maxImages . ' ' . $requiredAttr . '>';
        
        if ($value && is_array($value) && !empty($value)) {
            $html .= '<div class="mt-3">
                        <label class="form-label">Current Images:</label>
                        <div class="row g-2">';
            
            foreach ($value as $index => $image) {
                if (isset($image['path'])) {
                    $html .= '<div class="col-md-3">
                                <div class="card">
                                    <img src="' . asset('storage/' . $image['path']) . '" 
                                         class="card-img-top" 
                                         style="height: 120px; object-fit: cover;" 
                                         alt="Gallery image">
                                    <div class="card-body p-2">
                                        <small class="text-muted d-block text-truncate">
                                            ' . ($image['original_name'] ?? 'Image') . '
                                        </small>
                                        <small class="text-muted">
                                            ' . self::formatFileSize($image['size'] ?? 0) . '
                                        </small>
                                    </div>
                                </div>
                              </div>';
                }
            }
            
            $html .= '</div></div>';
        }
        
        if (isset($options['max_images'])) {
            $html .= '<div class="form-text">Maximum ' . $options['max_images'] . ' images allowed</div>';
        }
        
        return $html;
    }

    private static function renderWysiwyg($fieldKey, $field, $value, $errorClass, $requiredAttr)
    {
        $options = $field['options'] ?? [];
        $height = $options['height'] ?? 300;
        
        $html = '<textarea id="' . $fieldKey . '" name="' . $fieldKey . '" 
                 class="form-control wysiwyg-editor ' . $errorClass . '" 
                 style="height: ' . $height . 'px;" 
                 data-height="' . $height . '" ' . $requiredAttr . '>' . htmlspecialchars($value) . '</textarea>';
        
        $html .= '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        if (typeof tinymce !== "undefined") {
                            tinymce.init({
                                selector: "#' . $fieldKey . '",
                                height: ' . $height . ',
                                menubar: false,
                                plugins: "advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount",
                                toolbar: "undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help"
                            });
                        }
                    });
                  </script>';
        
        return $html;
    }

    private static function renderRepeater($fieldKey, $field, $value, $errorClass, $requiredAttr)
    {
        $options = $field['options'] ?? [];
        $minItems = $options['min_items'] ?? 0;
        $maxItems = $options['max_items'] ?? 10;
        $subFields = $options['sub_fields'] ?? [];
        
        $values = is_array($value) ? $value : [];
        
        $html = '<div class="repeater-field" data-field-name="' . $fieldKey . '" 
                 data-min-items="' . $minItems . '" data-max-items="' . $maxItems . '">';
        
        $html .= '<div class="repeater-items">';
        
        // Render existing items
        foreach ($values as $index => $itemValue) {
            $html .= self::renderRepeaterItem($fieldKey, $subFields, $itemValue, $index);
        }
        
        // Add empty item if no existing items
        if (empty($values)) {
            $html .= self::renderRepeaterItem($fieldKey, $subFields, [], 0);
        }
        
        $html .= '</div>';
        
        $html .= '<div class="repeater-controls mt-2">
                    <button type="button" class="btn btn-sm btn-outline-primary add-repeater-item">
                        <i class="fas fa-plus me-1"></i>Add Item
                    </button>
                  </div>';
        
        $html .= '</div>';
        
        // Add JavaScript for repeater functionality
        $html .= self::getRepeaterScript();
        
        return $html;
    }

    private static function renderRepeaterItem($fieldKey, $subFields, $values, $index)
    {
        $html = '<div class="repeater-item card mb-2">
                   <div class="card-header d-flex justify-content-between align-items-center py-2">
                     <span class="fw-bold">Item #' . ($index + 1) . '</span>
                     <button type="button" class="btn btn-sm btn-outline-danger remove-repeater-item">
                       <i class="fas fa-trash"></i>
                     </button>
                   </div>
                   <div class="card-body">';
        
        foreach ($subFields as $subFieldKey => $subField) {
            $subFieldName = $fieldKey . '[' . $index . '][' . $subFieldKey . ']';
            $subFieldValue = $values[$subFieldKey] ?? '';
            
            $html .= '<div class="mb-3">
                        <label class="form-label">' . $subField['label'] . '</label>';
            
            // Simplified sub-field rendering
            switch ($subField['type']) {
                case 'text':
                    $html .= '<input type="text" name="' . $subFieldName . '" 
                             class="form-control" value="' . htmlspecialchars($subFieldValue) . '">';
                    break;
                case 'textarea':
                    $html .= '<textarea name="' . $subFieldName . '" 
                             class="form-control" rows="3">' . htmlspecialchars($subFieldValue) . '</textarea>';
                    break;
                case 'number':
                    $html .= '<input type="number" name="' . $subFieldName . '" 
                             class="form-control" value="' . $subFieldValue . '">';
                    break;
                default:
                    $html .= '<input type="text" name="' . $subFieldName . '" 
                             class="form-control" value="' . htmlspecialchars($subFieldValue) . '">';
            }
            
            $html .= '</div>';
        }
        
        $html .= '</div></div>';
        
        return $html;
    }

    private static function getRepeaterScript()
    {
        return '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Add repeater item functionality
                    document.addEventListener("click", function(e) {
                        if (e.target.classList.contains("add-repeater-item") || 
                            e.target.closest(".add-repeater-item")) {
                            
                            const button = e.target.closest(".add-repeater-item");
                            const repeater = button.closest(".repeater-field");
                            const itemsContainer = repeater.querySelector(".repeater-items");
                            const items = itemsContainer.querySelectorAll(".repeater-item");
                            const maxItems = parseInt(repeater.dataset.maxItems);
                            
                            if (items.length >= maxItems) {
                                alert("Maximum " + maxItems + " items allowed");
                                return;
                            }
                            
                            // Clone the first item as template
                            const template = items[0].cloneNode(true);
                            const newIndex = items.length;
                            
                            // Update field names and clear values
                            template.querySelectorAll("input, textarea, select").forEach(function(field) {
                                const name = field.name;
                                if (name) {
                                    field.name = name.replace(/\[\d+\]/, "[" + newIndex + "]");
                                    field.value = "";
                                }
                            });
                            
                            // Update item number
                            template.querySelector(".fw-bold").textContent = "Item #" + (newIndex + 1);
                            
                            itemsContainer.appendChild(template);
                        }
                        
                        // Remove repeater item functionality
                        if (e.target.classList.contains("remove-repeater-item") || 
                            e.target.closest(".remove-repeater-item")) {
                            
                            const button = e.target.closest(".remove-repeater-item");
                            const item = button.closest(".repeater-item");
                            const repeater = button.closest(".repeater-field");
                            const itemsContainer = repeater.querySelector(".repeater-items");
                            const items = itemsContainer.querySelectorAll(".repeater-item");
                            const minItems = parseInt(repeater.dataset.minItems);
                            
                            if (items.length <= minItems) {
                                alert("Minimum " + minItems + " item(s) required");
                                return;
                            }
                            
                            item.remove();
                            
                            // Re-number remaining items
                            itemsContainer.querySelectorAll(".repeater-item").forEach(function(item, index) {
                                item.querySelector(".fw-bold").textContent = "Item #" + (index + 1);
                                
                                // Update field names
                                item.querySelectorAll("input, textarea, select").forEach(function(field) {
                                    const name = field.name;
                                    if (name) {
                                        field.name = name.replace(/\[\d+\]/, "[" + index + "]");
                                    }
                                });
                            });
                        }
                    });
                });
                </script>';
    }

    private static function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    public static function renderDisplayValue($fieldKey, $field, $value)
    {
        if (is_null($value) || $value === '') {
            return '<span class="text-muted">—</span>';
        }
        
        switch ($field['type']) {
            case 'boolean':
                return $value ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>';
                
            case 'image':
                if (isset($value['path'])) {
                    return '<img src="' . asset('storage/' . $value['path']) . '" 
                            alt="Image" class="img-thumbnail" style="max-width: 100px; max-height: 75px;">';
                }
                break;
                
            case 'file':
                if (isset($value['path'])) {
                    return '<a href="' . asset('storage/' . $value['path']) . '" target="_blank" class="text-primary">
                            <i class="fas fa-file me-1"></i>' . ($value['original_name'] ?? 'File') . '
                            </a>';
                }
                break;
                
            case 'gallery':
                if (is_array($value) && !empty($value)) {
                    $html = '<div class="d-flex gap-1">';
                    foreach (array_slice($value, 0, 3) as $image) {
                        if (isset($image['path'])) {
                            $html .= '<img src="' . asset('storage/' . $image['path']) . '" 
                                     alt="Gallery" class="img-thumbnail" style="width: 40px; height: 40px; object-fit: cover;">';
                        }
                    }
                    if (count($value) > 3) {
                        $html .= '<span class="badge bg-light text-dark align-self-center">+' . (count($value) - 3) . '</span>';
                    }
                    $html .= '</div>';
                    return $html;
                }
                break;
                
            case 'select':
            case 'radio':
                $options = $field['options']['options_list'] ?? [];
                return isset($options[$value]) ? $options[$value] : $value;
                
            case 'checkbox':
                if (is_array($value)) {
                    $options = $field['options']['options_list'] ?? [];
                    $labels = array_map(function($v) use ($options) {
                        return $options[$v] ?? $v;
                    }, $value);
                    return implode(', ', $labels);
                }
                return $value ? 'Yes' : 'No';
                
            case 'date':
                return date('M j, Y', strtotime($value));
                
            case 'datetime':
                return date('M j, Y g:i A', strtotime($value));
                
            case 'wysiwyg':
                return strip_tags(substr($value, 0, 100)) . (strlen($value) > 100 ? '...' : '');
                
            case 'repeater':
                if (is_array($value)) {
                    return '<span class="badge bg-info">' . count($value) . ' items</span>';
                }
                break;
                
            default:
                return strlen($value) > 50 ? substr($value, 0, 50) . '...' : $value;
        }
        
        return $value;
    }
}