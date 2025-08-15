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
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list-ul me-2"></i>Content Types
                        </h5>
                        <div>
                            <a href="{{ route('content-types.create') }}" class="btn btn-primary me-2">
                                {{-- <i class="fas fa-eye me-1"></i> --}}
                                Add
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Content Type</th>
                                        <th width="400">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="fieldsTableBody">
                                    @foreach ($contentTypes as $fieldKey => $contentType)
                                        <tr data-field-key="{{ $fieldKey }}">
                                            <td>
                                                <h5 class="fw-bold">
                                                    {{ $contentType->name }}
                                                </h5>
                                                <p>
                                                    {{ $contentType->description }}
                                                </p>
                                            </td>
                                            <td>
                                                <div class="flex text-capitalize">
                                                    <a href="{{ route('content-types.content-items.index', ['contentType' => $contentType->slug]) }}"
                                                        class="btn btn-primary">add</a>
                                                    <a href="{{ route('content-types.manage-fields', $contentType->slug) }}"
                                                        class="btn btn-success">Manage Fields</a>
                                                    <a href="{{ route('content-types.edit', $contentType->slug) }}"
                                                        class="btn btn-warning">Edit</a>
                                                    <button class="btn btn-danger"
                                                        onclick="deleteItem({{ $contentType->id }}, '{{ $contentType->name }}')"
                                                        title="Delete">
                                                        <i class="fas fa-trash"></i>Delete
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
