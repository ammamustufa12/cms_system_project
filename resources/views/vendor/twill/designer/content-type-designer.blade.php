@extends('twill::layouts.main')

@section('appTypeClass', 'body--form')

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .designer-container {
            display: flex;
            height: 100vh;
            background: #f8f9fa;
        }
        
        .designer-sidebar {
            width: 350px;
            background: #fff;
            border-right: 1px solid #dee2e6;
            overflow-y: auto;
        }
        
        .designer-canvas {
            flex: 1;
            background: #fff;
            overflow-y: auto;
            padding: 20px;
        }
        
        .designer-properties {
            width: 300px;
            background: #fff;
            border-left: 1px solid #dee2e6;
            overflow-y: auto;
        }
        
        .content-type-card {
            padding: 15px;
            margin: 10px;
            background: #fff;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .content-type-card:hover {
            border-color: #007bff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,123,255,0.15);
        }
        
        .content-type-card.selected {
            border-color: #28a745;
            background: rgba(40, 167, 69, 0.1);
        }
        
        .design-option {
            padding: 10px;
            margin: 5px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .design-option:hover {
            background: #e9ecef;
            border-color: #007bff;
        }
        
        .design-option.selected {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }
        
        .preview-area {
            min-height: 400px;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 30px;
            background: #fafbfc;
        }
        
        .preview-content-type {
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 20px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .field-preview {
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 6px;
        }
    </style>
@endpush

@section('content')
<div class="designer-container">
    <!-- Left Sidebar - Content Types -->
    <div class="designer-sidebar">
        <div class="p-3">
            <h5 class="mb-3">
                <i class="ri-layout-line me-2"></i>
                Content Type Designer
            </h5>
            
            <div class="section-title">Choose Content Type</div>
            @foreach($contentTypes as $contentType)
                <div class="content-type-card" data-content-type-id="{{ $contentType->id }}">
                    <div class="d-flex align-items-center">
                        <span class="me-3" style="font-size: 24px;">{{ $contentType->icon ?? '📄' }}</span>
                        <div>
                            <h6 class="mb-1">{{ $contentType->name }}</h6>
                            <small class="text-muted">{{ $contentType->description }}</small>
                            <br>
                            <small class="text-info">{{ count(is_array($contentType->fields_schema) ? $contentType->fields_schema : json_decode($contentType->fields_schema, true) ?? []) }} fields</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Center Canvas - Preview -->
    <div class="designer-canvas">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Content Type Preview</h4>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-primary" id="previewBtn">
                    <i class="ri-eye-line me-1"></i>Preview
                </button>
                <button type="button" class="btn btn-success" id="saveBtn">
                    <i class="ri-save-line me-1"></i>Save Design
                </button>
            </div>
        </div>
        
        <div class="preview-area" id="previewArea">
            <div class="text-center text-muted">
                <i class="ri-layout-line" style="font-size: 3rem; opacity: 0.5;"></i>
                <h5 class="mt-3">Select a content type to start designing</h5>
                <p>Choose a content type from the left sidebar to see design options</p>
            </div>
        </div>
    </div>

    <!-- Right Sidebar - Design Options -->
    <div class="designer-properties">
        <div class="p-3">
            <h6 class="mb-3">
                <i class="ri-settings-3-line me-2"></i>
                Design Options
            </h6>
            
            <div id="designOptions">
                <div class="text-center text-muted">
                    <i class="ri-cursor-line" style="font-size: 2rem;"></i>
                    <p class="mt-2">Select a content type to see design options</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contentTypeCards = document.querySelectorAll('.content-type-card');
    const previewArea = document.getElementById('previewArea');
    const designOptions = document.getElementById('designOptions');
    const saveBtn = document.getElementById('saveBtn');
    const previewBtn = document.getElementById('previewBtn');
    
    let selectedContentType = null;
    let currentDesign = {
        layout: 'single_column',
        style: 'default',
        theme: 'light',
        spacing: 'medium',
        animation: 'none'
    };

    // Content type selection
    contentTypeCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove previous selection
            contentTypeCards.forEach(c => c.classList.remove('selected'));
            
            // Select current card
            this.classList.add('selected');
            selectedContentType = this.dataset.contentTypeId;
            
            // Update design options
            updateDesignOptions();
            
            // Update preview
            updatePreview();
        });
    });

    function updateDesignOptions() {
        if (!selectedContentType) return;
        
        const designOptionsHtml = `
            <div class="section-title">Layout</div>
            ${Object.entries(@json($designOptions['layouts'])).map(([key, option]) => `
                <div class="design-option ${currentDesign.layout === key ? 'selected' : ''}" data-option="layout" data-value="${key}">
                    <i class="${option.icon} me-2"></i>
                    <strong>${option.name}</strong>
                    <br><small>${option.description}</small>
                </div>
            `).join('')}
            
            <div class="section-title">Style</div>
            ${Object.entries(@json($designOptions['styles'])).map(([key, option]) => `
                <div class="design-option ${currentDesign.style === key ? 'selected' : ''}" data-option="style" data-value="${key}">
                    <strong>${option.name}</strong>
                    <br><small>${option.description}</small>
                </div>
            `).join('')}
            
            <div class="section-title">Theme</div>
            ${Object.entries(@json($designOptions['themes'])).map(([key, option]) => `
                <div class="design-option ${currentDesign.theme === key ? 'selected' : ''}" data-option="theme" data-value="${key}">
                    <strong>${option.name}</strong>
                </div>
            `).join('')}
            
            <div class="section-title">Spacing</div>
            ${Object.entries(@json($designOptions['spacings'])).map(([key, option]) => `
                <div class="design-option ${currentDesign.spacing === key ? 'selected' : ''}" data-option="spacing" data-value="${key}">
                    <strong>${option.name}</strong>
                </div>
            `).join('')}
            
            <div class="section-title">Animation</div>
            ${Object.entries(@json($designOptions['animations'])).map(([key, option]) => `
                <div class="design-option ${currentDesign.animation === key ? 'selected' : ''}" data-option="animation" data-value="${key}">
                    <strong>${option.name}</strong>
                </div>
            `).join('')}
        `;
        
        designOptions.innerHTML = designOptionsHtml;
        
        // Add click handlers for design options
        designOptions.querySelectorAll('.design-option').forEach(option => {
            option.addEventListener('click', function() {
                const optionType = this.dataset.option;
                const optionValue = this.dataset.value;
                
                // Remove previous selection
                designOptions.querySelectorAll(`[data-option="${optionType}"]`).forEach(opt => {
                    opt.classList.remove('selected');
                });
                
                // Select current option
                this.classList.add('selected');
                
                // Update design
                currentDesign[optionType] = optionValue;
                
                // Update preview
                updatePreview();
            });
        });
    }

    function updatePreview() {
        if (!selectedContentType) return;
        
        // Get content type data
        const contentTypeData = @json($contentTypes->keyBy('id'));
        const contentType = contentTypeData[selectedContentType];
        
        if (!contentType) return;
        
        // Generate preview HTML
        const fieldsSchema = contentType.fields_schema ? 
            (Array.isArray(contentType.fields_schema) ? contentType.fields_schema : JSON.parse(contentType.fields_schema)) : 
            [];
        
        let previewHtml = `
            <div class="preview-content-type">
                <h6 class="mb-3">${contentType.name} Preview:</h6>
                <div class="content-type-form">
        `;
        
        // Add fields preview
        Object.entries(fieldsSchema).forEach(([fieldKey, field]) => {
            const fieldName = field.name || field.label || fieldKey;
            const fieldType = field.type || 'text';
            const isRequired = field.required || false;
            const description = field.description || '';
            
            previewHtml += `
                <div class="field-preview">
                    <label class="form-label">
                        ${fieldName} ${isRequired ? '<span class="text-danger">*</span>' : ''}
                    </label>
                    ${getFieldPreviewHtml(fieldType, field)}
                    ${description ? `<div class="form-text">${description}</div>` : ''}
                </div>
            `;
        });
        
        previewHtml += `
                </div>
            </div>
        `;
        
        previewArea.innerHTML = previewHtml;
    }

    function getFieldPreviewHtml(fieldType, field) {
        const options = field.options || {};
        
        switch(fieldType) {
            case 'text':
                return `<input type="text" class="form-control" placeholder="${options.placeholder || 'Enter text'}">`;
            case 'email':
                return `<input type="email" class="form-control" placeholder="${options.placeholder || 'Enter email'}">`;
            case 'textarea':
                return `<textarea class="form-control" rows="3" placeholder="${options.placeholder || 'Enter text'}"></textarea>`;
            case 'select':
                const selectOptions = options.choices || [];
                return `
                    <select class="form-select">
                        <option value="">Select an option</option>
                        ${selectOptions.map(option => `<option value="${option.value}">${option.label}</option>`).join('')}
                    </select>
                `;
            case 'checkbox':
                return `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="preview_${field.name}">
                        <label class="form-check-label" for="preview_${field.name}">
                            ${options.label || 'Check this option'}
                        </label>
                    </div>
                `;
            case 'radio':
                const radioOptions = options.choices || [];
                return radioOptions.map((option, index) => `
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="preview_${field.name}" id="preview_${field.name}_${index}">
                        <label class="form-check-label" for="preview_${field.name}_${index}">
                            ${option.label}
                        </label>
                    </div>
                `).join('');
            case 'number':
                return `<input type="number" class="form-control" placeholder="${options.placeholder || 'Enter number'}">`;
            case 'date':
                return `<input type="date" class="form-control">`;
            case 'file':
                return `<input type="file" class="form-control">`;
            default:
                return `<input type="text" class="form-control" placeholder="Enter ${fieldType}">`;
        }
    }

    // Save design
    saveBtn.addEventListener('click', function() {
        if (!selectedContentType) {
            alert('Please select a content type first');
            return;
        }
        
        fetch('{{ route("content-types.save-content-type-design") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                content_type_id: selectedContentType,
                design: currentDesign,
                preview_html: previewArea.innerHTML
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Content type design saved successfully!');
            } else {
                alert('Error saving design: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving design');
        });
    });

    // Preview button
    previewBtn.addEventListener('click', function() {
        if (!selectedContentType) {
            alert('Please select a content type first');
            return;
        }
        
        const previewWindow = window.open('', '_blank');
        previewWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Content Type Preview</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>${@json(\App\Services\FieldDesignService::getContentTypeDesignCSS())}</style>
            </head>
            <body>
                <div class="container mt-4">
                    ${previewArea.innerHTML}
                </div>
            </body>
            </html>
        `);
    });
});
</script>
@endsection
