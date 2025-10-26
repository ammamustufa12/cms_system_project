@extends('twill::layouts.form')

@section('contentFields')
    <div class="visual-content-builder">
        <!-- Header Section -->
        <div class="builder-header mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <i class="fas fa-palette me-2"></i>
                        Visual Content Type Builder
                    </h2>
                    <p class="text-muted mb-0">Design your content type with drag & drop interface</p>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary" onclick="saveContentType()">
                        <i class="fas fa-save me-1"></i>Save Content Type
                    </button>
                    <button type="button" class="btn btn-outline-info" onclick="previewContentType()">
                        <i class="fas fa-eye me-1"></i>Preview
                    </button>
                    <button type="button" class="btn btn-outline-success" onclick="generateMigration()">
                        <i class="fas fa-database me-1"></i>Generate Migration
                    </button>
                </div>
            </div>
        </div>

        <!-- Content Type Basic Info -->
        <div class="content-type-info card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Content Type Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="contentTypeName" class="form-label">Name *</label>
                            <input type="text" class="form-control" id="contentTypeName" 
                                   value="{{ $contentType->name ?? '' }}" placeholder="e.g., Product, Article">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="contentTypeSlug" class="form-label">Slug *</label>
                            <input type="text" class="form-control" id="contentTypeSlug" 
                                   value="{{ $contentType->slug ?? '' }}" placeholder="e.g., product, article">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="contentTypeIcon" class="form-label">Icon</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="contentTypeIcon" 
                                       value="{{ $contentType->icon ?? 'fas fa-cube' }}" placeholder="fas fa-cube">
                                <button type="button" class="btn btn-outline-secondary" onclick="openIconPicker()">
                                    <i class="fas fa-icons"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="contentTypeDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="contentTypeDescription" rows="2" 
                                      placeholder="Brief description of this content type">{{ $contentType->description ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="contentTypeColor" class="form-label">Color</label>
                            <input type="color" class="form-control form-control-color" id="contentTypeColor" 
                                   value="{{ $contentType->color ?? '#007bff' }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="contentTypeStatus" class="form-label">Status</label>
                            <select class="form-select" id="contentTypeStatus">
                                <option value="active" {{ ($contentType->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ ($contentType->status ?? 'active') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Builder Interface -->
        <div class="builder-interface">
            <div class="row">
                <!-- Field Types Palette -->
                <div class="col-md-3">
                    <div class="field-palette card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-puzzle-piece me-2"></i>
                                Field Types
                            </h6>
                        </div>
                        <div class="card-body p-2">
                            <div class="field-types-list">
                                @foreach($fieldTypes as $typeKey => $type)
                                    <div class="field-type-item" 
                                         data-field-type="{{ $typeKey }}"
                                         draggable="true">
                                        <div class="field-type-content">
                                            <i class="{{ $type['icon'] }} me-2"></i>
                                            <span class="field-type-label">{{ $type['label'] }}</span>
                                        </div>
                                        <div class="field-type-description">
                                            {{ $type['description'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Field Groups -->
                    <div class="field-groups-palette card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-layer-group me-2"></i>
                                Field Groups
                            </h6>
                        </div>
                        <div class="card-body p-2">
                            <div class="field-groups-list">
                                @foreach($fieldGroups as $groupKey => $group)
                                    <div class="field-group-item" 
                                         data-group="{{ $groupKey }}"
                                         style="border-left: 4px solid {{ $group['color'] }}">
                                        <div class="field-group-content">
                                            <i class="{{ $group['icon'] }} me-2"></i>
                                            <span class="field-group-label">{{ $group['name'] }}</span>
                                        </div>
                                        <div class="field-group-description">
                                            {{ $group['description'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Canvas Area -->
                <div class="col-md-6">
                    <div class="builder-canvas card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-edit me-2"></i>
                                Content Type Canvas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div id="builderCanvas" class="canvas-area">
                                <!-- Existing fields will be rendered here -->
                                @if(isset($contentType->fields_schema) && !empty($contentType->fields_schema))
                                    @foreach($contentType->fields_schema as $fieldKey => $field)
                                        <div class="canvas-field" data-field-key="{{ $fieldKey }}">
                                            <div class="field-header">
                                                <div class="field-info">
                                                    <i class="{{ $fieldTypes[$field['type']]['icon'] ?? 'fas fa-cube' }} me-2"></i>
                                                    <strong>{{ $field['name'] ?? $field['label'] ?? ucfirst(str_replace('_', ' ', $fieldKey)) }}</strong>
                                                    <span class="badge bg-secondary ms-2">{{ $field['type'] }}</span>
                                                    @if($field['required'] ?? false)
                                                        <span class="badge bg-danger ms-1">Required</span>
                                                    @endif
                                                </div>
                                                <div class="field-actions">
                                                    <button type="button" class="btn btn-sm btn-outline-warning" 
                                                            onclick="editField('{{ $fieldKey }}')">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                                            onclick="removeField('{{ $fieldKey }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="field-preview">
                                                {!! \App\Services\FormRendererService::renderField($fieldKey, $field) !!}
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="empty-canvas text-center py-5">
                                        <i class="fas fa-mouse-pointer fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Drag field types here to build your content type</h5>
                                        <p class="text-muted">Start by dragging a field from the palette on the left</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Properties Panel -->
                <div class="col-md-3">
                    <div class="properties-panel card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-cog me-2"></i>
                                Field Properties
                            </h6>
                        </div>
                        <div class="card-body">
                            <div id="fieldProperties">
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-hand-pointer fa-2x mb-2"></i>
                                    <p>Select a field to edit its properties</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Layout Options -->
                    <div class="layout-options card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-th me-2"></i>
                                Layout Options
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Form Layout</label>
                                <select class="form-select" id="formLayout">
                                    <option value="single">Single Column</option>
                                    <option value="two-column">Two Column</option>
                                    <option value="three-column">Three Column</option>
                                    <option value="custom">Custom Grid</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Field Spacing</label>
                                <select class="form-select" id="fieldSpacing">
                                    <option value="compact">Compact</option>
                                    <option value="normal" selected>Normal</option>
                                    <option value="spacious">Spacious</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Label Position</label>
                                <select class="form-select" id="labelPosition">
                                    <option value="top" selected>Top</option>
                                    <option value="left">Left</option>
                                    <option value="floating">Floating</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Field Editor Modal -->
    <div class="modal fade" id="fieldEditorModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Field</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="fieldEditorForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fieldName" class="form-label">Field Name *</label>
                                    <input type="text" class="form-control" id="fieldName" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fieldLabel" class="form-label">Field Label *</label>
                                    <input type="text" class="form-control" id="fieldLabel" name="label" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fieldType" class="form-label">Field Type *</label>
                                    <select class="form-select" id="fieldType" name="type" required>
                                        @foreach($fieldTypes as $typeKey => $type)
                                            <option value="{{ $typeKey }}">{{ $type['icon'] }} {{ $type['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fieldGroup" class="form-label">Field Group</label>
                                    <select class="form-select" id="fieldGroup" name="group">
                                        @foreach($fieldGroups as $groupKey => $group)
                                            <option value="{{ $groupKey }}">{{ $group['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="fieldDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="fieldDescription" name="description" rows="2"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="fieldRequired" name="required">
                                    <label class="form-check-label" for="fieldRequired">Required Field</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="fieldVisible" name="visible">
                                    <label class="form-check-label" for="fieldVisible">Visible</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="fieldSearchable" name="searchable">
                                    <label class="form-check-label" for="fieldSearchable">Searchable</label>
                                </div>
                            </div>
                        </div>

                        <!-- Field Options -->
                        <div id="fieldOptions" class="mt-3" style="display: none;">
                            <h6>Field Options</h6>
                            <div id="fieldOptionsContent"></div>
                        </div>

                        <!-- Field Preview -->
                        <div id="fieldPreview" class="mt-3" style="display: none;">
                            <h6>Preview</h6>
                            <div class="border p-3 rounded" id="fieldPreviewContent"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveField()">Save Field</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Icon Picker Modal -->
    <div class="modal fade" id="iconPickerModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Choose Icon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="icon-grid">
                        @php
                            $icons = [
                                'fas fa-cube', 'fas fa-file', 'fas fa-image', 'fas fa-video',
                                'fas fa-music', 'fas fa-pdf', 'fas fa-document', 'fas fa-folder',
                                'fas fa-user', 'fas fa-users', 'fas fa-envelope', 'fas fa-phone',
                                'fas fa-map-marker', 'fas fa-calendar', 'fas fa-clock', 'fas fa-tag',
                                'fas fa-link', 'fas fa-code', 'fas fa-database', 'fas fa-server',
                                'fas fa-cloud', 'fas fa-mobile', 'fas fa-laptop', 'fas fa-desktop',
                                'fas fa-cog', 'fas fa-wrench', 'fas fa-tools', 'fas fa-hammer',
                                'fas fa-palette', 'fas fa-paint-brush', 'fas fa-pencil', 'fas fa-edit',
                                'fas fa-save', 'fas fa-download', 'fas fa-upload', 'fas fa-share',
                                'fas fa-heart', 'fas fa-star', 'fas fa-thumbs-up', 'fas fa-check',
                                'fas fa-times', 'fas fa-exclamation', 'fas fa-question', 'fas fa-info'
                            ];
                        @endphp
                        @foreach($icons as $icon)
                            <div class="icon-item" data-icon="{{ $icon }}" onclick="selectIcon('{{ $icon }}')">
                                <i class="{{ $icon }} fa-2x"></i>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('extraCss')
<style>
.visual-content-builder {
    padding: 20px;
}

.field-type-item, .field-group-item {
    padding: 10px;
    margin-bottom: 8px;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    cursor: grab;
    transition: all 0.3s ease;
    background: white;
}

.field-type-item:hover, .field-group-item:hover {
    border-color: #007bff;
    box-shadow: 0 2px 8px rgba(0,123,255,0.15);
    transform: translateY(-2px);
}

.field-type-item:active, .field-group-item:active {
    cursor: grabbing;
}

.field-type-content, .field-group-content {
    display: flex;
    align-items: center;
    font-weight: 500;
}

.field-type-description, .field-group-description {
    font-size: 0.85rem;
    color: #6c757d;
    margin-top: 4px;
}

.canvas-area {
    min-height: 400px;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 20px;
    position: relative;
}

.canvas-area.drag-over {
    border-color: #007bff;
    background-color: rgba(0,123,255,0.05);
}

.canvas-field {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    margin-bottom: 15px;
    padding: 15px;
    transition: all 0.3s ease;
}

.canvas-field:hover {
    border-color: #007bff;
    box-shadow: 0 2px 8px rgba(0,123,255,0.15);
}

.canvas-field.selected {
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
}

.field-header {
    display: flex;
    justify-content-between;
    align-items-center;
    margin-bottom: 10px;
}

.field-info {
    display: flex;
    align-items: center;
}

.field-actions {
    display: flex;
    gap: 5px;
}

.field-preview {
    background: #f8f9fa;
    border-radius: 4px;
    padding: 10px;
}

.empty-canvas {
    background: #f8f9fa;
    border-radius: 8px;
}

.icon-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
    gap: 10px;
    max-height: 400px;
    overflow-y: auto;
}

.icon-item {
    padding: 15px;
    text-align: center;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.icon-item:hover {
    border-color: #007bff;
    background-color: rgba(0,123,255,0.05);
}

.icon-item.selected {
    border-color: #007bff;
    background-color: rgba(0,123,255,0.1);
}

.properties-panel .card-body {
    max-height: 500px;
    overflow-y: auto;
}

.field-palette, .field-groups-palette {
    max-height: 400px;
    overflow-y: auto;
}
</style>
@endpush

@push('extraJs')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
// Visual Content Builder JavaScript
let fieldTypes = @json($fieldTypes);
let fieldGroups = @json($fieldGroups);
let currentField = null;
let fieldCounter = 0;

// Initialize the builder
document.addEventListener('DOMContentLoaded', function() {
    initializeDragAndDrop();
    initializeCanvas();
    initializeFieldEditor();
});

function initializeDragAndDrop() {
    // Make field types draggable
    document.querySelectorAll('.field-type-item').forEach(function(item) {
        item.addEventListener('dragstart', function(e) {
            e.dataTransfer.setData('text/plain', JSON.stringify({
                type: 'field',
                fieldType: this.dataset.fieldType
            }));
        });
    });

    // Make field groups draggable
    document.querySelectorAll('.field-group-item').forEach(function(item) {
        item.addEventListener('dragstart', function(e) {
            e.dataTransfer.setData('text/plain', JSON.stringify({
                type: 'group',
                groupKey: this.dataset.group
            }));
        });
    });

    // Canvas drop zone
    const canvas = document.getElementById('builderCanvas');
    
    canvas.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    });

    canvas.addEventListener('dragleave', function(e) {
        this.classList.remove('drag-over');
    });

    canvas.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        
        const data = JSON.parse(e.dataTransfer.getData('text/plain'));
        
        if (data.type === 'field') {
            addFieldToCanvas(data.fieldType);
        } else if (data.type === 'group') {
            addGroupToCanvas(data.groupKey);
        }
    });
}

function initializeCanvas() {
    // Make existing fields selectable
    document.querySelectorAll('.canvas-field').forEach(function(field) {
        field.addEventListener('click', function() {
            selectField(this);
        });
    });
}

function initializeFieldEditor() {
    // Field type change handler
    document.getElementById('fieldType').addEventListener('change', function() {
        loadFieldOptions(this.value);
        generateFieldPreview();
    });
}

function addFieldToCanvas(fieldType) {
    fieldCounter++;
    const fieldKey = fieldType + '_' + fieldCounter;
    
    const fieldConfig = {
        name: fieldKey,
        label: fieldTypes[fieldType].label,
        type: fieldType,
        required: false,
        visible: true,
        searchable: false,
        group: 'basic',
        options: {}
    };

    const fieldHtml = createFieldHtml(fieldKey, fieldConfig);
    
    // Remove empty canvas message if exists
    const emptyCanvas = document.querySelector('.empty-canvas');
    if (emptyCanvas) {
        emptyCanvas.remove();
    }
    
    // Add field to canvas
    document.getElementById('builderCanvas').insertAdjacentHTML('beforeend', fieldHtml);
    
    // Make field selectable
    const newField = document.querySelector(`[data-field-key="${fieldKey}"]`);
    newField.addEventListener('click', function() {
        selectField(this);
    });
    
    // Select the new field
    selectField(newField);
}

function createFieldHtml(fieldKey, fieldConfig) {
    const fieldType = fieldTypes[fieldConfig.type];
    
    return `
        <div class="canvas-field" data-field-key="${fieldKey}">
            <div class="field-header">
                <div class="field-info">
                    <i class="${fieldType.icon} me-2"></i>
                    <strong>${fieldConfig.label}</strong>
                    <span class="badge bg-secondary ms-2">${fieldConfig.type}</span>
                    ${fieldConfig.required ? '<span class="badge bg-danger ms-1">Required</span>' : ''}
                </div>
                <div class="field-actions">
                    <button type="button" class="btn btn-sm btn-outline-warning" onclick="editField('${fieldKey}')">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeField('${fieldKey}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="field-preview">
                ${generateFieldPreviewHtml(fieldConfig)}
            </div>
        </div>
    `;
}

function generateFieldPreviewHtml(fieldConfig) {
    const fieldType = fieldTypes[fieldConfig.type];
    
    switch (fieldConfig.type) {
        case 'text':
        case 'email':
        case 'url':
            return `<input type="text" class="form-control" placeholder="Sample ${fieldType.label} input" disabled>`;
        case 'textarea':
            return `<textarea class="form-control" rows="3" placeholder="Sample ${fieldType.label} input" disabled></textarea>`;
        case 'number':
            return `<input type="number" class="form-control" placeholder="Sample ${fieldType.label} input" disabled>`;
        case 'select':
            return `<select class="form-select" disabled><option>Sample ${fieldType.label} option</option></select>`;
        case 'checkbox':
            return `<div class="form-check"><input type="checkbox" class="form-check-input" disabled><label class="form-check-label">Sample ${fieldType.label}</label></div>`;
        case 'radio':
            return `<div class="form-check"><input type="radio" class="form-check-input" disabled><label class="form-check-label">Sample ${fieldType.label} option</label></div>`;
        case 'date':
            return `<input type="date" class="form-control" disabled>`;
        case 'datetime':
            return `<input type="datetime-local" class="form-control" disabled>`;
        case 'file':
        case 'image':
            return `<input type="file" class="form-control" disabled>`;
        case 'color':
            return `<input type="color" class="form-control form-control-color" disabled>`;
        default:
            return `<input type="text" class="form-control" placeholder="Sample ${fieldType.label} input" disabled>`;
    }
}

function selectField(fieldElement) {
    // Remove previous selection
    document.querySelectorAll('.canvas-field').forEach(function(field) {
        field.classList.remove('selected');
    });
    
    // Select current field
    fieldElement.classList.add('selected');
    currentField = fieldElement;
    
    // Load field properties
    loadFieldProperties(fieldElement);
}

function loadFieldProperties(fieldElement) {
    const fieldKey = fieldElement.dataset.fieldKey;
    // This would load the actual field configuration
    // For now, show a placeholder
    document.getElementById('fieldProperties').innerHTML = `
        <div class="field-property">
            <label class="form-label">Field Key</label>
            <input type="text" class="form-control" value="${fieldKey}" readonly>
        </div>
        <div class="field-property mt-3">
            <button type="button" class="btn btn-primary btn-sm" onclick="editField('${fieldKey}')">
                <i class="fas fa-edit me-1"></i>Edit Field
            </button>
        </div>
    `;
}

function editField(fieldKey) {
    // Open field editor modal
    const modal = new bootstrap.Modal(document.getElementById('fieldEditorModal'));
    modal.show();
    
    // Load field data into form
    // This would load the actual field configuration
    document.getElementById('fieldName').value = fieldKey;
    document.getElementById('fieldLabel').value = 'Field Label';
    document.getElementById('fieldType').value = 'text';
    document.getElementById('fieldGroup').value = 'basic';
}

function removeField(fieldKey) {
    if (confirm('Are you sure you want to remove this field?')) {
        document.querySelector(`[data-field-key="${fieldKey}"]`).remove();
        
        // Clear properties panel if this field was selected
        if (currentField && currentField.dataset.fieldKey === fieldKey) {
            document.getElementById('fieldProperties').innerHTML = `
                <div class="text-center text-muted py-4">
                    <i class="fas fa-hand-pointer fa-2x mb-2"></i>
                    <p>Select a field to edit its properties</p>
                </div>
            `;
            currentField = null;
        }
    }
}

function loadFieldOptions(fieldType) {
    const fieldTypeConfig = fieldTypes[fieldType];
    if (!fieldTypeConfig || !fieldTypeConfig.options) {
        hideFieldOptions();
        return;
    }

    const optionsContainer = document.getElementById('fieldOptionsContent');
    optionsContainer.innerHTML = '';

    Object.entries(fieldTypeConfig.options).forEach(function([key, option]) {
        const optionHtml = createOptionInput(key, option);
        optionsContainer.appendChild(optionHtml);
    });

    showFieldOptions();
}

function createOptionInput(key, option) {
    const div = document.createElement('div');
    div.className = 'mb-3';

    const label = document.createElement('label');
    label.className = 'form-label';
    label.textContent = option.label;
    div.appendChild(label);

    let input;
    switch (option.type) {
        case 'text':
        case 'number':
            input = document.createElement('input');
            input.type = option.type;
            input.className = 'form-control';
            input.name = `options[${key}]`;
            input.value = option.default || '';
            break;
        case 'select':
            input = document.createElement('select');
            input.className = 'form-select';
            input.name = `options[${key}]`;
            Object.entries(option.options).forEach(function([value, label]) {
                const option = document.createElement('option');
                option.value = value;
                option.textContent = label;
                if (value === option.default) option.selected = true;
                input.appendChild(option);
            });
            break;
        case 'boolean':
            input = document.createElement('input');
            input.type = 'checkbox';
            input.className = 'form-check-input';
            input.name = `options[${key}]`;
            input.checked = option.default || false;
            break;
        default:
            input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control';
            input.name = `options[${key}]`;
            input.value = option.default || '';
    }

    div.appendChild(input);
    return div;
}

function showFieldOptions() {
    document.getElementById('fieldOptions').style.display = 'block';
}

function hideFieldOptions() {
    document.getElementById('fieldOptions').style.display = 'none';
}

function generateFieldPreview() {
    const fieldType = document.getElementById('fieldType').value;
    const fieldLabel = document.getElementById('fieldLabel').value || 'Field Label';
    
    if (!fieldType) return;

    const previewHtml = generateFieldPreviewHtml({
        type: fieldType,
        label: fieldLabel
    });

    document.getElementById('fieldPreviewContent').innerHTML = previewHtml;
    document.getElementById('fieldPreview').style.display = 'block';
}

function saveField() {
    // Implementation for saving field
    console.log('Save field');
    // Close modal
    bootstrap.Modal.getInstance(document.getElementById('fieldEditorModal')).hide();
}

function saveContentType() {
    const contentTypeData = {
        name: document.getElementById('contentTypeName').value,
        slug: document.getElementById('contentTypeSlug').value,
        description: document.getElementById('contentTypeDescription').value,
        icon: document.getElementById('contentTypeIcon').value,
        color: document.getElementById('contentTypeColor').value,
        status: document.getElementById('contentTypeStatus').value,
        fields: getCanvasFields()
    };

    console.log('Save content type:', contentTypeData);
    // Implementation for saving content type
}

function getCanvasFields() {
    const fields = {};
    document.querySelectorAll('.canvas-field').forEach(function(field) {
        const fieldKey = field.dataset.fieldKey;
        // This would extract the actual field configuration
        fields[fieldKey] = {
            name: fieldKey,
            label: 'Field Label',
            type: 'text',
            required: false,
            visible: true,
            searchable: false,
            group: 'basic',
            options: {}
        };
    });
    return fields;
}

function previewContentType() {
    console.log('Preview content type');
    // Implementation for preview
}

function generateMigration() {
    console.log('Generate migration');
    // Implementation for migration generation
}

function openIconPicker() {
    const modal = new bootstrap.Modal(document.getElementById('iconPickerModal'));
    modal.show();
}

function selectIcon(icon) {
    document.getElementById('contentTypeIcon').value = icon;
    bootstrap.Modal.getInstance(document.getElementById('iconPickerModal')).hide();
}
</script>
@endpush
