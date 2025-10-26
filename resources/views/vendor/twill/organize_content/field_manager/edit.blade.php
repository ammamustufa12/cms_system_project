@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Edit Field Type</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.field-manager.index') }}">Field Manager</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.field-manager.show', $fieldManager) }}">{{ $fieldManager->name }}</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid px-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">Field Type</h5>
                                <small class="text-muted">edit field type details</small>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" form="fieldTypeForm" class="btn btn-success btn-sm">
                                    <i class="ri-check-line me-1"></i> Save
                                </button>
                                <button type="submit" form="fieldTypeForm" name="action" value="save_and_close" class="btn btn-outline-primary btn-sm">
                                    <i class="ri-check-line me-1"></i> Save & Close
                                </button>
                                <a href="{{ route('admin.field-manager.show', $fieldManager) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="ri-eye-line me-1"></i> View
                                </a>
                                <a href="{{ route('admin.field-manager.index') }}" class="btn btn-outline-danger btn-sm">
                                    <i class="ri-close-line me-1"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form id="fieldTypeForm" method="POST" action="{{ route('admin.field-manager.update', $fieldManager) }}">
                            @csrf
                            @method('PUT')
                            
                            <!-- Field Type Details Section -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $fieldManager->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="is_active">
                                                Active
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Source:</label>
                                        <select class="form-select" name="source" required>
                                            <option value="local" {{ old('source', $fieldManager->source) == 'local' ? 'selected' : '' }}>Local</option>
                                            <option value="centralized" {{ old('source', $fieldManager->source) == 'centralized' ? 'selected' : '' }}>Centralized</option>
                                            <option value="custom" {{ old('source', $fieldManager->source) == 'custom' ? 'selected' : '' }}>Custom</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Type:</label>
                                        <input type="text" class="form-control" name="type" value="{{ old('type', $fieldManager->type) }}" placeholder="Enter field type" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Name:</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name', $fieldManager->name) }}" placeholder="Enter field type name" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Version:</label>
                                        <input type="text" class="form-control" name="version" value="{{ old('version', $fieldManager->version) }}" placeholder="Enter version">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Author:</label>
                                        <input type="text" class="form-control" name="author" value="{{ old('author', $fieldManager->author) }}" placeholder="Enter author name">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Description:</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Enter field type description">{{ old('description', $fieldManager->description) }}</textarea>
                            </div>
                            
                            <!-- Installation Instructions -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Installation Instructions:</label>
                                <textarea class="form-control" name="install_instructions" rows="5" placeholder="Enter installation instructions">{{ old('install_instructions', $fieldManager->install_instructions) }}</textarea>
                                <div class="form-text">Provide detailed instructions for installing this field type</div>
                            </div>
                            
                            <!-- Current Installation File -->
                            @if($fieldManager->install_file_path)
                            <div class="mb-4">
                                <label class="form-label fw-bold">Current Installation File:</label>
                                <div class="alert alert-info">
                                    <i class="ri-file-zip-line me-2"></i>
                                    <strong>File Path:</strong> {{ $fieldManager->install_file_path }}
                                </div>
                            </div>
                            @endif
                            
                            <!-- New Installation File Upload -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Upload New Installation File:</label>
                                <input type="file" class="form-control" name="install_file" accept=".zip">
                                <div class="form-text">Upload a ZIP file containing the field type implementation (max 10MB)</div>
                            </div>
                            
                            <!-- Field Type Configuration -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary">Field Type Configuration</h6>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Default Validation Rules:</label>
                                                    <textarea class="form-control" name="default_validation" rows="3" placeholder="Enter default validation rules">{{ old('default_validation', $fieldManager->default_validation ?? '') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Default Options:</label>
                                                    <textarea class="form-control" name="default_options" rows="3" placeholder="Enter default options">{{ old('default_options', $fieldManager->default_options ?? '') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Supported Data Types:</label>
                                                    <input type="text" class="form-control" name="supported_data_types" value="{{ old('supported_data_types', $fieldManager->supported_data_types ?? '') }}" placeholder="text,number,date,etc.">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Required Dependencies:</label>
                                                    <input type="text" class="form-control" name="dependencies" value="{{ old('dependencies', $fieldManager->dependencies ?? '') }}" placeholder="package1,package2,etc.">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
    // Form submission handling
    const form = document.getElementById('fieldTypeForm');
    form.addEventListener('submit', function(e) {
        // Basic validation
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });
    
    // File upload validation
    const fileInput = document.querySelector('input[name="install_file"]');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // Check file size (10MB max)
                if (file.size > 10 * 1024 * 1024) {
                    alert('File size must be less than 10MB');
                    this.value = '';
                    return;
                }
                
                // Check file type
                if (!file.name.toLowerCase().endsWith('.zip')) {
                    alert('Please select a ZIP file');
                    this.value = '';
                    return;
                }
            }
        });
    }
});
</script>
@endsection

