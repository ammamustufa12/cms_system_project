@extends('twill::layouts.main')

@section('appTypeClass', 'body--form')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Header -->
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">{{ $contentType->name }} Content Items</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('content-types.index') }}">Content Types</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('content-types.index') }}">Content Items</a>
                                </li>
                                <li class="breadcrumb-item active">Create Content</li>
                            </ol>
                        </div>

                    </div>

                    <!-- Form -->
                    <form action="{{ route('content-types.content-items.store', $contentType->slug) }}" method="POST"
                        enctype="multipart/form-data" id="contentForm">
                        @csrf

                        <div class="row">
                            <!-- Main Content -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-edit me-2"></i>Content Details
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Basic Fields -->
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                id="title" name="title" value="{{ old('title') }}"
                                                placeholder="Enter content title" required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="slug" class="form-label">Slug</label>
                                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                                id="slug" name="slug" value="{{ old('slug') }}"
                                                placeholder="auto-generated-from-title">
                                            <div class="form-text">Leave empty to auto-generate from title</div>
                                            @error('slug')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <hr class="my-4">

                                        <!-- Dynamic Fields -->
                                        <div id="dynamicFields">
                                            @foreach ($fieldsSchema as $fieldKey => $field)
                                                <div class="dynamic-field" data-field-type="{{ $field['type'] }}">
                                                    {!! App\Services\FormRendererService::renderField($fieldKey, $field, old($fieldKey), $errors) !!}
                                                </div>
                                            @endforeach

                                            <div class="dynamic-field" data-field-type="checkbox">
                                                <label>
                                                    <input type="checkbox" name="published_at" value="1"
                                                        {{ old('published_at') ? 'checked' : '' }}>
                                                    Publish
                                                </label>
                                                @error('published_at')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="my-4">
                                            <button class="btn btn-primary text-capitalize">submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            {{-- <div class="col-lg-4">
                                <!-- Publish Options -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-cog me-2"></i>Publish Options
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select @error('status') is-invalid @enderror" id="status"
                                                name="status" required>
                                                <option value="draft"
                                                    {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>
                                                    <i class="fas fa-edit"></i> Draft
                                                </option>
                                                <option value="published"
                                                    {{ old('status') === 'published' ? 'selected' : '' }}>
                                                    <i class="fas fa-globe"></i> Published
                                                </option>
                                                <option value="archived"
                                                    {{ old('status') === 'archived' ? 'selected' : '' }}>
                                                    <i class="fas fa-archive"></i> Archived
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary" name="action" value="save">
                                                <i class="fas fa-save me-2"></i>Save Content
                                            </button>
                                            <button type="submit" class="btn btn-success" name="action"
                                                value="save_and_publish">
                                                <i class="fas fa-globe me-2"></i>Save & Publish
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" id="previewBtn">
                                                <i class="fas fa-eye me-2"></i>Preview
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Content Type Info -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-info-circle me-2"></i>Content Type Info
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <strong>Type:</strong> {{ $contentType->name }}
                                        </div>
                                        <div class="mb-2">
                                            <strong>Fields:</strong> {{ count($fieldsSchema) }}
                                        </div>
                                        <div class="mb-2">
                                            <strong>Required Fields:</strong>
                                            {{ collect($fieldsSchema)->where('required', true)->count() }}
                                        </div>
                                        @if ($contentType->description)
                                            <div class="mt-3">
                                                <small class="text-muted">{{ $contentType->description }}</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Field Validation Status -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-check-circle me-2"></i>Field Validation
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div id="validationStatus">
                                            @foreach ($fieldsSchema as $fieldKey => $field)
                                                @if ($field['required'] ?? false)
                                                    <div class="d-flex align-items-center mb-2 validation-item"
                                                        data-field="{{ $fieldKey }}">
                                                        <div class="validation-icon me-2">
                                                            <i class="fas fa-circle text-muted"></i>
                                                        </div>
                                                        <span class="validation-label">{{ $field['label'] }}</span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview Modal -->
        <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Content Preview</h5>
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

    </div>

    <!-- Include TinyMCE for WYSIWYG fields -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-generate slug from title
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');

            titleInput.addEventListener('input', function() {
                if (!slugInput.value) {
                    slugInput.value = this.value
                        .toLowerCase()
                        .replace(/[^a-z0-9\s]/g, '')
                        .replace(/\s+/g, '-')
                        .trim();
                }
            });

            // Form validation
            const form = document.getElementById('contentForm');
            const requiredFields = @json(array_keys(array_filter($fieldsSchema, function ($field) {
                        return $field['required'] ?? false;
                    })));

            // Real-time validation for required fields
            requiredFields.forEach(function(fieldKey) {
                const field = document.querySelector(`[name="${fieldKey}"], [name="${fieldKey}[]"]`);
                if (field) {
                    field.addEventListener('input', function() {
                        updateValidationStatus(fieldKey, this.value);
                    });
                    field.addEventListener('change', function() {
                        updateValidationStatus(fieldKey, this.value);
                    });
                }
            });

            function updateValidationStatus(fieldKey, value) {
                const validationItem = document.querySelector(`[data-field="${fieldKey}"]`);
                if (validationItem) {
                    const icon = validationItem.querySelector('.validation-icon i');
                    const hasValue = value && value.length > 0;

                    if (hasValue) {
                        icon.className = 'fas fa-check-circle text-success';
                    } else {
                        icon.className = 'fas fa-circle text-muted';
                    }
                }
            }

            // Initialize TinyMCE for WYSIWYG fields
            const wysiwygFields = document.querySelectorAll('.wysiwyg-editor');
            if (wysiwygFields.length > 0) {
                wysiwygFields.forEach(function(field) {
                    const height = field.dataset.height || 300;
                    tinymce.init({
                        target: field,
                        height: parseInt(height),
                        menubar: false,
                        plugins: [
                            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap',
                            'preview',
                            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                            'insertdatetime', 'media', 'table', 'paste', 'code', 'help',
                            'wordcount'
                        ],
                        toolbar: 'undo redo | blocks | ' +
                            'bold italic forecolor | alignleft aligncenter ' +
                            'alignright alignjustify | bullist numlist outdent indent | ' +
                            'removeformat | help',
                        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
                    });
                });
            }

            // Handle form submission with action buttons
            document.querySelectorAll('button[name="action"]').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    const action = this.value;

                    if (action === 'save_and_publish') {
                        document.getElementById('status').value = 'published';
                    }

                    // Validate required fields before submission
                    let isValid = true;
                    requiredFields.forEach(function(fieldKey) {
                        const field = document.querySelector(
                            `[name="${fieldKey}"], [name="${fieldKey}[]"]`);
                        if (field) {
                            let value = field.value;

                            // Handle file inputs
                            if (field.type === 'file') {
                                value = field.files.length > 0 ? 'has_file' : '';
                            }

                            // Handle checkboxes
                            if (field.type === 'checkbox' && field.name.includes('[]')) {
                                const checkboxes = document.querySelectorAll(
                                    `[name="${field.name}"]:checked`);
                                value = checkboxes.length > 0 ? 'has_selection' : '';
                            }

                            if (!value) {
                                field.classList.add('is-invalid');
                                isValid = false;
                            } else {
                                field.classList.remove('is-invalid');
                            }
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        alert('Please fill in all required fields before saving.');
                        return false;
                    }
                });
            });

            // Preview functionality
            document.getElementById('previewBtn').addEventListener('click', function() {
                generatePreview();
                new bootstrap.Modal(document.getElementById('previewModal')).show();
            });

            function generatePreview() {
                const formData = new FormData(form);
                let previewHtml = '<div class="container">';

                // Title
                previewHtml += '<h1 class="mb-3">' + (formData.get('title') || 'Untitled') + '</h1>';

                // Status badge
                const status = formData.get('status') || 'draft';
                const statusColors = {
                    'draft': 'warning',
                    'published': 'success',
                    'archived': 'secondary'
                };
                previewHtml += '<div class="mb-4"><span class="badge bg-' + statusColors[status] + '">' +
                    status.charAt(0).toUpperCase() + status.slice(1) + '</span></div>';

                // Dynamic fields preview
                const fieldsSchema = @json($fieldsSchema);

                Object.entries(fieldsSchema).forEach(function([fieldKey, field]) {
                    const value = formData.get(fieldKey);
                    if (value) {
                        previewHtml += '<div class="mb-3">';
                        previewHtml += '<h6 class="text-muted">' + field.label + '</h6>';

                        switch (field.type) {
                            case 'wysiwyg':
                                previewHtml += '<div class="border p-3 rounded">' + value + '</div>';
                                break;
                            case 'image':
                                const fileInput = document.querySelector(`[name="${fieldKey}"]`);
                                if (fileInput && fileInput.files[0]) {
                                    const url = URL.createObjectURL(fileInput.files[0]);
                                    previewHtml += '<img src="' + url +
                                        '" class="img-fluid rounded" style="max-height: 300px;">';
                                }
                                break;
                            case 'boolean':
                                previewHtml += '<span class="badge bg-' + (value ? 'success">Yes' :
                                    'secondary">No') + '</span>';
                                break;
                            case 'date':
                                previewHtml += '<p>' + new Date(value).toLocaleDateString() + '</p>';
                                break;
                            case 'datetime':
                                previewHtml += '<p>' + new Date(value).toLocaleString() + '</p>';
                                break;
                            case 'textarea':
                                previewHtml +=
                                    '<div class="border p-3 rounded" style="white-space: pre-wrap;">' +
                                    value + '</div>';
                                break;
                            default:
                                previewHtml += '<p>' + value + '</p>';
                        }
                        previewHtml += '</div>';
                    }
                });

                previewHtml += '</div>';

                document.getElementById('previewContent').innerHTML = previewHtml;
            }

            // Auto-save functionality (draft)
            let autoSaveTimer;

            function autoSave() {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(function() {
                    const formData = new FormData(form);
                    formData.set('status', 'draft');
                    formData.set('auto_save', '1');

                    // Only auto-save if title is present
                    if (formData.get('title')) {
                        fetch(form.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    showToast('Draft saved automatically', 'success');
                                }
                            })
                            .catch(error => {
                                console.log('Auto-save failed:', error);
                            });
                    }
                }, 30000); // Auto-save every 30 seconds
            }

            // Start auto-save when user starts typing
            form.addEventListener('input', autoSave);
            form.addEventListener('change', autoSave);

            function showToast(message, type = 'info') {
                const toast = document.createElement('div');
                toast.className = `alert alert-${type} position-fixed top-0 end-0 m-3`;
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

            // Handle file uploads with progress
            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(function(input) {
                input.addEventListener('change', function() {
                    const files = this.files;
                    if (files.length > 0) {
                        // Show file info
                        const fileInfo = Array.from(files).map(file =>
                            `${file.name} (${formatFileSize(file.size)})`
                        ).join(', ');

                        // Create or update file info display
                        let infoDiv = this.parentNode.querySelector('.file-info');
                        if (!infoDiv) {
                            infoDiv = document.createElement('div');
                            infoDiv.className = 'file-info mt-2 p-2 bg-light rounded';
                            this.parentNode.appendChild(infoDiv);
                        }
                        infoDiv.innerHTML =
                            `<small class="text-muted">Selected: ${fileInfo}</small>`;
                    }
                });
            });

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Initialize validation status for existing values
            requiredFields.forEach(function(fieldKey) {
                const field = document.querySelector(`[name="${fieldKey}"], [name="${fieldKey}[]"]`);
                if (field && field.value) {
                    updateValidationStatus(fieldKey, field.value);
                }
            });

            // Handle repeater fields
            const repeaterFields = document.querySelectorAll('.repeater-field');
            repeaterFields.forEach(function(repeater) {
                // Repeater functionality is handled by the FormRendererService script
                console.log('Repeater field initialized:', repeater.dataset.fieldName);
            });
        });

        // Form submission confirmation
        window.addEventListener('beforeunload', function(e) {
            const form = document.getElementById('contentForm');
            const formData = new FormData(form);

            // Check if form has unsaved changes
            if (formData.get('title') && !form.dataset.saved) {
                e.preventDefault();
                e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
                return e.returnValue;
            }
        });
    </script> --}}

    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from title - UPDATED VERSION
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    let slugManuallyEdited = false;
    
    // Track manual editing
    slugInput.addEventListener('input', function() {
        slugManuallyEdited = this.value.trim() !== '';
    });
    
    // Auto-generate on title input
    titleInput.addEventListener('input', function() {
        if (!slugManuallyEdited || slugInput.value.trim() === '') {
            const title = this.value.trim();
            if (title) {
                slugInput.value = title
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-+|-+$/g, '');
                slugManuallyEdited = false;
            } else {
                slugInput.value = '';
            }
        }
    });

    // Rest of your existing JavaScript code...
    const form = document.getElementById('contentForm');
    // ... continue with rest of your code
});
</script>
    <style>
        .dynamic-field {
            position: relative;
        }

        .dynamic-field[data-field-type="wysiwyg"] {
            margin-bottom: 2rem;
        }

        .validation-item {
            font-size: 0.875rem;
        }

        .validation-icon {
            width: 20px;
        }

        .file-info {
            max-width: 100%;
            word-break: break-all;
        }

        .repeater-field {
            border: 1px solid #e3e6f0;
            border-radius: 0.375rem;
            padding: 1rem;
            background-color: #f8f9fc;
        }

        .repeater-item {
            background-color: white;
        }

        .repeater-controls {
            border-top: 1px solid #e3e6f0;
            padding-top: 1rem;
            margin-top: 1rem;
        }

        .form-check-input:checked {
            background-color: #5a6c7d;
            border-color: #5a6c7d;
        }

        .text-danger {
            color: #e74a3b !important;
        }

        .btn-success {
            background-color: #1cc88a;
            border-color: #1cc88a;
        }

        .btn-success:hover {
            background-color: #17a673;
            border-color: #17a673;
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

        /* Custom scrollbar for long forms */
        .card-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        .card-body::-webkit-scrollbar {
            width: 6px;
        }

        .card-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .card-body::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .card-body::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Field type specific styling */
        .checkbox-group,
        .radio-group {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            padding: 0.5rem;
        }

        .checkbox-group .form-check,
        .radio-group .form-check {
            margin-bottom: 0.25rem;
        }

        /* Gallery preview */
        .gallery-preview {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .gallery-preview img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 0.25rem;
        }
    </style>
@endsection
