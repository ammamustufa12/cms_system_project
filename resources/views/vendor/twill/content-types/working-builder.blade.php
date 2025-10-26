<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $contentType->name }} - Page Builder</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .page-builder-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: #1a1a1a;
            color: #fff;
        }

        /* Header Bar */
        .page-builder-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            z-index: 1000;
            flex-shrink: 0;
        }

        .header-left, .header-right {
            display: flex;
            gap: 8px;
        }

        .header-center {
            display: flex;
            align-items: center;
        }

        .responsive-options {
            display: flex;
            gap: 5px;
        }

        .responsive-options .btn {
            font-size: 12px;
            padding: 5px 10px;
        }

        /* Main Body */
        .page-builder-body {
            display: flex;
            flex: 1;
            height: calc(100vh - 60px);
            overflow: hidden;
        }

        /* Left Sidebar - Components */
        .components-sidebar {
            width: 280px;
            background: #2d2d2d;
            border-right: 1px solid #404040;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .sidebar-header {
            padding: 15px;
            border-bottom: 1px solid #404040;
            flex-shrink: 0;
        }

        .sidebar-header h6 {
            color: #fff;
            margin: 0 0 10px 0;
            font-weight: 600;
        }

        .sidebar-tabs {
            display: flex;
            gap: 5px;
        }

        .tab-btn {
            background: #404040;
            border: none;
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
        }

        .tab-btn.active {
            background: #667eea;
        }

        .search-bar {
            padding: 15px;
            position: relative;
            border-bottom: 1px solid #404040;
            flex-shrink: 0;
        }

        .search-bar input {
            background: #404040;
            border: 1px solid #555;
            color: #fff;
            padding: 8px 30px 8px 10px;
            border-radius: 4px;
            width: 100%;
        }

        .search-bar input::placeholder {
            color: #999;
        }

        .search-bar i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .components-content {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
        }

        .component-category {
            margin-bottom: 15px;
        }

        .category-header {
            display: flex;
            align-items: center;
            padding: 8px 0;
            cursor: pointer;
            color: #fff;
            font-weight: 500;
        }

        .category-header i {
            margin-right: 8px;
            transition: transform 0.2s;
        }

        .category-content {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-top: 10px;
        }

        .component-item {
            background: #404040;
            border: 1px solid #555;
            border-radius: 6px;
            padding: 12px 8px;
            cursor: grab;
            transition: all 0.2s;
            text-align: center;
            color: #fff;
            font-size: 12px;
        }

        .component-item:hover {
            background: #555;
            border-color: #667eea;
            transform: translateY(-2px);
        }

        .component-item:active {
            cursor: grabbing;
        }

        .component-item i {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
            color: #667eea;
        }

        /* Canvas Container */
        .canvas-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #f8f9fa;
            overflow: hidden;
        }

        .canvas-header {
            background: #fff;
            padding: 10px 20px;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            color: #333;
            flex-shrink: 0;
        }

        .canvas-area {
            flex: 1;
            background: #fff;
            margin: 20px;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            overflow-y: auto;
            position: relative;
        }

        .canvas-area.drag-over {
            border-color: #667eea;
            background: #f0f4ff;
        }

        .empty-canvas {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 400px;
            color: #999;
        }

        .field-preview {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .field-preview:hover {
            border-color: #667eea;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
        }

        .field-preview.selected {
            border-color: #667eea;
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
        }

        .builder-element {
            position: relative;
            margin-bottom: 15px;
            border: 2px solid transparent;
            border-radius: 8px;
            padding: 10px;
            transition: all 0.2s;
        }

        .builder-element:hover {
            border-color: #667eea;
        }

        .builder-element.selected {
            border-color: #667eea;
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
        }

        .element-controls {
            position: absolute;
            top: -10px;
            right: -10px;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .builder-element:hover .element-controls {
            opacity: 1;
        }

        .preview-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        .image-preview img {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .repeater-preview .alert {
            border-radius: 8px;
        }

        /* Right Sidebar - Settings */
        .settings-sidebar {
            width: 280px;
            background: #2d2d2d;
            border-left: 1px solid #404040;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .sidebar-header {
            padding: 15px;
            border-bottom: 1px solid #404040;
            flex-shrink: 0;
        }

        .settings-content {
            flex: 1;
            padding: 20px;
            color: #fff;
            overflow-y: auto;
        }

        .settings-content h5 {
            color: #fff;
            margin-bottom: 10px;
        }

        .settings-content h6 {
            color: #fff;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .settings-content p {
            color: #999;
            font-size: 14px;
        }

        .settings-content .form-control {
            background: #404040;
            border: 1px solid #555;
            color: #fff;
        }

        .settings-content .form-control:focus {
            background: #404040;
            border-color: #667eea;
            color: #fff;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .settings-content .form-select {
            background: #404040;
            border: 1px solid #555;
            color: #fff;
        }

        .settings-content .form-select:focus {
            background: #404040;
            border-color: #667eea;
            color: #fff;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .settings-content .form-label {
            color: #fff;
            font-weight: 500;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .components-sidebar, .settings-sidebar {
                width: 250px;
            }
        }

        @media (max-width: 768px) {
            .page-builder-body {
                flex-direction: column;
            }
            
            .components-sidebar, .settings-sidebar {
                width: 100%;
                height: 200px;
            }
            
            .canvas-container {
                height: 400px;
            }
        }
    </style>
</head>
<body>
<div class="page-builder-container">
    <!-- Top Header Bar -->
    <div class="page-builder-header">
        <div class="header-left">
            <button class="btn btn-success btn-sm" onclick="saveContent()">
                <i class="fas fa-save"></i> Save
            </button>
            <button class="btn btn-primary btn-sm" onclick="exportHTML()">
                <i class="fas fa-code"></i> Export HTML
            </button>
            <button class="btn btn-primary btn-sm" onclick="exportJSON()">
                <i class="fas fa-file-code"></i> Export JSON
            </button>
            <button class="btn btn-secondary btn-sm" onclick="importContent()">
                <i class="fas fa-upload"></i> Import
            </button>
            <button class="btn btn-secondary btn-sm" onclick="loadTemplate()">
                <i class="fas fa-folder-open"></i> Load
            </button>
        </div>
        
        <div class="header-center">
            <div class="responsive-options">
                <button class="btn btn-outline-light btn-sm active" data-device="desktop">
                    <i class="fas fa-desktop"></i> Desktop (1920x1080)
                </button>
                <button class="btn btn-outline-light btn-sm" data-device="tablet">
                    <i class="fas fa-tablet-alt"></i> Tablet (768x1024)
                </button>
                <button class="btn btn-outline-light btn-sm" data-device="mobile">
                    <i class="fas fa-mobile-alt"></i> Mobile (375x667)
                </button>
            </div>
        </div>
        
        <div class="header-right">
            <button class="btn btn-warning btn-sm" onclick="showGlobalSettings()">
                <i class="fas fa-globe"></i> Global
            </button>
            <button class="btn btn-warning btn-sm" onclick="showNavigator()">
                <i class="fas fa-sitemap"></i> Navigator
            </button>
            <button class="btn btn-info btn-sm" onclick="showTemplates()">
                <i class="fas fa-layer-group"></i> Templates
            </button>
            <button class="btn btn-secondary btn-sm" onclick="undo()">
                <i class="fas fa-undo"></i>
            </button>
            <button class="btn btn-secondary btn-sm" onclick="redo()">
                <i class="fas fa-redo"></i>
            </button>
            <button class="btn btn-success btn-sm" onclick="preview()">
                <i class="fas fa-eye"></i> Preview
            </button>
        </div>
    </div>

    <div class="page-builder-body">
        <!-- Left Sidebar - Components -->
        <div class="components-sidebar">
            <div class="sidebar-header">
                <h6>Components</h6>
                <div class="sidebar-tabs">
                    <button class="tab-btn active" data-tab="components">Components</button>
                    <button class="tab-btn" data-tab="blocks">Blocks</button>
                </div>
            </div>
            
            <div class="search-bar">
                <input type="text" placeholder="Search components" class="form-control">
                <i class="fas fa-search"></i>
                <i class="fas fa-asterisk"></i>
            </div>
            
            <div class="components-content">
                <div class="component-category">
                    <div class="category-header" onclick="toggleCategory('base')">
                        <i class="fas fa-chevron-down"></i>
                        <span>Base</span>
                    </div>
                    <div class="category-content" id="base-category">
                        <div class="component-item" draggable="true" data-type="h1">
                            <i class="fas fa-heading"></i>
                            <span>H1 Heading</span>
                        </div>
                        <div class="component-item" draggable="true" data-type="image">
                            <i class="fas fa-image"></i>
                            <span>Image</span>
                        </div>
                        <div class="component-item" draggable="true" data-type="hr">
                            <i class="fas fa-minus"></i>
                            <span>Horizontal Rule</span>
                        </div>
                        <div class="component-item" draggable="true" data-type="form">
                            <i class="fas fa-wpforms"></i>
                            <span>Form</span>
                        </div>
                        <div class="component-item" draggable="true" data-type="input">
                            <i class="fas fa-keyboard"></i>
                            <span>Input</span>
                        </div>
                        <div class="component-item" draggable="true" data-type="textarea">
                            <i class="fas fa-align-left"></i>
                            <span>Text Area</span>
                        </div>
                        <div class="component-item" draggable="true" data-type="select">
                            <i class="fas fa-list"></i>
                            <span>Select Input</span>
                        </div>
                        <div class="component-item" draggable="true" data-type="checkbox">
                            <i class="fas fa-check-square"></i>
                            <span>Checkbox</span>
                        </div>
                        <div class="component-item" draggable="true" data-type="radio">
                            <i class="fas fa-dot-circle"></i>
                            <span>Radio Button</span>
                        </div>
                        <div class="component-item" draggable="true" data-type="link">
                            <i class="fas fa-link"></i>
                            <span>Link</span>
                        </div>
                    </div>
                </div>
                
                <div class="component-category">
                    <div class="category-header" onclick="toggleCategory('basic')">
                        <i class="fas fa-chevron-down"></i>
                        <span>Basic</span>
                    </div>
                    <div class="category-content" id="basic-category">
                        <div class="component-item" draggable="true" data-type="h1">
                            <i class="fas fa-heading"></i>
                            <span>H1 Heading</span>
                        </div>
                        <div class="component-item" draggable="true" data-type="text-editor">
                            <i class="fas fa-edit"></i>
                            <span>Text Editor</span>
                        </div>
                        <div class="component-item" draggable="true" data-type="paragraph">
                            <i class="fas fa-paragraph"></i>
                            <span>Paragraph</span>
                        </div>
                        <div class="component-item" draggable="true" data-type="button">
                            <i class="fas fa-mouse-pointer"></i>
                            <span>Button</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Center - Canvas -->
        <div class="canvas-container">
            <div class="canvas-header">
                <span>CANVAS</span>
                <button class="btn btn-danger btn-sm" onclick="clearCanvas()">Clear</button>
            </div>
            <div id="canvas" class="canvas-area">
                @if(!empty($fieldsSchema))
                    <div class="preview-content">
                        @foreach($fieldsSchema as $fieldKey => $field)
                            <div class="field-preview" data-field="{{ $fieldKey }}">
                                <label class="form-label">{{ $field['label'] ?? ucfirst(str_replace('_', ' ', $fieldKey)) }}</label>
                                
                                @switch($field['type'])
                                    @case('text')
                                        <input type="text" class="form-control" value="{{ $sampleData[$fieldKey] ?? '' }}" readonly>
                                        @break
                                    
                                    @case('textarea')
                                        <textarea class="form-control" rows="3" readonly>{{ $sampleData[$fieldKey] ?? '' }}</textarea>
                                        @break
                                    
                                    @case('image')
                                        <div class="image-preview">
                                            <img src="{{ $sampleData[$fieldKey] ?? 'https://via.placeholder.com/400x300?text=No+Image' }}" 
                                                 class="img-fluid" style="max-height: 200px;">
                                        </div>
                                        @break
                                    
                                    @case('select')
                                        <select class="form-select" disabled>
                                            <option>{{ $sampleData[$fieldKey] ?? 'Select an option' }}</option>
                                        </select>
                                        @break
                                    
                                    @case('boolean')
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" 
                                                   {{ ($sampleData[$fieldKey] ?? false) ? 'checked' : '' }} disabled>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                        @break
                                    
                                    @case('repeater')
                                        <div class="repeater-preview">
                                            <div class="alert alert-info">
                                                <i class="fas fa-list"></i> Repeater Field - {{ count($sampleData[$fieldKey] ?? []) }} items
                                            </div>
                                        </div>
                                        @break
                                    
                                    @default
                                        <input type="text" class="form-control" value="{{ $sampleData[$fieldKey] ?? '' }}" readonly>
                                @endswitch
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-canvas">
                        <div class="text-center text-muted">
                            <i class="fas fa-magic fa-3x mb-3"></i>
                            <h4>Start Building Your Content</h4>
                            <p>Drag elements from the sidebar to start designing your page</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Sidebar - Settings -->
        <div class="settings-sidebar">
            <div class="sidebar-header">
                <h6>SETTINGS</h6>
            </div>
            <div id="settings-panel" class="settings-content">
                <div class="text-center">
                    <i class="fas fa-mouse-pointer fa-2x mb-3"></i>
                    <h5>Select an Element</h5>
                    <p class="text-muted">Click on any element to edit its properties</p>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
<script>
// Professional Page Builder JavaScript
let draggedElement = null;
let selectedElement = null;
let history = [];
let historyIndex = -1;

document.addEventListener('DOMContentLoaded', function() {
    initializePageBuilder();
});

function initializePageBuilder() {
    const canvas = document.getElementById('canvas');
    const componentItems = document.querySelectorAll('.component-item');
    
    // Make components draggable
    componentItems.forEach(item => {
        item.addEventListener('dragstart', function(e) {
            draggedElement = this;
            e.dataTransfer.effectAllowed = 'copy';
        });
    });
    
    // Canvas drop handling
    canvas.addEventListener('dragover', function(e) {
        e.preventDefault();
        canvas.classList.add('drag-over');
    });
    
    canvas.addEventListener('dragleave', function(e) {
        canvas.classList.remove('drag-over');
    });
    
    canvas.addEventListener('drop', function(e) {
        e.preventDefault();
        canvas.classList.remove('drag-over');
        
        if (draggedElement) {
            addElementToCanvas(draggedElement.dataset.type);
        }
    });
    
    // Element selection
    canvas.addEventListener('click', function(e) {
        const element = e.target.closest('.field-preview, .builder-element');
        if (element) {
            selectElement(element);
        }
    });
    
    // Responsive options
    document.querySelectorAll('[data-device]').forEach(btn => {
        btn.addEventListener('click', function() {
            setResponsiveView(this.dataset.device);
        });
    });
    
    // Tab switching
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            switchTab(this.dataset.tab);
        });
    });
}

