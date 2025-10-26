@extends('twill::layouts.main')

@section('appTypeClass', 'body--form')

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="page-content">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Advanced Page Builder - {{ $page->title }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pages.index') }}">Pages</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pages.edit', $page) }}">{{ $page->title }}</a></li>
                            <li class="breadcrumb-item active">Advanced Builder</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Builder Header -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">
                                    <i class="ri-code-s-slash-line me-2"></i>
                                    Advanced Page Builder
                                </h5>
                                <small class="text-muted">Build your page with advanced drag-and-drop components</small>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-primary" id="previewBtn">
                                    <i class="ri-eye-line me-1"></i>Preview
                                </button>
                                <button type="button" class="btn btn-outline-success" id="saveBtn">
                                    <i class="ri-save-line me-1"></i>Save
                                </button>
                                <a href="{{ route('pages.edit', $page) }}" class="btn btn-outline-secondary">
                                    <i class="ri-arrow-left-line me-1"></i>Back to Edit
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Builder Interface -->
                    <div class="row">
                        <!-- Components Panel -->
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-layout-2-line me-2"></i>
                                        Components
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="components-panel">
                                        <div class="component-category mb-3">
                                            <h6 class="text-muted mb-2">Layout</h6>
                                            <div class="component-list">
                                                <div class="component-item" draggable="true" data-component="container">
                                                    <i class="ri-layout-2-line me-2"></i>Container
                                                </div>
                                                <div class="component-item" draggable="true" data-component="row">
                                                    <i class="ri-layout-row-line me-2"></i>Row
                                                </div>
                                                <div class="component-item" draggable="true" data-component="column">
                                                    <i class="ri-layout-column-line me-2"></i>Column
                                                </div>
                                            </div>
                                        </div>

                                        <div class="component-category mb-3">
                                            <h6 class="text-muted mb-2">Content</h6>
                                            <div class="component-list">
                                                <div class="component-item" draggable="true" data-component="text">
                                                    <i class="ri-text me-2"></i>Text
                                                </div>
                                                <div class="component-item" draggable="true" data-component="heading">
                                                    <i class="ri-h-1 me-2"></i>Heading
                                                </div>
                                                <div class="component-item" draggable="true" data-component="paragraph">
                                                    <i class="ri-paragraph me-2"></i>Paragraph
                                                </div>
                                                <div class="component-item" draggable="true" data-component="image">
                                                    <i class="ri-image-line me-2"></i>Image
                                                </div>
                                                <div class="component-item" draggable="true" data-component="button">
                                                    <i class="ri-button-circle-line me-2"></i>Button
                                                </div>
                                            </div>
                                        </div>

                                        <div class="component-category mb-3">
                                            <h6 class="text-muted mb-2">Forms</h6>
                                            <div class="component-list">
                                                <div class="component-item" draggable="true" data-component="form">
                                                    <i class="ri-form me-2"></i>Form
                                                </div>
                                                <div class="component-item" draggable="true" data-component="input">
                                                    <i class="ri-input-cursor-line me-2"></i>Input
                                                </div>
                                                <div class="component-item" draggable="true" data-component="textarea">
                                                    <i class="ri-textarea me-2"></i>Textarea
                                                </div>
                                                <div class="component-item" draggable="true" data-component="select">
                                                    <i class="ri-list-check me-2"></i>Select
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Content Types Section -->
                                        <div class="component-category mb-3">
                                            <h6 class="text-muted mb-2">Content Types</h6>
                                            <div class="component-list" id="contentTypesList">
                                                @php
                                                    $contentTypes = \App\Services\ContentTypePageBuilderService::getContentTypesForPageBuilder();
                                                @endphp
                                                @foreach($contentTypes as $contentType)
                                                    <div class="component-item content-type-item" draggable="true" 
                                                         data-component="content-type" 
                                                         data-content-type="{{ $contentType['slug'] }}"
                                                         data-content-type-name="{{ $contentType['name'] }}">
                                                        <i class="{{ $contentType['icon'] }} me-2" style="color: {{ $contentType['color'] }};"></i>
                                                        {{ $contentType['name'] }}
                                                        <small class="d-block text-muted">{{ $contentType['fields_count'] }} fields</small>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Canvas Area -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-drag-drop-line me-2"></i>
                                        Canvas
                                    </h6>
                                </div>
                                <div class="card-body p-0">
                                    <div id="builderCanvas" class="builder-canvas">
                                        <div class="canvas-placeholder">
                                            <i class="ri-drag-drop-line" style="font-size: 3rem; color: #6c757d;"></i>
                                            <p class="text-muted mt-2">Drag components here to start building</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Properties Panel -->
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-settings-3-line me-2"></i>
                                        Properties
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div id="propertiesPanel">
                                        <div class="text-center text-muted">
                                            <i class="ri-cursor-line" style="font-size: 2rem;"></i>
                                            <p class="mt-2">Select a component to edit properties</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .builder-canvas {
            min-height: 500px;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            background: #f8f9fa;
        }

        .canvas-placeholder {
            text-align: center;
            padding: 50px 20px;
        }

        .component-item {
            padding: 10px;
            margin: 5px 0;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            cursor: grab;
            transition: all 0.2s;
        }

        .component-item:hover {
            background: #e9ecef;
            border-color: #007bff;
        }

        .component-item:active {
            cursor: grabbing;
        }

        .builder-component {
            border: 2px solid transparent;
            padding: 10px;
            margin: 5px 0;
            border-radius: 6px;
            position: relative;
            min-height: 40px;
        }

        .builder-component:hover {
            border-color: #007bff;
        }

        .builder-component.selected {
            border-color: #28a745;
            background: rgba(40, 167, 69, 0.1);
        }

        .component-actions {
            position: absolute;
            top: -10px;
            right: -10px;
            display: none;
        }

        .builder-component:hover .component-actions {
            display: block;
        }

        .component-actions .btn {
            padding: 2px 6px;
            font-size: 0.75rem;
        }

        .content-type-item {
            border-left: 3px solid #007bff;
        }

        .content-type-component {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin: 10px 0;
            background: #f8f9fa;
        }

        .content-type-component .component-header {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .content-type-component .component-header h4 {
            margin: 0;
            color: #495057;
        }

        .content-type-component .component-actions {
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
            margin-top: 15px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('builderCanvas');
            const propertiesPanel = document.getElementById('propertiesPanel');
            const saveBtn = document.getElementById('saveBtn');
            const previewBtn = document.getElementById('previewBtn');
            let selectedComponent = null;
            let componentCounter = 0;

            // Component templates
            const componentTemplates = {
                container: '<div class="container"><div class="row"><div class="col-12">Content goes here</div></div></div>',
                row: '<div class="row"><div class="col-12">Content goes here</div></div>',
                column: '<div class="col-12">Content goes here</div>',
                text: '<p>Your text here</p>',
                heading: '<h2>Your heading here</h2>',
                paragraph: '<p>Your paragraph here</p>',
                image: '<img src="https://via.placeholder.com/300x200" alt="Image" class="img-fluid">',
                button: '<button class="btn btn-primary">Click me</button>',
                form: '<form><div class="mb-3"><label class="form-label">Label</label><input type="text" class="form-control"></div></form>',
                input: '<input type="text" class="form-control" placeholder="Enter text">',
                textarea: '<textarea class="form-control" rows="3" placeholder="Enter text"></textarea>',
                select: '<select class="form-select"><option>Select option</option></select>',
                'content-type': 'Loading content type...'
            };

            // Content types data
            const contentTypes = @json(\App\Services\ContentTypePageBuilderService::getContentTypesForPageBuilder());

            // Drag and drop functionality
            document.querySelectorAll('.component-item').forEach(item => {
                item.addEventListener('dragstart', function(e) {
                    const component = this.dataset.component;
                    const contentType = this.dataset.contentType;
                    
                    if (component === 'content-type' && contentType) {
                        e.dataTransfer.setData('text/plain', component + ':' + contentType);
                    } else {
                        e.dataTransfer.setData('text/plain', component);
                    }
                });
            });

            canvas.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = '#007bff';
            });

            canvas.addEventListener('dragleave', function(e) {
                this.style.borderColor = '#dee2e6';
            });

            canvas.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = '#dee2e6';
                
                const data = e.dataTransfer.getData('text/plain');
                const parts = data.split(':');
                const componentType = parts[0];
                const contentTypeSlug = parts[1];
                
                addComponent(componentType, contentTypeSlug);
            });

            function addComponent(type, contentTypeSlug = null) {
                const componentId = 'component_' + (++componentCounter);
                let template = componentTemplates[type];
                
                // Handle content type components
                if (type === 'content-type' && contentTypeSlug) {
                    const contentType = contentTypes.find(ct => ct.slug === contentTypeSlug);
                    if (contentType) {
                        template = contentType.component_html;
                    }
                }
                
                if (template) {
                    const componentDiv = document.createElement('div');
                    componentDiv.className = 'builder-component';
                    componentDiv.id = componentId;
                    componentDiv.dataset.type = type;
                    if (contentTypeSlug) {
                        componentDiv.dataset.contentType = contentTypeSlug;
                    }
                    componentDiv.innerHTML = `
                        <div class="component-actions">
                            <button class="btn btn-sm btn-outline-primary" onclick="editComponent('${componentId}')">
                                <i class="ri-edit-line"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteComponent('${componentId}')">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </div>
                        ${template}
                    `;
                    
                    // Remove placeholder if it exists
                    const placeholder = canvas.querySelector('.canvas-placeholder');
                    if (placeholder) {
                        placeholder.remove();
                    }
                    
                    canvas.appendChild(componentDiv);
                    
                    // Add click handler for selection
                    componentDiv.addEventListener('click', function(e) {
                        e.stopPropagation();
                        selectComponent(this);
                    });
                }
            }

            function selectComponent(component) {
                // Remove previous selection
                document.querySelectorAll('.builder-component').forEach(comp => {
                    comp.classList.remove('selected');
                });
                
                // Select current component
                component.classList.add('selected');
                selectedComponent = component;
                
                // Update properties panel
                updatePropertiesPanel(component);
            }

            function updatePropertiesPanel(component) {
                const type = component.dataset.type;
                let propertiesHtml = `
                    <h6>${type.charAt(0).toUpperCase() + type.slice(1)} Properties</h6>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea class="form-control" id="componentContent" rows="3">${component.innerHTML.replace(/<div class="component-actions">.*?<\/div>/s, '')}</textarea>
                    </div>
                `;
                
                if (type === 'image') {
                    propertiesHtml += `
                        <div class="mb-3">
                            <label class="form-label">Image URL</label>
                            <input type="url" class="form-control" id="imageUrl" placeholder="https://example.com/image.jpg">
                        </div>
                    `;
                }
                
                if (type === 'button') {
                    propertiesHtml += `
                        <div class="mb-3">
                            <label class="form-label">Button Text</label>
                            <input type="text" class="form-control" id="buttonText" placeholder="Button text">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Button Class</label>
                            <select class="form-select" id="buttonClass">
                                <option value="btn-primary">Primary</option>
                                <option value="btn-secondary">Secondary</option>
                                <option value="btn-success">Success</option>
                                <option value="btn-danger">Danger</option>
                                <option value="btn-warning">Warning</option>
                                <option value="btn-info">Info</option>
                            </select>
                        </div>
                    `;
                }
                
                propertiesPanel.innerHTML = propertiesHtml;
                
                // Add event listeners for property changes
                const contentTextarea = propertiesPanel.querySelector('#componentContent');
                if (contentTextarea) {
                    contentTextarea.addEventListener('input', function() {
                        updateComponentContent(component, this.value);
                    });
                }
            }

            function updateComponentContent(component, content) {
                const actionsDiv = component.querySelector('.component-actions');
                component.innerHTML = actionsDiv.outerHTML + content;
                
                // Re-add click handler
                component.addEventListener('click', function(e) {
                    e.stopPropagation();
                    selectComponent(this);
                });
            }

            // Global functions for component actions
            window.editComponent = function(componentId) {
                const component = document.getElementById(componentId);
                selectComponent(component);
            };

            window.deleteComponent = function(componentId) {
                const component = document.getElementById(componentId);
                component.remove();
                
                // Show placeholder if no components left
                if (canvas.children.length === 0) {
                    canvas.innerHTML = `
                        <div class="canvas-placeholder">
                            <i class="ri-drag-drop-line" style="font-size: 3rem; color: #6c757d;"></i>
                            <p class="text-muted mt-2">Drag components here to start building</p>
                        </div>
                    `;
                }
            };

            // Save functionality
            saveBtn.addEventListener('click', function() {
                const content = canvas.innerHTML;
                
                fetch(`{{ route('pages.save-builder-content', $page) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        builder_content: content,
                        builder_type: 'advanced',
                        css_content: '',
                        js_content: ''
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Page saved successfully!');
                    } else {
                        alert('Error saving page: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error saving page');
                });
            });

            // Preview functionality
            previewBtn.addEventListener('click', function() {
                const content = canvas.innerHTML;
                const previewWindow = window.open('', '_blank');
                previewWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Preview - {{ $page->title }}</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    </head>
                    <body>
                        <div class="container mt-4">
                            ${content}
                        </div>
                    </body>
                    </html>
                `);
            });

            // Click outside to deselect
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.builder-component')) {
                    document.querySelectorAll('.builder-component').forEach(comp => {
                        comp.classList.remove('selected');
                    });
                    selectedComponent = null;
                    propertiesPanel.innerHTML = `
                        <div class="text-center text-muted">
                            <i class="ri-cursor-line" style="font-size: 2rem;"></i>
                            <p class="mt-2">Select a component to edit properties</p>
                        </div>
                    `;
                }
            });
        });
    </script>
@endsection
