@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Edit Field Group</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.field-groups.index') }}">Field Groups</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.field-groups.show', $fieldGroup) }}">{{ $fieldGroup->name }}</a></li>
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
                                <h5 class="card-title mb-0">Field Group</h5>
                                <small class="text-muted">edit field group details</small>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" form="fieldGroupForm" class="btn btn-success btn-sm">
                                    <i class="ri-check-line me-1"></i> Save
                                </button>
                                <button type="submit" form="fieldGroupForm" name="action" value="save_and_close" class="btn btn-outline-primary btn-sm">
                                    <i class="ri-check-line me-1"></i> Save & Close
                                </button>
                                <a href="{{ route('admin.field-groups.show', $fieldGroup) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="ri-eye-line me-1"></i> View
                                </a>
                                <a href="{{ route('admin.field-groups.index') }}" class="btn btn-outline-danger btn-sm">
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

                        <form id="fieldGroupForm" method="POST" action="{{ route('admin.field-groups.update', $fieldGroup) }}">
                            @csrf
                            @method('PUT')
                            
                            <!-- Field Group Details Section -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $fieldGroup->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="is_active">
                                                Active
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Source:</label>
                                        <select class="form-select" name="source" required>
                                            <option value="local" {{ old('source', $fieldGroup->source) == 'local' ? 'selected' : '' }}>Local</option>
                                            <option value="centralized" {{ old('source', $fieldGroup->source) == 'centralized' ? 'selected' : '' }}>Centralized</option>
                                            <option value="custom" {{ old('source', $fieldGroup->source) == 'custom' ? 'selected' : '' }}>Custom</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Access Rights:</label>
                                        <select class="form-select" name="access_rights" required>
                                            <option value="public" {{ old('access_rights', $fieldGroup->access_rights) == 'public' ? 'selected' : '' }}>Public</option>
                                            <option value="private" {{ old('access_rights', $fieldGroup->access_rights) == 'private' ? 'selected' : '' }}>Private</option>
                                            <option value="restricted" {{ old('access_rights', $fieldGroup->access_rights) == 'restricted' ? 'selected' : '' }}>Restricted</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Name:</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name', $fieldGroup->name) }}" placeholder="Enter field group name" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Sort Order:</label>
                                        <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $fieldGroup->sort_order ?? 0) }}" min="0">
                                        <div class="form-text">Lower numbers appear first</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Description:</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Enter field group description">{{ old('description', $fieldGroup->description) }}</textarea>
                            </div>
                            
                            <!-- Field Group Configuration -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary">Field Group Configuration</h6>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Default Field Settings:</label>
                                                    <textarea class="form-control" name="default_field_settings" rows="3" placeholder="Enter default field settings">{{ old('default_field_settings', $fieldGroup->default_field_settings ?? '') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Validation Rules:</label>
                                                    <textarea class="form-control" name="validation_rules" rows="3" placeholder="Enter validation rules">{{ old('validation_rules', $fieldGroup->validation_rules ?? '') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Allowed Field Types:</label>
                                                    <input type="text" class="form-control" name="allowed_field_types" value="{{ old('allowed_field_types', $fieldGroup->allowed_field_types ?? '') }}" placeholder="text,number,date,etc.">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Max Fields:</label>
                                                    <input type="number" class="form-control" name="max_fields" value="{{ old('max_fields', $fieldGroup->max_fields ?? '') }}" placeholder="Maximum number of fields">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Current Fields in Group -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary">Current Fields in this Group</h6>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Field Name</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($fieldGroup->fields as $field)
                                            <tr>
                                                <td>{{ $field->id }}</td>
                                                <td>{{ $field->label }}</td>
                                                <td><span class="badge bg-info">{{ ucfirst($field->type) }}</span></td>
                                                <td>
                                                    <span class="badge bg-{{ $field->is_active ? 'success' : 'danger' }}">
                                                        {{ $field->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('admin.fields.show', $field) }}" class="btn btn-outline-primary">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                        <a href="{{ route('admin.fields.edit', $field) }}" class="btn btn-outline-secondary">
                                                            <i class="ri-edit-line"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-3">
                                                    <div class="text-muted">
                                                        <i class="ri-database-2-line fa-2x mb-2"></i>
                                                        <p class="mb-0">No fields in this group yet</p>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
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
    const form = document.getElementById('fieldGroupForm');
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
});
</script>
@endsection










