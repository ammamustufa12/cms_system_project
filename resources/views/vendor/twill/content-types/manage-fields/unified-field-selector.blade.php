<!-- Unified Field Selector Component -->
@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

<div class="unified-field-selector">
    <div class="row">
        <!-- Field Categories Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-layer-group me-2"></i>
                        Field Categories
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($fieldTypesByCategory as $category => $fieldTypes)
                            <a href="#" class="list-group-item list-group-item-action category-filter" 
                               data-category="{{ $category }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>{{ $category }}</span>
                                    <span class="badge bg-primary rounded-pill">{{ count($fieldTypes) }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Field Types Grid -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-plus-circle me-2"></i>
                            Available Field Types
                        </h5>
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control" id="fieldSearch" placeholder="Search field types...">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row" id="fieldTypesGrid">
                        @foreach($fieldTypesByCategory as $category => $fieldTypes)
                            @foreach($fieldTypes as $fieldType)
                                <div class="col-md-4 mb-3 field-type-card" data-category="{{ $category }}" data-type="{{ $fieldType['type'] }}">
                                    <div class="card h-100 field-type-item" data-field-type-id="{{ $fieldType['id'] }}">
                                        <div class="card-body">
                                            <div class="d-flex align-items-start mb-2">
                                                <div class="field-type-icon me-3" style="background: {{ $fieldType['color'] }};">
                                                    <i class="{{ $fieldType['icon'] }}"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="card-title mb-1">{{ $fieldType['name'] }}</h6>
                                                    <small class="text-muted">{{ $fieldType['type'] }}</small>
                                                </div>
                                            </div>
                                            <p class="card-text small text-muted mb-3">
                                                {{ Str::limit($fieldType['description'], 80) }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-secondary">{{ $category }}</span>
                                                <button class="btn btn-sm btn-primary add-field-btn" 
                                                        data-field-type-id="{{ $fieldType['id'] }}"
                                                        data-field-type-name="{{ $fieldType['name'] }}"
                                                        data-field-type="{{ $fieldType['type'] }}">
                                                    <i class="fas fa-plus me-1"></i>
                                                    Add Field
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Field Modal -->
<div class="modal fade" id="addFieldModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>
                    Add Field to Content Type
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addFieldForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fieldName" class="form-label">Field Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="fieldName" name="field_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fieldKey" class="form-label">Field Key</label>
                                <input type="text" class="form-control" id="fieldKey" name="field_key" placeholder="auto-generated">
                                <div class="form-text">Leave empty for auto-generation</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fieldOrder" class="form-label">Order</label>
                                <input type="number" class="form-control" id="fieldOrder" name="order" value="999" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" id="fieldRequired" name="required">
                                    <label class="form-check-label" for="fieldRequired">
                                        Required Field
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="fieldDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="fieldDescription" name="description" rows="3"></textarea>
                    </div>
                    
                    <!-- Field-specific options will be loaded here -->
                    <div id="fieldOptionsContainer">
                        <!-- Dynamic content based on field type -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Add Field
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.field-type-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
}

.field-type-card {
    transition: transform 0.2s ease;
}

.field-type-card:hover {
    transform: translateY(-2px);
}

.field-type-item {
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.2s ease;
}

.field-type-item:hover {
    border-color: #007bff;
    box-shadow: 0 4px 8px rgba(0,123,255,0.1);
}

.category-filter.active {
    background-color: #007bff;
    color: white;
}

#fieldTypesGrid .field-type-card.hidden {
    display: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fieldTypes = @json($allFieldTypes);
    const contentTypeSlug = '{{ $contentType->slug }}';
    const csrfToken = '{{ csrf_token() }}';
    let selectedFieldTypeId = null; // Store selected field type ID
    
    // Category filtering
    document.querySelectorAll('.category-filter').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Update active state
            document.querySelectorAll('.category-filter').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filter field types
            const category = this.dataset.category;
            document.querySelectorAll('.field-type-card').forEach(card => {
                if (category === 'All' || card.dataset.category === category) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        });
    });
    
    // Search functionality
    document.getElementById('fieldSearch').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('.field-type-card').forEach(card => {
            const fieldName = card.querySelector('.card-title').textContent.toLowerCase();
            const fieldType = card.querySelector('.text-muted').textContent.toLowerCase();
            const description = card.querySelector('.card-text').textContent.toLowerCase();
            
            if (fieldName.includes(searchTerm) || fieldType.includes(searchTerm) || description.includes(searchTerm)) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    });
    
    // Add field button click
    document.querySelectorAll('.add-field-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const fieldTypeId = this.dataset.fieldTypeId;
            const fieldTypeName = this.dataset.fieldTypeName;
            const fieldType = this.dataset.fieldType;
            
            // Store selected field type ID
            selectedFieldTypeId = fieldTypeId;
            
            // Set field name
            document.getElementById('fieldName').value = fieldTypeName;
            
            // Auto-generate field key
            const fieldKey = fieldTypeName.toLowerCase().replace(/[^a-z0-9]/g, '_');
            document.getElementById('fieldKey').value = fieldKey;
            
            // Load field-specific options
            loadFieldOptions(fieldTypeId, fieldType);
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('addFieldModal'));
            modal.show();
        });
    });
    
    // Form submission
    document.getElementById('addFieldForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('field_type_id', selectedFieldTypeId);
        
        // Add CSRF token
        formData.append('_token', csrfToken);
        
        // Add field options
        const fieldOptions = {};
        document.querySelectorAll('#fieldOptionsContainer input, #fieldOptionsContainer select, #fieldOptionsContainer textarea').forEach(input => {
            if (input.name && input.value) {
                fieldOptions[input.name] = input.value;
            }
        });
        formData.append('options', JSON.stringify(fieldOptions));
        
        // Submit via AJAX
        const encodedSlug = encodeURIComponent(contentTypeSlug);
        
        // Debug: Log form data
        console.log('Submitting field:', {
            field_type_id: selectedFieldTypeId,
            field_name: formData.get('field_name'),
            field_key: formData.get('field_key'),
            options: formData.get('options'),
            csrf_token: formData.get('_token'),
            url: `/admin/content-types/${encodedSlug}/add-field-unified`
        });
        fetch(`/admin/content-types/${encodedSlug}/add-field-unified`, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json();
            } else {
                // If not JSON, get text and try to parse
                return response.text().then(text => {
                    console.log('Response text:', text);
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        throw new Error('Invalid JSON response: ' + text.substring(0, 100));
                    }
                });
            }
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                // Show success message
                showAlert('success', data.message);
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('addFieldModal'));
                modal.hide();
                
                // Reload page to show new field
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showAlert('error', data.message || 'Unknown error occurred');
            }
        })
        .catch(error => {
            console.error('Error details:', error);
            showAlert('error', 'An error occurred while adding the field: ' + error.message);
        });
    });
    
    function loadFieldOptions(fieldTypeId, fieldType) {
        const container = document.getElementById('fieldOptionsContainer');
        container.innerHTML = '';
        
        const fieldTypeData = fieldTypes[fieldTypeId];
        if (fieldTypeData && fieldTypeData.config) {
            const optionsHtml = generateFieldOptionsHtml(fieldTypeData.config);
            container.innerHTML = optionsHtml;
        }
    }
    
    function generateFieldOptionsHtml(options) {
        let html = '<h6 class="mb-3">Field Options</h6>';
        
        Object.entries(options).forEach(([key, option]) => {
            const label = option.label || key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            const type = option.type || 'text';
            const defaultValue = option.default || '';
            
            html += `<div class="mb-3">`;
            html += `<label for="option_${key}" class="form-label">${label}</label>`;
            
            if (type === 'text' || type === 'number') {
                html += `<input type="${type}" class="form-control" id="option_${key}" name="${key}" value="${defaultValue}">`;
            } else if (type === 'textarea') {
                html += `<textarea class="form-control" id="option_${key}" name="${key}" rows="3">${defaultValue}</textarea>`;
            } else if (type === 'boolean') {
                html += `<div class="form-check">`;
                html += `<input class="form-check-input" type="checkbox" id="option_${key}" name="${key}" ${defaultValue ? 'checked' : ''}>`;
                html += `<label class="form-check-label" for="option_${key}">${label}</label>`;
                html += `</div>`;
            } else if (type === 'select' && option.options) {
                html += `<select class="form-select" id="option_${key}" name="${key}">`;
                Object.entries(option.options).forEach(([value, label]) => {
                    html += `<option value="${value}" ${value === defaultValue ? 'selected' : ''}>${label}</option>`;
                });
                html += `</select>`;
            }
            
            html += `</div>`;
        });
        
        return html;
    }
    
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        // Insert at the top of the page
        const container = document.querySelector('.container-fluid') || document.body;
        container.insertAdjacentHTML('afterbegin', alertHtml);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            const alert = container.querySelector('.alert');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }
});
</script>
