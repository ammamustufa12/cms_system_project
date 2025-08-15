@extends('twill::layouts.main')

@section('appTypeClass', 'body--listing')

@section('content')
    <div class="page-content">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">{{ $contentType->name }} / Manage Fields</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('content-types.index') }}">Content Type</a></li>
                            <li class="breadcrumb-item active">Manage Fields</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    @php
                        $fieldsSchema = is_array($contentType->fields_schema)
                            ? $contentType->fields_schema
                            : json_decode($contentType->fields_schema, true) ?? [];
                    @endphp

                    @if (count($fieldsSchema) > 0)
                        <!-- Fields List -->
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-list-ul me-2"></i>Field Configuration
                                </h5>
                                <div>
                                    <a href="{{ route('content-types.add-field', $contentType->slug) }}"
                                        class="btn btn-primary me-2">
                                        {{-- <i class="fas fa-eye me-1"></i> --}}
                                        Add
                                    </a>
                                    {{-- <button class="btn btn-sm btn-outline-secondary" id="sortFieldsBtn">
                                        <i class="fas fa-sort me-1"></i>Reorder Fields
                                    </button> --}}
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50">#</th>
                                                <th>Field Name</th>
                                                <th>Label</th>
                                                <th>Type</th>
                                                <th width="100">Required</th>
                                                <th width="120">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="fieldsTableBody">
                                            @foreach ($fieldsSchema as $fieldKey => $field)
                                                <tr data-field-key="{{ $fieldKey }}">
                                                    <td>
                                                        <span
                                                            class="badge bg-light text-dark">{{ $field['order'] ?? $loop->iteration }}</span>
                                                        <i class="fas fa-grip-vertical text-muted ms-2 sort-handle"
                                                            style="cursor: move;"></i>
                                                    </td>
                                                    <td>
                                                        <code class="text-primary">{{ $fieldKey }}</code>
                                                        @if (!empty($field['description']))
                                                            <small
                                                                class="d-block text-muted">{{ $field['description'] }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>{{ $field['label'] }}</strong>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-secondary">
                                                            @if (isset($fieldTypes[$field['type']]))
                                                                <i
                                                                    class="{{ $fieldTypes[$field['type']]['icon'] }} me-1"></i>
                                                                {{ $fieldTypes[$field['type']]['label'] }}
                                                            @else
                                                                {{ ucfirst($field['type']) }}
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if ($field['required'] ?? false)
                                                            <span class="badge bg-danger">Required</span>
                                                        @else
                                                            <span class="badge bg-light text-dark">Optional</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="{{ route('content-types.edit-field', ['slug' => $contentType->slug, 'fieldKey' => $fieldKey]) }}"
                                                                class="btn btn-outline-primary btn-sm edit-field"
                                                                data-field-key="{{ $fieldKey }}" title="Edit Field">
                                                                <i class="fas fa-edit text-capitalize">edit</i>
                                                            </a>
                                                            <button class="btn btn-outline-danger btn-sm delete-field"
                                                                data-field-key="{{ $fieldKey }}"
                                                                data-field-name="{{ $field['label'] }}"
                                                                title="Delete Field">
                                                                <i class="fas fa-trash text-capitalize">delete</i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-list-ul fa-4x text-muted"></i>
                                </div>
                                <h4 class="text-muted mb-3">No Fields Added Yet</h4>
                                <p class="text-muted mb-4">
                                    Start building your content type by adding fields. Fields define what kind of data can
                                    be
                                    stored in this content type.
                                </p>
                                <a href="{{ route('content-types.add-field', $contentType->slug) }}"
                                    class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add Your First Field
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Preview Modal -->
        <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Preview - {{ $contentType->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="previewContent">
                        <!-- Preview content will be loaded here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
     <!-- Fixed Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the field <strong id="deleteFieldName"></strong>?</p>
                <p class="text-danger small">This action cannot be undone and may affect existing content items.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Field</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete field functionality - Fixed
    document.querySelectorAll('.delete-field').forEach(button => {
        button.addEventListener('click', function() {
            const fieldKey = this.dataset.fieldKey;
            const fieldName = this.dataset.fieldName;

            // Set field name in modal
            document.getElementById('deleteFieldName').textContent = fieldName;
            
            // Set correct action URL
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `{{ url('admin/content-types/' . $contentType->slug) }}/${fieldKey}`;

            // Show modal
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });

    // Initialize sortable for field reordering
    const fieldsTableBody = document.getElementById('fieldsTableBody');
    if (fieldsTableBody) {
        new Sortable(fieldsTableBody, {
            handle: '.sort-handle',
            animation: 150,
            onEnd: function(evt) {
                updateFieldOrder();
            }
        });
    }

    // Update field order function
    function updateFieldOrder() {
        const rows = fieldsTableBody.querySelectorAll('tr');
        const fieldOrder = Array.from(rows).map(row => row.dataset.fieldKey);

        fetch(`{{ route('content-types.reorder-fields', $contentType->slug) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    field_order: fieldOrder
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update order numbers in the UI
                    rows.forEach((row, index) => {
                        const orderBadge = row.querySelector('.badge');
                        orderBadge.textContent = index + 1;
                    });
                    showToast('Field order updated successfully', 'success');
                }
            })
            .catch(error => {
                console.error('Error updating field order:', error);
                showToast('Error updating field order', 'error');
            });
    }

    // Show toast function
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
        }, 5000);
    }
});
</script>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
                    // Initialize sortable for field reordering
                    const fieldsTableBody = document.getElementById('fieldsTableBody');
                    if (fieldsTableBody) {
                        new Sortable(fieldsTableBody, {
                            handle: '.sort-handle',
                            animation: 150,
                            onEnd: function(evt) {
                                updateFieldOrder();
                            }
                        });
                    }

                    // Preview form functionality
                    document.getElementById('previewBtn')?.addEventListener('click', function() {
                        generateFormPreview();
                        new bootstrap.Modal(document.getElementById('previewModal')).show();
                    });

                    // Delete field functionality
                    document.querySelectorAll('.delete-field').forEach(button => {
                        button.addEventListener('click', function() {
                            const fieldKey = this.dataset.fieldKey;
                            const fieldName = this.dataset.fieldName;

                            document.getElementById('deleteFieldName').textContent = fieldName;
                            document.getElementById('deleteForm').action =
                                `{{ route('content-types.delete-field', [$contentType->slug, '']) }}/${fieldKey}`;

                            new bootstrap.Modal(document.getElementById('deleteModal')).show();
                        });
                    });

                    // Edit field functionality
                    document.querySelectorAll('.edit-field').forEach(button => {
                        button.addEventListener('click', function() {
                            const fieldKey = this.dataset.fieldKey;
                            const url =
                                `{{ url('admin/content-types/' . $contentType->slug) }}/${fieldKey}`;
                            window.location.href = url;
                        });

                        function updateFieldOrder() {
                            const rows = fieldsTableBody.querySelectorAll('tr');
                            const fieldOrder = Array.from(rows).map(row => row.dataset.fieldKey);

                            fetch(`{{ route('content-types.reorder-fields', $contentType->slug) }}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        field_order: fieldOrder
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Update order numbers in the UI
                                        rows.forEach((row, index) => {
                                            const orderBadge = row.querySelector('.badge');
                                            orderBadge.textContent = index + 1;
                                        });

                                        showToast('Field order updated successfully', 'success');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error updating field order:', error);
                                    showToast('Error updating field order', 'error');
                                });
                        }

                        function generateFormPreview() {
                            const fieldsData = @json($fieldsSchema);
                            const fieldTypes = @json($fieldTypes);

                            let previewHtml = '<form class="needs-validation" novalidate>';

                            // Sort fields by order
                            const sortedFields = Object.entries(fieldsData).sort((a, b) => {
                                return (a[1].order || 0) - (b[1].order || 0);
                            });

                            sortedFields.forEach(([fieldKey, field]) => {
                                previewHtml += '<div class="mb-3">';
                                previewHtml += `<label class="form-label">${field.label}`;

                                if (field.required) {
                                    previewHtml += ' <span class="text-danger">*</span>';
                                }

                                previewHtml += '</label>';

                                if (field.description) {
                                    previewHtml += `<div class="form-text">${field.description}</div>`;
                                }

                                // Generate field input based on type
                                previewHtml += generateFieldPreview(fieldKey, field);
                                previewHtml += '</div>';
                            });

                            previewHtml += '</form>';

                            document.getElementById('previewContent').innerHTML = previewHtml;
                        }

                        function generateFieldPreview(fieldKey, field) {
                            const options = field.options || {};
                            const required = field.required ? 'required' : '';

                            switch (field.type) {
                                case 'text':
                                case 'email':
                                    return `<input type="${field.type}" class="form-control" name="${fieldKey}" 
                        placeholder="${options.placeholder || ''}" 
                        maxlength="${options.max_length || ''}" ${required}>`;

                                case 'textarea':
                                    return `<textarea class="form-control" name="${fieldKey}" 
                        rows="${options.rows || 4}" 
                        placeholder="${options.placeholder || ''}" 
                        maxlength="${options.max_length || ''}" ${required}></textarea>`;

                                case 'number':
                                    return `<input type="number" class="form-control" name="${fieldKey}" 
                        min="${options.min || ''}" max="${options.max || ''}" 
                        step="${options.step || '1'}" ${required}>`;

                                case 'select':
                                    let selectHtml = `<select class="form-select" name="${fieldKey}" ${required}>`;
                                    selectHtml += '<option value="">Select an option</option>';
                                    if (options.options_list) {
                                        Object.entries(options.options_list).forEach(([value, label]) => {
                                            selectHtml += `<option value="${value}">${label}</option>`;
                                        });
                                    }
                                    selectHtml += '</select>';
                                    return selectHtml;

                                case 'checkbox':
                                    if (options.multiple && options.options_list) {
                                        let checkboxHtml = '<div class="checkbox-group">';
                                        Object.entries(options.options_list).forEach(([value, label]) => {
                                            checkboxHtml += `
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="${fieldKey}[]" value="${value}">
                                <label class="form-check-label">${label}</label>
                            </div>
                        `;
                                        });
                                        checkboxHtml += '</div>';
                                        return checkboxHtml;
                                    } else {
                                        return `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="${fieldKey}" value="1" ${required}>
                            <label class="form-check-label">${field.label}</label>
                        </div>
                    `;
                                    }

                                case 'radio':
                                    let radioHtml = '<div class="radio-group">';
                                    if (options.options_list) {
                                        Object.entries(options.options_list).forEach(([value, label]) => {
                                            radioHtml += `
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="${fieldKey}" value="${value}" ${required}>
                                <label class="form-check-label">${label}</label>
                            </div>
                        `;
                                        });
                                    }
                                    radioHtml += '</div>';
                                    return radioHtml;

                                case 'boolean':
                                    return `
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="${fieldKey}" value="1">
                        <label class="form-check-label">${options.label_on || 'Yes'} / ${options.label_off || 'No'}</label>
                    </div>
                `;

                                case 'date':
                                    return `<input type="date" class="form-control" name="${fieldKey}" ${required}>`;

                                case 'datetime':
                                    return `<input type="datetime-local" class="form-control" name="${fieldKey}" ${required}>`;

                                case 'file':
                                case 'image':
                                    return `<input type="file" class="form-control" name="${fieldKey}" 
                        accept="${options.accepted_types ? options.accepted_types.split(',').map(t => '.' + t.trim()).join(',') : ''}" ${required}>`;

                                case 'wysiwyg':
                                    return `<textarea class="form-control" name="${fieldKey}" rows="${options.height ? Math.floor(options.height/20) : 6}" ${required}></textarea>
                        <small class="form-text text-muted">Rich text editor would be loaded here</small>`;

                                default:
                                    return `<input type="text" class="form-control" name="${fieldKey}" ${required}>`;
                            }
                        }

                        function showToast(message, type = 'info') {
                            // Simple toast notification
                            const toast = document.createElement('div');
                            toast.className =
                                `alert alert-${type === 'error' ? 'danger' : type} position-fixed top-0 end-0 m-3`;
                            toast.style.zIndex = '9999';
                            toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
        `;
                            document.body.appendChild(toast);

                            setTimeout(() => {
                                toast.remove();
                            }, 5000);
                        }
                    });

                    // Global functions for quick actions
                    function duplicateContentType() {
                        if (confirm('This will create a copy of this content type with all its fields. Continue?')) {
                            // Implementation for duplicating content type
                            showToast('Feature coming soon!', 'info');
                        }
                    }

                    function exportSchema() {
                        const schema = @json($fieldsSchema);
                        const dataStr = JSON.stringify(schema, null, 2);
                        const dataBlob = new Blob([dataStr], {
                            type: 'application/json'
                        });
                        const url = URL.createObjectURL(dataBlob);
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = `${@json($contentType->slug)}_schema.json`;
                        link.click();
                        URL.revokeObjectURL(url);
                        showToast('Schema exported successfully!', 'success');
                    }

                    function importSchema() {
                        const input = document.createElement('input');
                        input.type = 'file';
                        input.accept = '.json';
                        input.onchange = function(e) {
                            const file = e.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    try {
                                        const schema = JSON.parse(e.target.result);
                                        // Implementation for importing schema
                                        showToast('Import feature coming soon!', 'info');
                                    } catch (error) {
                                        showToast('Invalid JSON file', 'error');
                                    }
                                };
                                reader.readAsText(file);
                            }
                        };
                        input.click();
                    }
    </script>

    <style>
        .card {
            border: 1px solid #e3e6f0;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .sort-handle {
            cursor: move;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #5a5c69;
        }

        .badge {
            font-size: 0.75rem;
        }

        .btn-group-sm>.btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .checkbox-group .form-check,
        .radio-group .form-check {
            margin-bottom: 0.5rem;
        }

        .form-check-input:checked {
            background-color: #5a6c7d;
            border-color: #5a6c7d;
        }

        .text-danger {
            color: #e74a3b !important;
        }

        .opacity-75 {
            opacity: 0.75;
        }

        /* Sortable styles */
        .sortable-ghost {
            opacity: 0.4;
        }

        .sortable-chosen {
            background-color: #f8f9fc;
        }

        /* Toast positioning */
        .position-fixed {
            position: fixed !important;
        }

        .top-0 {
            top: 0 !important;
        }

        .end-0 {
            right: 0 !important;
        }

        .m-3 {
            margin: 1rem !important;
        }
    </style>
@endsection
