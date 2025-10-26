@extends('twill::layouts.main')

@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1>Layout Builder: {{ $contentType->name }}</h1>
                <p class="text-muted">Design how your content will be displayed using drag & drop</p>
            </div>
            <div>
                <a href="{{ route('content-types.manage-fields', $contentType->slug) }}" class="btn btn-secondary">
                    <i class="ri-arrow-left-line"></i> Back to Fields
                </a>
            </div>
        </div>

        <!-- Layout Builder Interface -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Visual Layout Designer</h5>
                            <div class="btn-toolbar">
                                <div class="btn-group me-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary active" id="desktop-view">
                                        <i class="ri-computer-line"></i> Desktop
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="tablet-view">
                                        <i class="ri-tablet-line"></i> Tablet
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="mobile-view">
                                        <i class="ri-smartphone-line"></i> Mobile
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-success" id="save-layout">
                                        <i class="ri-save-line"></i> Save Layout
                                    </button>
                                    <button type="button" class="btn btn-sm btn-info" id="preview-layout">
                                        <i class="ri-eye-line"></i> Preview
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <!-- GrapesJS Editor Container -->
                        <div id="gjs" style="height: 70vh;">
                            <!-- Default content -->
                            <div class="container mt-4">
                                <h1>@{{title}}</h1>
                                <p>Start designing your layout by dragging content fields from the left panel.</p>
                                <div class="row">
                                    <div class="col-md-8">
                                        <p>Main content area - drag your fields here</p>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="sidebar">
                                            <p>Sidebar area</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Template Management Modal -->
        <div class="modal fade" id="saveTemplateModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Save Layout Template</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="saveTemplateForm">
                            <div class="mb-3">
                                <label for="templateName" class="form-label">Template Name</label>
                                <input type="text" class="form-control" id="templateName" name="layout_name"
                                    placeholder="e.g., Default Layout, Blog Post, Product Page" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Preview</label>
                                <div id="templatePreview" class="border rounded p-3 bg-light"
                                    style="max-height: 200px; overflow-y: auto;">
                                    <small class="text-muted">Template preview will appear here...</small>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmSaveTemplate">Save Template</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Modal -->
        <div class="modal fade" id="previewModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Layout Preview with Sample Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0">
                        <iframe id="previewFrame" style="width: 100%; height: 600px; border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('extra_css')
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    <style>
        /* Custom styles for better Twill integration */
        .gjs-pn-views-container {
            border-right: 1px solid #dee2e6;
        }

        .gjs-pn-panels {
            border-bottom: 1px solid #dee2e6;
        }

        .gjs-block {
            border-radius: 6px;
            margin-bottom: 8px;
            border: 1px solid #e3e6f0;
        }

        .gjs-block:hover {
            border-color: #5777ba;
        }

        .content-field {
            border: 2px dashed #5777ba;
            padding: 15px;
            margin: 10px 0;
            border-radius: 6px;
            background: #f8f9fa;
        }

        .field-wrapper {
            margin-bottom: 1rem;
        }

        .field-wrapper label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            display: block;
        }

        .field-value,
        .field-content {
            color: #6c757d;
            font-style: italic;
        }

        .field-image {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 10px;
        }

        .gallery-item {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }

        /* Device preview styles */
        .gjs-cv-canvas[data-device="tablet"] {
            width: 768px;
        }

        .gjs-cv-canvas[data-device="mobile"] {
            width: 320px;
        }
    </style>
@endpush

