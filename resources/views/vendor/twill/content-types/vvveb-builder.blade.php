<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vvveb.js Visual Builder - {{ $contentType->name }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Vvveb.js CSS -->
    <link href="{{ asset('vvveb/public/css/vvvebjs-editor-helpers.css') }}" rel="stylesheet">
    <!-- GrapesJS CSS (Vvveb.js uses GrapesJS) -->
    <link href="https://cdn.jsdelivr.net/npm/grapesjs@0.21.7/dist/css/grapes.min.css" rel="stylesheet">
    
    <style>
        :root {
            --vvveb-primary: #007bff;
            --vvveb-dark: #1a1a1a;
            --vvveb-sidebar: #2d2d2d;
            --vvveb-panel: #3a3a3a;
            --vvveb-text: #ffffff;
            --vvveb-text-muted: #b0b0b0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--vvveb-dark);
            color: var(--vvveb-text);
            overflow: hidden;
        }

        .vvveb-editor {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* Top Toolbar */
        .vvveb-toolbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: var(--vvveb-dark);
            border-bottom: 1px solid #444;
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 20px;
        }

        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .toolbar-center {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .toolbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .toolbar-btn {
            background: transparent;
            border: 1px solid #555;
            color: var(--vvveb-text);
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .toolbar-btn:hover {
            background: var(--vvveb-primary);
            border-color: var(--vvveb-primary);
        }

        .toolbar-btn.active {
            background: var(--vvveb-primary);
            border-color: var(--vvveb-primary);
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: var(--vvveb-primary);
        }

        /* Left Sidebar */
        .vvveb-sidebar {
            width: 300px;
            background: var(--vvveb-sidebar);
            border-right: 1px solid #444;
            margin-top: 60px;
            height: calc(100vh - 60px);
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #444;
        }

        .sidebar-tabs {
            display: flex;
            border-bottom: 1px solid #444;
        }

        .sidebar-tab {
            flex: 1;
            padding: 15px;
            background: transparent;
            border: none;
            color: var(--vvveb-text-muted);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar-tab.active {
            background: var(--vvveb-panel);
            color: var(--vvveb-text);
            border-bottom: 2px solid var(--vvveb-primary);
        }

        .sidebar-content {
            padding: 20px;
        }

        .section-category {
            margin-bottom: 20px;
        }

        .section-category h6 {
            color: var(--vvveb-text);
            margin-bottom: 10px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section-item {
            background: var(--vvveb-panel);
            border: 1px solid #555;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-item:hover {
            background: var(--vvveb-primary);
            border-color: var(--vvveb-primary);
        }

        .section-icon {
            width: 24px;
            height: 24px;
            background: var(--vvveb-primary);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
        }

        .section-info h6 {
            margin: 0;
            font-size: 13px;
            color: var(--vvveb-text);
        }

        .section-info small {
            color: var(--vvveb-text-muted);
            font-size: 11px;
        }

        /* Main Content Area */
        .vvveb-main {
            flex: 1;
            margin-top: 60px;
            height: calc(100vh - 60px);
            position: relative;
            background: #f8f9fa;
        }

        .vvveb-canvas {
            width: 100%;
            height: 100%;
            border: none;
            background: white;
        }

        /* Right Navigator Panel */
        .vvveb-navigator {
            width: 250px;
            background: var(--vvveb-sidebar);
            border-left: 1px solid #444;
            margin-top: 60px;
            height: calc(100vh - 60px);
            overflow-y: auto;
        }

        .navigator-header {
            padding: 20px;
            border-bottom: 1px solid #444;
        }

        .navigator-content {
            padding: 20px;
        }

        .navigator-item {
            padding: 8px 0;
            border-bottom: 1px solid #444;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navigator-item:hover {
            background: var(--vvveb-panel);
            padding-left: 10px;
        }

        .navigator-icon {
            width: 16px;
            height: 16px;
            background: var(--vvveb-primary);
            border-radius: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 10px;
        }

        /* Responsive Design */
        .device-buttons {
            display: flex;
            gap: 5px;
        }

        .device-btn {
            width: 40px;
            height: 30px;
            background: var(--vvveb-panel);
            border: 1px solid #555;
            color: var(--vvveb-text);
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .device-btn.active {
            background: var(--vvveb-primary);
            border-color: var(--vvveb-primary);
        }

        /* Loading State */
        .loading-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: var(--vvveb-text-muted);
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #444;
            border-top: 4px solid var(--vvveb-primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Modal Styles */
        .vvveb-modal .modal-content {
            background: var(--vvveb-sidebar);
            border: 1px solid #444;
            color: var(--vvveb-text);
        }

        .vvveb-modal .modal-header {
            border-bottom: 1px solid #444;
        }

        .vvveb-modal .form-control {
            background: var(--vvveb-panel);
            border: 1px solid #555;
            color: var(--vvveb-text);
        }

        .vvveb-modal .form-control:focus {
            background: var(--vvveb-panel);
            border-color: var(--vvveb-primary);
            color: var(--vvveb-text);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
</head>
<body>
    <!-- Top Toolbar -->
    <div class="vvveb-toolbar">
        <div class="toolbar-left">
            <div class="logo">Vvveb</div>
            <button class="toolbar-btn" onclick="undo()" title="Undo">
                <i class="fas fa-undo"></i>
            </button>
            <button class="toolbar-btn" onclick="redo()" title="Redo">
                <i class="fas fa-redo"></i>
            </button>
            <button class="toolbar-btn" onclick="preview()" title="Preview">
                <i class="fas fa-eye"></i>
            </button>
            <button class="toolbar-btn" onclick="showBlocks()" title="Blocks">
                <i class="fas fa-cubes"></i>
            </button>
            <button class="toolbar-btn" onclick="showLayers()" title="Layers">
                <i class="fas fa-layer-group"></i>
            </button>
            <button class="toolbar-btn" onclick="showStyles()" title="Styles">
                <i class="fas fa-paint-brush"></i>
            </button>
            <button class="toolbar-btn" onclick="showTraits()" title="Traits">
                <i class="fas fa-cog"></i>
            </button>
        </div>
        
        <div class="toolbar-center">
            <div class="device-buttons">
                <button class="device-btn active" data-device="desktop" onclick="setDevice('desktop')">
                    <i class="fas fa-desktop"></i>
                </button>
                <button class="device-btn" data-device="tablet" onclick="setDevice('tablet')">
                    <i class="fas fa-tablet-alt"></i>
                </button>
                <button class="device-btn" data-device="mobile" onclick="setDevice('mobile')">
                    <i class="fas fa-mobile-alt"></i>
                </button>
            </div>
            <span class="zoom-level">100%</span>
        </div>
        
        <div class="toolbar-right">
            <button class="toolbar-btn" onclick="showCode()" title="Code Editor">
                <i class="fas fa-code"></i>
            </button>
            <button class="toolbar-btn" onclick="toggleFullscreen()" title="Fullscreen">
                <i class="fas fa-expand"></i>
            </button>
            <button class="toolbar-btn" onclick="savePage()">
                <i class="fas fa-save"></i> Save Page
            </button>
            <button class="toolbar-btn" onclick="exportHTML()">
                <i class="fas fa-download"></i> Export
            </button>
            <button class="toolbar-btn" onclick="toggleTheme()" title="Toggle Theme">
                <i class="fas fa-moon"></i>
            </button>
        </div>
    </div>

    <!-- Main Editor Container -->
    <div class="vvveb-editor">
        <!-- Left Sidebar -->
        <div class="vvveb-sidebar">
            <div class="sidebar-header">
                <h5>{{ $contentType->name }} - Visual Builder</h5>
                <p class="text-muted mb-0">Drag components to build your page</p>
            </div>
            
            <div class="sidebar-tabs">
                <button class="sidebar-tab active" onclick="switchTab('sections')">Sections</button>
                <button class="sidebar-tab" onclick="switchTab('components')">Components</button>
                <button class="sidebar-tab" onclick="switchTab('pages')">Pages</button>
            </div>
            
            <div class="sidebar-content">
                <!-- Sections Tab -->
                <div id="sections-tab" class="tab-content active">
                    <div class="section-category">
                        <h6>Hero Sections</h6>
                        <div class="section-item" draggable="true" data-type="hero-1">
                            <div class="section-icon"><i class="fas fa-star"></i></div>
                            <div class="section-info">
                                <h6>Hero 1</h6>
                                <small>Large banner with title</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="hero-2">
                            <div class="section-icon"><i class="fas fa-star"></i></div>
                            <div class="section-info">
                                <h6>Hero 2</h6>
                                <small>Centered content hero</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="hero-3">
                            <div class="section-icon"><i class="fas fa-star"></i></div>
                            <div class="section-info">
                                <h6>Hero 3</h6>
                                <small>Video background hero</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="section-category">
                        <h6>Content Sections</h6>
                        <div class="section-item" draggable="true" data-type="features">
                            <div class="section-icon"><i class="fas fa-cogs"></i></div>
                            <div class="section-info">
                                <h6>Features</h6>
                                <small>Feature showcase grid</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="testimonials">
                            <div class="section-icon"><i class="fas fa-quote-left"></i></div>
                            <div class="section-info">
                                <h6>Testimonials</h6>
                                <small>Customer testimonials</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="pricing">
                            <div class="section-icon"><i class="fas fa-dollar-sign"></i></div>
                            <div class="section-info">
                                <h6>Pricing</h6>
                                <small>Pricing table section</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="team">
                            <div class="section-icon"><i class="fas fa-users"></i></div>
                            <div class="section-info">
                                <h6>Team</h6>
                                <small>Team members section</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="section-category">
                        <h6>Forms</h6>
                        <div class="section-item" draggable="true" data-type="contact-form">
                            <div class="section-icon"><i class="fas fa-envelope"></i></div>
                            <div class="section-info">
                                <h6>Contact Form</h6>
                                <small>Contact form section</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="newsletter">
                            <div class="section-icon"><i class="fas fa-newspaper"></i></div>
                            <div class="section-info">
                                <h6>Newsletter</h6>
                                <small>Newsletter signup</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="section-category">
                        <h6>Navigation</h6>
                        <div class="section-item" draggable="true" data-type="navbar">
                            <div class="section-icon"><i class="fas fa-bars"></i></div>
                            <div class="section-info">
                                <h6>Navbar</h6>
                                <small>Navigation bar</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="footer">
                            <div class="section-icon"><i class="fas fa-footer"></i></div>
                            <div class="section-info">
                                <h6>Footer</h6>
                                <small>Page footer</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Components Tab -->
                <div id="components-tab" class="tab-content">
                    <div class="section-category">
                        <h6>Basic Elements</h6>
                        <div class="section-item" draggable="true" data-type="text">
                            <div class="section-icon"><i class="fas fa-font"></i></div>
                            <div class="section-info">
                                <h6>Text</h6>
                                <small>Text block</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="heading">
                            <div class="section-icon"><i class="fas fa-heading"></i></div>
                            <div class="section-info">
                                <h6>Heading</h6>
                                <small>H1-H6 headings</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="paragraph">
                            <div class="section-icon"><i class="fas fa-paragraph"></i></div>
                            <div class="section-info">
                                <h6>Paragraph</h6>
                                <small>Text paragraph</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="image">
                            <div class="section-icon"><i class="fas fa-image"></i></div>
                            <div class="section-info">
                                <h6>Image</h6>
                                <small>Image element</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="button">
                            <div class="section-icon"><i class="fas fa-mouse-pointer"></i></div>
                            <div class="section-info">
                                <h6>Button</h6>
                                <small>Clickable button</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="link">
                            <div class="section-icon"><i class="fas fa-link"></i></div>
                            <div class="section-info">
                                <h6>Link</h6>
                                <small>Hyperlink</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="section-category">
                        <h6>Layout Elements</h6>
                        <div class="section-item" draggable="true" data-type="container">
                            <div class="section-icon"><i class="fas fa-square"></i></div>
                            <div class="section-info">
                                <h6>Container</h6>
                                <small>Bootstrap container</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="row">
                            <div class="section-icon"><i class="fas fa-grip-lines"></i></div>
                            <div class="section-info">
                                <h6>Row</h6>
                                <small>Bootstrap row</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="column">
                            <div class="section-icon"><i class="fas fa-columns"></i></div>
                            <div class="section-info">
                                <h6>Column</h6>
                                <small>Bootstrap column</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="card">
                            <div class="section-icon"><i class="fas fa-id-card"></i></div>
                            <div class="section-info">
                                <h6>Card</h6>
                                <small>Bootstrap card</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="section-category">
                        <h6>Form Elements</h6>
                        <div class="section-item" draggable="true" data-type="form">
                            <div class="section-icon"><i class="fas fa-wpforms"></i></div>
                            <div class="section-info">
                                <h6>Form</h6>
                                <small>Form container</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="input">
                            <div class="section-icon"><i class="fas fa-keyboard"></i></div>
                            <div class="section-info">
                                <h6>Input</h6>
                                <small>Text input field</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="textarea">
                            <div class="section-icon"><i class="fas fa-align-left"></i></div>
                            <div class="section-info">
                                <h6>Textarea</h6>
                                <small>Multi-line text input</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="select">
                            <div class="section-icon"><i class="fas fa-caret-down"></i></div>
                            <div class="section-info">
                                <h6>Select</h6>
                                <small>Dropdown select</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="section-category">
                        <h6>Media Elements</h6>
                        <div class="section-item" draggable="true" data-type="video">
                            <div class="section-icon"><i class="fas fa-video"></i></div>
                            <div class="section-info">
                                <h6>Video</h6>
                                <small>Video element</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="audio">
                            <div class="section-icon"><i class="fas fa-volume-up"></i></div>
                            <div class="section-info">
                                <h6>Audio</h6>
                                <small>Audio element</small>
                            </div>
                        </div>
                        <div class="section-item" draggable="true" data-type="iframe">
                            <div class="section-icon"><i class="fas fa-window-maximize"></i></div>
                            <div class="section-info">
                                <h6>Iframe</h6>
                                <small>Embedded content</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Pages Tab -->
                <div id="pages-tab" class="tab-content">
                    <div class="section-category">
                        <h6>Page Templates</h6>
                        <div class="section-item" onclick="loadTemplate('blank')">
                            <div class="section-icon"><i class="fas fa-file"></i></div>
                            <div class="section-info">
                                <h6>Blank Page</h6>
                                <small>Start from scratch</small>
                            </div>
                        </div>
                        <div class="section-item" onclick="loadTemplate('landing')">
                            <div class="section-icon"><i class="fas fa-rocket"></i></div>
                            <div class="section-info">
                                <h6>Landing Page</h6>
                                <small>Complete landing page</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="vvveb-main">
            <div class="loading-container" id="loadingContainer">
                <div class="spinner"></div>
                <p>Loading Visual Builder...</p>
            </div>
            <iframe id="vvveb-canvas" class="vvveb-canvas" style="display: none;"></iframe>
        </div>
        
        <!-- Right Navigator Panel -->
        <div class="vvveb-navigator">
            <div class="navigator-header">
                <h6>Navigator</h6>
                <small class="text-muted">Page structure</small>
            </div>
            <div class="navigator-content" id="navigatorContent">
                <div class="navigator-item">
                    <div class="navigator-icon"><i class="fas fa-globe"></i></div>
                    <span>body</span>
                </div>
                <div class="navigator-item">
                    <div class="navigator-icon"><i class="fas fa-square"></i></div>
                    <span>container</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Save Modal -->
    <div class="modal fade vvveb-modal" id="savePageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Save Page</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="savePageForm">
                        <div class="mb-3">
                            <label class="form-label">Page Name</label>
                            <input type="text" class="form-control" name="page_name" value="{{ $contentType->name }} Page" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File Name</label>
                            <input type="text" class="form-control" name="file_name" value="{{ $contentType->slug }}-page" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Save to Folder</label>
                            <select class="form-select" name="folder">
                                <option value="templates">Templates</option>
                                <option value="pages">Pages</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="confirmSave()">Save Page</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- GrapesJS Core with fallbacks -->
    <script>
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
                setTimeout(initializeVvveb, 100);
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
    
    // Start loading when page loads
    document.addEventListener('DOMContentLoaded', loadGrapesJS);
    </script>
    
    <script>
        let editor;
        let currentDevice = 'desktop';
        let isDarkTheme = true;
        let currentPage = 'home';
        
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
        
        // Initialize Vvveb.js Editor
        function initializeVvveb() {
            try {
                console.log('Initializing Vvveb.js editor...');
                
                // Check if GrapesJS is loaded
                if (typeof grapesjs === 'undefined') {
                    console.error('GrapesJS not loaded');
                    showError('GrapesJS library failed to load. Please refresh the page.');
                    return;
                }
                
                // Hide loading container
                document.getElementById('loadingContainer').style.display = 'none';
                document.getElementById('vvveb-canvas').style.display = 'block';
                
                // Initialize GrapesJS with Vvveb.js styling
                editor = grapesjs.init({
                    container: '#vvveb-canvas',
                    height: '100%',
                    width: '100%',
                    layerManager: {
                        appendTo: '.vvveb-navigator'
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
                
                console.log('Vvveb.js editor initialized successfully!');
                
                // Set default content
                setTimeout(() => {
                    if (editor.getComponents().length === 0) {
                        editor.setComponents(`
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="jumbotron bg-primary text-white text-center py-5">
                                            <h1 class="display-4">Welcome to Vvveb.js Builder</h1>
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
                
                // Update navigator when components change
                editor.on('component:add component:remove component:update', function() {
                    updateNavigator();
                });
                
            } catch (error) {
                console.error('Error initializing Vvveb.js:', error);
                showError('Failed to initialize page builder: ' + error.message);
            }
        }
        
        // Update Navigator Panel
        function updateNavigator() {
            const navigatorContent = document.getElementById('navigatorContent');
            const components = editor.getComponents();
            
            let html = '<div class="navigator-item"><div class="navigator-icon"><i class="fas fa-globe"></i></div><span>body</span></div>';
            
            if (components && components.length > 0) {
                components.forEach((component, index) => {
                    const tag = component.get('tagName') || 'div';
                    const type = component.get('type') || 'element';
                    const icon = getComponentIcon(tag, type);
                    
                    html += `
                        <div class="navigator-item" onclick="selectComponent(${index})">
                            <div class="navigator-icon">${icon}</div>
                            <span>${tag}</span>
                        </div>
                    `;
                });
            }
            
            navigatorContent.innerHTML = html;
        }
        
        // Get component icon
        function getComponentIcon(tag, type) {
            const icons = {
                'div': '<i class="fas fa-square"></i>',
                'section': '<i class="fas fa-square"></i>',
                'header': '<i class="fas fa-header"></i>',
                'nav': '<i class="fas fa-bars"></i>',
                'main': '<i class="fas fa-home"></i>',
                'article': '<i class="fas fa-file-text"></i>',
                'aside': '<i class="fas fa-sidebar"></i>',
                'footer': '<i class="fas fa-footer"></i>',
                'h1': '<i class="fas fa-heading"></i>',
                'h2': '<i class="fas fa-heading"></i>',
                'h3': '<i class="fas fa-heading"></i>',
                'h4': '<i class="fas fa-heading"></i>',
                'h5': '<i class="fas fa-heading"></i>',
                'h6': '<i class="fas fa-heading"></i>',
                'p': '<i class="fas fa-paragraph"></i>',
                'img': '<i class="fas fa-image"></i>',
                'button': '<i class="fas fa-mouse-pointer"></i>',
                'a': '<i class="fas fa-link"></i>',
                'ul': '<i class="fas fa-list"></i>',
                'ol': '<i class="fas fa-list-ol"></i>',
                'li': '<i class="fas fa-list-item"></i>',
                'form': '<i class="fas fa-wpforms"></i>',
                'input': '<i class="fas fa-keyboard"></i>',
                'textarea': '<i class="fas fa-align-left"></i>',
                'select': '<i class="fas fa-caret-down"></i>',
                'table': '<i class="fas fa-table"></i>',
                'tr': '<i class="fas fa-table-row"></i>',
                'td': '<i class="fas fa-table-cell"></i>',
                'th': '<i class="fas fa-table-header"></i>'
            };
            
            return icons[tag] || '<i class="fas fa-cube"></i>';
        }
        
        // Select component in navigator
        function selectComponent(index) {
            const components = editor.getComponents();
            if (components && components[index]) {
                editor.select(components[index]);
            }
        }
        
        // Toolbar Functions
        function undo() {
            if (editor) editor.UndoManager.undo();
        }
        
        function redo() {
            if (editor) editor.UndoManager.redo();
        }
        
        function preview() {
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
        
        function setDevice(device) {
            currentDevice = device;
            document.querySelectorAll('.device-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelector(`[data-device="${device}"]`).classList.add('active');
            
            if (editor) {
                const deviceManager = editor.DeviceManager;
                switch(device) {
                    case 'mobile':
                        deviceManager.select('Mobile');
                        break;
                    case 'tablet':
                        deviceManager.select('Tablet');
                        break;
                    case 'desktop':
                    default:
                        deviceManager.select('Desktop');
                        break;
                }
            }
        }
        
        // Vvveb.js specific functions
        function showBlocks() {
            if (editor) {
                editor.runCommand('open-blocks');
            }
        }
        
        function showLayers() {
            if (editor) {
                editor.runCommand('open-layers');
            }
        }
        
        function showStyles() {
            if (editor) {
                editor.runCommand('open-styles');
            }
        }
        
        function showTraits() {
            if (editor) {
                editor.runCommand('open-traits');
            }
        }
        
        function toggleFullscreen() {
            if (editor) {
                editor.runCommand('toggle-fullscreen');
            }
        }
        
        function showCode() {
            if (editor) {
                editor.runCommand('open-code');
            }
        }
        
        function showSettings() {
            if (editor) {
                editor.runCommand('open-settings');
            }
        }
        
        function savePage() {
            new bootstrap.Modal(document.getElementById('savePageModal')).show();
        }
        
        function confirmSave() {
            const form = document.getElementById('savePageForm');
            const formData = new FormData(form);
            
            // Save to server
            fetch('{{ route("content-types.save-layout", $contentType->slug) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    name: formData.get('page_name'),
                    content: editor.getHtml(),
                    css: editor.getCss()
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess('Page saved successfully!');
                    bootstrap.Modal.getInstance(document.getElementById('savePageModal')).hide();
                } else {
                    showError('Failed to save page: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error saving page:', error);
                showError('Failed to save page');
            });
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
        
        function toggleTheme() {
            isDarkTheme = !isDarkTheme;
            const themeIcon = document.querySelector('.toolbar-right .toolbar-btn:last-child i');
            themeIcon.className = isDarkTheme ? 'fas fa-moon' : 'fas fa-sun';
            
            // Apply theme changes
            document.body.style.filter = isDarkTheme ? 'none' : 'invert(1) hue-rotate(180deg)';
        }
        
        // Sidebar Functions
        function switchTab(tab) {
            document.querySelectorAll('.sidebar-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
            
            event.target.classList.add('active');
            document.getElementById(tab + '-tab').classList.add('active');
        }
        
        function loadTemplate(template) {
            if (editor) {
                let templateContent = '';
                
                switch(template) {
                    case 'blank':
                        templateContent = '<div class="container"><div class="row"><div class="col-12"><h1>Blank Page</h1><p>Start building your content here.</p></div></div></div>';
                        break;
                    case 'landing':
                        templateContent = `
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="jumbotron bg-primary text-white text-center py-5">
                                            <h1 class="display-4">Welcome to {{ $contentType->name }}</h1>
                                            <p class="lead">This is a professional landing page template.</p>
                                            <button class="btn btn-light btn-lg">Get Started</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row py-5">
                                    <div class="col-md-4 text-center">
                                        <h3>Feature 1</h3>
                                        <p>Description of your first feature.</p>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h3>Feature 2</h3>
                                        <p>Description of your second feature.</p>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h3>Feature 3</h3>
                                        <p>Description of your third feature.</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        break;
                }
                
                editor.setComponents(templateContent);
                showSuccess('Template loaded successfully!');
            }
        }
        
        // Drag and Drop for Sections
        document.addEventListener('DOMContentLoaded', function() {
            const sectionItems = document.querySelectorAll('.section-item[draggable="true"]');
            
            sectionItems.forEach(item => {
                item.addEventListener('dragstart', function(e) {
                    e.dataTransfer.setData('text/plain', this.dataset.type);
                });
            });
            
            // Add drop zone to canvas
            const canvas = document.getElementById('vvveb-canvas');
            if (canvas) {
                canvas.addEventListener('dragover', function(e) {
                    e.preventDefault();
                });
                
                canvas.addEventListener('drop', function(e) {
                    e.preventDefault();
                    const sectionType = e.dataTransfer.getData('text/plain');
                    addSection(sectionType);
                });
            }
        });
        
        function addSection(type) {
            if (editor) {
                let sectionHtml = '';
                
                switch(type) {
                    case 'hero-1':
                        sectionHtml = `
                            <div class="jumbotron bg-primary text-white text-center py-5">
                                <h1 class="display-4">Hero Section</h1>
                                <p class="lead">This is a hero section with call-to-action.</p>
                                <button class="btn btn-light btn-lg">Learn More</button>
                            </div>
                        `;
                        break;
                    case 'hero-2':
                        sectionHtml = `
                            <div class="container py-5">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h1 class="display-4">Welcome to Our Site</h1>
                                        <p class="lead">Build amazing websites with our visual builder.</p>
                                        <button class="btn btn-primary btn-lg">Get Started</button>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxOCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPjUwMHgzMDA8L3RleHQ+PC9zdmc+" class="img-fluid" alt="Hero Image">
                                    </div>
                                </div>
                            </div>
                        `;
                        break;
                    case 'hero-3':
                        sectionHtml = `
                            <div class="hero-video bg-dark text-white text-center py-5" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTkyMCIgaGVpZ2h0PSIxMDgwIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9IiMzMzMiLz48dGV4dCB4PSI1MCUiIHk9IjUwJSIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjI0IiBmaWxsPSIjNjY2IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkeT0iLjNlbSI+MTkyMHgxMDgwPC90ZXh0Pjwvc3ZnPg=='); background-size: cover; background-position: center;">
                                <div class="container">
                                    <h1 class="display-4">Video Background Hero</h1>
                                    <p class="lead">Stunning video background with overlay content.</p>
                                    <button class="btn btn-light btn-lg">Watch Video</button>
                                </div>
                            </div>
                        `;
                        break;
                    case 'features':
                        sectionHtml = `
                            <div class="container py-5">
                                <div class="row text-center">
                                    <div class="col-12 mb-5">
                                        <h2>Our Features</h2>
                                        <p class="lead">Discover what makes us different</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 text-center mb-4">
                                        <div class="feature-icon mb-3">
                                            <i class="fas fa-rocket fa-3x text-primary"></i>
                                        </div>
                                        <h4>Fast Performance</h4>
                                        <p>Lightning fast loading times and optimized performance.</p>
                                    </div>
                                    <div class="col-md-4 text-center mb-4">
                                        <div class="feature-icon mb-3">
                                            <i class="fas fa-shield-alt fa-3x text-primary"></i>
                                        </div>
                                        <h4>Secure & Reliable</h4>
                                        <p>Enterprise-grade security and 99.9% uptime guarantee.</p>
                                    </div>
                                    <div class="col-md-4 text-center mb-4">
                                        <div class="feature-icon mb-3">
                                            <i class="fas fa-cog fa-3x text-primary"></i>
                                        </div>
                                        <h4>Easy to Use</h4>
                                        <p>Intuitive interface that anyone can master quickly.</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        break;
                    case 'testimonials':
                        sectionHtml = `
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
                                                <div class="mt-3">
                                                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMzAiIGN5PSIzMCIgcj0iMzAiIGZpbGw9IiMwMDdiZmYiLz48dGV4dCB4PSI1MCUiIHk9IjUwJSIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjE0IiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkpEPC90ZXh0Pjwvc3ZnPg==" class="rounded-circle mb-2" alt="Customer">
                                                    <h6 class="mb-0">John Doe</h6>
                                                    <small class="text-muted">CEO, Company Inc.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100">
                                            <div class="card-body text-center">
                                                <p class="card-text">"Amazing results in just a few days. Couldn't be happier!"</p>
                                                <div class="mt-3">
                                                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMzAiIGN5PSIzMCIgcj0iMzAiIGZpbGw9IiMwMDdiZmYiLz48dGV4dCB4PSI1MCUiIHk9IjUwJSIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjE0IiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkpTPC90ZXh0Pjwvc3ZnPg==" class="rounded-circle mb-2" alt="Customer">
                                                    <h6 class="mb-0">Jane Smith</h6>
                                                    <small class="text-muted">Marketing Director</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100">
                                            <div class="card-body text-center">
                                                <p class="card-text">"Outstanding support and incredible value for money."</p>
                                                <div class="mt-3">
                                                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMzAiIGN5PSIzMCIgcj0iMzAiIGZpbGw9IiMwMDdiZmYiLz48dGV4dCB4PSI1MCUiIHk9IjUwJSIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjE0IiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPk1KPC90ZXh0Pjwvc3ZnPg==" class="rounded-circle mb-2" alt="Customer">
                                                    <h6 class="mb-0">Mike Johnson</h6>
                                                    <small class="text-muted">Business Owner</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        break;
                    case 'pricing':
                        sectionHtml = `
                            <div class="container py-5">
                                <div class="row text-center">
                                    <div class="col-12 mb-5">
                                        <h2>Pricing Plans</h2>
                                        <p class="lead">Choose the perfect plan for your needs</p>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100">
                                            <div class="card-header text-center">
                                                <h4>Basic</h4>
                                                <h2 class="text-primary">$29<small>/month</small></h2>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-unstyled">
                                                    <li><i class="fas fa-check text-success me-2"></i>5 Projects</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>10GB Storage</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>Email Support</li>
                                                </ul>
                                                <button class="btn btn-outline-primary w-100">Choose Plan</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100 border-primary">
                                            <div class="card-header text-center bg-primary text-white">
                                                <h4>Pro</h4>
                                                <h2>$59<small>/month</small></h2>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-unstyled">
                                                    <li><i class="fas fa-check text-success me-2"></i>Unlimited Projects</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>100GB Storage</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>Priority Support</li>
                                                </ul>
                                                <button class="btn btn-primary w-100">Choose Plan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        break;
                    case 'team':
                        sectionHtml = `
                            <div class="container py-5">
                                <div class="row text-center">
                                    <div class="col-12 mb-5">
                                        <h2>Meet Our Team</h2>
                                        <p class="lead">The people behind our success</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <div class="card text-center">
                                            <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIyNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPjMwMHgzMDA8L3RleHQ+PC9zdmc+" class="card-img-top" alt="Team Member">
                                            <div class="card-body">
                                                <h5 class="card-title">John Doe</h5>
                                                <p class="text-muted">CEO & Founder</p>
                                                <p class="card-text">Visionary leader with 10+ years experience.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="card text-center">
                                            <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIyNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPjMwMHgzMDA8L3RleHQ+PC9zdmc+" class="card-img-top" alt="Team Member">
                                            <div class="card-body">
                                                <h5 class="card-title">Jane Smith</h5>
                                                <p class="text-muted">CTO</p>
                                                <p class="card-text">Technical expert and innovation driver.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="card text-center">
                                            <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIyNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPjMwMHgzMDA8L3RleHQ+PC9zdmc+" class="card-img-top" alt="Team Member">
                                            <div class="card-body">
                                                <h5 class="card-title">Mike Johnson</h5>
                                                <p class="text-muted">Lead Designer</p>
                                                <p class="card-text">Creative mind behind our beautiful designs.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        break;
                    case 'contact-form':
                        sectionHtml = `
                            <div class="container py-5">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="text-center mb-5">
                                            <h2>Get In Touch</h2>
                                            <p class="lead">We'd love to hear from you</p>
                                        </div>
                                        <form>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <input type="text" class="form-control" placeholder="Your Name" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <input type="email" class="form-control" placeholder="Your Email" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" class="form-control" placeholder="Subject">
                                            </div>
                                            <div class="mb-3">
                                                <textarea class="form-control" rows="5" placeholder="Your Message" required></textarea>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        `;
                        break;
                    case 'newsletter':
                        sectionHtml = `
                            <div class="bg-primary text-white py-5">
                                <div class="container">
                                    <div class="row justify-content-center text-center">
                                        <div class="col-md-6">
                                            <h3>Subscribe to Our Newsletter</h3>
                                            <p>Get the latest updates and news delivered to your inbox.</p>
                                            <form class="mt-4">
                                                <div class="input-group">
                                                    <input type="email" class="form-control" placeholder="Enter your email">
                                                    <button class="btn btn-light" type="submit">Subscribe</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        break;
                    case 'navbar':
                        sectionHtml = `
                            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                <div class="container">
                                    <a class="navbar-brand" href="#">Brand</a>
                                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                                        <span class="navbar-toggler-icon"></span>
                                    </button>
                                    <div class="collapse navbar-collapse" id="navbarNav">
                                        <ul class="navbar-nav ms-auto">
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Home</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">About</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Services</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Contact</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        `;
                        break;
                    case 'footer':
                        sectionHtml = `
                            <footer class="bg-dark text-white py-5">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4 mb-4">
                                            <h5>Company</h5>
                                            <p>Building amazing websites with modern technology.</p>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <h5>Quick Links</h5>
                                            <ul class="list-unstyled">
                                                <li><a href="#" class="text-white-50">Home</a></li>
                                                <li><a href="#" class="text-white-50">About</a></li>
                                                <li><a href="#" class="text-white-50">Services</a></li>
                                                <li><a href="#" class="text-white-50">Contact</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <h5>Contact Info</h5>
                                            <p>Email: info@company.com</p>
                                            <p>Phone: +1 (555) 123-4567</p>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <p>&copy; 2024 Company. All rights reserved.</p>
                                        </div>
                                    </div>
                                </div>
                            </footer>
                        `;
                        break;
                }
                
                if (sectionHtml) {
                    editor.addComponents(sectionHtml);
                    showSuccess('Section added successfully!');
                }
            }
        }
        
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
            
            // Wait for Vvveb.js to load
            let loadAttempts = 0;
            const maxAttempts = 10;
            
            function tryInitialize() {
                loadAttempts++;
                
                if (typeof grapesjs !== 'undefined') {
                    console.log('GrapesJS loaded, initializing editor...');
                    initializeVvveb();
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
