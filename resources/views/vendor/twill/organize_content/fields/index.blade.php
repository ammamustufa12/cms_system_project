@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Fields</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Fields</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid px-5">
        <div class="row">
            <!-- Left Column - Field Groups List -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">Field Group</h5>
                    </div>
                    <div class="card-body">
                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 mb-3">
                            <a href="{{ route('admin.field-groups.create') }}" class="btn btn-success btn-sm">
                                <i class="ri-add-line me-1"></i> New
                            </a>
                            <button class="btn btn-primary btn-sm">
                                <i class="ri-edit-line me-1"></i> Edit
                            </button>
                            <button class="btn btn-info btn-sm">
                                <i class="ri-file-copy-line me-1"></i> Copy
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="ri-delete-bin-line me-1"></i> X Delete
                            </button>
                            <button class="btn btn-success btn-sm">
                                <i class="ri-check-line me-1"></i> Activate
                            </button>
                            <button class="btn btn-warning btn-sm">
                                <i class="ri-pause-line me-1"></i> Disable
                            </button>
                        </div>

                        <!-- Search -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="ri-search-line"></i></span>
                            <input type="text" class="form-control" placeholder="Search Field Groups">
                        </div>

                        <!-- Display Count -->
                        <div class="d-flex justify-content-end mb-3">
                            <select class="form-select form-select-sm" style="width: auto;">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                            </select>
                            <span class="text-muted ms-1">v</span>
                        </div>

                        <!-- Field Groups List -->
                        <div class="list-group">
                            <!-- All Fields Filter -->
                            <div class="list-group-item list-group-item-action {{ !request('field_group_id') ? 'active' : '' }} border-0 mb-2 bg-primary text-white">
                                <a href="{{ route('admin.fields.index') }}" class="text-decoration-none text-white">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">All Fields</span>
                                    </div>
                                </a>
                            </div>

                            @foreach($fieldGroups as $fieldGroup)
                            <div class="list-group-item list-group-item-action {{ request('field_group_id') == $fieldGroup->id ? 'active' : '' }} border-0 mb-2" style="border-left: 4px solid #007bff !important;">
                                <a href="{{ route('admin.fields.index', ['field_group_id' => $fieldGroup->id]) }}" class="text-decoration-none">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <i class="ri-drag-move-2-line text-muted"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $fieldGroup->name }}</h6>
                                                <div class="d-flex gap-2">
                                                    <span class="badge bg-info">{{ $fieldGroup->source_badge }}</span>
                                                    <span class="text-muted small">ID: {{ $fieldGroup->id }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="badge bg-{{ $fieldGroup->is_active ? 'success' : 'secondary' }}">
                                            {{ $fieldGroup->status_badge }}
                                        </span>
                                    </div>
                                </a>
                            </div>
                            @endforeach
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
                                    <li class="page-item"><a class="page-link" href="#"><i class="ri-arrow-right-s-line"></i></a></li>
                                    <li class="page-item"><a class="page-link" href="#"><i class="ri-arrow-right-s-line"></i><i class="ri-arrow-right-s-line"></i></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Center Column - Fields Table -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">Fields</h5>
                                <small class="text-muted">sub heading</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.fields.create') }}" class="btn btn-success btn-sm">
                                    <i class="ri-add-line me-1"></i> New
                                </a>
                                <button class="btn btn-primary btn-sm" data-action="edit" onclick="handleBulkEdit()">
                                    <i class="ri-edit-line me-1"></i> Edit
                                </button>
                                <button class="btn btn-info btn-sm" data-action="copy" onclick="handleBulkCopy()">
                                    <i class="ri-file-copy-line me-1"></i> Copy
                                </button>
                                <button class="btn btn-danger btn-sm" data-action="delete" onclick="handleBulkDelete()">
                                    <i class="ri-delete-bin-line me-1"></i> X Delete
                                </button>
                                <button class="btn btn-success btn-sm" data-action="activate">
                                    <i class="ri-check-line me-1"></i> Activate
                                </button>
                                <button class="btn btn-warning btn-sm" data-action="deactivate">
                                    <i class="ri-pause-line me-1"></i> Disable
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Search and Filter -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="input-group" style="width: 250px;">
                                    <span class="input-group-text"><i class="ri-search-line"></i></span>
                                    <input type="text" class="form-control" placeholder="Search Fields">
                                </div>
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="ri-filter-line"></i>
                                </button>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <select class="form-select form-select-sm" style="width: auto;">
                                    <option>10</option>
                                    <option>25</option>
                                    <option>50</option>
                                </select>
                                <span class="text-muted">v</span>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Fields Table -->
                        <form id="fieldsForm" method="POST">
                            @csrf
                            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                <table class="table table-hover">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th><input type="checkbox" class="form-check-input"></th>
                                        <th><i class="ri-drag-move-2-line"></i></th>
                                        <th>Status</th>
                                        <th>ID</th>
                                        <th>Field Group</th>
                                        <th>Type</th>
                                        <th>Label</th>
                                        <th>Database Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($fields as $field)
                                    <tr>
                                        <td><input type="checkbox" class="form-check-input" name="selected_fields[]" value="{{ $field->id }}"></td>
                                        <td><i class="ri-drag-move-2-line text-muted"></i></td>
                                        <td>
                                            @if($field->is_active)
                                                <span class="badge bg-success rounded-pill d-inline-flex align-items-center" style="width: 12px; height: 12px;" title="Active">
                                                    <i class="ri-check-line" style="font-size: 8px;"></i>
                                                </span>
                                            @else
                                                <span class="badge bg-danger rounded-pill d-inline-flex align-items-center" style="width: 12px; height: 12px;" title="Inactive">
                                                    <i class="ri-close-line" style="font-size: 8px;"></i>
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $field->id }}</td>
                                        <td>{{ $field->fieldGroup->name ?? 'N/A' }}</td>
                                        <td>{{ ucfirst($field->type) }}</td>
                                        <td>{{ $field->label }}</td>
                                        <td><code>{{ $field->alias }}</code></td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.fields.show', $field) }}" class="btn btn-outline-primary" title="View">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('admin.fields.edit', $field) }}" class="btn btn-outline-secondary" title="Edit">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.fields.copy', $field) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-info" title="Copy">
                                                        <i class="ri-file-copy-line"></i>
                                                    </button>
                                                </form>
                                                @if($field->is_active)
                                                    <form method="POST" action="{{ route('admin.fields.deactivate', $field) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-warning" title="Deactivate">
                                                            <i class="ri-pause-line"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('admin.fields.activate', $field) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-success" title="Activate">
                                                            <i class="ri-play-line"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <form method="POST" action="{{ route('admin.fields.destroy', $field) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this field?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="ri-database-2-line fa-3x mb-3"></i>
                                                <p>No fields found. <a href="{{ route('admin.fields.create') }}">Create your first field</a></p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            </div>
                        </form>

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

            <!-- Right Column - Field Quick View -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">> Field Quick View</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">Edit this field to view more detail</p>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Field Type: Text</label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 mb-3">
                            <button class="btn btn-success btn-sm">
                                <i class="ri-save-line me-1"></i> Save
                            </button>
                            <button class="btn btn-primary btn-sm">
                                <i class="ri-check-line me-1"></i> Active
                            </button>
                            <button class="btn btn-secondary btn-sm">
                                <i class="ri-pause-line me-1"></i> Disable
                            </button>
                        </div>

                        <!-- Viewable Setting -->
                        <div class="mb-3">
                            <label class="form-label">Viewable:</label>
                            <select class="form-select form-select-sm">
                                <option selected>Public</option>
                                <option>Private</option>
                                <option>Restricted</option>
                            </select>
                        </div>

                        <!-- Form Fields -->
                        <div class="mb-3">
                            <label class="form-label">Field Title:</label>
                            <input type="text" class="form-control form-control-sm" value="Street Address">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alias:</label>
                            <input type="text" class="form-control form-control-sm" value="street">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Field Group:</label>
                            <select class="form-select form-select-sm">
                                <option selected>Address</option>
                                <option>Contact Details</option>
                                <option>Pricing</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description:</label>
                            <textarea class="form-control form-control-sm" rows="3" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle bulk actions
    const activateBtn = document.querySelector('button[data-action="activate"]');
    const deactivateBtn = document.querySelector('button[data-action="deactivate"]');
    const deleteBtn = document.querySelector('button[data-action="delete"]');
    const copyBtn = document.querySelector('button[data-action="copy"]');
    const editBtn = document.querySelector('button[data-action="edit"]');
    
    // Select all checkbox functionality
    const selectAllCheckbox = document.querySelector('thead input[type="checkbox"]');
    const fieldCheckboxes = document.querySelectorAll('tbody input[type="checkbox"]');
    
    selectAllCheckbox.addEventListener('change', function() {
        fieldCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    
    // Individual field actions
    fieldCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedBoxes = document.querySelectorAll('tbody input[type="checkbox"]:checked');
            selectAllCheckbox.checked = checkedBoxes.length === fieldCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < fieldCheckboxes.length;
        });
    });
    
    // Bulk activate action
    if (activateBtn) {
        activateBtn.addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('tbody input[type="checkbox"]:checked');
            if (checkedBoxes.length === 0) {
                alert('Please select fields to activate.');
                return;
            }
            
            if (confirm(`Are you sure you want to activate ${checkedBoxes.length} field(s)?`)) {
                // Create form for bulk activation
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.fields.bulk-activate") }}';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                checkedBoxes.forEach(checkbox => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'field_ids[]';
                    input.value = checkbox.value;
                    form.appendChild(input);
                });
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    
    // Bulk copy action
    if (copyBtn) {
        copyBtn.addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('tbody input[type="checkbox"]:checked');
            if (checkedBoxes.length === 0) {
                alert('Please select fields to copy.');
                return;
            }
            
            if (checkedBoxes.length > 1) {
                alert('Please select only one field to copy at a time.');
                return;
            }
            
            if (confirm(`Are you sure you want to copy this field?`)) {
                const fieldId = checkedBoxes[0].value;
                window.location.href = '{{ route("admin.fields.copy", ":id") }}'.replace(':id', fieldId);
            }
        });
    }
    
    // Bulk edit action
    if (editBtn) {
        editBtn.addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('tbody input[type="checkbox"]:checked');
            if (checkedBoxes.length === 0) {
                alert('Please select a field to edit.');
                return;
            }
            
            if (checkedBoxes.length > 1) {
                alert('Please select only one field to edit at a time.');
                return;
            }
            
            const fieldId = checkedBoxes[0].value;
            window.location.href = '{{ route("admin.fields.edit", ":id") }}'.replace(':id', fieldId);
        });
    }
    
    // Global functions for onclick handlers
    window.handleBulkEdit = function() {
        const checkedBoxes = document.querySelectorAll('tbody input[type="checkbox"]:checked');
        if (checkedBoxes.length === 0) {
            alert('Please select a field to edit.');
            return;
        }
        
        if (checkedBoxes.length > 1) {
            alert('Please select only one field to edit at a time.');
            return;
        }
        
        const fieldId = checkedBoxes[0].value;
        window.location.href = '{{ route("admin.fields.edit", ":id") }}'.replace(':id', fieldId);
    };
    
    window.handleBulkCopy = function() {
        const checkedBoxes = document.querySelectorAll('tbody input[type="checkbox"]:checked');
        if (checkedBoxes.length === 0) {
            alert('Please select a field to copy.');
            return;
        }
        
        if (checkedBoxes.length > 1) {
            alert('Please select only one field to copy at a time.');
            return;
        }
        
        if (confirm('Are you sure you want to copy this field?')) {
            const fieldId = checkedBoxes[0].value;
            window.location.href = '{{ route("admin.fields.copy", ":id") }}'.replace(':id', fieldId);
        }
    };
    
    window.handleBulkDelete = function() {
        const checkedBoxes = document.querySelectorAll('tbody input[type="checkbox"]:checked');
        if (checkedBoxes.length === 0) {
            alert('Please select fields to delete.');
            return;
        }
        
        if (confirm(`Are you sure you want to delete ${checkedBoxes.length} field(s)? This action cannot be undone.`)) {
            // Create form for bulk deletion
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.fields.bulk-delete") }}';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            checkedBoxes.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'field_ids[]';
                input.value = checkbox.value;
                form.appendChild(input);
            });
            
            document.body.appendChild(form);
            form.submit();
        }
    };
    
    // Bulk deactivate action
    if (deactivateBtn) {
        deactivateBtn.addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('tbody input[type="checkbox"]:checked');
            if (checkedBoxes.length === 0) {
                alert('Please select fields to deactivate.');
                return;
            }
            
            if (confirm(`Are you sure you want to deactivate ${checkedBoxes.length} field(s)?`)) {
                // Create form for bulk deactivation
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.fields.bulk-deactivate") }}';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                checkedBoxes.forEach(checkbox => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'field_ids[]';
                    input.value = checkbox.value;
                    form.appendChild(input);
                });
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    
    // Bulk delete action
    if (deleteBtn) {
        deleteBtn.addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('tbody input[type="checkbox"]:checked');
            if (checkedBoxes.length === 0) {
                alert('Please select fields to delete.');
                return;
            }
            
            if (confirm(`Are you sure you want to delete ${checkedBoxes.length} field(s)? This action cannot be undone.`)) {
                // Create form for bulk deletion
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.fields.bulk-delete") }}';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                checkedBoxes.forEach(checkbox => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'field_ids[]';
                    input.value = checkbox.value;
                    form.appendChild(input);
                });
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    
    // Search functionality
    const searchInput = document.querySelector('input[placeholder="Search Fields"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Field group search
    const groupSearchInput = document.querySelector('input[placeholder="Search Field Groups"]');
    if (groupSearchInput) {
        groupSearchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const groupItems = document.querySelectorAll('.list-group-item');
            
            groupItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
});
</script>
@endsection