{{-- resources/views/admin/content-types/index.blade.php --}}
@extends('twill::layouts.main')


@section('content')
    <div class="page-content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Content Types</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Content Types</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="container-fluid px-5">

            <!-- Stats Cards -->
            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-primary text-white rounded-3 p-3 me-3">
                                <i class="fas fa-layer-group fa-lg"></i>
                            </div>
                            <div>
                                <h4 class="mb-0">{{ $contentTypes->count() }}</h4>
                                <small class="text-muted">Content Types</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-success text-white rounded-3 p-3 me-3">
                                <i class="fas fa-eye fa-lg"></i>
                            </div>
                            <div>
                                <h4 class="mb-0">{{ $contentTypes->where('status', 'active')->count() }}</h4>
                                <small class="text-muted">Active</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-info text-white rounded-3 p-3 me-3">
                                <i class="fas fa-file-alt fa-lg"></i>
                            </div>
                            <div>
                                <h4 class="mb-0">
                                    {{ $contentTypes->sum(function ($ct) {return $ct->contentItems->count();}) }}</h4>
                                <small class="text-muted">Total Items</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-warning text-white rounded-3 p-3 me-3">
                                <i class="fas fa-cog fa-lg"></i>
                            </div>
                            <div>
                                <h4 class="mb-0">{{ $contentTypes->where('layout_config', '!=', null)->count() }}</h4>
                                <small class="text-muted">With Layouts</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Types Grid -->
            @if ($contentTypes->count() > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-layer-group me-2"></i>Content Types
                                </h5>
                                <div>
                                    <a href="{{ route('content-types.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i>Create New
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Types Cards -->
                <div class="row g-4 mt-2">
                    @foreach ($contentTypes as $contentType)
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="card content-type-card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="content-type-icon me-3" style="background: {{ $contentType->color ?? '#007bff' }};">
                                            <i class="{{ $contentType->icon ?? 'fas fa-cube' }}"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $contentType->name }}</h6>
                                            <small class="text-muted">{{ $contentType->slug }}</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-{{ $contentType->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($contentType->status) }}
                                    </span>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-3">{{ $contentType->description ?? 'No description available' }}</p>
                                    
                                    <!-- Stats -->
                                    <div class="row text-center mb-3">
                                        <div class="col-4">
                                            <div class="stat-item">
                                                <strong>{{ count(is_array($contentType->fields_schema) ? $contentType->fields_schema : []) }}</strong>
                                                <small class="text-muted d-block">Fields</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="stat-item">
                                                <strong>{{ $contentType->contentItems->count() }}</strong>
                                                <small class="text-muted d-block">Items</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="stat-item">
                                                <strong>{{ count(is_array($contentType->layout_config) ? $contentType->layout_config : []) }}</strong>
                                                <small class="text-muted d-block">Layouts</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quick Actions -->
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('content-types.content-items.index', ['contentType' => $contentType->slug]) }}" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-plus me-1"></i>Add Items
                                        </a>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('content-types.manage-fields', $contentType->slug) }}" 
                                               class="btn btn-outline-success btn-sm">
                                                <i class="fas fa-cog me-1"></i>Fields
                                            </a>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('content-types.working-builder', $contentType->slug) }}" 
                                                   class="btn btn-success btn-sm">
                                                    <i class="fas fa-check-circle me-1"></i>Edit with Elementor
                                                </a>
                                                {{-- <a href="{{ route('advanced-builder', $contentType->slug) }}" 
                                                   class="btn btn-warning btn-sm">
                                                    <i class="fas fa-magic me-1"></i>Advanced
                                                </a> --}}
                                                {{-- <a href="{{ route('content-types.professional-builder', $contentType->slug) }}" 
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fas fa-layout me-1"></i>Professional
                                                </a>
                                                <a href="{{ route('content-types.simple-builder', $contentType->slug) }}" 
                                                   class="btn btn-outline-success btn-sm">
                                                    <i class="fas fa-rocket me-1"></i>Simple
                                                </a>
                                                <a href="{{ route('content-types.grapes-builder', $contentType->slug) }}" 
                                                   class="btn btn-outline-info btn-sm">
                                                    <i class="fas fa-palette me-1"></i>GrapesJS
                                                </a>
                                                <a href="{{ route('content-types.vvveb-builder', $contentType->slug) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-magic me-1"></i>Vvveb.js
                                                </a> --}}
                                            </div>
                                            <a href="{{ route('content-types.edit', $contentType->slug) }}" 
                                               class="btn btn-outline-warning btn-sm">
                                                <i class="fas fa-edit me-1"></i>Edit
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            Updated {{ $contentType->updated_at->diffForHumans() }}
                                        </small>
                                        <button class="btn btn-outline-danger btn-sm" 
                                                onclick="deleteItem({{ $contentType->id }}, '{{ $contentType->name }}')"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-5">
                    <i class="fas fa-layer-group fa-4x text-muted opacity-25 mb-3"></i>
                    <h4 class="mb-2">No Content Types Yet</h4>
                    <p class="text-muted mb-4">Create your first content type to start managing dynamic content</p>
                    <a href="{{ route('content-types.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Create Your First Content Type
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    <!-- Delete Confirmation Modal - Exactly like ContentItem -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="deleteItemName"></strong>?</p>
                    <p class="text-danger small">This action cannot be undone and will delete all associated content items
                        and files.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Content Type</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    @push('extra_css')
    <style>
        .content-type-card {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .content-type-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            border-color: #007bff;
        }
        
        .content-type-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }
        
        .stat-item {
            padding: 8px;
        }
        
        .stat-item strong {
            font-size: 1.25rem;
            color: #007bff;
            display: block;
        }
        
        .btn-group .btn {
            border-radius: 0;
        }
        
        .btn-group .btn:first-child {
            border-top-left-radius: 0.375rem;
            border-bottom-left-radius: 0.375rem;
        }
        
        .btn-group .btn:last-child {
            border-top-right-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
        }
    </style>
    @endpush

    @push('extra_js')
        {{-- <script>
            function confirmDelete(contentTypeId) {
                const form = document.getElementById('deleteForm');
                form.action = `/admin/content-types/${contentTypeId}`;

                const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                modal.show();
            }
        </script> --}}

        <script>
            // Delete function - Exactly like ContentItem controller
            function deleteItem(itemId, itemTitle) {
                document.getElementById('deleteItemName').textContent = itemTitle;
                document.getElementById('deleteForm').action = `/admin/content-types/${itemId}`;

                new bootstrap.Modal(document.getElementById('deleteModal')).show();
            }

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
                }, 3000);
            }
        </script>
    @endpush
@endsection
