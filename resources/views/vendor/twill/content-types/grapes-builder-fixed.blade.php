<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrapesJS Visual Builder - {{ $contentType->name }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- GrapesJS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/grapesjs@0.21.7/dist/css/grapes.min.css" rel="stylesheet">
    
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
        }

        .grapes-builder-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .builder-header {
            background: #2c3e50;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .builder-title {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .builder-actions {
            display: flex;
            gap: 10px;
        }

        .btn-builder {
            background: #3498db;
            border: 1px solid #2980b9;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-builder:hover {
            background: #2980b9;
            color: white;
        }

        .builder-main {
            flex: 1;
            display: flex;
            height: calc(100vh - 70px);
        }

        .builder-sidebar {
            width: 300px;
            background: #34495e;
            color: white;
            overflow-y: auto;
            padding: 20px;
        }

        .sidebar-section {
            margin-bottom: 20px;
        }

        .sidebar-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #ecf0f1;
        }

        .component-item {
            background: #2c3e50;
            border: 1px solid #34495e;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .component-item:hover {
            background: #3498db;
            border-color: #3498db;
        }

        .component-icon {
            width: 24px;
            height: 24px;
            background: #3498db;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
        }

        .component-info h6 {
            margin: 0;
            font-size: 14px;
            color: white;
        }

        .component-info small {
            color: #bdc3c7;
            font-size: 12px;
        }

        .builder-canvas {
            flex: 1;
            background: white;
            position: relative;
        }

        .canvas-container {
            width: 100%;
            height: 100%;
            border: none;
            background: white;
        }

        .loading-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #7f8c8d;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #ecf0f1;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .success-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #27ae60;
            color: white;
            padding: 15px 20px;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            z-index: 1000;
            display: none;
        }

        .error-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #e74c3c;
            color: white;
            padding: 15px 20px;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            z-index: 1000;
            display: none;
        }

        /* GrapesJS Panel Styles */
        .gjs-pn-panel {
            background: #34495e !important;
            border: 1px solid #555 !important;
        }

        .gjs-pn-panel .gjs-pn-buttons {
            background: #2c3e50 !important;
        }

        .gjs-pn-button {
            color: white !important;
            background: transparent !important;
            border: none !important;
        }

        .gjs-pn-button:hover {
            background: #3498db !important;
        }

        .gjs-pn-active {
            background: #3498db !important;
        }

        .gjs-block {
            background: #2c3e50 !important;
            border: 1px solid #555 !important;
            color: white !important;
        }

        .gjs-block:hover {
            background: #3498db !important;
        }

        .gjs-layer {
            background: #2c3e50 !important;
            border: 1px solid #555 !important;
            color: white !important;
        }

        .gjs-layer:hover {
            background: #3498db !important;
        }
    </style>
