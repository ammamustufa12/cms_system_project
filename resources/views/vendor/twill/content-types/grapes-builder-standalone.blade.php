@extends('twill::layouts.form')

@section('contentFields')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1>Layout Builder: {{ $contentType->name }}</h1>
                <p class="text-muted">Simple layout designer for your content</p>
            </div>
            <div>
                <a href="{{ route('content-types.manage-fields', $contentType->slug) }}" class="btn btn-secondary">
                    <i class="ri-arrow-left-line"></i> Back to Fields
                </a>
            </div>
        </div>

        <!-- Simple Layout Builder -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Layout Designer</h5>
                    </div>
                    <div class="card-body">
                        <!-- Simple Toolbar -->
                        <div class="mb-3">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary" onclick="addText()">Add Text</button>
                                <button type="button" class="btn btn-primary" onclick="addImage()">Add Image</button>
                                <button type="button" class="btn btn-primary" onclick="addContainer()">Add Container</button>
                                <button type="button" class="btn btn-success" onclick="saveLayout()">Save Layout</button>
                                <button type="button" class="btn btn-info" onclick="previewLayout()">Preview</button>
                            </div>
                        </div>
                        
                        <!-- Layout Canvas -->
                        <div id="layout-canvas" style="min-height: 400px; border: 2px dashed #dee2e6; padding: 20px; background: #f8f9fa;">
                            <div id="empty-message" class="text-center text-muted">
                                <h5>Your layout will appear here</h5>
                                <p>Click the buttons above to add elements</p>
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
    <style>
        /* Standalone Layout Builder Styles */
        .layout-toolbar {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .layout-element {
            position: relative;
            border: 2px dashed transparent;
            margin: 10px 0;
            padding: 10px;
            min-height: 40px;
            transition: all 0.2s ease;
        }

        .layout-element:hover {
            border-color: #007bff;
            background: rgba(0, 123, 255, 0.05);
        }

        .layout-element.selected {
            border-color: #007bff;
            background: rgba(0, 123, 255, 0.1);
        }

        .element-controls {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #007bff;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: none;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            cursor: pointer;
            z-index: 10;
        }

        .layout-element:hover .element-controls {
            display: flex;
        }

        .element-controls:hover {
            background: #0056b3;
        }

        .text-element {
            font-family: inherit;
            line-height: 1.5;
        }

        .image-element {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }

        .container-element {
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 15px;
            background: #f8f9fa;
        }

        .button-element {
            display: inline-block;
            padding: 8px 16px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .button-element:hover {
            background: #0056b3;
        }

        .empty-state {
            text-align: center;
            padding: 50px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 20px;
            display: block;
        }

        /* Device preview styles */
        .canvas-desktop {
            width: 100%;
        }

        .canvas-tablet {
            width: 768px;
            margin: 0 auto;
        }

        .canvas-mobile {
            width: 375px;
            margin: 0 auto;
        }

        /* Field styling */
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
    </style>
@endpush

@push('extra_js')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script>
        // Variables from PHP
        const contentTypeSlug = @json($contentType->slug);
        const fieldsSchema = @json($fieldsSchema ?? []);
        const sampleData = @json($sampleData ?? []);
        
        // Debug info
        console.log('🚀 Standalone Layout Builder Loaded');
        console.log('Content Type:', contentTypeSlug);
        console.log('Fields Schema:', fieldsSchema);
        console.log('Sample Data:', sampleData);

        let layoutData = [];
        let selectedElement = null;
        let history = [];
        let historyIndex = -1;

        document.addEventListener('DOMContentLoaded', function() {
            console.log('🔄 Initializing Standalone Layout Builder...');
            
            try {
                initializeLayoutBuilder();
                loadContentFieldBlocks();
                setupEventListeners();
                console.log('✅ Layout Builder initialized successfully');
            } catch (error) {
                console.error('❌ Error initializing Layout Builder:', error);
                showAlert('error', 'Failed to initialize layout builder: ' + error.message);
            }
        });

        function initializeLayoutBuilder() {
            const canvas = document.getElementById('canvas');
            const layoutContent = document.getElementById('layout-content');
            const emptyState = document.getElementById('empty-state');

            // Initialize with default content
            if (layoutContent.children.length === 0) {
                addInitialContent();
            }
        }

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
                    console.log(`🎯 Loaded ${data.blocks.length} field blocks`);
                    showAlert('success', `Loaded ${data.blocks.length} content fields for ${data.content_type.name}`);
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

        function addInitialContent() {
            const placeholderText = '{' + '{field_name}' + '}'; // Avoid Blade parsing
            
            const starterContent = `
                <div class="container-element">
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">Welcome to Layout Builder!</h4>
                        <p>Use the toolbar above to add elements to your layout.</p>
                        <hr>
                        <p class="mb-0">
                            <small>
                                <i class="ri-information-line"></i>
                                Use <code>${placeholderText}</code> placeholders for dynamic content
                            </small>
                        </p>
                    </div>
                </div>
            `;

            const layoutContent = document.getElementById('layout-content');
            layoutContent.innerHTML = starterContent;
            hideEmptyState();
        }

        function setupEventListeners() {
            // Toolbar buttons
            document.querySelectorAll('[data-action]').forEach(btn => {
                btn.addEventListener('click', function() {
                    const action = this.getAttribute('data-action');
                    handleToolbarAction(action);
                });
            });

            // Device view buttons
            document.getElementById('desktop-view').addEventListener('click', function() {
                setDeviceView('desktop');
                updateActiveButton(this);
            });

            document.getElementById('tablet-view').addEventListener('click', function() {
                setDeviceView('tablet');
                updateActiveButton(this);
            });

            document.getElementById('mobile-view').addEventListener('click', function() {
                setDeviceView('mobile');
                updateActiveButton(this);
            });

            // Action buttons
            document.getElementById('save-layout').addEventListener('click', function() {
                saveLayout();
            });

            document.getElementById('preview-layout').addEventListener('click', function() {
                previewLayout();
            });

            // Template save confirmation
            document.getElementById('confirmSaveTemplate').addEventListener('click', function() {
                saveLayoutTemplate();
            });
        }

        function handleToolbarAction(action) {
            switch(action) {
                case 'add-text':
                    addTextElement();
                    break;
                case 'add-image':
                    addImageElement();
                    break;
                case 'add-container':
                    addContainerElement();
                    break;
                case 'add-button':
                    addButtonElement();
                    break;
                case 'undo':
                    undo();
                    break;
                case 'redo':
                    redo();
                    break;
                case 'clear':
                    clearLayout();
                    break;
            }
        }

        function addTextElement() {
            const element = createElement('text', {
                content: 'Click to edit text',
                tag: 'p'
            });
            addElementToCanvas(element);
        }

        function addImageElement() {
            const element = createElement('image', {
                src: 'https://via.placeholder.com/300x200?text=Image',
                alt: 'Placeholder image'
            });
            addElementToCanvas(element);
        }

        function addContainerElement() {
            const element = createElement('container', {
                content: 'Container content'
            });
            addElementToCanvas(element);
        }

        function addButtonElement() {
            const element = createElement('button', {
                text: 'Click Me',
                href: '#'
            });
            addElementToCanvas(element);
        }

        function createElement(type, props) {
            const id = 'element_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            return {
                id: id,
                type: type,
                props: props,
                timestamp: Date.now()
            };
        }

        function addElementToCanvas(element) {
            const layoutContent = document.getElementById('layout-content');
            const elementDiv = document.createElement('div');
            elementDiv.className = 'layout-element';
            elementDiv.setAttribute('data-element-id', element.id);
            
            let content = '';
            switch(element.type) {
                case 'text':
                    content = `<${element.props.tag || 'p'} class="text-element">${element.props.content}</${element.props.tag || 'p'}>`;
                    break;
                case 'image':
                    content = `<img src="${element.props.src}" alt="${element.props.alt}" class="image-element">`;
                    break;
                case 'container':
                    content = `<div class="container-element">${element.props.content}</div>`;
                    break;
                case 'button':
                    content = `<a href="${element.props.href}" class="button-element">${element.props.text}</a>`;
                    break;
            }
            
            elementDiv.innerHTML = content + `
                <div class="element-controls">
                    <i class="ri-delete-bin-line" data-action="delete"></i>
                </div>
            `;
            
            layoutContent.appendChild(elementDiv);
            hideEmptyState();
            
            // Add click handlers
            elementDiv.addEventListener('click', function(e) {
                if (e.target.closest('.element-controls')) return;
                selectElement(this);
            });
            
            elementDiv.querySelector('[data-action="delete"]').addEventListener('click', function(e) {
                e.stopPropagation();
                deleteElement(elementDiv);
            });
            
            // Save to history
            saveToHistory();
        }

        function selectElement(elementDiv) {
            // Remove previous selection
            document.querySelectorAll('.layout-element.selected').forEach(el => {
                el.classList.remove('selected');
            });
            
            // Select current element
            elementDiv.classList.add('selected');
            selectedElement = elementDiv;
        }

        function deleteElement(elementDiv) {
            elementDiv.remove();
            selectedElement = null;
            saveToHistory();
            
            // Show empty state if no elements
            if (document.getElementById('layout-content').children.length === 0) {
                showEmptyState();
            }
        }

        function clearLayout() {
            if (confirm('Are you sure you want to clear the entire layout?')) {
                document.getElementById('layout-content').innerHTML = '';
                selectedElement = null;
                showEmptyState();
                saveToHistory();
            }
        }

        function setDeviceView(device) {
            const canvas = document.getElementById('canvas');
            canvas.className = `canvas-${device}`;
        }

        function updateActiveButton(activeBtn) {
            document.querySelectorAll('[id$="-view"]').forEach(btn => {
                btn.classList.remove('active');
            });
            activeBtn.classList.add('active');
        }

        function saveToHistory() {
            const layoutContent = document.getElementById('layout-content');
            const state = layoutContent.innerHTML;
            
            // Remove current state from history if we're not at the end
            history = history.slice(0, historyIndex + 1);
            
            // Add new state
            history.push(state);
            historyIndex++;
            
            // Limit history size
            if (history.length > 50) {
                history.shift();
                historyIndex--;
            }
        }

        function undo() {
            if (historyIndex > 0) {
                historyIndex--;
                document.getElementById('layout-content').innerHTML = history[historyIndex];
                selectedElement = null;
            }
        }

        function redo() {
            if (historyIndex < history.length - 1) {
                historyIndex++;
                document.getElementById('layout-content').innerHTML = history[historyIndex];
                selectedElement = null;
            }
        }

        function showEmptyState() {
            document.getElementById('empty-state').style.display = 'block';
        }

        function hideEmptyState() {
            document.getElementById('empty-state').style.display = 'none';
        }

        function saveLayout() {
            const layoutContent = document.getElementById('layout-content').innerHTML;
            
            if (!layoutContent.trim()) {
                showAlert('warning', 'Please add some content before saving');
                return;
            }

            // Show save template modal
            document.getElementById('templatePreview').innerHTML = layoutContent.substring(0, 200) + '...';
            new bootstrap.Modal(document.getElementById('saveTemplateModal')).show();
        }

        function previewLayout() {
            const layoutContent = document.getElementById('layout-content').innerHTML;
            
            if (!layoutContent.trim()) {
                showAlert('warning', 'Please add some content before previewing');
                return;
            }

            // Process template with sample data
            const processedHtml = processTemplateWithSampleData(layoutContent, sampleData[0] || {});

            const previewContent = `
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Layout Preview</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
                        .layout-element { margin: 10px 0; }
                        .container-element { border: 1px solid #dee2e6; border-radius: 4px; padding: 15px; background: #f8f9fa; }
                        .text-element { font-family: inherit; line-height: 1.5; }
                        .image-element { max-width: 100%; height: auto; border-radius: 4px; }
                        .button-element { display: inline-block; padding: 8px 16px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; }
                        .button-element:hover { background: #0056b3; }
                    </style>
                </head>
                <body>${processedHtml}</body>
                </html>
            `;

            document.getElementById('previewFrame').srcdoc = previewContent;
            new bootstrap.Modal(document.getElementById('previewModal')).show();
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
                const layoutContent = document.getElementById('layout-content').innerHTML;

                const formData = new FormData();
                formData.append('layout_name', templateName);
                formData.append('html', layoutContent);
                formData.append('css', '');
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

            if (!data || typeof data !== 'object') {
                console.warn('No sample data provided for template processing');
                return processedHtml;
            }

            Object.keys(data).forEach(key => {
                const placeholder = '{{' + key + '}}';
                let value = data[key];

                // Handle different data types
                if (value === null || value === undefined) {
                    value = '';
                } else if (Array.isArray(value)) {
                    if (key === 'gallery' || (value.length > 0 && typeof value[0] === 'string' && value[0].includes('http'))) {
                        const galleryHtml = value.map(url =>
                            `<img src="${url}" alt="Gallery Image" class="gallery-item" />`
                        ).join('');
                        value = `<div class="gallery-grid">${galleryHtml}</div>`;
                    } else {
                        value = value.join(', ');
                    }
                } else if (typeof value === 'boolean') {
                    value = value ? 'Yes' : 'No';
                } else if (typeof value === 'object') {
                    value = JSON.stringify(value);
                } else {
                    value = String(value);
                }

                // Escape special regex characters and replace
                const escapedPlaceholder = placeholder.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                processedHtml = processedHtml.replace(new RegExp(escapedPlaceholder, 'g'), value);
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
@endsection