function addElementToCanvas(type) {
    const canvas = document.getElementById('canvas');
    const emptyCanvas = canvas.querySelector('.empty-canvas');
    
    if (emptyCanvas) {
        emptyCanvas.remove();
    }
    
    let elementHTML = '';
    
    switch(type) {
        case 'h1':
            elementHTML = `
                <div class="builder-element" data-type="h1">
                    <h1 contenteditable="true">Your Heading Here</h1>
                    <div class="element-controls">
                        <button class="btn btn-sm btn-outline-danger" onclick="removeElement(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            break;
        case 'image':
            elementHTML = `
                <div class="builder-element" data-type="image">
                    <img src="https://via.placeholder.com/400x300?text=Your+Image" class="img-fluid" style="max-height: 200px;">
                    <div class="element-controls">
                        <button class="btn btn-sm btn-outline-danger" onclick="removeElement(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            break;
        case 'hr':
            elementHTML = `
                <div class="builder-element" data-type="hr">
                    <hr>
                    <div class="element-controls">
                        <button class="btn btn-sm btn-outline-danger" onclick="removeElement(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            break;
        case 'form':
            elementHTML = `
                <div class="builder-element" data-type="form">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <div class="element-controls">
                        <button class="btn btn-sm btn-outline-danger" onclick="removeElement(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            break;
        case 'input':
            elementHTML = `
                <div class="builder-element" data-type="input">
                    <input type="text" class="form-control" placeholder="Your input here">
                    <div class="element-controls">
                        <button class="btn btn-sm btn-outline-danger" onclick="removeElement(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            break;
        case 'textarea':
            elementHTML = `
                <div class="builder-element" data-type="textarea">
                    <textarea class="form-control" rows="3" placeholder="Your text here"></textarea>
                    <div class="element-controls">
                        <button class="btn btn-sm btn-outline-danger" onclick="removeElement(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            break;
        case 'select':
            elementHTML = `
                <div class="builder-element" data-type="select">
                    <select class="form-select">
                        <option>Select an option</option>
                        <option>Option 1</option>
                        <option>Option 2</option>
                    </select>
                    <div class="element-controls">
                        <button class="btn btn-sm btn-outline-danger" onclick="removeElement(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            break;
        case 'checkbox':
            elementHTML = `
                <div class="builder-element" data-type="checkbox">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input">
                        <label class="form-check-label">Checkbox option</label>
                    </div>
                    <div class="element-controls">
                        <button class="btn btn-sm btn-outline-danger" onclick="removeElement(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            break;
        case 'radio':
            elementHTML = `
                <div class="builder-element" data-type="radio">
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="radio-group">
                        <label class="form-check-label">Radio option</label>
                    </div>
                    <div class="element-controls">
                        <button class="btn btn-sm btn-outline-danger" onclick="removeElement(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            break;
        case 'link':
            elementHTML = `
                <div class="builder-element" data-type="link">
                    <a href="#" contenteditable="true">Your link text</a>
                    <div class="element-controls">
                        <button class="btn btn-sm btn-outline-danger" onclick="removeElement(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            break;
        case 'paragraph':
            elementHTML = `
                <div class="builder-element" data-type="paragraph">
                    <p contenteditable="true">Your paragraph text here. Click to edit and customize your content.</p>
                    <div class="element-controls">
                        <button class="btn btn-sm btn-outline-danger" onclick="removeElement(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            break;
        case 'button':
            elementHTML = `
                <div class="builder-element" data-type="button">
                    <button class="btn btn-primary" contenteditable="true">Your Button Text</button>
                    <div class="element-controls">
                        <button class="btn btn-sm btn-outline-danger" onclick="removeElement(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            break;
        case 'text-editor':
            elementHTML = `
                <div class="builder-element" data-type="text-editor">
                    <div class="text-editor" contenteditable="true">
                        <h3>Your Title</h3>
                        <p>Your content here. This is a rich text editor where you can format your text.</p>
                        <ul>
                            <li>List item 1</li>
                            <li>List item 2</li>
                        </ul>
                    </div>
                    <div class="element-controls">
                        <button class="btn btn-sm btn-outline-danger" onclick="removeElement(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            break;
    }
    
    canvas.insertAdjacentHTML('beforeend', elementHTML);
    
    // Add to history
    saveToHistory();
    
    // Select the new element
    const newElement = canvas.lastElementChild;
    selectElement(newElement);
}

function selectElement(element) {
    // Remove previous selection
    document.querySelectorAll('.builder-element.selected').forEach(el => {
        el.classList.remove('selected');
    });
    
    // Add selection to current element
    element.classList.add('selected');
    selectedElement = element;
    
    // Show properties
    showProperties(element);
}

function showProperties(element) {
    const settingsPanel = document.getElementById('settings-panel');
    const type = element.dataset.type;
    
    let propertiesHTML = `
        <h6>Element Properties</h6>
        <div class="mb-3">
            <label class="form-label">Type</label>
            <input type="text" class="form-control" value="${type}" readonly>
        </div>
    `;
    
    switch(type) {
        case 'h1':
        case 'paragraph':
            propertiesHTML += `
                <div class="mb-3">
                    <label class="form-label">Text</label>
                    <textarea class="form-control" rows="3" onchange="updateElementText(this.value)">${element.textContent}</textarea>
                </div>
            `;
            break;
        case 'button':
            propertiesHTML += `
                <div class="mb-3">
                    <label class="form-label">Button Text</label>
                    <input type="text" class="form-control" value="${element.textContent}" onchange="updateElementText(this.value)">
                </div>
                <div class="mb-3">
                    <label class="form-label">Button Style</label>
                    <select class="form-select" onchange="updateButtonStyle(this.value)">
                        <option value="btn-primary">Primary</option>
                        <option value="btn-secondary">Secondary</option>
                        <option value="btn-success">Success</option>
                        <option value="btn-danger">Danger</option>
                        <option value="btn-warning">Warning</option>
                        <option value="btn-info">Info</option>
                    </select>
                </div>
            `;
            break;
        case 'image':
            propertiesHTML += `
                <div class="mb-3">
                    <label class="form-label">Image URL</label>
                    <input type="url" class="form-control" placeholder="Enter image URL" onchange="updateImageSrc(this.value)">
                </div>
                <div class="mb-3">
                    <label class="form-label">Alt Text</label>
                    <input type="text" class="form-control" placeholder="Enter alt text" onchange="updateImageAlt(this.value)">
                </div>
            `;
            break;
    }
    
    propertiesHTML += `
        <div class="mb-3">
            <button class="btn btn-danger btn-sm w-100" onclick="removeElement(this)">
                <i class="fas fa-trash"></i> Remove Element
            </button>
        </div>
    `;
    
    settingsPanel.innerHTML = propertiesHTML;
}

function updateElementText(text) {
    if (selectedElement) {
        const editableElement = selectedElement.querySelector('[contenteditable="true"]');
        if (editableElement) {
            editableElement.textContent = text;
        }
    }
}

function updateButtonStyle(style) {
    if (selectedElement) {
        const button = selectedElement.querySelector('button');
        if (button) {
            button.className = `btn ${style}`;
        }
    }
}

function updateImageSrc(src) {
    if (selectedElement) {
        const img = selectedElement.querySelector('img');
        if (img && src) {
            img.src = src;
        }
    }
}

function updateImageAlt(alt) {
    if (selectedElement) {
        const img = selectedElement.querySelector('img');
        if (img) {
            img.alt = alt;
        }
    }
}

function removeElement(button) {
    const element = button.closest('.builder-element');
    if (element) {
        element.remove();
        saveToHistory();
        
        // Reset settings panel
        document.getElementById('settings-panel').innerHTML = `
            <div class="text-center">
                <i class="fas fa-mouse-pointer fa-2x mb-3"></i>
                <h5>Select an Element</h5>
                <p class="text-muted">Click on any element to edit its properties</p>
            </div>
        `;
    }
}

function setResponsiveView(device) {
    const canvas = document.getElementById('canvas');
    const buttons = document.querySelectorAll('[data-device]');
    
    // Update button states
    buttons.forEach(btn => btn.classList.remove('active'));
    document.querySelector(`[data-device="${device}"]`).classList.add('active');
    
    // Apply responsive styles
    canvas.className = 'canvas-area';
    switch(device) {
        case 'tablet':
            canvas.style.maxWidth = '768px';
            canvas.style.margin = '20px auto';
            break;
        case 'mobile':
            canvas.style.maxWidth = '375px';
            canvas.style.margin = '20px auto';
            break;
        default:
            canvas.style.maxWidth = '100%';
            canvas.style.margin = '20px';
    }
}

function switchTab(tab) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelector(`[data-tab="${tab}"]`).classList.add('active');
    
    // Show/hide content based on tab
    console.log(`Switched to ${tab} tab`);
}

function saveToHistory() {
    const canvas = document.getElementById('canvas');
    const state = canvas.innerHTML;
    
    // Remove states after current index
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
        const canvas = document.getElementById('canvas');
        canvas.innerHTML = history[historyIndex];
    }
}

function redo() {
    if (historyIndex < history.length - 1) {
        historyIndex++;
        const canvas = document.getElementById('canvas');
        canvas.innerHTML = history[historyIndex];
    }
}

function clearCanvas() {
    if (confirm('Are you sure you want to clear the canvas?')) {
        document.getElementById('canvas').innerHTML = `
            <div class="empty-canvas">
                <div class="text-center text-muted">
                    <i class="fas fa-magic fa-3x mb-3"></i>
                    <h4>Start Building Your Content</h4>
                    <p>Drag elements from the sidebar to start designing your page</p>
                </div>
            </div>
        `;
        saveToHistory();
    }
}

function saveContent() {
    const canvas = document.getElementById('canvas');
    const content = canvas.innerHTML;
    
    // Here you would typically send the content to the server
    console.log('Saving content:', content);
    alert('Content saved successfully!');
}

function exportHTML() {
    const canvas = document.getElementById('canvas');
    const content = canvas.innerHTML;
    
    // Create a complete HTML document
    const html = `
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exported Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        ${content}
    </div>
</body>
</html>
    `;
    
    // Download the HTML file
    const blob = new Blob([html], { type: 'text/html' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'page.html';
    a.click();
    URL.revokeObjectURL(url);
}

function exportJSON() {
    const canvas = document.getElementById('canvas');
    const content = canvas.innerHTML;
    
    const data = {
        content: content,
        timestamp: new Date().toISOString(),
        version: '1.0'
    };
    
    const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'page.json';
    a.click();
    URL.revokeObjectURL(url);
}

function importContent() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = '.json';
    input.onchange = function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const data = JSON.parse(e.target.result);
                    document.getElementById('canvas').innerHTML = data.content;
                    saveToHistory();
                } catch (error) {
                    alert('Error importing file: ' + error.message);
                }
            };
            reader.readAsText(file);
        }
    };
    input.click();
}

function loadTemplate() {
    alert('Template loading functionality will be implemented here.');
}

function showGlobalSettings() {
    alert('Global settings panel will be implemented here.');
}

function showNavigator() {
    alert('Navigator panel will be implemented here.');
}

function showTemplates() {
    alert('Templates panel will be implemented here.');
}

function preview() {
    const canvas = document.getElementById('canvas');
    const content = canvas.innerHTML;
    
    // Open preview in new window
    const previewWindow = window.open('', '_blank');
    previewWindow.document.write(`
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Page Preview</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container">
                ${content}
            </div>
        </body>
        </html>
    `);
}
    </script>
</body>
</html>