@push('extra_js')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- GrapesJS Core -->
    <script src="https://unpkg.com/grapesjs"></script>
    <script src="https://unpkg.com/grapesjs-blocks-basic"></script>

    <script>
        // Variables from PHP
        const contentTypeSlug = @json($contentType->slug);
        const fieldsSchema = @json($fieldsSchema ?? []);
        const sampleData = @json($sampleData ?? []);
        
        // Debug info
        console.log('🚀 Layout Builder Loaded');
        console.log('Content Type:', contentTypeSlug);
        console.log('Fields Schema:', fieldsSchema);
        console.log('Sample Data:', sampleData);

        let editor;

        document.addEventListener('DOMContentLoaded', function() {
            console.log('🔄 Initializing GrapesJS...');
            
            try {
                // Initialize GrapesJS
                editor = grapesjs.init({
                    container: '#gjs',
                    fromElement: true,
                    height: '100vh',
                    width: 'auto',

                    // Storage configuration
                    storageManager: {
                        type: 'local',
                        autosave: true,
                        autoload: true,
                        stepsBeforeSave: 1,
                        options: {
                            local: {
                                key: `gjs-${contentTypeSlug}-layout`
                            }
                        }
                    },

                    // Device manager
                    deviceManager: {
                        devices: [{
                                name: 'Desktop',
                                width: '',
                            },
                            {
                                name: 'Tablet',
                                width: '768px',
                                widthMedia: '992px',
                            },
                            {
                                name: 'Mobile',
                                width: '320px',
                                widthMedia: '768px',
                            }
                        ]
                    },

                    // Plugins
                    plugins: ['gjs-blocks-basic'],
                    pluginsOpts: {
                        'gjs-blocks-basic': {
                            flexGrid: true,
                            stylePrefix: 'gjs-',
                            addBasicStyle: true
                        }
                    },

                    // Canvas
                    canvas: {
                        styles: [
                            'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css'
                        ]
                    },

                    // Asset Manager
                    assetManager: {
                        embedAsBase64: false,
                        assets: [
                            'https://picsum.photos/350/250/?random=1',
                            'https://picsum.photos/350/250/?random=2',
                            'https://picsum.photos/350/250/?random=3',
                        ]
                    }
                });

                console.log('✅ GrapesJS initialized successfully');

                // Load content field blocks after editor is initialized
                editor.on('load', function() {
                    console.log('📡 Editor loaded, loading field blocks...');
                    loadContentFieldBlocks();
                });

                // Add custom CSS for field styling
                editor.on('load', function() {
                    const css = `
                        .field-wrapper {
                            margin-bottom: 1.5rem;
                            padding: 1rem;
                            border-left: 4px solid #0d6efd;
                            background: #f8f9fa;
                            border-radius: 0 0.375rem 0.375rem 0;
                            transition: all 0.2s ease;
                        }
                        
                        .field-wrapper:hover {
                            background: #e3f2fd;
                            border-left-color: #2196f3;
                            transform: translateX(2px);
                        }
                        
                        .field-label {
                            font-weight: 600;
                            color: #495057;
                            margin-bottom: 0.5rem;
                            display: block;
                            font-size: 0.875rem;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                        }
                        
                        .field-value, .field-content {
                            color: #212529;
                            margin: 0;
                            font-style: italic;
                        }
                        
                        .field-image {
                            max-width: 100%;
                            height: auto;
                            border-radius: 0.375rem;
                            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                        }
                    `;
                    
                    editor.CssComposer.addRules(css);
                });

                // Setup commands and event listeners
                setupCommands();
                setupEventListeners();

            } catch (error) {
                console.error('❌ Error initializing GrapesJS:', error);
                showAlert('error', 'Failed to initialize page builder: ' + error.message);
            }
        });

        function loadContentFieldBlocks() {
            console.log('📡 Loading field blocks for:', contentTypeSlug);

            fetch(`/admin/content-types/${contentTypeSlug}/field-blocks`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            })
            .then(response => {
                console.log('📡 API Response Status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('📦 Field blocks response:', data);

                if (data.success && data.blocks && Array.isArray(data.blocks)) {
                    console.log(`🎯 Adding ${data.blocks.length} blocks to GrapesJS...`);
                    
                    // Add blocks to GrapesJS
                    data.blocks.forEach((block, index) => {
                        try {
                            editor.BlockManager.add(block.id, {
                                label: block.label,
                                category: block.category,
                                content: block.content,
                                attributes: block.attributes || {}
                            });
                            console.log(`✅ Added block ${index + 1}: ${block.label}`);
                        } catch (blockError) {
                            console.error(`❌ Error adding block ${block.id}:`, blockError);
                        }
                    });

                    showAlert('success', `Loaded ${data.blocks.length} content fields for ${data.content_type.name}`);

                    // Add starter content if canvas is empty
                    setTimeout(() => {
                        if (isCanvasEmpty()) {
                            addInitialContent(data.content_type);
                        }
                    }, 1000);

                } else {
                    console.warn('⚠️ No blocks received or request failed:', data);
                    showAlert('warning', data.message || 'No content fields found. Please add fields to your content type first.');
                }
            })
            .catch(error => {
                console.error('❌ Error loading field blocks:', error);
                showAlert('error', 'Failed to load content fields: ' + error.message);
            });
        }

        function isCanvasEmpty() {
            try {
                const wrapper = editor.getWrapper();
                const components = wrapper.components();
                return components.length === 0 || (components.length === 1 && !components.at(0).get('content'));
            } catch (error) {
                console.error('Error checking canvas state:', error);
                return true;
            }
        }

        function addInitialContent(contentType) {
const placeholderText = '{' + '{field_name}' + '}'; // Avoid Blade parsing
            
            const starterContent = `
                <div class="container mt-4">
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">Welcome to ${contentType.name} Layout Builder!</h4>
                        <p>Drag content fields from the <strong>Content Fields</strong> category in the left panel to build your layout.</p>
                        <hr>
                        <p class="mb-0">
                            <small>
                                <i class="ri-information-line"></i>
                                Available fields: ${contentType.field_count} | 
                                Use <code>${placeholderText}</code> placeholders for dynamic content
                            </small>
                        </p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Drop your content fields here</h2>
                            <p class="text-muted">Start by dragging the "All Fields Layout" block for a quick start, or build your custom layout field by field.</p>
                        </div>
                    </div>
                </div>
            `;

            try {
                editor.setComponents(starterContent);
                console.log('✅ Initial content added');
            } catch (error) {
                console.error('❌ Error setting initial content:', error);
            }
        }

        function setupCommands() {
            // Save layout command
            editor.Commands.add('save-layout', {
                run: function(editor) {
                    const html = editor.getHtml();
                    const css = editor.getCss();

                    // Show save template modal
                    document.getElementById('templatePreview').innerHTML = html.substring(0, 200) + '...';
                    new bootstrap.Modal(document.getElementById('saveTemplateModal')).show();
                }
            });

            // Preview layout command
            editor.Commands.add('preview-layout', {
                run: function(editor) {
                    const html = editor.getHtml();
                    const css = editor.getCss();

                    // Process template with sample data
                    const processedHtml = processTemplateWithSampleData(html, sampleData[0] || {});

                    const previewContent = `
                        <!DOCTYPE html>
                        <html lang="en">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Layout Preview</title>
                            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
                            <style>${css}</style>
                        </head>
                        <body>${processedHtml}</body>
                        </html>
                    `;

                    document.getElementById('previewFrame').srcdoc = previewContent;
                    new bootstrap.Modal(document.getElementById('previewModal')).show();
                }
            });
        }

        function setupEventListeners() {
            // Device view buttons
            document.getElementById('desktop-view').addEventListener('click', function() {
                editor.setDevice('Desktop');
                updateActiveButton(this);
            });

            document.getElementById('tablet-view').addEventListener('click', function() {
                editor.setDevice('Tablet');
                updateActiveButton(this);
            });

            document.getElementById('mobile-view').addEventListener('click', function() {
                editor.setDevice('Mobile');
                updateActiveButton(this);
            });

            // Action buttons
            document.getElementById('save-layout').addEventListener('click', function() {
                editor.runCommand('save-layout');
            });

            document.getElementById('preview-layout').addEventListener('click', function() {
                editor.runCommand('preview-layout');
            });

            // Template save confirmation
            document.getElementById('confirmSaveTemplate').addEventListener('click', function() {
                saveLayoutTemplate();
            });
        }

        function updateActiveButton(activeBtn) {
            document.querySelectorAll('[id$="-view"]').forEach(btn => {
                btn.classList.remove('active');
            });
            activeBtn.classList.add('active');
        }

        function saveLayoutTemplate() {
            const templateName = document.getElementById('templateName').value.trim();

            if (!templateName) {
                showAlert('error', 'Please enter a template name');
                return;
            }

            const saveBtn = document.getElementById('confirmSaveTemplate');
            const originalText = saveBtn.textContent;
            saveBtn.disabled = true;
            saveBtn.textContent = 'Saving...';

            try {
                const html = editor.getHtml();
                const css = editor.getCss();

                const formData = new FormData();
                formData.append('layout_name', templateName);
                formData.append('html', html);
                formData.append('css', css || '');
                formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');

                fetch(`/admin/content-types/${contentTypeSlug}/save-layout`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(async response => {
                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || `HTTP error! status: ${response.status}`);
                    }

                    return data;
                })
                .then(data => {
                    if (data.success) {
                        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('saveTemplateModal'));
                        if (modalInstance) {
                            modalInstance.hide();
                        }

                        showAlert('success', data.message);
                        document.getElementById('templateName').value = '';
                        document.getElementById('templatePreview').innerHTML = '<small class="text-muted">Template preview will appear here...</small>';
                    } else {
                        throw new Error(data.message || 'Failed to save template');
                    }
                })
                .catch(error => {
                    console.error('Error saving template:', error);
                    showAlert('error', 'An error occurred while saving: ' + error.message);
                })
                .finally(() => {
                    saveBtn.disabled = false;
                    saveBtn.textContent = originalText;
                });

            } catch (error) {
                console.error('Error preparing template data:', error);
                showAlert('error', 'Error preparing template data');
                saveBtn.disabled = false;
                saveBtn.textContent = originalText;
            }
        }

        function processTemplateWithSampleData(html, data) {
            let processedHtml = html;

            Object.keys(data).forEach(key => {
                const placeholder = '{{' + key + '}}';
                let value = data[key];

                if (Array.isArray(value)) {
                    if (key === 'gallery' || (typeof value[0] === 'string' && value[0].includes('http'))) {
                        const galleryHtml = value.map(url =>
                            `<img src="${url}" alt="Gallery Image" class="gallery-item" />`
                        ).join('');
                        value = `<div class="gallery-grid">${galleryHtml}</div>`;
                    } else {
                        value = value.join(', ');
                    }
                } else if (typeof value === 'boolean') {
                    value = value ? 'Yes' : 'No';
                }

                processedHtml = processedHtml.replace(new RegExp(placeholder.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g'), value);
            });

            return processedHtml;
        }

        function showAlert(type, message) {
            // Remove any existing alerts first
            const existingAlerts = document.querySelectorAll('.alert');
            existingAlerts.forEach(alert => alert.remove());

            const alertClass = type === 'success' ? 'alert-success' : 
                             type === 'warning' ? 'alert-warning' : 'alert-danger';
            const iconClass = type === 'success' ? 'ri-check-line' : 
                             type === 'warning' ? 'ri-information-line' : 'ri-error-warning-line';

            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert" style="margin-bottom: 1rem;">
                    <i class="${iconClass} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;

            const alertContainer = document.querySelector('.page-content') || document.body;
            alertContainer.insertAdjacentHTML('afterbegin', alertHtml);

            // Auto-remove after 5 seconds
            setTimeout(() => {
                const alert = alertContainer.querySelector('.alert');
                if (alert) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150);
                }
            }, 5000);
        }
    </script>
@endpush