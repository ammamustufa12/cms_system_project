@extends('twill::layouts.main')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Install Field Type</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Install Field Type</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid px-5">
        <div class="row">
            <!-- Left Column - Field Types List -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">Field Types</h5>
                    </div>
                    <div class="card-body">
                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 mb-3">
                            <button class="btn btn-success btn-sm" onclick="showInstallForm()">
                                <i class="ri-download-line me-1"></i> Install Field
                            </button>
                            <button class="btn btn-danger btn-sm" data-action="delete">
                                <i class="ri-delete-bin-line me-1"></i> Delete
                            </button>
                        </div>

                        <!-- Search -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="ri-search-line"></i></span>
                            <input type="text" class="form-control" placeholder="Search Field Type">
                        </div>

                        <!-- Display Count -->
                        <div class="d-flex justify-content-end mb-3">
                            <select class="form-select form-select-sm" style="width: auto;">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                            </select>
                            <span class="text-muted ms-1">v</span>
                            <div class="btn-group btn-group-sm ms-2">
                                <button class="btn btn-outline-secondary"><i class="ri-arrow-left-s-line"></i></button>
                                <button class="btn btn-outline-secondary"><i class="ri-arrow-right-s-line"></i></button>
                            </div>
                        </div>

                        <!-- Field Types List -->
                        <div class="list-group">
                            @forelse($fieldTypes as $fieldType)
                            <div class="list-group-item list-group-item-action field-type-item border-0 mb-2 {{ $loop->first ? 'active bg-primary text-white' : '' }}" 
                                 style="border-left: 4px solid #007bff !important;" data-field-id="{{ $fieldType->id }}">
                                <a href="#" class="text-decoration-none {{ $loop->first ? 'text-white' : '' }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <i class="ri-drag-move-2-line text-muted"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $fieldType->name }}</h6>
                                                <div class="d-flex gap-2">
                                                    <span class="badge bg-info">{{ $fieldType->source_badge }}</span>
                                                    <span class="text-muted small">ID: {{ $fieldType->id }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="badge bg-{{ $fieldType->is_active ? 'success' : 'secondary' }}">
                                            {{ $fieldType->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </a>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="ri-database-2-line fa-2x text-muted mb-2"></i>
                                <p class="text-muted small">No field types found</p>
                            </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            <nav>
                                <ul class="pagination pagination-sm">
                                    <li class="page-item"><a class="page-link" href="#"><i class="ri-arrow-left-s-line"></i><i class="ri-arrow-left-s-line"></i></a></li>
                                    <li class="page-item"><a class="page-link" href="#"><i class="ri-arrow-left-s-line"></i></a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                                    <li class="page-item"><a class="page-link" href="#">6</a></li>
                                    <li class="page-item"><a class="page-link" href="#"><i class="ri-arrow-right-s-line"></i></a></li>
                                    <li class="page-item"><a class="page-link" href="#"><i class="ri-arrow-right-s-line"></i><i class="ri-arrow-right-s-line"></i></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Center Column - Install Form & Field Types Cards -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">Field Types</h5>
                                <small class="text-muted">core fields used to capture and record data</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Install Field Type Section -->
                        <div class="border border-success rounded p-4 mb-4" id="installSection" style="border-width: 3px !important;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex gap-3">
                                    <span class="badge bg-success">tabs?</span>
                                    <span class="text-muted">Install Zip File | Update | Install from CENTRALIZED</span>
                                </div>
                                <button class="btn btn-sm btn-outline-secondary" onclick="hideInstallForm()">
                                    <i class="ri-close-line"></i>
                                </button>
                            </div>
                            
                            <form action="{{ route('admin.field-manager.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Upload and Install File:</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="install_file" accept=".zip">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="ri-close-line"></i>
                                        </button>
                                        <button class="btn btn-primary" type="button">
                                            <i class="ri-folder-open-line me-1"></i> Browse
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Field Type Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="type" class="form-label">Field Type</label>
                                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
                                        <option value="textarea" {{ old('type') == 'textarea' ? 'selected' : '' }}>Text Area</option>
                                        <option value="email" {{ old('type') == 'email' ? 'selected' : '' }}>Email</option>
                                        <option value="number" {{ old('type') == 'number' ? 'selected' : '' }}>Number</option>
                                        <option value="select" {{ old('type') == 'select' ? 'selected' : '' }}>Select</option>
                                        <option value="checkbox" {{ old('type') == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                        <option value="radio" {{ old('type') == 'radio' ? 'selected' : '' }}>Radio</option>
                                        <option value="file" {{ old('type') == 'file' ? 'selected' : '' }}>File</option>
                                        <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Image</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="source" class="form-label">Source</label>
                                            <select class="form-select @error('source') is-invalid @enderror" id="source" name="source" required>
                                                <option value="local" {{ old('source') == 'local' ? 'selected' : '' }}>Local</option>
                                                <option value="centralized" {{ old('source') == 'centralized' ? 'selected' : '' }}>Centralized</option>
                                                <option value="custom" {{ old('source') == 'custom' ? 'selected' : '' }}>Custom</option>
                                            </select>
                                            @error('source')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="version" class="form-label">Version</label>
                                            <input type="text" class="form-control @error('version') is-invalid @enderror" 
                                                   id="version" name="version" value="{{ old('version', '1.0.0') }}">
                                            @error('version')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-muted mb-3">
                                    <small>Future: promote new field type/ updates?</small>
                                </div>
                                
                                <!-- Placeholder boxes -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="border rounded p-3 text-center bg-light">
                                            <i class="ri-image-line fa-2x text-muted mb-2"></i>
                                            <div class="text-muted">Upload Preview</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="border rounded p-3 text-center bg-light">
                                            <i class="ri-file-zip-line fa-2x text-muted mb-2"></i>
                                            <div class="text-muted">Zip File</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="border rounded p-3 text-center bg-light">
                                            <i class="ri-settings-3-line fa-2x text-muted mb-2"></i>
                                            <div class="text-muted">Configuration</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="submit" class="btn btn-success">
                                        <i class="ri-download-line me-1"></i> Install Field Type
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Field Types Cards -->
                        <div class="row">
                            @forelse($fieldTypes as $fieldType)
                            <div class="col-md-12 mb-3">
                                <div class="card border-start border-primary border-3 h-100 field-type-card {{ $loop->first ? 'border-primary' : '' }}" data-field-id="{{ $fieldType->id }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="card-title mb-0">{{ $fieldType->name }}</h6>
                                            <span class="badge bg-{{ $fieldType->is_active ? 'success' : 'secondary' }}">
                                                {{ $fieldType->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                        <p class="card-text text-muted small">
                                            {{ Str::limit($fieldType->description ?: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text', 100) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-info">{{ $fieldType->source_badge }}</span>
                                                <span class="text-muted small">ID: {{ $fieldType->id }}</span>
                                            </div>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.field-manager.show', $fieldType) }}" class="btn btn-outline-primary" title="View">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('admin.field-manager.edit', $fieldType) }}" class="btn btn-outline-secondary" title="Edit">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                @if($fieldType->is_active)
                                                    <form action="{{ route('admin.field-manager.deactivate', $fieldType) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-warning" title="Deactivate">
                                                            <i class="ri-pause-line"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.field-manager.activate', $fieldType) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-success" title="Activate">
                                                            <i class="ri-play-line"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('admin.field-manager.destroy', $fieldType) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this field type?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="ri-database-2-line fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No field types found. Install your first field type above.</p>
                                </div>
                            </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            <nav>
                                <ul class="pagination pagination-sm">
                                    <li class="page-item"><a class="page-link" href="#"><i class="ri-arrow-left-s-line"></i><i class="ri-arrow-left-s-line"></i></a></li>
                                    <li class="page-item"><a class="page-link" href="#"><i class="ri-arrow-left-s-line"></i></a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                                    <li class="page-item"><a class="page-link" href="#">6</a></li>
                                    <li class="page-item"><a class="page-link" href="#"><i class="ri-arrow-right-s-line"></i></a></li>
                                    <li class="page-item"><a class="page-link" href="#"><i class="ri-arrow-right-s-line"></i><i class="ri-arrow-right-s-line"></i></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Field Type Edit Panel -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0" id="fieldTitle">Text Area</h5>
                            <div class="d-flex gap-2">
                                <span class="badge bg-info" id="fieldSource">SOURCE CENTRALIZED</span>
                                <span class="text-muted small" id="fieldId">ID: 1</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Action Buttons -->
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <button class="btn btn-success btn-sm" id="saveBtn">
                                <i class="ri-save-line me-1"></i> Save
                            </button>
                            <button class="btn btn-success btn-sm" id="saveCloseBtn">
                                <i class="ri-save-line me-1"></i> Save & Close
                            </button>
                            <button class="btn btn-primary btn-sm" id="editBtn">
                                <i class="ri-edit-line me-1"></i> Edit
                            </button>
                            <button class="btn btn-success btn-sm" id="activateBtn">
                                <i class="ri-check-line me-1"></i> Activate
                            </button>
                            <button class="btn btn-danger btn-sm" id="cancelBtn">
                                <i class="ri-close-line me-1"></i> Cancel
                            </button>
                        </div>

                        <!-- Field Configuration Form -->
                        <form id="fieldEditForm" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <!-- Field Name -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Field Title:</label>
                                <input type="text" class="form-control form-control-sm" id="fieldName" name="name" value="Text Area">
                            </div>

                            <!-- Field Alias -->
                            <div class="mb-3">
                                <label class="form-label">Alias:</label>
                                <input type="text" class="form-control form-control-sm" id="fieldAlias" name="alias" value="text_area">
                            </div>

                            <!-- Field Type -->
                            <div class="mb-3">
                                <label class="form-label">Field Type:</label>
                                <select class="form-select form-select-sm" id="fieldType" name="type">
                                    <option value="text">Text</option>
                                    <option value="textarea" selected>Text Area</option>
                                    <option value="email">Email</option>
                                    <option value="number">Number</option>
                                    <option value="select">Select</option>
                                    <option value="checkbox">Checkbox</option>
                                    <option value="radio">Radio</option>
                                    <option value="file">File</option>
                                </select>
                            </div>

                            <!-- Field Group -->
                            <div class="mb-3">
                                <label class="form-label">Field Group:</label>
                                <select class="form-select form-select-sm" id="fieldGroup" name="field_group">
                                    <option value="text_fields" selected>Text Fields</option>
                                    <option value="form_fields">Form Fields</option>
                                    <option value="media_fields">Media Fields</option>
                                </select>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Description</label>
                                <textarea class="form-control" id="fieldDescription" name="description" rows="4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</textarea>
                            </div>

                            <!-- Access Section -->
                            <div class="border rounded p-3">
                                <h6 class="fw-bold mb-2">Access</h6>
                                <p class="text-muted small mb-3">control who has viewing access to this group</p>
                                <div class="mb-3">
                                    <label class="form-label">Access Rights:</label>
                                    <select class="form-select form-select-sm" id="accessRights" name="access_rights">
                                        <option value="public" selected>Public</option>
                                        <option value="private">Private</option>
                                        <option value="restricted">Restricted</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Field type selection from left column
    const fieldTypeItems = document.querySelectorAll('.field-type-item');
    const detailsPanel = document.querySelector('.col-lg-3 .card');
    
    // Field type selection from left column
    fieldTypeItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all items
            fieldTypeItems.forEach(i => {
                i.classList.remove('active', 'bg-primary', 'text-white');
                i.classList.add('text-dark');
            });
            
            // Add active class to clicked item
            this.classList.add('active', 'bg-primary', 'text-white');
            this.classList.remove('text-dark');
            
            // Get field type ID
            const fieldId = this.getAttribute('data-field-id');
            
            // Fetch detailed information via AJAX
            fetch(`/admin/field-manager/${fieldId}/details`)
                .then(response => response.json())
                .then(data => {
                    updateEditPanel(data);
                })
                .catch(error => {
                    console.error('Error fetching field details:', error);
                    // Fallback to basic info
                    const fieldName = this.querySelector('h6').textContent;
                    const fieldDescription = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.';
                    updateEditPanelBasic(fieldName, fieldDescription, fieldId);
                });
        });
    });
    
    // Search functionality for field types in left column
    const searchInput = document.querySelector('input[placeholder="Search Field Type"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const fieldItems = document.querySelectorAll('.field-type-item');
            
            fieldItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
    
    function updateEditPanel(data) {
        // Update header
        document.getElementById('fieldTitle').textContent = data.name;
        document.getElementById('fieldSource').textContent = data.source_badge;
        document.getElementById('fieldId').textContent = `ID: ${data.id}`;
        
        // Update form fields
        document.getElementById('fieldName').value = data.name;
        document.getElementById('fieldAlias').value = data.slug || data.name.toLowerCase().replace(/\s+/g, '_');
        document.getElementById('fieldType').value = data.type;
        document.getElementById('fieldDescription').value = data.description;
        
        // Update status buttons
        const activateBtn = document.getElementById('activateBtn');
        if (data.is_active) {
            activateBtn.classList.remove('btn-success');
            activateBtn.classList.add('btn-warning');
            activateBtn.innerHTML = '<i class="ri-pause-line me-1"></i> Disable';
        } else {
            activateBtn.classList.remove('btn-warning');
            activateBtn.classList.add('btn-success');
            activateBtn.innerHTML = '<i class="ri-check-line me-1"></i> Activate';
        }
        
        // Update form action
        const form = document.getElementById('fieldEditForm');
        form.action = `/admin/field-manager/${data.id}`;
    }
    
    function updateEditPanelBasic(name, description, id) {
        // Update header
        document.getElementById('fieldTitle').textContent = name;
        document.getElementById('fieldId').textContent = `ID: ${id}`;
        
        // Update form fields
        document.getElementById('fieldName').value = name;
        document.getElementById('fieldAlias').value = name.toLowerCase().replace(/\s+/g, '_');
        document.getElementById('fieldDescription').value = description;
        
        // Update form action
        const form = document.getElementById('fieldEditForm');
        form.action = `/admin/field-manager/${id}`;
    }
    
    // Form submission handlers
    document.getElementById('saveBtn').addEventListener('click', function() {
        document.getElementById('fieldEditForm').submit();
    });
    
    document.getElementById('saveCloseBtn').addEventListener('click', function() {
        // Add a hidden input to indicate save and close
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'save_and_close';
        input.value = '1';
        document.getElementById('fieldEditForm').appendChild(input);
        document.getElementById('fieldEditForm').submit();
    });
    
    document.getElementById('editBtn').addEventListener('click', function() {
        // Enable form fields for editing
        const formFields = document.querySelectorAll('#fieldEditForm input, #fieldEditForm select, #fieldEditForm textarea');
        formFields.forEach(field => {
            field.disabled = false;
            field.readOnly = false;
        });
    });
    
    document.getElementById('activateBtn').addEventListener('click', function() {
        const fieldId = document.getElementById('fieldId').textContent.replace('ID: ', '');
        const isActive = this.textContent.includes('Activate');
        const action = isActive ? 'activate' : 'deactivate';
        
        fetch(`/admin/field-manager/${fieldId}/${action}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
    
    document.getElementById('cancelBtn').addEventListener('click', function() {
        // Reset form to original values
        location.reload();
    });
    
    // File upload preview
    const fileInput = document.querySelector('input[type="file"]');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // Update preview boxes
                const previewBoxes = document.querySelectorAll('.border.rounded.p-3.text-center.bg-light');
                if (previewBoxes.length > 0) {
                    previewBoxes[0].innerHTML = `
                        <i class="ri-file-line fa-2x text-success mb-2"></i>
                        <div class="text-success">${file.name}</div>
                    `;
                }
            }
        });
    }
    
    // Browse button functionality
    const browseBtn = document.querySelector('button[type="button"]');
    if (browseBtn) {
        browseBtn.addEventListener('click', function() {
            fileInput.click();
        });
    }
});

// Toggle install section
function showInstallForm() {
    const installSection = document.getElementById('installSection');
    if (installSection) {
        installSection.style.display = 'block';
    }
}

function hideInstallForm() {
    const installSection = document.getElementById('installSection');
    if (installSection) {
        installSection.style.display = 'none';
    }
}
</script>
@endsection

