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
        
        .field-type-card {
            padding: 15px;
            margin: 10px;
            background: #fff;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .field-type-card:hover {
            border-color: #007bff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,123,255,0.15);
        }
        
        .field-type-card.selected {
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
        
        .preview-field {
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
    </style>
@endpush

@section('content')
<div class="designer-container">
    <!-- Left Sidebar - Field Types -->
    <div class="designer-sidebar">
        <div class="p-3">
            <h5 class="mb-3">
                <i class="ri-palette-line me-2"></i>
                Field Type Designer
            </h5>
            
            <div class="section-title">Choose Field Type</div>
            @foreach($fieldTypes as $typeKey => $fieldType)
                <div class="field-type-card" data-field-type="{{ $typeKey }}">
                    <div class="d-flex align-items-center">
                        <span class="me-3" style="font-size: 24px;">{{ $fieldType['icon'] ?? '📝' }}</span>
                        <div>
                            <h6 class="mb-1">{{ $fieldType['label'] }}</h6>
                            <small class="text-muted">{{ $fieldType['description'] }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Center Canvas - Preview -->
    <div class="designer-canvas">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Field Preview</h4>
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
                <i class="ri-palette-line" style="font-size: 3rem; opacity: 0.5;"></i>
                <h5 class="mt-3">Select a field type to start designing</h5>
                <p>Choose a field type from the left sidebar to see design options</p>
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
                    <p class="mt-2">Select a field type to see design options</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fieldTypeCards = document.querySelectorAll('.field-type-card');
    const previewArea = document.getElementById('previewArea');
    const designOptions = document.getElementById('designOptions');
    const saveBtn = document.getElementById('saveBtn');
    const previewBtn = document.getElementById('previewBtn');
    
    let selectedFieldType = null;
    let currentDesign = {
        layout: 'single_column',
        style: 'default',
        size: 'medium',
        animation: 'none'
    };

    // Field type selection
    fieldTypeCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove previous selection
            fieldTypeCards.forEach(c => c.classList.remove('selected'));
            
            // Select current card
            this.classList.add('selected');
            selectedFieldType = this.dataset.fieldType;
            
            // Update design options
            updateDesignOptions();
            
            // Update preview
            updatePreview();
        });
    });

    function updateDesignOptions() {
        if (!selectedFieldType) return;
        
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
            
            <div class="section-title">Size</div>
            ${Object.entries(@json($designOptions['sizes'])).map(([key, option]) => `
                <div class="design-option ${currentDesign.size === key ? 'selected' : ''}" data-option="size" data-value="${key}">
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
        if (!selectedFieldType) return;
        
        const fieldType = @json($fieldTypes)[selectedFieldType];
        const sampleField = {
            name: 'Sample Field',
            type: selectedFieldType,
            required: true,
            description: 'This is a sample field for preview',
            options: fieldType.options || {}
        };
        
        // Generate preview HTML using FieldDesignService
        fetch('{{ route("content-types.field-designer") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                field_type: selectedFieldType,
                design: currentDesign,
                action: 'preview'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                previewArea.innerHTML = `
                    <div class="preview-field">
                        <h6 class="mb-3">Preview:</h6>
                        ${data.preview_html}
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Fallback preview
            previewArea.innerHTML = `
                <div class="preview-field">
                    <h6 class="mb-3">Preview:</h6>
                    <div class="field-wrapper">
                        <label class="field-label">Sample Field <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Enter sample field">
                        <div class="field-description">This is a sample field for preview</div>
                    </div>
                </div>
            `;
        });
    }

    // Save design
    saveBtn.addEventListener('click', function() {
        if (!selectedFieldType) {
            alert('Please select a field type first');
            return;
        }
        
        fetch('{{ route("content-types.save-field-design") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                field_type: selectedFieldType,
                design: currentDesign,
                preview_html: previewArea.innerHTML
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Field design saved successfully!');
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
        if (!selectedFieldType) {
            alert('Please select a field type first');
            return;
        }
        
        const previewWindow = window.open('', '_blank');
        previewWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Field Preview</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>${@json(\App\Services\FieldDesignService::getFieldDesignCSS())}</style>
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
