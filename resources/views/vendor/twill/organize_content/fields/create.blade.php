@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Create Field</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.fields.index') }}">Fields</a></li>
                        <li class="breadcrumb-item active">Create</li>
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
                                <h5 class="card-title mb-0">Field</h5>
                                <small class="text-muted">core field details</small>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" form="fieldForm" class="btn btn-success btn-sm">
                                    <i class="ri-check-line me-1"></i> Save
                                </button>
                                <button type="submit" form="fieldForm" name="action" value="save_and_close" class="btn btn-outline-primary btn-sm">
                                    <i class="ri-check-line me-1"></i> Save & Close
                                </button>
                                <button type="submit" form="fieldForm" name="action" value="save_and_new" class="btn btn-outline-primary btn-sm">
                                    <i class="ri-add-line me-1"></i> Save & New
                                </button>
                                <button type="submit" form="fieldForm" name="action" value="save_as_copy" class="btn btn-outline-primary btn-sm">
                                    <i class="ri-file-copy-line me-1"></i> Save as Copy
                                </button>
                                <a href="{{ route('admin.fields.index') }}" class="btn btn-outline-danger btn-sm">
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

                        <form id="fieldForm" method="POST" action="{{ route('admin.fields.store') }}">
                            @csrf
                            
                            <!-- Field Details Section -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                            <label class="form-check-label fw-bold" for="is_active">
                                                Active
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Viewable:</label>
                                        <select class="form-select" name="viewable" required>
                                            <option value="public" {{ old('viewable') == 'public' ? 'selected' : '' }}>Public</option>
                                            <option value="private" {{ old('viewable') == 'private' ? 'selected' : '' }}>Private</option>
                                            <option value="restricted" {{ old('viewable') == 'restricted' ? 'selected' : '' }}>Restricted</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Field Group:</label>
                                        <select class="form-select" name="field_group_id">
                                            <option value="">Select Field Group</option>
                                            @foreach($fieldGroups as $fieldGroup)
                                                <option value="{{ $fieldGroup->id }}" {{ old('field_group_id') == $fieldGroup->id ? 'selected' : '' }}>
                                                    {{ $fieldGroup->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Field Name:</label>
                                        <input type="text" class="form-control" name="label" value="{{ old('label') }}" placeholder="Enter field name" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Alias:</label>
                                        <input type="text" class="form-control" name="alias" value="{{ old('alias') }}" placeholder="Enter field alias" required>
                                        <div class="form-text">Used as database column name</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Field Type:</label>
                                        <select class="form-select" name="type" id="fieldType" required>
                                            <option value="">Select Field Type</option>
                                            <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
                                            <option value="textarea" {{ old('type') == 'textarea' ? 'selected' : '' }}>Textarea</option>
                                            <option value="number" {{ old('type') == 'number' ? 'selected' : '' }}>Number</option>
                                            <option value="email" {{ old('type') == 'email' ? 'selected' : '' }}>Email</option>
                                            <option value="url" {{ old('type') == 'url' ? 'selected' : '' }}>URL</option>
                                            <option value="date" {{ old('type') == 'date' ? 'selected' : '' }}>Date</option>
                                            <option value="datetime" {{ old('type') == 'datetime' ? 'selected' : '' }}>DateTime</option>
                                            <option value="time" {{ old('type') == 'time' ? 'selected' : '' }}>Time</option>
                                            <option value="select" {{ old('type') == 'select' ? 'selected' : '' }}>Select Dropdown</option>
                                            <option value="checkbox" {{ old('type') == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                            <option value="radio" {{ old('type') == 'radio' ? 'selected' : '' }}>Radio Button</option>
                                            <option value="file" {{ old('type') == 'file' ? 'selected' : '' }}>File Upload</option>
                                            <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Image Upload</option>
                                            <option value="boolean" {{ old('type') == 'boolean' ? 'selected' : '' }}>Boolean (Yes/No)</option>
                                            <option value="json" {{ old('type') == 'json' ? 'selected' : '' }}>JSON</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Description:</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been">{{ old('description') }}</textarea>
                            </div>
                            
                            <!-- Field Type Specific Options -->
                            <div id="fieldOptions" class="mb-4" style="display: none;">
                                <div class="d-flex gap-2 mb-3">
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="optionsBtn">
                                        Options
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="additionalBtn">
                                        ...additional...?
                                    </button>
                                </div>
                                
                                <!-- Checkbox Options -->
                                <div id="checkboxOptions" class="card border-0" style="display: none;">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Checkbox Options</h6>
                                        <small class="text-muted">sub text</small>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Option 1:</label>
                                                    <input type="text" class="form-control" name="field_config[options][0][label]" placeholder="Option label">
                                                    <input type="hidden" name="field_config[options][0][value]" value="option_1">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Option 2:</label>
                                                    <input type="text" class="form-control" name="field_config[options][1][label]" placeholder="Option label">
                                                    <input type="hidden" name="field_config[options][1][value]" value="option_2">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Option 3:</label>
                                                    <input type="text" class="form-control" name="field_config[options][2][label]" placeholder="Option label">
                                                    <input type="hidden" name="field_config[options][2][value]" value="option_3">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Option 4:</label>
                                                    <input type="text" class="form-control" name="field_config[options][3][label]" placeholder="Option label">
                                                    <input type="hidden" name="field_config[options][3][value]" value="option_4">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Option 5:</label>
                                                    <input type="text" class="form-control" name="field_config[options][4][label]" placeholder="Option label">
                                                    <input type="hidden" name="field_config[options][4][value]" value="option_5">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Option 6:</label>
                                                    <input type="text" class="form-control" name="field_config[options][5][label]" placeholder="Option label">
                                                    <input type="hidden" name="field_config[options][5][value]" value="option_6">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="addOption">
                                            <i class="ri-add-line me-1"></i> Add Option
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Select Options -->
                                <div id="selectOptions" class="card border-0" style="display: none;">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Select Options</h6>
                                        <small class="text-muted">sub text</small>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Option 1:</label>
                                                    <input type="text" class="form-control" name="field_config[select_options][0][label]" placeholder="Option label">
                                                    <input type="text" class="form-control mt-1" name="field_config[select_options][0][value]" placeholder="Option value">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Option 2:</label>
                                                    <input type="text" class="form-control" name="field_config[select_options][1][label]" placeholder="Option label">
                                                    <input type="text" class="form-control mt-1" name="field_config[select_options][1][value]" placeholder="Option value">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Option 3:</label>
                                                    <input type="text" class="form-control" name="field_config[select_options][2][label]" placeholder="Option label">
                                                    <input type="text" class="form-control mt-1" name="field_config[select_options][2][value]" placeholder="Option value">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Option 4:</label>
                                                    <input type="text" class="form-control" name="field_config[select_options][3][label]" placeholder="Option label">
                                                    <input type="text" class="form-control mt-1" name="field_config[select_options][3][value]" placeholder="Option value">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Option 5:</label>
                                                    <input type="text" class="form-control" name="field_config[select_options][4][label]" placeholder="Option label">
                                                    <input type="text" class="form-control mt-1" name="field_config[select_options][4][value]" placeholder="Option value">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Option 6:</label>
                                                    <input type="text" class="form-control" name="field_config[select_options][5][label]" placeholder="Option label">
                                                    <input type="text" class="form-control mt-1" name="field_config[select_options][5][value]" placeholder="Option value">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="addSelectOption">
                                            <i class="ri-add-line me-1"></i> Add Option
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Radio Options -->
                                <div id="radioOptions" class="card border-0" style="display: none;">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Radio Options</h6>
                                        <small class="text-muted">sub text</small>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Option 1:</label>
                                                    <input type="text" class="form-control" name="field_config[radio_options][0][label]" placeholder="Option label">
                                                    <input type="text" class="form-control mt-1" name="field_config[radio_options][0][value]" placeholder="Option value">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Option 2:</label>
                                                    <input type="text" class="form-control" name="field_config[radio_options][1][label]" placeholder="Option label">
                                                    <input type="text" class="form-control mt-1" name="field_config[radio_options][1][value]" placeholder="Option value">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Option 3:</label>
                                                    <input type="text" class="form-control" name="field_config[radio_options][2][label]" placeholder="Option label">
                                                    <input type="text" class="form-control mt-1" name="field_config[radio_options][2][value]" placeholder="Option value">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Option 4:</label>
                                                    <input type="text" class="form-control" name="field_config[radio_options][3][label]" placeholder="Option label">
                                                    <input type="text" class="form-control mt-1" name="field_config[radio_options][3][value]" placeholder="Option value">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Option 5:</label>
                                                    <input type="text" class="form-control" name="field_config[radio_options][4][label]" placeholder="Option label">
                                                    <input type="text" class="form-control mt-1" name="field_config[radio_options][4][value]" placeholder="Option value">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Option 6:</label>
                                                    <input type="text" class="form-control" name="field_config[radio_options][5][label]" placeholder="Option label">
                                                    <input type="text" class="form-control mt-1" name="field_config[radio_options][5][value]" placeholder="Option value">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="addRadioOption">
                                            <i class="ri-add-line me-1"></i> Add Option
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- File Upload Options -->
                                <div id="fileOptions" class="card border-0" style="display: none;">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">File Upload Options</h6>
                                        <small class="text-muted">sub text</small>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Allowed File Types:</label>
                                                    <input type="text" class="form-control" name="field_config[allowed_types]" placeholder="jpg,jpeg,png,pdf,doc,docx" value="{{ old('field_config.allowed_types', 'jpg,jpeg,png,pdf,doc,docx') }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Max File Size (MB):</label>
                                                    <input type="number" class="form-control" name="field_config[max_size]" placeholder="10" value="{{ old('field_config.max_size', '10') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Multiple Files:</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="field_config[multiple]" value="1" id="multipleFiles">
                                                        <label class="form-check-label" for="multipleFiles">
                                                            Allow multiple file uploads
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Required:</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="field_config[required]" value="1" id="fileRequired">
                                                        <label class="form-check-label" for="fileRequired">
                                                            File upload is required
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Validation Rules -->
                                <div id="validationOptions" class="card border-0" style="display: none;">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Validation Rules</h6>
                                        <small class="text-muted">sub text</small>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Required:</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="validation_rules[required]" value="1" id="validationRequired">
                                                        <label class="form-check-label" for="validationRequired">
                                                            This field is required
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Min Length:</label>
                                                    <input type="number" class="form-control" name="validation_rules[min_length]" placeholder="Minimum length">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Max Length:</label>
                                                    <input type="number" class="form-control" name="validation_rules[max_length]" placeholder="Maximum length">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Min Value:</label>
                                                    <input type="number" class="form-control" name="validation_rules[min_value]" placeholder="Minimum value">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Max Value:</label>
                                                    <input type="number" class="form-control" name="validation_rules[max_value]" placeholder="Maximum value">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Pattern (Regex):</label>
                                                    <input type="text" class="form-control" name="validation_rules[pattern]" placeholder="Regular expression pattern">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Sort Order -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Sort Order:</label>
                                <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                <div class="form-text">Lower numbers appear first</div>
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
    const fieldTypeSelect = document.getElementById('fieldType');
    const fieldOptions = document.getElementById('fieldOptions');
    const checkboxOptions = document.getElementById('checkboxOptions');
    const selectOptions = document.getElementById('selectOptions');
    const radioOptions = document.getElementById('radioOptions');
    const fileOptions = document.getElementById('fileOptions');
    const validationOptions = document.getElementById('validationOptions');
    const optionsBtn = document.getElementById('optionsBtn');
    const additionalBtn = document.getElementById('additionalBtn');
    
    // Show/hide field options based on field type
    fieldTypeSelect.addEventListener('change', function() {
        const fieldType = this.value;
        
        // Hide all option sections
        checkboxOptions.style.display = 'none';
        selectOptions.style.display = 'none';
        radioOptions.style.display = 'none';
        fileOptions.style.display = 'none';
        validationOptions.style.display = 'none';
        
        // Show field options container for types that need options
        if (['checkbox', 'select', 'radio', 'file', 'image'].includes(fieldType)) {
            fieldOptions.style.display = 'block';
            
            // Show specific option section
            if (fieldType === 'checkbox') {
                checkboxOptions.style.display = 'block';
            } else if (fieldType === 'select') {
                selectOptions.style.display = 'block';
            } else if (fieldType === 'radio') {
                radioOptions.style.display = 'block';
            } else if (['file', 'image'].includes(fieldType)) {
                fileOptions.style.display = 'block';
            }
        } else {
            fieldOptions.style.display = 'none';
        }
    });
    
    // Toggle validation options
    additionalBtn.addEventListener('click', function() {
        if (validationOptions.style.display === 'none') {
            validationOptions.style.display = 'block';
            this.textContent = 'Hide additional...';
        } else {
            validationOptions.style.display = 'none';
            this.textContent = '...additional...?';
        }
    });
    
    // Auto-generate alias from label
    const labelInput = document.querySelector('input[name="label"]');
    const aliasInput = document.querySelector('input[name="alias"]');
    
    labelInput.addEventListener('input', function() {
        if (!aliasInput.value) {
            const alias = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s]/g, '')
                .replace(/\s+/g, '_')
                .trim();
            aliasInput.value = alias;
        }
    });
    
    // Add option functionality
    let optionCount = 6;
    
    document.getElementById('addOption').addEventListener('click', function() {
        const container = this.parentElement;
        const newOption = document.createElement('div');
        newOption.className = 'mb-3';
        newOption.innerHTML = `
            <label class="form-label">Option ${optionCount + 1}:</label>
            <input type="text" class="form-control" name="field_config[options][${optionCount}][label]" placeholder="Option label">
            <input type="hidden" name="field_config[options][${optionCount}][value]" value="option_${optionCount + 1}">
        `;
        container.insertBefore(newOption, this);
        optionCount++;
    });
    
    document.getElementById('addSelectOption').addEventListener('click', function() {
        const container = this.parentElement;
        const newOption = document.createElement('div');
        newOption.className = 'mb-3';
        newOption.innerHTML = `
            <label class="form-label">Option ${optionCount + 1}:</label>
            <input type="text" class="form-control" name="field_config[select_options][${optionCount}][label]" placeholder="Option label">
            <input type="text" class="form-control mt-1" name="field_config[select_options][${optionCount}][value]" placeholder="Option value">
        `;
        container.insertBefore(newOption, this);
        optionCount++;
    });
    
    document.getElementById('addRadioOption').addEventListener('click', function() {
        const container = this.parentElement;
        const newOption = document.createElement('div');
        newOption.className = 'mb-3';
        newOption.innerHTML = `
            <label class="form-label">Option ${optionCount + 1}:</label>
            <input type="text" class="form-control" name="field_config[radio_options][${optionCount}][label]" placeholder="Option label">
            <input type="text" class="form-control mt-1" name="field_config[radio_options][${optionCount}][value]" placeholder="Option value">
        `;
        container.insertBefore(newOption, this);
        optionCount++;
    });
    
    // Form submission handling
    const form = document.getElementById('fieldForm');
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

