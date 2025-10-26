<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Page Builder - {{ $contentType->name }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- GrapesJS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/grapesjs@0.21.7/dist/css/grapes.min.css">
    
    <style>
        /* Professional Page Builder Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: #f8f9fa;
        }
        
        .page-builder-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .page-builder-header {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .header-center {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo {
            font-size: 18px;
            font-weight: 600;
            color: #495057;
        }
        
        .device-buttons {
            display: flex;
            background: #f8f9fa;
            border-radius: 6px;
            padding: 2px;
        }
        
        .device-btn {
            background: none;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            color: #6c757d;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .device-btn.active {
            background: #007bff;
            color: white;
        }
        
        .device-btn:hover:not(.active) {
            background: #e9ecef;
        }
        
        .toolbar-btn {
            background: none;
            border: 1px solid #dee2e6;
            padding: 8px 12px;
            border-radius: 4px;
            color: #495057;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
        }
        
        .toolbar-btn:hover {
            background: #f8f9fa;
            border-color: #007bff;
        }
        
        .toolbar-btn.active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }
        
        /* GrapesJS Container */
        #gjs {
            height: calc(100vh - 70px);
            width: 100%;
        }
        
        /* Custom GrapesJS Styling */
        .gjs-one-bg {
            background-color: #f8f9fa;
        }
        
        .gjs-two-color {
            color: #495057;
        }
        
        .gjs-three-bg {
            background-color: #007bff;
            color: white;
        }
        
        .gjs-four-color,
        .gjs-four-color-h:hover {
            color: #007bff;
        }
        
        .gjs-pn-panel {
            background: #fff;
            border: 1px solid #e9ecef;
        }
        
        .gjs-pn-button {
            color: #495057;
        }
        
        .gjs-pn-button:hover {
            background: #f8f9fa;
        }
        
        .gjs-pn-active {
            background: #007bff;
            color: white;
        }
        
        .gjs-cv-canvas {
            background: #fff;
        }
        
        .gjs-block {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 10px;
            margin: 5px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .gjs-block:hover {
            background: #f8f9fa;
            border-color: #007bff;
        }
        
        .gjs-sm-sectors {
            background: #fff;
        }
        
        .gjs-sm-sector {
            border-bottom: 1px solid #e9ecef;
        }
        
        .gjs-sm-title {
            background: #f8f9fa;
            color: #495057;
            font-weight: 600;
        }
        
        .gjs-sm-properties {
            background: #fff;
        }
        
        .gjs-sm-property {
            border-bottom: 1px solid #f8f9fa;
        }
        
        .gjs-sm-label {
            color: #495057;
        }
        
        .gjs-field {
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 6px 8px;
        }
        
        .gjs-field:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .gjs-btn {
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 16px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .gjs-btn:hover {
            background: #0056b3;
        }
        
        .gjs-btn-secondary {
            background: #6c757d;
        }
        
        .gjs-btn-secondary:hover {
            background: #545b62;
        }
        
        /* Loading State */
        .loading-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        
        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #e9ecef;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .loading-text {
            margin-top: 20px;
            color: #495057;
            font-size: 14px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .page-builder-header {
                padding: 10px;
                flex-wrap: wrap;
            }
            
            .header-center {
                order: 3;
                width: 100%;
                justify-content: center;
                margin-top: 10px;
            }
            
            .device-buttons {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Container -->
    <div id="loadingContainer" class="loading-container">
        <div>
            <div class="loading-spinner"></div>
            <div class="loading-text">Loading Professional Page Builder...</div>
        </div>
    </div>

    <!-- Page Builder Container -->
    <div class="page-builder-container" style="display: none;">
        <!-- Header -->
        <div class="page-builder-header">
            <div class="header-left">
                <div class="logo">
                    <i class="ri-layout-line me-2"></i>
                    Professional Builder
                </div>
                <div class="text-muted small">
                    {{ $contentType->name }} Layout Designer
                </div>
            </div>
            
            <div class="header-center">
                <!-- Device View Buttons -->
                <div class="device-buttons">
                    <button class="device-btn active" id="desktop-view" data-device="desktop">
                        <i class="ri-computer-line me-1"></i>Desktop
                    </button>
                    <button class="device-btn" id="tablet-view" data-device="tablet">
                        <i class="ri-tablet-line me-1"></i>Tablet
                    </button>
                    <button class="device-btn" id="mobile-view" data-device="mobile">
                        <i class="ri-smartphone-line me-1"></i>Mobile
                    </button>
                </div>
            </div>
            
            <div class="header-right">
                <button class="toolbar-btn" id="preview-btn" title="Preview">
                    <i class="ri-eye-line"></i>
                </button>
                <button class="toolbar-btn" id="fullscreen-btn" title="Fullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
                <button class="toolbar-btn" id="code-btn" title="Code Editor">
                    <i class="ri-code-line"></i>
                </button>
                <button class="toolbar-btn" id="undo-btn" title="Undo">
                    <i class="ri-arrow-left-line"></i>
                </button>
                <button class="toolbar-btn" id="redo-btn" title="Redo">
                    <i class="ri-arrow-right-line"></i>
                </button>
                <button class="toolbar-btn" id="save-btn" title="Save">
                    <i class="ri-save-line"></i>
                </button>
                <button class="toolbar-btn" id="export-btn" title="Export">
                    <i class="ri-download-line"></i>
                </button>
                <button class="toolbar-btn" id="clear-btn" title="Clear">
                    <i class="ri-delete-bin-line"></i>
                </button>
                <button class="toolbar-btn" id="help-btn" title="Help">
                    <i class="ri-question-line"></i>
                </button>
            </div>
        </div>

        <!-- GrapesJS Canvas -->
        <div id="gjs"></div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Layout Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="previewFrame" style="width: 100%; height: 600px; border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Modal -->
    <div class="modal fade" id="saveModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Save Layout Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="saveForm">
                        <div class="mb-3">
                            <label for="layoutName" class="form-label">Template Name</label>
                            <input type="text" class="form-control" id="layoutName" name="layout_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Preview</label>
                            <div id="layoutPreview" class="border rounded p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                                <small class="text-muted">Template preview will appear here...</small>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmSave">Save Template</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- GrapesJS Scripts -->
    <script>
        // Variables from PHP
        const contentTypeSlug = @json($contentType->slug);
        const fieldsSchema = @json($fieldsSchema ?? []);
        const sampleData = @json($sampleData ?? []);
        
        let editor;
        let currentDevice = 'desktop';
        
        // Utility Functions
        function showSuccess(message) {
            showToast(message, 'success');
        }
        
        function showError(message) {
            showToast(message, 'error');
        }
        
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type === 'error' ? 'danger' : type} position-fixed top-0 end-0 m-3`;
            toast.style.zIndex = '9999';
            toast.innerHTML = `
                ${message}
                <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
            `;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
        
        // Load GrapesJS with multiple fallbacks
        function loadGrapesJS() {
            const urls = [
                'https://unpkg.com/grapesjs@0.21.7/dist/grapes.min.js',
                'https://cdn.jsdelivr.net/npm/grapesjs@0.21.7/dist/grapes.min.js',
                'https://cdnjs.cloudflare.com/ajax/libs/grapesjs/0.21.7/grapes.min.js'
            ];
            
            function loadScript(urlIndex = 0) {
                if (urlIndex >= urls.length) {
                    console.error('Failed to load GrapesJS from all CDNs');
                    showError('Failed to load GrapesJS library. Please check your internet connection.');
                    return;
                }
                
                const script = document.createElement('script');
                script.src = urls[urlIndex];
                script.onload = function() {
                    console.log(`GrapesJS loaded successfully from ${urls[urlIndex]}`);
                    setTimeout(initializeEditor, 100);
                };
                script.onerror = function() {
                    console.warn(`Failed to load GrapesJS from ${urls[urlIndex]}, trying next...`);
                    loadScript(urlIndex + 1);
                };
                document.head.appendChild(script);
            }
            
            // Start loading
            loadScript();
        }
        
        // Initialize GrapesJS Editor
        function initializeEditor() {
            try {
                console.log('Initializing GrapesJS editor...');
                
                // Hide loading container
                document.getElementById('loadingContainer').style.display = 'none';
                document.querySelector('.page-builder-container').style.display = 'flex';
                
                // Initialize GrapesJS with complete configuration
                editor = grapesjs.init({
                    container: '#gjs',
                    height: 'calc(100vh - 70px)',
                    width: '100%',
                    storageManager: {
                        type: 'local',
                        autosave: true,
                        autoload: true,
                        stepsBeforeSave: 1
                    },
                    canvas: {
                        styles: [
                            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'
                        ]
                    },
                    deviceManager: {
                        devices: [
                            {
                                name: 'Desktop',
                                width: '',
                                widthMedia: '992px',
                            },
                            {
                                name: 'Tablet',
                                width: '768px',
                                widthMedia: '768px',
                            },
                            {
                                name: 'Mobile',
                                width: '320px',
                                widthMedia: '480px',
                            }
                        ]
                    },
                    panels: {
                        defaults: [
                            {
                                id: 'layers',
                                el: '.panel__right',
                                resizable: {
                                    maxDim: 350,
                                    minDim: 200,
                                    tc: 0,
                                    cl: 1,
                                    cr: 0,
                                    bc: 0,
                                    keyWidth: 'flex-basis',
                                },
                            },
                            {
                                id: 'panel-switcher',
                                el: '.panel__switcher',
                                buttons: [
                                    {
                                        id: 'show-layers',
                                        active: true,
                                        label: '<i class="ri-layout-line"></i>',
                                        command: 'show-layers',
                                        togglable: false,
                                    },
                                    {
                                        id: 'show-style',
                                        active: true,
                                        label: '<i class="ri-palette-line"></i>',
                                        command: 'show-styles',
                                        togglable: false,
                                    },
                                    {
                                        id: 'show-traits',
                                        active: true,
                                        label: '<i class="ri-settings-3-line"></i>',
                                        command: 'show-traits',
                                        togglable: false,
                                    }
                                ],
                            },
                            {
                                id: 'panel-devices',
                                el: '.panel__devices',
                                buttons: [
                                    {
                                        id: 'device-desktop',
                                        label: '<i class="ri-computer-line"></i>',
                                        command: 'set-device-desktop',
                                        active: true,
                                        togglable: false,
                                    },
                                    {
                                        id: 'device-tablet',
                                        label: '<i class="ri-tablet-line"></i>',
                                        command: 'set-device-tablet',
                                        togglable: false,
                                    },
                                    {
                                        id: 'device-mobile',
                                        label: '<i class="ri-smartphone-line"></i>',
                                        command: 'set-device-mobile',
                                        togglable: false,
                                    }
                                ],
                            }
                        ]
                    },
                    traitManager: {
                        appendTo: '.traits-container',
                    },
                    selectorManager: {
                        appendTo: '.styles-container',
                    },
                    layerManager: {
                        appendTo: '.layers-container',
                    },
                    blockManager: {
                        appendTo: '.blocks-container',
                    }
                });
                
                // Add default content if canvas is empty
                if (!editor.getHtml()) {
                    addDefaultContent();
                }
                
                // Setup event listeners
                setupEventListeners();
                
                console.log('✅ GrapesJS editor initialized successfully');
                showSuccess('Professional Page Builder loaded successfully!');
                
            } catch (error) {
                console.error('❌ Error initializing GrapesJS editor:', error);
                showError('Failed to initialize page builder: ' + error.message);
            }
        }
        
        function addDefaultContent() {
            const defaultHtml = `
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="display-4 text-center mb-4">Build your templates without coding</h1>
                            <p class="lead text-center mb-5">Create beautiful layouts with our drag & drop builder</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Feature 1</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <a href="#" class="btn btn-primary">Learn More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Feature 2</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <a href="#" class="btn btn-primary">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            editor.setComponents(defaultHtml);
        }
        
        function setupEventListeners() {
            // Device view buttons
            document.getElementById('desktop-view').addEventListener('click', function() {
                editor.runCommand('set-device-desktop');
                updateDeviceButtons(this);
            });
            
            document.getElementById('tablet-view').addEventListener('click', function() {
                editor.runCommand('set-device-tablet');
                updateDeviceButtons(this);
            });
            
            document.getElementById('mobile-view').addEventListener('click', function() {
                editor.runCommand('set-device-mobile');
                updateDeviceButtons(this);
            });
            
            // Toolbar buttons
            document.getElementById('preview-btn').addEventListener('click', function() {
                previewLayout();
            });
            
            document.getElementById('fullscreen-btn').addEventListener('click', function() {
                toggleFullscreen();
            });
            
            document.getElementById('code-btn').addEventListener('click', function() {
                editor.runCommand('core:open-code');
            });
            
            document.getElementById('undo-btn').addEventListener('click', function() {
                editor.runCommand('core:undo');
            });
            
            document.getElementById('redo-btn').addEventListener('click', function() {
                editor.runCommand('core:redo');
            });
            
            document.getElementById('save-btn').addEventListener('click', function() {
                saveLayout();
            });
            
            document.getElementById('export-btn').addEventListener('click', function() {
                exportLayout();
            });
            
            document.getElementById('clear-btn').addEventListener('click', function() {
                clearLayout();
            });
            
            document.getElementById('help-btn').addEventListener('click', function() {
                showHelp();
            });
        }
        
        function updateDeviceButtons(activeBtn) {
            document.querySelectorAll('.device-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            activeBtn.classList.add('active');
        }
        
        function previewLayout() {
            const html = editor.getHtml();
            const css = editor.getCss();
            
            const previewContent = `
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Layout Preview</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>${css}</style>
                </head>
                <body>${html}</body>
                </html>
            `;
            
            document.getElementById('previewFrame').srcdoc = previewContent;
            new bootstrap.Modal(document.getElementById('previewModal')).show();
        }
        
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        }
        
        function saveLayout() {
            const html = editor.getHtml();
            const css = editor.getCss();
            
            if (!html.trim()) {
                showError('Please add some content before saving');
                return;
            }
            
            // Show save modal
            document.getElementById('layoutPreview').innerHTML = html.substring(0, 200) + '...';
            new bootstrap.Modal(document.getElementById('saveModal')).show();
        }
        
        function exportLayout() {
            const html = editor.getHtml();
            const css = editor.getCss();
            
            const fullHtml = `
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Exported Layout</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>${css}</style>
                </head>
                <body>${html}</body>
                </html>
            `;
            
            const blob = new Blob([fullHtml], { type: 'text/html' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'layout.html';
            a.click();
            URL.revokeObjectURL(url);
            
            showSuccess('Layout exported successfully!');
        }
        
        function clearLayout() {
            if (confirm('Are you sure you want to clear the entire layout?')) {
                editor.setComponents('');
                showSuccess('Layout cleared successfully!');
            }
        }
        
        function showHelp() {
            alert('Professional Page Builder Help:\n\n' +
                  '• Drag components from the left panel to the canvas\n' +
                  '• Click on elements to select and edit them\n' +
                  '• Use the right panel to modify styles and properties\n' +
                  '• Switch between desktop, tablet, and mobile views\n' +
                  '• Use the toolbar buttons for various actions\n' +
                  '• Save your layouts as templates for reuse');
        }
        
        // Save template confirmation
        document.getElementById('confirmSave').addEventListener('click', function() {
            const layoutName = document.getElementById('layoutName').value.trim();
            
            if (!layoutName) {
                showError('Please enter a template name');
                return;
            }
            
            const saveBtn = this;
            const originalText = saveBtn.textContent;
            saveBtn.disabled = true;
            saveBtn.textContent = 'Saving...';
            
            const html = editor.getHtml();
            const css = editor.getCss();
            
            const formData = new FormData();
            formData.append('layout_name', layoutName);
            formData.append('html', html);
            formData.append('css', css);
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
                    const modalInstance = bootstrap.Modal.getInstance(document.getElementById('saveModal'));
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                    showSuccess(data.message);
                    document.getElementById('layoutName').value = '';
                } else {
                    throw new Error(data.message || 'Failed to save template');
                }
            })
            .catch(error => {
                console.error('Error saving template:', error);
                showError('An error occurred while saving: ' + error.message);
            })
            .finally(() => {
                saveBtn.disabled = false;
                saveBtn.textContent = originalText;
            });
        });
        
        // Start loading when page loads
        document.addEventListener('DOMContentLoaded', loadGrapesJS);
    </script>
</body>
</html>