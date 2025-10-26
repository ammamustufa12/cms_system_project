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
                    <h4 class="mb-sm-0">Working Page Builder - {{ $page->title }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pages.index') }}">Pages</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pages.edit', $page) }}">{{ $page->title }}</a></li>
                            <li class="breadcrumb-item active">Working Builder</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <!-- Builder Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">
                                    <i class="ri-hammer-line me-2"></i>
                                    Working Page Builder
                                </h5>
                                <small class="text-muted">Simple and effective page building tools</small>
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
                </div>
            </div>

            <!-- Builder Content with Sidebar -->
            <div class="row">
                <!-- Left Sidebar - Components -->
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="ri-layout-2-line me-2"></i>
                                Components
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <!-- Layout Components -->
                            <div class="sidebar-section">
                                <h6 class="sidebar-title">Layout Components</h6>
                                <div class="component-item" draggable="true" data-component="container">
                                    <i class="ri-layout-2-line"></i>
                                    <div class="component-info">
                                        <h6>Container</h6>
                                        <small>Bootstrap container</small>
                                    </div>
                                </div>
                                <div class="component-item" draggable="true" data-component="row">
                                    <i class="ri-layout-row-line"></i>
                                    <div class="component-info">
                                        <h6>Row</h6>
                                        <small>Bootstrap row</small>
                                    </div>
                                </div>
                                <div class="component-item" draggable="true" data-component="column">
                                    <i class="ri-layout-column-line"></i>
                                    <div class="component-info">
                                        <h6>Column</h6>
                                        <small>Bootstrap column</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Content Components -->
                            <div class="sidebar-section">
                                <h6 class="sidebar-title">Content Components</h6>
                                <div class="component-item" draggable="true" data-component="heading">
                                    <i class="ri-h-1"></i>
                                    <div class="component-info">
                                        <h6>Heading</h6>
                                        <small>H1, H2, H3, etc.</small>
                                    </div>
                                </div>
                                <div class="component-item" draggable="true" data-component="paragraph">
                                    <i class="ri-text"></i>
                                    <div class="component-info">
                                        <h6>Paragraph</h6>
                                        <small>Text content</small>
                                    </div>
                                </div>
                                <div class="component-item" draggable="true" data-component="image">
                                    <i class="ri-image-line"></i>
                                    <div class="component-info">
                                        <h6>Image</h6>
                                        <small>Image with alt text</small>
                                    </div>
                                </div>
                                <div class="component-item" draggable="true" data-component="button">
                                    <i class="ri-button-circle-line"></i>
                                    <div class="component-info">
                                        <h6>Button</h6>
                                        <small>Call to action button</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Your Content Types -->
                            <div class="sidebar-section">
                                <h6 class="sidebar-title">Your Content Types</h6>
                                @php
                                    $contentTypes = \App\Services\ContentTypePageBuilderService::getContentTypesForPageBuilder();
                                @endphp
                                @foreach($contentTypes as $contentType)
                                    <div class="component-item content-type-item" draggable="true" 
                                         data-component="content-type" 
                                         data-content-type="{{ $contentType['slug'] }}">
                                        <i class="{{ $contentType['icon'] }}" style="color: {{ $contentType['color'] }};"></i>
                                        <div class="component-info">
                                            <h6>{{ $contentType['name'] }}</h6>
                                            <small>{{ $contentType['fields_count'] }} fields</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pre-built Sections -->
                            <div class="sidebar-section">
                                <h6 class="sidebar-title">Pre-built Sections</h6>
                                <div class="component-item" draggable="true" data-component="hero">
                                    <i class="ri-layout-3-line"></i>
                                    <div class="component-info">
                                        <h6>Hero Section</h6>
                                        <small>Landing page hero</small>
                                    </div>
                                </div>
                                <div class="component-item" draggable="true" data-component="features">
                                    <i class="ri-star-line"></i>
                                    <div class="component-info">
                                        <h6>Features</h6>
                                        <small>Feature showcase</small>
                                    </div>
                                </div>
                                <div class="component-item" draggable="true" data-component="testimonials">
                                    <i class="ri-quote-text"></i>
                                    <div class="component-info">
                                        <h6>Testimonials</h6>
                                        <small>Customer reviews</small>
                                    </div>
                                </div>
                                <div class="component-item" draggable="true" data-component="contact">
                                    <i class="ri-phone-line"></i>
                                    <div class="component-info">
                                        <h6>Contact Form</h6>
                                        <small>Contact information</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Center Canvas -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="ri-edit-line me-2"></i>
                                Page Canvas
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div id="pageBuilder" class="page-builder-canvas">
                                <div class="builder-placeholder">
                                    <i class="ri-drag-drop-line" style="font-size: 3rem; color: #6c757d;"></i>
                                    <h4>Start Building Your Page</h4>
                                    <p class="text-muted">Drag components from the left sidebar to start building</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar - Properties -->
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

    <style>
        .page-builder-canvas {
            min-height: 600px;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            background: #fafbfc;
        }

        .builder-placeholder {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .builder-placeholder i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .builder-placeholder h4 {
            margin-bottom: 10px;
            color: #495057;
        }

        .sidebar-section {
            border-bottom: 1px solid #dee2e6;
            padding: 15px;
        }

        .sidebar-section:last-child {
            border-bottom: none;
        }

        .sidebar-title {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #e9ecef;
        }

        .component-item {
            padding: 10px;
            margin: 5px 0;
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            cursor: grab;
            transition: all 0.2s;
            display: flex;
            align-items: center;
        }

        .component-item:hover {
            background: #e9ecef;
            border-color: #007bff;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .component-item:active {
            cursor: grabbing;
        }

        .component-item i {
            font-size: 16px;
            margin-right: 10px;
            color: #6c757d;
        }

        .component-item .component-info {
            flex: 1;
        }

        .component-item .component-info h6 {
            margin: 0;
            font-size: 13px;
            font-weight: 600;
            color: #495057;
        }

        .component-item .component-info small {
            color: #6c757d;
            font-size: 11px;
        }

        .content-type-item {
            border-left: 3px solid #007bff;
        }

        .builder-section {
            background: white;
            border: 2px solid transparent;
            border-radius: 8px;
            padding: 20px;
            margin: 10px 0;
            position: relative;
            transition: all 0.2s;
        }

        .builder-section:hover {
            border-color: #007bff;
            box-shadow: 0 4px 12px rgba(0,123,255,0.15);
        }

        .builder-section.selected {
            border-color: #28a745;
            box-shadow: 0 4px 12px rgba(40,167,69,0.15);
        }

        .section-actions {
            position: absolute;
            top: -10px;
            right: -10px;
            display: none;
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            padding: 4px;
        }

        .builder-section:hover .section-actions {
            display: block;
        }

        .section-actions .btn {
            padding: 4px 8px;
            font-size: 12px;
            margin: 0 2px;
        }

        .section-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 10px 15px;
            margin: -20px -20px 20px -20px;
            border-radius: 6px 6px 0 0;
            font-weight: 600;
            color: #495057;
        }

        .content-type-section {
            border-left: 4px solid #007bff;
        }

        .content-type-section .section-header {
            background: #f8f9fa;
            color: #495057;
        }

        .editable {
            outline: none;
            border: 1px solid transparent;
            padding: 5px;
            border-radius: 4px;
        }

        .editable:hover {
            border-color: #007bff;
        }

        .editable:focus {
            border-color: #28a745;
            background: rgba(40, 167, 69, 0.1);
        }

        .properties-panel h6 {
            margin-bottom: 15px;
            color: #495057;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const builder = document.getElementById('pageBuilder');
            const propertiesPanel = document.getElementById('propertiesPanel');
            const saveBtn = document.getElementById('saveBtn');
            const previewBtn = document.getElementById('previewBtn');
            let sectionCounter = 0;
            let selectedComponent = null;

            // Component templates
            const componentTemplates = {
                container: '<div class="container"><div class="row"><div class="col-12">Content goes here</div></div></div>',
                row: '<div class="row"><div class="col-12">Content goes here</div></div>',
                column: '<div class="col-12">Content goes here</div>',
                heading: '<h2>Your Heading Here</h2>',
                paragraph: '<p>Your paragraph text goes here. You can edit this content by clicking on it.</p>',
                image: '<img src="https://via.placeholder.com/400x300" alt="Image" class="img-fluid rounded">',
                button: '<button class="btn btn-primary">Click Me</button>',
                hero: `
                    <div class="hero-section text-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <div class="container">
                            <h1 class="display-4 fw-bold mb-4">Welcome to Our Website</h1>
                            <p class="lead mb-4">We provide amazing solutions for your business needs</p>
                            <button class="btn btn-light btn-lg">Get Started Today</button>
                        </div>
                    </div>
                `,
                features: `
                    <div class="py-5">
                        <div class="container">
                            <h2 class="text-center mb-5">Our Features</h2>
                            <div class="row">
                                <div class="col-md-4 text-center mb-4">
                                    <i class="ri-star-line" style="font-size: 3rem; color: #007bff;"></i>
                                    <h4>Feature 1</h4>
                                    <p>Description of your first feature</p>
                                </div>
                                <div class="col-md-4 text-center mb-4">
                                    <i class="ri-heart-line" style="font-size: 3rem; color: #28a745;"></i>
                                    <h4>Feature 2</h4>
                                    <p>Description of your second feature</p>
                                </div>
                                <div class="col-md-4 text-center mb-4">
                                    <i class="ri-shield-check-line" style="font-size: 3rem; color: #ffc107;"></i>
                                    <h4>Feature 3</h4>
                                    <p>Description of your third feature</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                testimonials: `
                    <div class="py-5" style="background: #f8f9fa;">
                        <div class="container">
                            <h2 class="text-center mb-5">What Our Customers Say</h2>
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <p class="card-text">"Amazing service! Highly recommended."</p>
                                            <h6 class="card-title">John Doe</h6>
                                            <small class="text-muted">CEO, Company Inc.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <p class="card-text">"Excellent quality and fast delivery."</p>
                                            <h6 class="card-title">Jane Smith</h6>
                                            <small class="text-muted">Manager, ABC Corp.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <p class="card-text">"Outstanding support team!"</p>
                                            <h6 class="card-title">Mike Johnson</h6>
                                            <small class="text-muted">Director, XYZ Ltd.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                contact: `
                    <div class="py-5">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h2>Get in Touch</h2>
                                    <p class="lead">We'd love to hear from you. Send us a message!</p>
                                    <div class="mb-3">
                                        <i class="ri-phone-line me-2"></i>
                                        <span>+1 (555) 123-4567</span>
                                    </div>
                                    <div class="mb-3">
                                        <i class="ri-mail-line me-2"></i>
                                        <span>info@company.com</span>
                                    </div>
                                    <div class="mb-3">
                                        <i class="ri-map-pin-line me-2"></i>
                                        <span>123 Business Street, City, State 12345</span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <form>
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" placeholder="Your name">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" placeholder="your@email.com">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Message</label>
                                            <textarea class="form-control" rows="4" placeholder="Your message"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Send Message</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            };

            // Content types data
            const contentTypes = @json(\App\Services\ContentTypePageBuilderService::getContentTypesForPageBuilder());

            // Content types data
            const contentTypes = @json(\App\Services\ContentTypePageBuilderService::getContentTypesForPageBuilder());

            // Global function to add sections
            window.addSection = function(type) {
                const template = sectionTemplates[type];
                if (template) {
                    const sectionId = 'section_' + (++sectionCounter);
                    const sectionDiv = document.createElement('div');
                    sectionDiv.className = 'builder-section';
                    sectionDiv.id = sectionId;
                    sectionDiv.innerHTML = `
                        <div class="section-actions">
                            <button class="btn btn-sm btn-outline-primary" onclick="editSection('${sectionId}')">
                                <i class="ri-edit-line"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteSection('${sectionId}')">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="moveSection('${sectionId}', 'up')">
                                <i class="ri-arrow-up-line"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="moveSection('${sectionId}', 'down')">
                                <i class="ri-arrow-down-line"></i>
                            </button>
                        </div>
                        <div class="section-header">${template.title}</div>
                        <div class="section-content editable" contenteditable="true">${template.content}</div>
                    `;
                    
                    // Remove placeholder if it exists
                    const placeholder = builder.querySelector('.builder-placeholder');
                    if (placeholder) {
                        placeholder.remove();
                    }
                    
                    builder.appendChild(sectionDiv);
                    
                    // Make content editable
                    const editableContent = sectionDiv.querySelector('.section-content');
                    editableContent.addEventListener('input', function() {
                        // Content has been edited
                    });
                }
            };

            // Global function to add content types
            window.addContentType = function(contentTypeSlug) {
                const contentType = contentTypes.find(ct => ct.slug === contentTypeSlug);
                if (contentType) {
                    const sectionId = 'section_' + (++sectionCounter);
                    const sectionDiv = document.createElement('div');
                    sectionDiv.className = 'builder-section content-type-section';
                    sectionDiv.id = sectionId;
                    sectionDiv.innerHTML = `
                        <div class="section-actions">
                            <button class="btn btn-sm btn-outline-primary" onclick="editSection('${sectionId}')">
                                <i class="ri-edit-line"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteSection('${sectionId}')">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="moveSection('${sectionId}', 'up')">
                                <i class="ri-arrow-up-line"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="moveSection('${sectionId}', 'down')">
                                <i class="ri-arrow-down-line"></i>
                            </button>
                        </div>
                        <div class="section-header">
                            <i class="${contentType.icon} me-2" style="color: ${contentType.color};"></i>
                            ${contentType.name} (${contentType.fields_count} fields)
                        </div>
                        <div class="section-content editable" contenteditable="true">${contentType.component_html}</div>
                    `;
                    
                    // Remove placeholder if it exists
                    const placeholder = builder.querySelector('.builder-placeholder');
                    if (placeholder) {
                        placeholder.remove();
                    }
                    
                    builder.appendChild(sectionDiv);
                    
                    // Make content editable
                    const editableContent = sectionDiv.querySelector('.section-content');
                    editableContent.addEventListener('input', function() {
                        // Content has been edited
                    });
                }
            };

            // Global functions for section actions
            window.editSection = function(sectionId) {
                const section = document.getElementById(sectionId);
                const content = section.querySelector('.section-content');
                content.focus();
            };

            window.deleteSection = function(sectionId) {
                const section = document.getElementById(sectionId);
                section.remove();
                
                // Show placeholder if no sections left
                if (builder.children.length === 0) {
                    builder.innerHTML = `
                        <div class="builder-placeholder">
                            <i class="ri-hammer-line" style="font-size: 3rem; color: #6c757d;"></i>
                            <p class="text-muted mt-2">Click "Add Section" buttons above to start building</p>
                        </div>
                    `;
                }
            };

            window.moveSection = function(sectionId, direction) {
                const section = document.getElementById(sectionId);
                if (direction === 'up' && section.previousElementSibling) {
                    section.parentNode.insertBefore(section, section.previousElementSibling);
                } else if (direction === 'down' && section.nextElementSibling) {
                    section.parentNode.insertBefore(section.nextElementSibling, section);
                }
            };

            // Save functionality
            saveBtn.addEventListener('click', function() {
                const content = builder.innerHTML;
                
                fetch(`{{ route('pages.save-builder-content', $page) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        builder_content: content,
                        builder_type: 'working',
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
                const content = builder.innerHTML;
                const previewWindow = window.open('', '_blank');
                previewWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Preview - {{ $page->title }}</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    </head>
                    <body>
                        ${content}
                    </body>
                    </html>
                `);
            });
        });
    </script>
@endsection
