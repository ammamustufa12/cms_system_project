@extends('twill::layouts.form')

@section('contentFields')
    <div class="field-manager-container">
        <!-- Header Section -->
    
        <div class="field-manager-header">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="content-type-icon me-3" style="background: {{ $contentType->color ?? '#007bff' }};">
                                    </div>
                                    <div>
                                        <h4 class="mb-0">{{ $contentType->name }} - Field Manager</h4>
                                        <p class="text-muted mb-0">{{ $contentType->description ?? 'Manage fields for this content type' }}</p>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFieldModal">
                                        <i class="fas fa-plus me-1"></i>Add Field
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#fieldGroupsModal">
                                        <i class="fas fa-layer-group me-1"></i>Field Groups
                                    </button>
                                    <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#visibilityRulesModal">
                                        <i class="fas fa-eye me-1"></i>Visibility Rules
                                    </button>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown">
                                            <i class="fas fa-download me-1"></i>Export/Import
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="exportFields()">
                                                <i class="fas fa-download me-2"></i>Export Fields
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#importFieldsModal">
                                                <i class="fas fa-upload me-2"></i>Import Fields
                                            </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0">{{ $statistics['total_fields'] }}</h4>
                                    <small>Total Fields</small>
                                </div>
                                <i class="fas fa-cube fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0">{{ $statistics['required_fields'] }}</h4>
                                    <small>Required Fields</small>
                                </div>
                                <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0">{{ count($statistics['field_types']) }}</h4>
                                    <small>Field Types</small>
                                </div>
                                <i class="fas fa-tags fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0">{{ $statistics['visibility_rules'] }}</h4>
                                    <small>Visibility Rules</small>
                                </div>
                                <i class="fas fa-eye fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Field Groups Tabs -->
        <div class="field-groups-tabs">
            <ul class="nav nav-tabs" id="fieldGroupsTabs" role="tablist">
                @foreach($fieldGroups as $groupKey => $group)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                id="{{ $groupKey }}-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#{{ $groupKey }}" 
                                type="button" 
                                role="tab">
                            <i class="{{ $group['icon'] ?? 'fas fa-cube' }}" style="color: {{ $group['color'] ?? '#007bff' }}"></i>
                            {{ $group['name'] }}
                            <span class="badge bg-secondary ms-2">{{ $statistics['field_groups'][$groupKey] ?? 0 }}</span>
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content" id="fieldGroupsTabContent">
                @foreach($fieldGroups as $groupKey => $group)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                         id="{{ $groupKey }}" 
                         role="tabpanel">
                        
                        <!-- Field Group Header -->
                        <div class="field-group-header d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="mb-1">{{ $group['name'] }}</h5>
                                <p class="text-muted mb-0">{{ $group['description'] }}</p>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                    onclick="addFieldToGroup('{{ $groupKey }}')">
                                <i class="fas fa-plus me-1"></i>Add Field
                            </button>
                        </div>

                        <!-- Fields List -->
                        <div class="fields-list" id="fields-{{ $groupKey }}">
                            @php
                                $groupFields = collect($contentType->fields_schema ?? [])
                                    ->filter(function($field) use ($groupKey) {
                                        return ($field['group'] ?? 'basic') === $groupKey;
                                    })
                                    ->sortBy('order');
                            @endphp

                            @if($groupFields->count() > 0)
                                <div class="row g-3 sortable-fields" data-group="{{ $groupKey }}">
                                    @foreach($groupFields as $fieldKey => $field)
                                        <div class="col-xl-4 col-lg-6 col-md-6 field-item" data-field-key="{{ $fieldKey }}">
                                            <div class="card field-card h-100">
                                                <div class="card-header">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-grip-vertical text-muted me-2 drag-handle"></i>
                                                            <div class="field-type-icon me-2" style="background: {{ $fieldTypes[$field['type']]['color'] ?? '#007bff' }};">
                                                                <i class="{{ $fieldTypes[$field['type']]['icon'] ?? 'fas fa-cube' }}"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">{{ $field['name'] ?? $field['label'] ?? ucfirst(str_replace('_', ' ', $fieldKey)) }}</h6>
                                                                <small class="text-muted">{{ $fieldTypes[$field['type']]['label'] ?? $field['type'] }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                                    type="button" data-bs-toggle="dropdown">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item" href="#" onclick="previewField('{{ $fieldKey }}')">
                                                                    <i class="fas fa-eye me-2"></i>Preview
                                                                </a></li>
                                                                <li><a class="dropdown-item" href="#" onclick="editField('{{ $fieldKey }}')">
                                                                    <i class="fas fa-edit me-2"></i>Edit
                                                                </a></li>
                                                                <li><a class="dropdown-item" href="#" onclick="duplicateField('{{ $fieldKey }}')">
                                                                    <i class="fas fa-copy me-2"></i>Duplicate
                                                                </a></li>
                                                                <li><hr class="dropdown-divider"></li>
                                                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteField('{{ $fieldKey }}')">
                                                                    <i class="fas fa-trash me-2"></i>Delete
                                                                </a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    @if(!empty($field['description']))
                                                        <p class="text-muted small mb-3">{{ $field['description'] }}</p>
                                                    @endif
                                                    
                                                    <!-- Field Properties -->
                                                    <div class="field-properties">
                                                        <div class="row g-2">
                                                            <div class="col-6">
                                                                <div class="property-item">
                                                                    <small class="text-muted">Required</small>
                                                                    <div class="fw-bold">
                                                                        @if($field['required'] ?? false)
                                                                            <span class="text-success">Yes</span>
                                                                        @else
                                                                            <span class="text-muted">No</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="property-item">
                                                                    <small class="text-muted">Order</small>
                                                                    <div class="fw-bold">{{ $field['order'] ?? 0 }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        @if(!empty($field['options']))
                                                            <div class="mt-2">
                                                                <small class="text-muted">Options:</small>
                                                                <div class="small">
                                                                    @foreach($field['options'] as $key => $value)
                                                                        <span class="badge bg-light text-dark me-1">
                                                                            {{ $key }}: {{ is_array($value) ? implode(', ', $value) : $value }}
                                                                        </span>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="card-footer bg-transparent">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="field-badges">
                                                            @if($field['required'] ?? false)
                                                                <span class="badge bg-danger me-1">Required</span>
                                                            @endif
                                                            <span class="badge bg-secondary">{{ $field['type'] }}</span>
                                                        </div>
                                                        <div class="field-actions">
                                                            <button class="btn btn-sm btn-outline-primary" 
                                                                    onclick="editField('{{ $fieldKey }}')" 
                                                                    title="Edit Field">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state text-center py-5">
                                    <i class="fas fa-cube fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No fields in this group</h5>
                                    <p class="text-muted">Add your first field to get started</p>
                                    <button type="button" class="btn btn-primary" 
                                            onclick="addFieldToGroup('{{ $groupKey }}')">
                                        <i class="fas fa-plus me-1"></i>Add Field
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Add Field Modal -->
    <div class="modal fade" id="addFieldModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Field</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addFieldForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fieldName" class="form-label">Field Name *</label>
                                    <input type="text" class="form-control" id="fieldName" name="name" required>
                                    <div class="form-text">Internal field name (e.g., product_title)</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fieldLabel" class="form-label">Field Label *</label>
                                    <input type="text" class="form-control" id="fieldLabel" name="label" required>
                                    <div class="form-text">Display label for the field</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fieldType" class="form-label">Field Type *</label>
                                    <select class="form-select" id="fieldType" name="type" required>
                                        <option value="">Select field type</option>
                                        @foreach($fieldTypes as $typeKey => $type)
                                            <option value="{{ $typeKey }}" data-icon="{{ $type['icon'] }}">
                                                {{ $type['icon'] }} {{ $type['label'] }}
                                            </option>
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
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="fieldRequired" name="required">
                                    <label class="form-check-label" for="fieldRequired">
                                        Required Field
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fieldVisibility" class="form-label">Visibility</label>
                                    <select class="form-select" id="fieldVisibility" name="visibility">
                                        <option value="always">Always Visible</option>
                                        <option value="conditional">Conditional</option>
                                        <option value="hidden">Hidden</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Field Options -->
                        <div id="fieldOptions" class="mb-3" style="display: none;">
                            <h6>Field Options</h6>
                            <div id="fieldOptionsContent"></div>
                        </div>

                        <!-- Field Preview -->
                        <div id="fieldPreview" class="mb-3" style="display: none;">
                            <h6>Preview</h6>
                            <div class="border p-3 rounded" id="fieldPreviewContent"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveField()">Add Field</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Field Groups Modal -->
    <div class="modal fade" id="fieldGroupsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage Field Groups</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="fieldGroupsList">
                        @foreach($fieldGroups as $groupKey => $group)
                            <div class="field-group-item card mb-3" data-group-key="{{ $groupKey }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="groups[{{ $groupKey }}][name]" 
                                                   value="{{ $group['name'] }}" placeholder="Group Name">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="groups[{{ $groupKey }}][description]" 
                                                   value="{{ $group['description'] }}" placeholder="Description">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="groups[{{ $groupKey }}][icon]" 
                                                   value="{{ $group['icon'] }}" placeholder="Icon">
                                        </div>
                                        <div class="col-md-2">
                                            <div class="d-flex">
                                                <input type="color" class="form-control form-control-color" 
                                                       name="groups[{{ $groupKey }}][color]" value="{{ $group['color'] }}">
                                                <button type="button" class="btn btn-outline-danger ms-2" 
                                                        onclick="removeFieldGroup('{{ $groupKey }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-outline-primary" onclick="addFieldGroup()">
                        <i class="fas fa-plus me-1"></i>Add Group
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveFieldGroups()">Save Groups</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Visibility Rules Modal -->
    <div class="modal fade" id="visibilityRulesModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage Visibility Rules</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="visibilityRulesList">
                        @foreach($visibilityRules as $index => $rule)
                            <div class="visibility-rule-item card mb-3" data-rule-index="{{ $index }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select class="form-select" name="rules[{{ $index }}][field]">
                                                <option value="">Select Field</option>
                                                @foreach(is_array($contentType->fields_schema) ? $contentType->fields_schema : [] as $fieldKey => $field)
                                                    <option value="{{ $fieldKey }}" {{ $rule['field'] == $fieldKey ? 'selected' : '' }}>
                                                        {{ $field['name'] ?? $field['label'] ?? ucfirst(str_replace('_', ' ', $fieldKey)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-select" name="rules[{{ $index }}][condition]">
                                                <option value="equals" {{ $rule['condition'] == 'equals' ? 'selected' : '' }}>Equals</option>
                                                <option value="not_equals" {{ $rule['condition'] == 'not_equals' ? 'selected' : '' }}>Not Equals</option>
                                                <option value="contains" {{ $rule['condition'] == 'contains' ? 'selected' : '' }}>Contains</option>
                                                <option value="empty" {{ $rule['condition'] == 'empty' ? 'selected' : '' }}>Is Empty</option>
                                                <option value="not_empty" {{ $rule['condition'] == 'not_empty' ? 'selected' : '' }}>Is Not Empty</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="rules[{{ $index }}][value]" 
                                                   value="{{ $rule['value'] }}" placeholder="Value">
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-select" name="rules[{{ $index }}][action]">
                                                <option value="show" {{ $rule['action'] == 'show' ? 'selected' : '' }}>Show</option>
                                                <option value="hide" {{ $rule['action'] == 'hide' ? 'selected' : '' }}>Hide</option>
                                                <option value="require" {{ $rule['action'] == 'require' ? 'selected' : '' }}>Require</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-outline-danger" 
                                                    onclick="removeVisibilityRule({{ $index }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-outline-primary" onclick="addVisibilityRule()">
                        <i class="fas fa-plus me-1"></i>Add Rule
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveVisibilityRules()">Save Rules</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Fields Modal -->
    <div class="modal fade" id="importFieldsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Field Configuration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('field-manager.import', $contentType->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="importFile" class="form-label">Select JSON File</label>
                            <input type="file" class="form-control" id="importFile" name="import_file" accept=".json" required>
                            <div class="form-text">Select a previously exported field configuration file</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Import Fields</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@push('extra_css')
<style>
    .field-manager-container {
        padding: 20px;
        background: #f8f9fa;
        min-height: 100vh;
    }
    
    .content-type-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
    }
    
    .field-card {
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .field-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-color: #007bff;
    }
    
    .field-type-icon {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }
    
    .property-item {
        padding: 4px 0;
    }
    
    .property-item small {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .field-badges .badge {
        font-size: 0.7rem;
    }
    
    .field-actions .btn {
        border-radius: 4px;
    }
    
    .sortable-fields {
        min-height: 200px;
    }
    
    .field-item {
        cursor: move;
    }
    
    .field-item:hover .drag-handle {
        color: #007bff !important;
    }
    
    .drag-handle {
        cursor: grab;
    }
    
    .drag-handle:active {
        cursor: grabbing;
    }
    
    .nav-tabs .nav-link {
        border: none;
        border-bottom: 2px solid transparent;
        color: #6c757d;
        font-weight: 500;
    }
    
    .nav-tabs .nav-link.active {
        border-bottom-color: #007bff;
        color: #007bff;
        background: none;
    }
    
    .nav-tabs .nav-link:hover {
        border-bottom-color: #007bff;
        color: #007bff;
    }
    
    .field-group-header {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }
    
    .empty-state {
        background: white;
        border-radius: 8px;
        padding: 60px 20px;
    }
    
    .statistics-card {
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .statistics-card .card-body {
        padding: 1.5rem;
    }
    
    .statistics-card h4 {
        font-size: 2rem;
        font-weight: 700;
    }
    
    .statistics-card small {
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
@endpush

@endsection

@push('extraCss')
<style>
}

.field-item {
    transition: all 0.3s ease;
}

.field-item:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.drag-handle {
    cursor: move;
}

.sortable-fields {
    min-height: 50px;
}

.empty-state {
    background: #f8f9fa;
    border-radius: 8px;
}

.field-group-item {
    border-left: 4px solid #007bff;
}

.visibility-rule-item {
    border-left: 4px solid #28a745;
}

.nav-tabs .nav-link {
    border: none;
    border-bottom: 2px solid transparent;
}

.nav-tabs .nav-link.active {
    border-bottom-color: #007bff;
    background: none;
}

.field-preview {
    background: #f8f9fa;
    border-radius: 4px;
}
</style>
@endpush

@push('extraJs')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
// Field Manager JavaScript
let fieldTypes = @json($fieldTypes);
let fieldGroups = @json($fieldGroups);
let currentFieldType = null;

// Initialize sortable fields
document.addEventListener('DOMContentLoaded', function() {
    initializeSortable();
    initializeFieldTypeHandler();
});

function initializeSortable() {
    document.querySelectorAll('.sortable-fields').forEach(function(container) {
        new Sortable(container, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function(evt) {
                updateFieldOrder();
            }
        });
    });
}

function initializeFieldTypeHandler() {
    document.getElementById('fieldType').addEventListener('change', function() {
        currentFieldType = this.value;
        if (currentFieldType) {
            loadFieldOptions(currentFieldType);
            generateFieldPreview();
        } else {
            hideFieldOptions();
            hideFieldPreview();
        }
    });
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
        case 'multi_select':
            input = document.createElement('select');
            input.className = 'form-select';
            input.name = `options[${key}][]`;
            input.multiple = true;
            option.options.forEach(function(value) {
                const option = document.createElement('option');
                option.value = value;
                option.textContent = value;
                if (option.default && option.default.includes(value)) option.selected = true;
                input.appendChild(option);
            });
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

function generateFieldPreview() {
    if (!currentFieldType) return;

    const fieldName = document.getElementById('fieldName').value || 'preview_field';
    const fieldLabel = document.getElementById('fieldLabel').value || 'Preview Field';
    const options = getFieldOptions();

    // Generate preview HTML (simplified)
    const previewHtml = `<div class="mb-3">
        <label class="form-label">${fieldLabel}</label>
        <input type="text" class="form-control" placeholder="Sample ${fieldTypeConfig.label} input">
    </div>`;

    document.getElementById('fieldPreviewContent').innerHTML = previewHtml;
    showFieldPreview();
}

function getFieldOptions() {
    const options = {};
    const formData = new FormData(document.getElementById('addFieldForm'));
    
    for (let [key, value] of formData.entries()) {
        if (key.startsWith('options[')) {
            const optionKey = key.match(/options\[(.*?)\]/)[1];
            options[optionKey] = value;
        }
    }
    
    return options;
}

function showFieldOptions() {
    document.getElementById('fieldOptions').style.display = 'block';
}

function hideFieldOptions() {
    document.getElementById('fieldOptions').style.display = 'none';
}

function showFieldPreview() {
    document.getElementById('fieldPreview').style.display = 'block';
}

function hideFieldPreview() {
    document.getElementById('fieldPreview').style.display = 'none';
}

function saveField() {
    const formData = new FormData(document.getElementById('addFieldForm'));
    const fieldData = Object.fromEntries(formData.entries());
    
    // Convert options to proper format
    fieldData.options = getFieldOptions();
    fieldData.required = document.getElementById('fieldRequired').checked;

    fetch(`{{ route('field-manager.create-field', $contentType->slug) }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(fieldData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Failed to create field'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while creating the field');
    });
}

function editField(fieldKey) {
    // Implementation for editing field
    console.log('Edit field:', fieldKey);
}

function duplicateField(fieldKey) {
    if (confirm('Are you sure you want to duplicate this field?')) {
        fetch(`{{ route('field-manager.duplicate-field', $contentType->slug) }}/${fieldKey}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Failed to duplicate field'));
            }
        });
    }
}

function deleteField(fieldKey) {
    if (confirm('Are you sure you want to delete this field? This action cannot be undone.')) {
        fetch(`{{ route('field-manager.delete-field', $contentType->slug) }}/${fieldKey}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Failed to delete field'));
            }
        });
    }
}

function previewField(fieldKey) {
    // Implementation for field preview
    console.log('Preview field:', fieldKey);
}

function updateFieldOrder() {
    const fieldOrder = [];
    document.querySelectorAll('.field-item').forEach(function(item) {
        fieldOrder.push(item.dataset.fieldKey);
    });

    fetch(`{{ route('field-manager.reorder-fields', $contentType->slug) }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ field_order: fieldOrder })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Field order updated');
        }
    });
}

function addFieldToGroup(groupKey) {
    document.getElementById('fieldGroup').value = groupKey;
    document.getElementById('addFieldModal').click();
}

function saveFieldGroups() {
    const groups = {};
    document.querySelectorAll('.field-group-item').forEach(function(item) {
        const groupKey = item.dataset.groupKey;
        const inputs = item.querySelectorAll('input');
        groups[groupKey] = {
            name: inputs[0].value,
            description: inputs[1].value,
            icon: inputs[2].value,
            color: inputs[3].value,
            order: 1
        };
    });

    fetch(`{{ route('field-manager.save-field-groups', $contentType->slug) }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ field_groups: groups })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Failed to save field groups'));
        }
    });
}

function addFieldGroup() {
    const groupsList = document.getElementById('fieldGroupsList');
    const newGroupKey = 'group_' + Date.now();
    
    const groupHtml = `
        <div class="field-group-item card mb-3" data-group-key="${newGroupKey}">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="groups[${newGroupKey}][name]" placeholder="Group Name">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="groups[${newGroupKey}][description]" placeholder="Description">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="groups[${newGroupKey}][icon]" placeholder="Icon">
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex">
                            <input type="color" class="form-control form-control-color" name="groups[${newGroupKey}][color]" value="#007bff">
                            <button type="button" class="btn btn-outline-danger ms-2" onclick="removeFieldGroup('${newGroupKey}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    groupsList.insertAdjacentHTML('beforeend', groupHtml);
}

function removeFieldGroup(groupKey) {
    if (confirm('Are you sure you want to remove this field group?')) {
        document.querySelector(`[data-group-key="${groupKey}"]`).remove();
    }
}

function saveVisibilityRules() {
    const rules = [];
    document.querySelectorAll('.visibility-rule-item').forEach(function(item) {
        const inputs = item.querySelectorAll('input, select');
        rules.push({
            field: inputs[0].value,
            condition: inputs[1].value,
            value: inputs[2].value,
            action: inputs[3].value
        });
    });

    fetch(`{{ route('field-manager.save-visibility-rules', $contentType->slug) }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ visibility_rules: rules })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Failed to save visibility rules'));
        }
    });
}

function addVisibilityRule() {
    const rulesList = document.getElementById('visibilityRulesList');
    const ruleIndex = document.querySelectorAll('.visibility-rule-item').length;
    
    const ruleHtml = `
        <div class="visibility-rule-item card mb-3" data-rule-index="${ruleIndex}">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-select" name="rules[${ruleIndex}][field]">
                            <option value="">Select Field</option>
                            @foreach(is_array($contentType->fields_schema) ? $contentType->fields_schema : [] as $fieldKey => $field)
                                <option value="{{ $fieldKey }}">{{ $field['name'] ?? $field['label'] ?? ucfirst(str_replace('_', ' ', $fieldKey)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="rules[${ruleIndex}][condition]">
                            <option value="equals">Equals</option>
                            <option value="not_equals">Not Equals</option>
                            <option value="contains">Contains</option>
                            <option value="empty">Is Empty</option>
                            <option value="not_empty">Is Not Empty</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="rules[${ruleIndex}][value]" placeholder="Value">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="rules[${ruleIndex}][action]">
                            <option value="show">Show</option>
                            <option value="hide">Hide</option>
                            <option value="require">Require</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-danger" onclick="removeVisibilityRule(${ruleIndex})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    rulesList.insertAdjacentHTML('beforeend', ruleHtml);
}

function removeVisibilityRule(ruleIndex) {
    document.querySelector(`[data-rule-index="${ruleIndex}"]`).remove();
}

function exportFields() {
    window.open(`{{ route('field-manager.export', $contentType->slug) }}`, '_blank');
}
</script>
@endpush
