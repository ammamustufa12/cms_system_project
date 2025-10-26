@extends('twill::layouts.form')

@section('contentFields')
    <div class="grapes-builder-container">
        <!-- Header Section -->
        <div class="builder-header mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <i class="fas fa-palette me-2"></i>
                        Visual Page Builder
                    </h2>
                    <p class="text-muted mb-0">Professional drag & drop page builder with GrapesJS</p>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary" onclick="saveLayout()">
                        <i class="fas fa-save me-1"></i>Save Layout
                    </button>
                    <button type="button" class="btn btn-outline-info" onclick="previewLayout()">
                        <i class="fas fa-eye me-1"></i>Preview
                    </button>
                    <button type="button" class="btn btn-outline-success" onclick="exportHTML()">
                        <i class="fas fa-download me-1"></i>Export HTML
                    </button>
                    <button type="button" class="btn btn-outline-warning" onclick="clearCanvas()">
                        <i class="fas fa-trash me-1"></i>Clear
                    </button>
                </div>
            </div>
        </div>

        <!-- Content Type Info -->
        <div class="content-type-info card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Content Type: {{ $contentType->name ?? 'New Content Type' }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <strong>Slug:</strong> {{ $contentType->slug ?? 'new-content-type' }}
                    </div>
                    <div class="col-md-3">
                        <strong>Fields:</strong> {{ count(is_array($contentType->fields_schema) ? $contentType->fields_schema : []) }} fields
                    </div>
                    <div class="col-md-3">
                        <strong>Status:</strong> 
                        <span class="badge bg-{{ ($contentType->status ?? 'active') == 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($contentType->status ?? 'active') }}
                        </span>
                    </div>
                    <div class="col-md-3">
                        <strong>Last Updated:</strong> {{ $contentType->updated_at ?? 'Never' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- GrapesJS Builder -->
        <div class="grapes-builder">
            <div id="gjs" class="grapesjs-container">
                <div class="loading-container" style="
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    height: 100%;
                    padding: 20px;
                    text-align: center;
                    background: #f8f9fa;
                ">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h5 class="text-muted">Loading Page Builder...</h5>
                    <p class="text-muted small">Initializing GrapesJS editor</p>
                </div>
            </div>
        </div>

        <!-- Field Blocks Panel -->
        <div class="field-blocks-panel" id="fieldBlocksPanel" style="display: none;">
            <div class="panel-header">
                <h6>Content Fields</h6>
                <button type="button" class="btn-close" onclick="toggleFieldBlocks()"></button>
            </div>
            <div class="panel-body">
                <div class="field-blocks-list">
                    @if(isset($contentType->fields_schema) && !empty($contentType->fields_schema) && is_array($contentType->fields_schema))
                        @foreach($contentType->fields_schema as $fieldKey => $field)
                            <div class="field-block-item" 
                                 data-field-key="{{ $fieldKey }}"
                                 data-field-type="{{ $field['type'] }}"
                                 draggable="true">
                                <div class="field-block-content">
                                    <i class="{{ $fieldTypes[$field['type']]['icon'] ?? 'fas fa-cube' }} me-2"></i>
                                    <span class="field-block-label">{{ $field['name'] ?? $field['label'] ?? ucfirst(str_replace('_', ' ', $fieldKey)) }}</span>
                                </div>
                                <div class="field-block-description">
                                    {{ $field['description'] ?? $fieldTypes[$field['type']]['description'] ?? '' }}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-3">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                            <p>No fields available. Please add fields first.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Floating Action Button -->
        <div class="floating-actions">
            <button type="button" class="btn btn-primary btn-lg rounded-circle" onclick="toggleFieldBlocks()">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

    <!-- Save Layout Modal -->
    <div class="modal fade" id="saveLayoutModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Save Layout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="saveLayoutForm">
                        <div class="mb-3">
                            <label for="layoutName" class="form-label">Layout Name</label>
                            <input type="text" class="form-control" id="layoutName" 
                                   value="{{ $contentType->name ?? '' }} Layout" required>
                        </div>
                        <div class="mb-3">
                            <label for="layoutDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="layoutDescription" rows="3" 
                                      placeholder="Brief description of this layout"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="setAsDefault" checked>
                                <label class="form-check-label" for="setAsDefault">
                                    Set as default layout for this content type
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="confirmSaveLayout()">Save Layout</button>
                </div>
            </div>
        </div>
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
@endsection

@push('extraCss')
<style>
.grapes-builder-container {
    padding: 20px;
    background: #f8f9fa;
    min-height: 100vh;
}

.grapes-builder {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.grapesjs-container {
    height: 80vh;
    min-height: 600px;
}

.field-blocks-panel {
    position: fixed;
    top: 0;
    right: -400px;
    width: 400px;
    height: 100vh;
    background: white;
    box-shadow: -2px 0 10px rgba(0,0,0,0.1);
    z-index: 1050;
    transition: right 0.3s ease;
}

.field-blocks-panel.show {
    right: 0;
}

.panel-header {
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: between;
    align-items: center;
}

.panel-body {
    padding: 20px;
    height: calc(100vh - 80px);
    overflow-y: auto;
}

.field-block-item {
    padding: 15px;
    margin-bottom: 10px;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    cursor: grab;
    transition: all 0.3s ease;
    background: white;
}

.field-block-item:hover {
    border-color: #007bff;
    box-shadow: 0 2px 8px rgba(0,123,255,0.15);
    transform: translateY(-2px);
}

.field-block-item:active {
    cursor: grabbing;
}

.field-block-content {
    display: flex;
    align-items: center;
    font-weight: 500;
    margin-bottom: 5px;
}

.field-block-description {
    font-size: 0.85rem;
    color: #6c757d;
}

.floating-actions {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 1040;
}

.floating-actions .btn {
    width: 60px;
    height: 60px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* GrapesJS Custom Styles */
.gjs-cv-canvas {
    background: #f8f9fa;
}

.gjs-block {
    width: auto;
    height: auto;
    min-height: auto;
    margin: 5px;
}

.gjs-block-label {
    font-size: 12px;
}

/* Custom Field Blocks */
.field-block {
    border: 2px dashed #007bff;
    padding: 10px;
    margin: 5px;
    background: rgba(0,123,255,0.05);
    border-radius: 4px;
    position: relative;
}

.field-block::before {
    content: attr(data-field-label);
    position: absolute;
    top: -8px;
    left: 8px;
    background: #007bff;
    color: white;
    padding: 2px 8px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 500;
}

.field-block:hover {
    border-color: #0056b3;
    background: rgba(0,123,255,0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .field-blocks-panel {
        width: 100%;
        right: -100%;
    }
    
    .floating-actions {
        bottom: 20px;
        right: 20px;
    }
    
    .floating-actions .btn {
        width: 50px;
        height: 50px;
    }
}
</style>
@endpush

@push('extraJs')
<!-- GrapesJS CSS -->
<link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
<!-- Fallback CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/grapesjs@0.21.7/dist/css/grapes.min.css" onerror="this.onerror=null;this.href='https://unpkg.com/grapesjs/dist/css/grapes.min.css';">

<!-- GrapesJS JS with fallback loading -->
<script>
// Load GrapesJS with fallback
function loadScript(src, fallback, callback) {
    const script = document.createElement('script');
    script.src = src;
    script.onload = callback;
    script.onerror = function() {
        console.warn('Failed to load from primary CDN, trying fallback...');
        const fallbackScript = document.createElement('script');
        fallbackScript.src = fallback;
        fallbackScript.onload = callback;
        fallbackScript.onerror = function() {
            console.error('Failed to load GrapesJS from all CDNs');
            showError('Failed to load page builder library. Please check your internet connection.');
        };
        document.head.appendChild(fallbackScript);
    };
    document.head.appendChild(script);
}

// Load all required scripts
let loadedScripts = 0;
const totalScripts = 12;

function onScriptLoad() {
    loadedScripts++;
    console.log(`Loaded script ${loadedScripts}/${totalScripts}`);
    
    if (loadedScripts === totalScripts) {
        console.log('All GrapesJS scripts loaded successfully');
        // Initialize after all scripts are loaded
        setTimeout(() => {
            if (typeof grapesjs !== 'undefined') {
                initializeGrapesJS();
                initializeFieldBlocks();
                loadExistingLayout();
            } else {
                showError('GrapesJS library not available after loading all scripts');
            }
        }, 100);
    }
}

// Load core GrapesJS
loadScript('https://unpkg.com/grapesjs', 'https://cdn.jsdelivr.net/npm/grapesjs@0.21.7/dist/grapes.min.js', onScriptLoad);

// Load plugins
loadScript('https://unpkg.com/grapesjs-preset-webpage', 'https://cdn.jsdelivr.net/npm/grapesjs-preset-webpage@1.0.3/dist/index.js', onScriptLoad);
loadScript('https://unpkg.com/grapesjs-blocks-basic', 'https://cdn.jsdelivr.net/npm/grapesjs-blocks-basic@1.0.1/dist/index.js', onScriptLoad);
loadScript('https://unpkg.com/grapesjs-plugin-forms', 'https://cdn.jsdelivr.net/npm/grapesjs-plugin-forms@2.0.5/dist/index.js', onScriptLoad);
loadScript('https://unpkg.com/grapesjs-component-countdown', 'https://cdn.jsdelivr.net/npm/grapesjs-component-countdown@1.0.1/dist/index.js', onScriptLoad);
loadScript('https://unpkg.com/grapesjs-plugin-export', 'https://cdn.jsdelivr.net/npm/grapesjs-plugin-export@1.0.11/dist/index.js', onScriptLoad);
loadScript('https://unpkg.com/grapesjs-tabs', 'https://cdn.jsdelivr.net/npm/grapesjs-tabs@1.0.6/dist/index.js', onScriptLoad);
loadScript('https://unpkg.com/grapesjs-custom-code', 'https://cdn.jsdelivr.net/npm/grapesjs-custom-code@1.0.3/dist/index.js', onScriptLoad);
loadScript('https://unpkg.com/grapesjs-touch', 'https://cdn.jsdelivr.net/npm/grapesjs-touch@0.1.1/dist/index.js', onScriptLoad);
loadScript('https://unpkg.com/grapesjs-parser-postcss', 'https://cdn.jsdelivr.net/npm/grapesjs-parser-postcss@1.0.2/dist/index.js', onScriptLoad);
loadScript('https://unpkg.com/grapesjs-style-bg', 'https://cdn.jsdelivr.net/npm/grapesjs-style-bg@2.0.1/dist/index.js', onScriptLoad);
loadScript('https://unpkg.com/grapesjs-plugin-ckeditor', 'https://cdn.jsdelivr.net/npm/grapesjs-plugin-ckeditor@1.0.2/dist/index.js', onScriptLoad);
</script>

<script>
// GrapesJS Builder Configuration
let editor;
let fieldTypes = @json($fieldTypes ?? []);
let contentType = @json($contentType ?? null);
let fieldBlocks = [];

// Initialize GrapesJS Editor - now handled by script loading mechanism above

function initializeGrapesJS() {
    try {
        console.log('Initializing GrapesJS editor...');
        editor = grapesjs.init({
        container: '#gjs',
        height: '100%',
        width: '100%',
        plugins: [
            'gjs-preset-webpage',
            'gjs-blocks-basic',
            'gjs-plugin-forms',
            'gjs-component-countdown',
            'gjs-plugin-export',
            'gjs-tabs',
            'gjs-custom-code',
            'gjs-touch',
            'gjs-parser-postcss',
            'gjs-style-bg'
        ],
        pluginsOpts: {
            'gjs-preset-webpage': {
                modalImportTitle: 'Import Template',
                modalImportLabel: '<div style="margin-bottom: 10px; font-size: 13px;">Paste here your HTML/CSS and click Import</div>',
                modalImportContent: function(editor) {
                    return editor.getHtml() + '<style>' + editor.getCss() + '</style>'
                },
                filestackOpts: null,
                aviaryOpts: false,
                blocksBasicOpts: {
                    blocks: ['column1', 'column2', 'column3', 'column3-7', 'text', 'link', 'image', 'video'],
                    flexGrid: 1,
                },
                customStyleManager: [{
                    name: 'General',
                    buildProps: ['float', 'display', 'position', 'top', 'right', 'left', 'bottom'],
                    properties: [{
                        type: 'integer',
                        name: 'The width',
                        property: 'width',
                        units: ['px', '%'],
                        defaults: 'auto',
                        min: 0,
                    }]
                }]
            },
            'gjs-blocks-basic': {
                blocks: ['column1', 'column2', 'column3', 'column3-7', 'text', 'link', 'image', 'video'],
                flexGrid: 1,
            },
            'gjs-plugin-forms': {
                blocks: ['form', 'input', 'textarea', 'select', 'button', 'label', 'checkbox', 'radio']
            }
        },
        storageManager: {
            type: 'remote',
            autosave: true,
            autoload: true,
            stepsBeforeSave: 3,
            urlStore: '{{ route("content-types.save-layout", $contentType->slug ?? "new") }}',
            urlLoad: '{{ route("content-types.load-layout", $contentType->slug ?? "new") }}',
            params: {
                _token: '{{ csrf_token() }}'
            }
        },
        blockManager: {
            appendTo: '.gjs-blocks-cs'
        },
        layerManager: {
            appendTo: '.gjs-layers-cs'
        },
        traitManager: {
            appendTo: '.gjs-traits-cs'
        },
        selectorManager: {
            appendTo: '.gjs-selectors-cs'
        },
        styleManager: {
            appendTo: '.gjs-sm-cs'
        },
        panels: {
            defaults: [
                {
                    id: 'basic-actions',
                    el: '.gjs-pn-panel.gjs-pn-basic-actions',
                    buttons: [
                        {
                            id: 'visibility',
                            active: true,
                            className: 'btn-toggle-borders',
                            label: '<i class="fas fa-eye"></i>',
                            command: 'sw-visibility',
                        },
                        {
                            id: 'export',
                            className: 'btn-open-export',
                            label: '<i class="fas fa-download"></i>',
                            command: 'export-template',
                            context: 'export-template',
                        },
                        {
                            id: 'show-json',
                            className: 'btn-show-json',
                            label: '<i class="fas fa-code"></i>',
                            context: 'show-json',
                            command(editor) {
                                editor.Modal.setTitle('Components JSON')
                                    .setContent(`<textarea style="width:100%; height: 300px;">
                                        ${JSON.stringify(editor.getComponents(), null, 2)}
                                    </textarea>`)
                                    .open();
                            },
                        }
                    ],
                },
                {
                    id: 'panel-switcher',
                    el: '.gjs-pn-panel.gjs-pn-panel-switcher',
                    buttons: [
                        {
                            id: 'show-layers',
                            active: true,
                            label: '<i class="fas fa-layer-group"></i>',
                            command: 'show-layers',
                            togglable: false,
                        },
                        {
                            id: 'show-style',
                            active: true,
                            label: '<i class="fas fa-paint-brush"></i>',
                            command: 'show-styles',
                            togglable: false,
                        },
                        {
                            id: 'show-traits',
                            active: true,
                            label: '<i class="fas fa-cog"></i>',
                            command: 'show-traits',
                            togglable: false,
                        }
                    ],
                }
            ]
        },
        canvas: {
            styles: [
                'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css',
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css'
            ],
            scripts: [
                'https://code.jquery.com/jquery-3.3.1.slim.min.js',
                'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js'
            ]
        }
    });

    // Add custom field blocks
    addCustomFieldBlocks();
    
    // Setup event listeners
    setupEventListeners();
    
    console.log('GrapesJS editor initialized successfully!');
    
    } catch (error) {
        console.error('Error initializing GrapesJS:', error);
        showError('Failed to initialize page builder: ' + error.message);
    }
}

function showError(message) {
    const container = document.getElementById('gjs');
    if (container) {
        container.innerHTML = `
            <div class="error-container" style="
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100%;
                padding: 20px;
                text-align: center;
                background: #f8f9fa;
                border: 2px dashed #dc3545;
                border-radius: 8px;
            ">
                <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                <h4 class="text-danger mb-3">Page Builder Error</h4>
                <p class="text-muted mb-3">${message}</p>
                <button class="btn btn-primary" onclick="location.reload()">
                    <i class="fas fa-refresh me-1"></i>Reload Page
                </button>
            </div>
        `;
    }
}

function addCustomFieldBlocks() {
    if (!contentType || !contentType.fields_schema) return;

    const blockManager = editor.BlockManager;
    
    // Clear existing field blocks
    fieldBlocks.forEach(blockId => {
        blockManager.remove(blockId);
    });
    fieldBlocks = [];

    // Add field blocks
    Object.entries(contentType.fields_schema).forEach(([fieldKey, field]) => {
        const fieldType = fieldTypes[field.type] || { icon: 'fas fa-cube', label: field.type };
        const blockId = `field-${fieldKey}`;
        
        blockManager.add(blockId, {
            label: `${fieldType.icon} ${field.label}`,
            category: 'Content Fields',
            content: createFieldBlockHTML(fieldKey, field),
            attributes: {
                class: 'field-block',
                'data-field-key': fieldKey,
                'data-field-type': field.type
            }
        });
        
        fieldBlocks.push(blockId);
    });
}

function createFieldBlockHTML(fieldKey, field) {
    const fieldType = fieldTypes[field.type] || { icon: 'fas fa-cube', label: field.type };
    
    let content = '';
    switch (field.type) {
        case 'text':
        case 'email':
        case 'url':
            content = `<input type="${field.type === 'email' ? 'email' : field.type === 'url' ? 'url' : 'text'}" 
                             class="form-control" 
                             placeholder="${field.label}" 
                             data-field="${fieldKey}">`;
            break;
        case 'textarea':
            content = `<textarea class="form-control" 
                                 placeholder="${field.label}" 
                                 data-field="${fieldKey}"></textarea>`;
            break;
        case 'number':
            content = `<input type="number" 
                             class="form-control" 
                             placeholder="${field.label}" 
                             data-field="${fieldKey}">`;
            break;
        case 'select':
            content = `<select class="form-control" data-field="${fieldKey}">
                         <option>${field.label}</option>
                       </select>`;
            break;
        case 'checkbox':
            content = `<div class="form-check">
                         <input type="checkbox" class="form-check-input" data-field="${fieldKey}">
                         <label class="form-check-label">${field.label}</label>
                       </div>`;
            break;
        case 'radio':
            content = `<div class="form-check">
                         <input type="radio" class="form-check-input" data-field="${fieldKey}">
                         <label class="form-check-label">${field.label}</label>
                       </div>`;
            break;
        case 'date':
            content = `<input type="date" 
                             class="form-control" 
                             data-field="${fieldKey}">`;
            break;
        case 'datetime':
            content = `<input type="datetime-local" 
                             class="form-control" 
                             data-field="${fieldKey}">`;
            break;
        case 'file':
        case 'image':
            content = `<input type="file" 
                             class="form-control" 
                             data-field="${fieldKey}">`;
            break;
        case 'color':
            content = `<input type="color" 
                             class="form-control form-control-color" 
                             data-field="${fieldKey}">`;
            break;
        case 'wysiwyg':
            content = `<div class="wysiwyg-editor" data-field="${fieldKey}">
                         <p>${field.label}</p>
                       </div>`;
            break;
        default:
            content = `<div class="field-placeholder" data-field="${fieldKey}">
                         <i class="${fieldType.icon}"></i>
                         <span>${field.label}</span>
                       </div>`;
    }
    
    return `
        <div class="field-block" data-field-key="${fieldKey}" data-field-label="${field.label}">
            ${content}
        </div>
    `;
}

function setupEventListeners() {
    // Field blocks panel toggle
    window.toggleFieldBlocks = function() {
        const panel = document.getElementById('fieldBlocksPanel');
        panel.classList.toggle('show');
    };
    
    // Save layout
    window.saveLayout = function() {
        const modal = new bootstrap.Modal(document.getElementById('saveLayoutModal'));
        modal.show();
    };
    
    // Preview layout
    window.previewLayout = function() {
        const html = editor.getHtml();
        const css = editor.getCss();
        const fullHtml = `
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Layout Preview</title>
                <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
                <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
                <style>${css}</style>
            </head>
            <body>
                ${html}
            </body>
            </html>
        `;
        
        const iframe = document.getElementById('previewFrame');
        iframe.srcdoc = fullHtml;
        
        const modal = new bootstrap.Modal(document.getElementById('previewModal'));
        modal.show();
    };
    
    // Export HTML
    window.exportHTML = function() {
        const html = editor.getHtml();
        const css = editor.getCss();
        const fullHtml = `<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>${contentType?.name || 'Content'} Layout</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>${css}</style>
</head>
<body>
    ${html}
</body>
</html>`;
        
        const blob = new Blob([fullHtml], { type: 'text/html' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `${contentType?.slug || 'content'}-layout.html`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    };
    
    // Clear canvas
    window.clearCanvas = function() {
        if (confirm('Are you sure you want to clear the entire layout? This action cannot be undone.')) {
            editor.setComponents('');
            editor.setStyle('');
        }
    };
    
    // Confirm save layout
    window.confirmSaveLayout = function() {
        const layoutName = document.getElementById('layoutName').value;
        const layoutDescription = document.getElementById('layoutDescription').value;
        const setAsDefault = document.getElementById('setAsDefault').checked;
        
        const layoutData = {
            name: layoutName,
            description: layoutDescription,
            html: editor.getHtml(),
            css: editor.getCss(),
            set_as_default: setAsDefault,
            _token: '{{ csrf_token() }}'
        };
        
        fetch('{{ route("content-types.save-layout", $contentType->slug ?? "new") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(layoutData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Layout saved successfully!');
                bootstrap.Modal.getInstance(document.getElementById('saveLayoutModal')).hide();
            } else {
                alert('Error saving layout: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving layout');
        });
    };
}

function initializeFieldBlocks() {
    // Make field blocks draggable
    document.querySelectorAll('.field-block-item').forEach(function(item) {
        item.addEventListener('dragstart', function(e) {
            e.dataTransfer.setData('text/plain', JSON.stringify({
                type: 'field',
                fieldKey: this.dataset.fieldKey,
                fieldType: this.dataset.fieldType
            }));
        });
    });
}

function loadExistingLayout() {
    if (contentType && contentType.layout_config) {
        const layout = contentType.layout_config;
        if (layout.html) {
            editor.setComponents(layout.html);
        }
        if (layout.css) {
            editor.setStyle(layout.css);
        }
    }
}

// Auto-save functionality
setInterval(function() {
    if (editor) {
        const html = editor.getHtml();
        const css = editor.getCss();
        
        // Auto-save to localStorage
        localStorage.setItem('grapesjs-layout', JSON.stringify({
            html: html,
            css: css,
            timestamp: new Date().toISOString()
        }));
    }
}, 30000); // Auto-save every 30 seconds
</script>
@endpush
