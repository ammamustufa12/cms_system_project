@extends('twill::layouts.main')

@section('appTypeClass', 'body--form')

@section('content')
    <div class="page-content">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">{{ $contentType->name }} / Add New Field</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{route('content-types.index')}}">Content Type</a></li>
                                <li class="breadcrumb-item"><a href="{{route('content-types.manage-fields', $contentType->slug)}}">Manage Fields</a></li>
                                <li class="breadcrumb-item active">Add New Field</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Header -->
                    {{-- <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="mb-1">Add New Field</h2>
                            <p class="text-muted mb-0">Content Type: <strong>{{ $contentType->name }}</strong></p>
                        </div>
                        <a href="{{ route('content-types.manage-fields', $contentType->slug) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Fields
                        </a>
                    </div> --}}

                    <!-- Form Card -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Field Configuration</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('content-types.store-field', $contentType->slug) }}" method="POST"
                                id="fieldForm">
                                @csrf

                                <div class="row">
                                    <!-- Left Column - Basic Info -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="field_name" class="form-label">Field Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('field_name') is-invalid @enderror"
                                                id="field_name" name="field_name" value="{{ old('field_name') }}"
                                                placeholder="e.g. product_title">
                                            <div class="form-text">This will be used as the field identifier (no spaces or
                                                special characters)</div>
                                            @error('field_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="field_label" class="form-label">Field Label <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('field_label') is-invalid @enderror"
                                                id="field_label" name="field_label" value="{{ old('field_label') }}"
                                                placeholder="e.g. Product Title">
                                            <div class="form-text">This will be displayed to users</div>
                                            @error('field_label')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="field_type" class="form-label">Field Type <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('field_type') is-invalid @enderror"
                                                id="field_type" name="field_type">
                                                <option value="">Select Field Type</option>
                                                @foreach ($fieldTypes as $type => $config)
                                                    <option value="{{ $type }}" data-icon="{{ $config['icon'] }}"
                                                        data-description="{{ $config['description'] }}"
                                                        {{ old('field_type') == $type ? 'selected' : '' }}>
                                                        {{ $config['label'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('field_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="3"
                                                placeholder="Optional field description or help text">{{ old('description') }}</textarea>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="required" name="required"
                                                value="1" {{ old('required') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="required">
                                                Required Field
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Right Column - Field Options -->
                                    <div class="col-md-6">
                                        <div class="card bg-light">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    <i class="fas fa-cog me-2"></i>Field Options
                                                </h6>
                                            </div>
                                            <div class="card-body" id="fieldOptions">
                                                <p class="text-muted">Select a field type to see available options</p>
                                            </div>
                                        </div>

                                        <!-- Field Preview -->
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    <i class="fas fa-eye me-2"></i>Field Preview
                                                </h6>
                                            </div>
                                            <div class="card-body" id="fieldPreview">
                                                <p class="text-muted">Field preview will appear here</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="row">
                                    <div class="col-12">
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('content-types.manage-fields', $contentType->slug) }}"
                                                class="btn btn-light">
                                                Cancel
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Add Field
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Field Type Options Templates -->
        <div id="fieldOptionsTemplates" style="display: none;">
            <!-- Text Field Options -->
            <div data-type="text">
                <div class="mb-3">
                    <label class="form-label">Placeholder Text</label>
                    <input type="text" class="form-control" name="options[placeholder]"
                        placeholder="Enter placeholder text">
                </div>
                <div class="mb-3">
                    <label class="form-label">Maximum Length</label>
                    <input type="number" class="form-control" name="options[max_length]" placeholder="e.g. 255">
                </div>
                <div class="mb-3">
                    <label class="form-label">Default Value</label>
                    <input type="text" class="form-control" name="options[default_value]" placeholder="Default text">
                </div>
            </div>

            <!-- Textarea Options -->
            <div data-type="textarea">
                <div class="mb-3">
                    <label class="form-label">Placeholder Text</label>
                    <input type="text" class="form-control" name="options[placeholder]"
                        placeholder="Enter placeholder text">
                </div>
                <div class="mb-3">
                    <label class="form-label">Number of Rows</label>
                    <input type="number" class="form-control" name="options[rows]" value="4" min="2"
                        max="20">
                </div>
                <div class="mb-3">
                    <label class="form-label">Maximum Length</label>
                    <input type="number" class="form-control" name="options[max_length]" placeholder="e.g. 1000">
                </div>
            </div>

            <!-- Number Field Options -->
            <div data-type="number">
                <div class="mb-3">
                    <label class="form-label">Minimum Value</label>
                    <input type="number" class="form-control" name="options[min]" placeholder="Minimum allowed value">
                </div>
                <div class="mb-3">
                    <label class="form-label">Maximum Value</label>
                    <input type="number" class="form-control" name="options[max]" placeholder="Maximum allowed value">
                </div>
                <div class="mb-3">
                    <label class="form-label">Step</label>
                    <input type="number" class="form-control" name="options[step]" value="1" step="0.01">
                </div>
                <div class="mb-3">
                    <label class="form-label">Default Value</label>
                    <input type="number" class="form-control" name="options[default_value]"
                        placeholder="Default number">
                </div>
            </div>

            <!-- Select/Checkbox/Radio Options -->
            <div data-type="select,checkbox,radio">
                <div class="mb-3">
                    <label class="form-label">Options List</label>
                    <div id="optionsList">
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="options[options_list][0][value]"
                                placeholder="Value">
                            <input type="text" class="form-control" name="options[options_list][0][label]"
                                placeholder="Label">
                            <button type="button" class="btn btn-outline-danger remove-option">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addOption">
                        <i class="fas fa-plus me-1"></i>Add Option
                    </button>
                </div>
                <div class="form-check" data-show-for="select,checkbox">
                    <input class="form-check-input" type="checkbox" name="options[multiple]" value="1">
                    <label class="form-check-label">Allow Multiple Selection</label>
                </div>
            </div>

            <!-- Boolean Options -->
            <div data-type="boolean">
                <div class="mb-3">
                    <label class="form-label">Label for "On" State</label>
                    <input type="text" class="form-control" name="options[label_on]" value="Yes"
                        placeholder="Yes">
                </div>
                <div class="mb-3">
                    <label class="form-label">Label for "Off" State</label>
                    <input type="text" class="form-control" name="options[label_off]" value="No"
                        placeholder="No">
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="options[default_value]" value="1">
                    <label class="form-check-label">Default to "On"</label>
                </div>
            </div>

            <!-- File/Image Options -->
            <div data-type="file,image">
                <div class="mb-3">
                    <label class="form-label">Accepted File Types</label>
                    <input type="text" class="form-control" name="options[accepted_types]"
                        placeholder="e.g. jpg,png,pdf" data-type-hint="image">
                </div>
                <div class="mb-3">
                    <label class="form-label">Maximum File Size (MB)</label>
                    <input type="number" class="form-control" name="options[max_size]" value="10" min="1"
                        max="100">
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fieldTypeSelect = document.getElementById('field_type');
            const fieldOptionsContainer = document.getElementById('fieldOptions');
            const fieldPreview = document.getElementById('fieldPreview');
            const optionsTemplates = document.getElementById('fieldOptionsTemplates');

            // Handle field type change
            fieldTypeSelect.addEventListener('change', function() {
                const selectedType = this.value;
                updateFieldOptions(selectedType);
                updateFieldPreview(selectedType);
            });

            function updateFieldOptions(type) {
                fieldOptionsContainer.innerHTML = '';

                if (!type) {
                    fieldOptionsContainer.innerHTML =
                        '<p class="text-muted">Select a field type to see available options</p>';
                    return;
                }

                // Find matching template
                const template = optionsTemplates.querySelector(`[data-type*="${type}"]`);
                if (template) {
                    fieldOptionsContainer.innerHTML = template.innerHTML;

                    // Initialize dynamic option list if needed
                    initializeOptionsList();
                } else {
                    fieldOptionsContainer.innerHTML =
                        '<p class="text-muted">No additional options for this field type</p>';
                }
            }

            function updateFieldPreview(type) {
                const fieldName = document.getElementById('field_name').value || 'sample_field';
                const fieldLabel = document.getElementById('field_label').value || 'Sample Field';
                const isRequired = document.getElementById('required').checked;

                let previewHtml =
                    `<label class="form-label">${fieldLabel} ${isRequired ? '<span class="text-danger">*</span>' : ''}</label>`;

                switch (type) {
                    case 'text':
                    case 'email':
                        previewHtml +=
                            `<input type="${type}" class="form-control" placeholder="Enter ${fieldLabel.toLowerCase()}">`;
                        break;
                    case 'textarea':
                        previewHtml +=
                            `<textarea class="form-control" rows="4" placeholder="Enter ${fieldLabel.toLowerCase()}"></textarea>`;
                        break;
                    case 'number':
                        previewHtml += `<input type="number" class="form-control" placeholder="Enter number">`;
                        break;
                    case 'select':
                        previewHtml +=
                            `<select class="form-select"><option>Select an option</option><option>Option 1</option><option>Option 2</option></select>`;
                        break;
                    case 'checkbox':
                        previewHtml +=
                            `<div class="form-check"><input class="form-check-input" type="checkbox"><label class="form-check-label">Checkbox option</label></div>`;
                        break;
                    case 'radio':
                        previewHtml +=
                            `<div class="form-check"><input class="form-check-input" type="radio" name="radio_preview"><label class="form-check-label">Radio option 1</label></div>`;
                        break;
                    case 'boolean':
                        previewHtml +=
                            `<div class="form-check form-switch"><input class="form-check-input" type="checkbox"><label class="form-check-label">Toggle switch</label></div>`;
                        break;
                    case 'date':
                        previewHtml += `<input type="date" class="form-control">`;
                        break;
                    case 'file':
                    case 'image':
                        previewHtml += `<input type="file" class="form-control">`;
                        break;
                    default:
                        previewHtml += `<input type="text" class="form-control" placeholder="Preview for ${type}">`;
                }

                fieldPreview.innerHTML = previewHtml;
            }

            function initializeOptionsList() {
                const addOptionBtn = document.getElementById('addOption');
                const optionsList = document.getElementById('optionsList');

                if (!addOptionBtn || !optionsList) return;

                addOptionBtn.addEventListener('click', function() {
                    const optionIndex = optionsList.children.length;
                    const optionHtml = `
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="options[options_list][${optionIndex}][value]" placeholder="Value">
                    <input type="text" class="form-control" name="options[options_list][${optionIndex}][label]" placeholder="Label">
                    <button type="button" class="btn btn-outline-danger remove-option">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
                    optionsList.insertAdjacentHTML('beforeend', optionHtml);
                });

                // Remove option handler
                optionsList.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-option')) {
                        e.target.closest('.input-group').remove();
                    }
                });
            }

            // Auto-generate field name from label
            document.getElementById('field_label').addEventListener('input', function() {
                const fieldNameInput = document.getElementById('field_name');
                if (!fieldNameInput.value) {
                    fieldNameInput.value = this.value.toLowerCase()
                        .replace(/[^a-z0-9\s]/g, '')
                        .replace(/\s+/g, '_');
                }
                updateFieldPreview(fieldTypeSelect.value);
            });

            // Update preview on field name change
            document.getElementById('field_name').addEventListener('input', function() {
                updateFieldPreview(fieldTypeSelect.value);
            });

            // Update preview on required change
            document.getElementById('required').addEventListener('change', function() {
                updateFieldPreview(fieldTypeSelect.value);
            });
        });
    </script>

    <style>
        .card {
            border: 1px solid #e3e6f0;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .form-check-input:checked {
            background-color: #5a6c7d;
            border-color: #5a6c7d;
        }

        #fieldPreview {
            min-height: 100px;
            background: #f8f9fc;
            border-radius: 0.35rem;
            padding: 1rem;
        }

        .input-group .form-control {
            border-right: 0;
        }

        .input-group .form-control:not(:last-child) {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .remove-option {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .text-danger {
            color: #e74a3b !important;
        }
    </style>
@endsection
