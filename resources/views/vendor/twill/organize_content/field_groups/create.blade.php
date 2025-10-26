@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Create Field Group</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.field-groups.index') }}">Field Groups</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">Field Group Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.field-groups.store') }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug" class="form-label">Slug</label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                               id="slug" name="slug" value="{{ old('slug') }}">
                                        <div class="form-text">Leave empty to auto-generate from name</div>
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
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
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="source" class="form-label">Source <span class="text-danger">*</span></label>
                                        <select class="form-select @error('source') is-invalid @enderror" 
                                                id="source" name="source" required>
                                            <option value="">Select Source</option>
                                            <option value="local" {{ old('source') == 'local' ? 'selected' : '' }}>Local</option>
                                            <option value="centralized" {{ old('source') == 'centralized' ? 'selected' : '' }}>Centralized</option>
                                            <option value="custom" {{ old('source') == 'custom' ? 'selected' : '' }}>Custom</option>
                                        </select>
                                        @error('source')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="access_rights" class="form-label">Access Rights <span class="text-danger">*</span></label>
                                        <select class="form-select @error('access_rights') is-invalid @enderror" 
                                                id="access_rights" name="access_rights" required>
                                            <option value="">Select Access Rights</option>
                                            <option value="public" {{ old('access_rights') == 'public' ? 'selected' : '' }}>Public</option>
                                            <option value="private" {{ old('access_rights') == 'private' ? 'selected' : '' }}>Private</option>
                                            <option value="restricted" {{ old('access_rights') == 'restricted' ? 'selected' : '' }}>Restricted</option>
                                        </select>
                                        @error('access_rights')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sort_order" class="form-label">Sort Order</label>
                                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                               id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                        @error('sort_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.field-groups.index') }}" class="btn btn-secondary">
                                    <i class="ri-arrow-left-line me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-save-line me-1"></i> Create Field Group
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">Help & Tips</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="fw-bold">Field Groups</h6>
                            <p class="text-muted small">Field groups help organize related fields together, making it easier to manage and find fields when you need them.</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold">Source Types</h6>
                            <ul class="text-muted small">
                                <li><strong>Local:</strong> Created within your system</li>
                                <li><strong>Centralized:</strong> From a central repository</li>
                                <li><strong>Custom:</strong> Custom developed solutions</li>
                            </ul>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold">Access Rights</h6>
                            <ul class="text-muted small">
                                <li><strong>Public:</strong> Accessible to everyone</li>
                                <li><strong>Private:</strong> Restricted access</li>
                                <li><strong>Restricted:</strong> Limited access with permissions</li>
                            </ul>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold">Sort Order</h6>
                            <p class="text-muted small">Lower numbers appear first in lists. Use this to control the display order of field groups.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slug = name.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    
    document.getElementById('slug').value = slug;
});
</script>
@endsection