</head>
<body>
    <!-- Success/Error Messages -->
    <div class="success-message" id="successMessage">
        <i class="fas fa-check-circle me-2"></i>
        <span id="successText">Operation completed successfully!</span>
    </div>
    
    <div class="error-message" id="errorMessage">
        <i class="fas fa-exclamation-circle me-2"></i>
        <span id="errorText">An error occurred!</span>
    </div>

    <!-- Builder Container -->
    <div class="grapes-builder-container">
        <!-- Header -->
        <div class="builder-header">
            <div>
                <h1 class="builder-title">
                    <i class="fas fa-palette me-2"></i>
                    GrapesJS Visual Builder
                </h1>
                <p class="mb-0">Content Type: {{ $contentType->name }}</p>
            </div>
            <div class="builder-actions">
                <button class="btn-builder" onclick="saveLayout()">
                    <i class="fas fa-save"></i> Save
                </button>
                <button class="btn-builder" onclick="previewLayout()">
                    <i class="fas fa-eye"></i> Preview
                </button>
                <button class="btn-builder" onclick="exportHTML()">
                    <i class="fas fa-download"></i> Export
                </button>
                <button class="btn-builder" onclick="clearCanvas()">
                    <i class="fas fa-trash"></i> Clear
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="builder-main">
            <!-- Left Sidebar -->
            <div class="builder-sidebar">
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Basic Elements</h3>
                    
                    <div class="component-item" draggable="true" data-type="text">
                        <div class="component-icon"><i class="fas fa-font"></i></div>
                        <div class="component-info">
                            <h6>Text</h6>
                            <small>Add text content</small>
                        </div>
                    </div>
                    
                    <div class="component-item" draggable="true" data-type="heading">
                        <div class="component-icon"><i class="fas fa-heading"></i></div>
                        <div class="component-info">
                            <h6>Heading</h6>
                            <small>Add headings (H1-H6)</small>
                        </div>
                    </div>
                    
                    <div class="component-item" draggable="true" data-type="image">
                        <div class="component-icon"><i class="fas fa-image"></i></div>
                        <div class="component-info">
                            <h6>Image</h6>
                            <small>Add images</small>
                        </div>
                    </div>
                    
                    <div class="component-item" draggable="true" data-type="button">
                        <div class="component-icon"><i class="fas fa-mouse-pointer"></i></div>
                        <div class="component-info">
                            <h6>Button</h6>
                            <small>Add buttons</small>
                        </div>
                    </div>
                </div>

                <div class="sidebar-section">
                    <h3 class="sidebar-title">Layout Elements</h3>
                    
                    <div class="component-item" draggable="true" data-type="container">
                        <div class="component-icon"><i class="fas fa-square"></i></div>
                        <div class="component-info">
                            <h6>Container</h6>
                            <small>Bootstrap container</small>
                        </div>
                    </div>
                    
                    <div class="component-item" draggable="true" data-type="row">
                        <div class="component-icon"><i class="fas fa-grip-lines"></i></div>
                        <div class="component-info">
                            <h6>Row</h6>
                            <small>Bootstrap row</small>
                        </div>
                    </div>
                    
                    <div class="component-item" draggable="true" data-type="column">
                        <div class="component-icon"><i class="fas fa-columns"></i></div>
                        <div class="component-info">
                            <h6>Column</h6>
                            <small>Bootstrap column</small>
                        </div>
                    </div>
                    
                    <div class="component-item" draggable="true" data-type="card">
                        <div class="component-icon"><i class="fas fa-id-card"></i></div>
                        <div class="component-info">
                            <h6>Card</h6>
                            <small>Bootstrap card</small>
                        </div>
                    </div>
                </div>

                <div class="sidebar-section">
                    <h3 class="sidebar-title">Sections</h3>
                    
                    <div class="component-item" draggable="true" data-type="hero">
                        <div class="component-icon"><i class="fas fa-star"></i></div>
                        <div class="component-info">
                            <h6>Hero Section</h6>
                            <small>Large banner section</small>
                        </div>
                    </div>
                    
                    <div class="component-item" draggable="true" data-type="features">
                        <div class="component-icon"><i class="fas fa-cogs"></i></div>
                        <div class="component-info">
                            <h6>Features</h6>
                            <small>Feature showcase</small>
                        </div>
                    </div>
                    
                    <div class="component-item" draggable="true" data-type="testimonials">
                        <div class="component-icon"><i class="fas fa-quote-left"></i></div>
                        <div class="component-info">
                            <h6>Testimonials</h6>
                            <small>Customer testimonials</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Canvas -->
            <div class="builder-canvas">
                <div class="loading-container" id="loadingContainer">
                    <div class="spinner"></div>
                    <p>Loading GrapesJS Builder...</p>
                </div>
                <div id="gjs" class="canvas-container" style="display: none;"></div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- GrapesJS Core with fallbacks -->
    <script>
    // Load GrapesJS with multiple fallbacks
    function loadGrapesJS() {
        const scripts = [
            {
                name: 'GrapesJS Core',
                urls: [
                    'https://unpkg.com/grapesjs@0.21.7/dist/grapes.min.js',
                    'https://cdn.jsdelivr.net/npm/grapesjs@0.21.7/dist/grapes.min.js',
                    'https://cdnjs.cloudflare.com/ajax/libs/grapesjs/0.21.7/grapes.min.js'
                ]
            },
            {
                name: 'GrapesJS Preset Webpage',
                urls: [
                    'https://unpkg.com/grapesjs-preset-webpage@1.0.3/dist/grapesjs-preset-webpage.min.js',
                    'https://cdn.jsdelivr.net/npm/grapesjs-preset-webpage@1.0.3/dist/grapesjs-preset-webpage.min.js'
                ]
            }
        ];
        
        let loadedScripts = 0;
        const totalScripts = scripts.length;
        
        function loadScript(scriptInfo, scriptIndex = 0) {
            if (scriptIndex >= scriptInfo.urls.length) {
                console.error(`Failed to load ${scriptInfo.name} from all CDNs`);
                showError(`Failed to load ${scriptInfo.name}. Please check your internet connection.`);
                return;
            }
            
            const script = document.createElement('script');
            script.src = scriptInfo.urls[scriptIndex];
            script.onload = function() {
                console.log(`${scriptInfo.name} loaded successfully from ${scriptInfo.urls[scriptIndex]}`);
                loadedScripts++;
                if (loadedScripts === totalScripts) {
                    console.log('All GrapesJS scripts loaded, initializing...');
                    setTimeout(initializeBuilder, 100);
                }
            };
            script.onerror = function() {
                console.warn(`Failed to load ${scriptInfo.name} from ${scriptInfo.urls[scriptIndex]}, trying next...`);
                loadScript(scriptInfo, scriptIndex + 1);
            };
            document.head.appendChild(script);
        }
        
        // Load all scripts
        scripts.forEach(scriptInfo => loadScript(scriptInfo));
    }
    
    // Start loading when page loads
    document.addEventListener('DOMContentLoaded', loadGrapesJS);
    </script>
    
    <script>
        let editor;
        let currentContent = '';

        // Initialize GrapesJS Editor
        function initializeBuilder() {
            try {
                console.log('Initializing GrapesJS Builder...');
                
                // Check if GrapesJS is loaded
                if (typeof grapesjs === 'undefined') {
                    console.error('GrapesJS not loaded');
                    showError('GrapesJS library failed to load. Please refresh the page.');
                    return;
                }
                
                // Hide loading container
                document.getElementById('loadingContainer').style.display = 'none';
                document.getElementById('gjs').style.display = 'block';
                
                // Initialize GrapesJS with simplified configuration
                editor = grapesjs.init({
                    container: '#gjs',
                    height: '100%',
                    width: '100%',
                    plugins: ['gjs-preset-webpage'],
                    pluginsOpts: {
                        'gjs-preset-webpage': {
                            modalImportTitle: 'Import Template',
                            modalImportLabel: '<div style="margin-bottom: 10px; font-size: 13px;">Paste here your HTML/CSS and click Import</div>',
                            modalImportContent: function(editor) {
                                return editor.getHtml() + '<style>' + editor.getCss() + '</style>';
                            }
                        }
                    },
                    storageManager: {
                        type: 'local',
                        autosave: true,
                        autoload: true,
                        stepsBeforeSave: 1
                    },
                    canvas: {
                        styles: [
                            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'
                        ],
                        scripts: [
                            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'
                        ]
                    },
                    deviceManager: {
                        devices: [
                            {
                                name: 'Desktop',
                                width: '',
                                widthMedia: '1024px'
                            },
                            {
                                name: 'Tablet',
                                width: '768px',
                                widthMedia: '768px'
                            },
                            {
                                name: 'Mobile',
                                width: '375px',
                                widthMedia: '480px'
                            }
                        ]
                    }
                });
                
                console.log('GrapesJS Builder initialized successfully!');
                
                // Set default content
                setTimeout(() => {
                    if (editor.getComponents().length === 0) {
                        editor.setComponents(`
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="jumbotron bg-primary text-white text-center py-5">
                                            <h1 class="display-4">Welcome to GrapesJS Builder</h1>
                                            <p class="lead">Start building your {{ $contentType->name }} page by dragging components from the left panel.</p>
                                            <hr class="my-4">
                                            <p>This is a professional visual page builder with drag & drop functionality.</p>
                                            <button class="btn btn-light btn-lg">Get Started</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                    }
                }, 1000);
                
                // Setup drag and drop
                setupDragAndDrop();
                
            } catch (error) {
                console.error('Error initializing builder:', error);
                showError('Failed to initialize page builder: ' + error.message);
            }
        }

        // Setup drag and drop functionality
        function setupDragAndDrop() {
            const componentItems = document.querySelectorAll('.component-item[draggable="true"]');
            
            componentItems.forEach(item => {
                item.addEventListener('dragstart', function(e) {
                    e.dataTransfer.setData('text/plain', this.dataset.type);
                });
            });
            
            // Add drop zone to canvas
            const canvas = document.getElementById('gjs');
            if (canvas) {
                canvas.addEventListener('dragover', function(e) {
                    e.preventDefault();
                });
                
                canvas.addEventListener('drop', function(e) {
                    e.preventDefault();
                    const componentType = e.dataTransfer.getData('text/plain');
                    addComponent(componentType);
                });
            }
        }

        // Add component to canvas
        function addComponent(type) {
            if (editor) {
                let componentHtml = '';
                
                switch(type) {
                    case 'text':
                        componentHtml = '<p>This is a text paragraph. Click to edit.</p>';
                        break;
                    case 'heading':
                        componentHtml = '<h2>This is a heading. Click to edit.</h2>';
                        break;
                    case 'image':
                        componentHtml = '<img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxOCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPjMwMHgyMDA8L3RleHQ+PC9zdmc+" class="img-fluid" alt="Image">';
                        break;
                    case 'button':
                        componentHtml = '<button class="btn btn-primary">Click Me</button>';
                        break;
                    case 'container':
                        componentHtml = '<div class="container"><p>Container content</p></div>';
                        break;
                    case 'row':
                        componentHtml = '<div class="row"><div class="col-12"><p>Row content</p></div></div>';
                        break;
                    case 'column':
                        componentHtml = '<div class="col-md-6"><p>Column content</p></div>';
                        break;
                    case 'card':
                        componentHtml = '<div class="card"><div class="card-body"><h5 class="card-title">Card Title</h5><p class="card-text">Card content goes here.</p></div></div>';
                        break;
                    case 'hero':
                        componentHtml = `
                            <div class="jumbotron bg-primary text-white text-center py-5">
                                <h1 class="display-4">Hero Section</h1>
                                <p class="lead">This is a hero section with call-to-action.</p>
                                <button class="btn btn-light btn-lg">Learn More</button>
                            </div>
                        `;
                        break;
                    case 'features':
                        componentHtml = `
                            <div class="container py-5">
                                <div class="row text-center">
                                    <div class="col-12 mb-5">
                                        <h2>Our Features</h2>
                                        <p class="lead">Discover what makes us different</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 text-center mb-4">
                                        <h4>Feature 1</h4>
                                        <p>Description of feature 1.</p>
                                    </div>
                                    <div class="col-md-4 text-center mb-4">
                                        <h4>Feature 2</h4>
                                        <p>Description of feature 2.</p>
                                    </div>
                                    <div class="col-md-4 text-center mb-4">
                                        <h4>Feature 3</h4>
                                        <p>Description of feature 3.</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        break;
                    case 'testimonials':
                        componentHtml = `
                            <div class="container py-5">
                                <div class="row text-center">
                                    <div class="col-12 mb-5">
                                        <h2>What Our Customers Say</h2>
                                        <p class="lead">Real feedback from real customers</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100">
                                            <div class="card-body text-center">
                                                <p class="card-text">"This is the best service I've ever used. Highly recommended!"</p>
                                                <h6 class="mb-0">John Doe</h6>
                                                <small class="text-muted">CEO, Company Inc.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        break;
                }
                
                if (componentHtml) {
                    editor.addComponents(componentHtml);
                    showSuccess('Component added successfully!');
                }
            }
        }

        // Builder Functions
        function saveLayout() {
            if (editor) {
                const html = editor.getHtml();
                const css = editor.getCss();
                
                // Save to server
                fetch('{{ route("content-types.save-layout", $contentType->slug) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        name: '{{ $contentType->name }} Layout',
                        content: html,
                        css: css
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccess('Layout saved successfully!');
                    } else {
                        showError('Failed to save layout: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error saving layout:', error);
                    showError('Failed to save layout');
                });
            }
        }

        function previewLayout() {
            if (editor) {
                const previewWindow = window.open('', '_blank');
                const html = editor.getHtml();
                const css = editor.getCss();
                const fullHtml = `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $contentType->name }} - Preview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>${css}</style>
</head>
<body>
    ${html}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>`;
                previewWindow.document.write(fullHtml);
                previewWindow.document.close();
            }
        }

        function exportHTML() {
            if (editor) {
                const html = editor.getHtml();
                const css = editor.getCss();
                const fullHtml = `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $contentType->name }} Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>${css}</style>
</head>
<body>
    ${html}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>`;
                
                const blob = new Blob([fullHtml], { type: 'text/html' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = '{{ $contentType->slug }}-page.html';
                a.click();
                URL.revokeObjectURL(url);
            }
        }

        function clearCanvas() {
            if (editor) {
                editor.setComponents('');
                showSuccess('Canvas cleared successfully!');
            }
        }

        // Utility Functions
        function showSuccess(message) {
            const successDiv = document.getElementById('successMessage');
            const successText = document.getElementById('successText');
            successText.textContent = message;
            successDiv.style.display = 'block';
            setTimeout(() => {
                successDiv.style.display = 'none';
            }, 3000);
        }

        function showError(message) {
            const errorDiv = document.getElementById('errorMessage');
            const errorText = document.getElementById('errorText');
            errorText.textContent = message;
            errorDiv.style.display = 'block';
            setTimeout(() => {
                errorDiv.style.display = 'none';
            }, 5000);
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Add CSRF token to head
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                const meta = document.createElement('meta');
                meta.name = 'csrf-token';
                meta.content = '{{ csrf_token() }}';
                document.head.appendChild(meta);
            }
            
            // Wait for GrapesJS to load
            let loadAttempts = 0;
            const maxAttempts = 10;
            
            function tryInitialize() {
                loadAttempts++;
                
                if (typeof grapesjs !== 'undefined') {
                    console.log('GrapesJS loaded, initializing builder...');
                    initializeBuilder();
                } else if (loadAttempts < maxAttempts) {
                    console.log(`GrapesJS not ready, attempt ${loadAttempts}/${maxAttempts}`);
                    setTimeout(tryInitialize, 500);
                } else {
                    console.error('GrapesJS failed to load after maximum attempts');
                    showError('Failed to load page builder. Please refresh the page.');
                }
            }
            
            // Start trying to initialize
            setTimeout(tryInitialize, 1000);
        });
    </script>
</body>
</html>
