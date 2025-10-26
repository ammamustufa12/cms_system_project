@extends('twill::layouts.form')

@section('contentFields')
    <div class="page-builder-container">
        <!-- Header Section -->
        <div class="page-builder-header mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <i class="fas fa-palette me-2"></i>
                        Visual Page Builder
                    </h2>
                    <p class="text-muted mb-0">Choose a content type to start building layouts</p>
                </div>
                <div class="btn-group">
                    <a href="{{ route('content-types.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-cog me-1"></i>Manage Content Types
                    </a>
                    <a href="{{ route('content-types.create') }}" class="btn btn-outline-success">
                        <i class="fas fa-plus me-1"></i>Create New Content Type
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Types Grid -->
        <div class="content-types-grid">
            @if($contentTypes->count() > 0)
                <div class="row">
                    @foreach($contentTypes as $contentType)
                        <div class="col-md-4 mb-4">
                            <div class="content-type-card card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="{{ $contentType->icon ?? 'fas fa-cube' }} me-2" 
                                           style="color: {{ $contentType->color ?? '#007bff' }}"></i>
                                        <h5 class="mb-0">{{ $contentType->name }}</h5>
                                    </div>
                                    <span class="badge bg-{{ $contentType->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($contentType->status) }}
                                    </span>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-3">{{ $contentType->description ?? 'No description available' }}</p>
                                    
                                    <div class="content-type-stats mb-3">
                                        <div class="row text-center">
                                            <div class="col-4">
                                                <div class="stat-item">
                                                    <strong>{{ count(is_array($contentType->fields_schema) ? $contentType->fields_schema : []) }}</strong>
                                                    <small class="text-muted d-block">Fields</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="stat-item">
                                                    <strong>{{ count(is_array($contentType->field_groups) ? $contentType->field_groups : []) }}</strong>
                                                    <small class="text-muted d-block">Groups</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="stat-item">
                                                    <strong>{{ count(is_array($contentType->layout_config) ? $contentType->layout_config : []) }}</strong>
                                                    <small class="text-muted d-block">Layouts</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="btn-group w-100">
                                        <a href="{{ route('content-types.grapes-builder', $contentType->slug) }}" 
                                           class="btn btn-primary">
                                            <i class="fas fa-palette me-1"></i>Visual Builder
                                        </a>
                                        <a href="{{ route('field-manager.index', $contentType->slug) }}" 
                                           class="btn btn-outline-secondary">
                                            <i class="fas fa-cog me-1"></i>Fields
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state text-center py-5">
                    <i class="fas fa-cube fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted mb-3">No Content Types Available</h4>
                    <p class="text-muted mb-4">Create your first content type to start building layouts</p>
                    <a href="{{ route('content-types.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Create Content Type
                    </a>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions mt-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="quick-action-item text-center">
                                <i class="fas fa-plus-circle fa-2x text-primary mb-2"></i>
                                <h6>Create Content Type</h6>
                                <p class="text-muted small">Start with a new content type</p>
                                <a href="{{ route('content-types.create') }}" class="btn btn-sm btn-outline-primary">Create</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="quick-action-item text-center">
                                <i class="fas fa-download fa-2x text-success mb-2"></i>
                                <h6>Import Template</h6>
                                <p class="text-muted small">Import existing layouts</p>
                                <button class="btn btn-sm btn-outline-success" onclick="alert('Import feature coming soon!')">Import</button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="quick-action-item text-center">
                                <i class="fas fa-book fa-2x text-info mb-2"></i>
                                <h6>Documentation</h6>
                                <p class="text-muted small">Learn how to use the builder</p>
                                <button class="btn btn-sm btn-outline-info" onclick="alert('Documentation coming soon!')">Learn</button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="quick-action-item text-center">
                                <i class="fas fa-cog fa-2x text-warning mb-2"></i>
                                <h6>Settings</h6>
                                <p class="text-muted small">Configure builder settings</p>
                                <button class="btn btn-sm btn-outline-warning" onclick="alert('Settings coming soon!')">Configure</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('extraCss')
<style>
.page-builder-container {
    padding: 20px;
    background: #f8f9fa;
    min-height: 100vh;
}

.content-type-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.content-type-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border-color: #007bff;
}

.stat-item {
    padding: 10px;
}

.stat-item strong {
    font-size: 1.5rem;
    color: #007bff;
}

.quick-action-item {
    padding: 20px;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.quick-action-item:hover {
    border-color: #007bff;
    background: rgba(0,123,255,0.05);
}

.empty-state {
    background: white;
    border-radius: 8px;
    padding: 60px 20px;
}

.content-types-grid .card {
    height: 100%;
}

.card-footer .btn-group .btn {
    flex: 1;
}
</style>
@endpush