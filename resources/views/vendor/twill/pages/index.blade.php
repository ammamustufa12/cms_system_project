@extends('twill::layouts.main')

@section('appTypeClass', 'body--listing')

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="page-content">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Pages Management</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pages</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Page Header -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="ri-pages-line me-2"></i>
                                All Pages ({{ $pages->total() }})
                            </h5>
                            <div class="btn-group">
                                <a href="{{ route('pages.create') }}" class="btn btn-primary">
                                    <i class="ri-add-line me-1"></i>
                                    Create New Page
                                </a>
                                <a href="{{ route('page.builder') }}" class="btn btn-success">
                                    <i class="ri-tools-line me-1"></i>
                                    Page Builder
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0">{{ $pages->total() }}</h4>
                                            <p class="mb-0">Total Pages</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="ri-file-text-line" style="font-size: 2rem; opacity: 0.7;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0">{{ $pages->where('status', 'published')->count() }}</h4>
                                            <p class="mb-0">Published</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="ri-eye-line" style="font-size: 2rem; opacity: 0.7;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0">{{ $pages->where('status', 'draft')->count() }}</h4>
                                            <p class="mb-0">Drafts</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="ri-draft-line" style="font-size: 2rem; opacity: 0.7;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0">{{ $pages->where('is_homepage', true)->count() }}</h4>
                                            <p class="mb-0">Homepage</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="ri-home-line" style="font-size: 2rem; opacity: 0.7;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pages List -->
                    <div class="card">
                        <div class="card-body p-0">
                            @if($pages->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 50px;">
                                                    <input type="checkbox" id="selectAllPages" class="form-check-input">
                                                </th>
                                                <th>Title</th>
                                                <th>Slug</th>
                                                <th>Status</th>
                                                <th>Homepage</th>
                                                <th>Sort Order</th>
                                                <th>Created</th>
                                                <th style="width: 200px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pages as $page)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input page-checkbox" value="{{ $page->id }}">
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if($page->featured_image)
                                                                <img src="{{ $page->featured_image }}" alt="{{ $page->title }}" 
                                                                     class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                            @else
                                                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                                                     style="width: 40px; height: 40px;">
                                                                    <i class="ri-file-text-line text-muted"></i>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <h6 class="mb-0">{{ $page->title }}</h6>
                                                                @if($page->excerpt)
                                                                    <small class="text-muted">{{ Str::limit($page->excerpt, 50) }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <code class="text-muted">{{ $page->slug }}</code>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{ $page->status_badge_class }}">
                                                            {{ ucfirst($page->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($page->is_homepage)
                                                            <span class="badge bg-primary">
                                                                <i class="ri-home-line me-1"></i>Homepage
                                                            </span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info">{{ $page->sort_order }}</span>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">
                                                            {{ $page->created_at->format('M d, Y') }}
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('pages.show', $page) }}" 
                                                               class="btn btn-outline-info btn-sm" title="View">
                                                                <i class="ri-eye-line"></i>
                                                            </a>
                                                            <a href="{{ route('pages.edit', $page) }}" 
                                                               class="btn btn-outline-primary btn-sm" title="Edit">
                                                                <i class="ri-edit-line"></i>
                                                            </a>
                                                            <a href="{{ route('pages.preview', $page) }}" 
                                                               class="btn btn-outline-success btn-sm" title="Preview" target="_blank">
                                                                <i class="ri-external-link-line"></i>
                                                            </a>
                                                            
                                                            <!-- Page Builder Dropdown -->
                                                            <div class="btn-group" role="group">
                                                                <button type="button" class="btn btn-outline-warning btn-sm dropdown-toggle" data-bs-toggle="dropdown" title="Page Builders">
                                                                    <i class="ri-tools-line"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item fw-bold" href="{{ route('pages.page-builder', $page) }}">
                                                                        <i class="ri-tools-line me-2 text-primary"></i>Elementor Style Builder
                                                                    </a></li>

                                                                </ul>
                                                            </div>
                                                            @if(!$page->is_homepage)
                                                                <form action="{{ route('pages.set-homepage', $page) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-outline-warning btn-sm" 
                                                                            title="Set as Homepage" 
                                                                            onclick="return confirm('Set this page as homepage?')">
                                                                        <i class="ri-home-line"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            <form action="{{ route('pages.toggle-status', $page) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-outline-{{ $page->status === 'published' ? 'warning' : 'success' }} btn-sm" 
                                                                        title="{{ $page->status === 'published' ? 'Unpublish' : 'Publish' }}">
                                                                    <i class="ri-{{ $page->status === 'published' ? 'eye-off-line' : 'eye-line' }}"></i>
                                                                </button>
                                                            </form>
                                                            @if(!$page->is_homepage)
                                                                <form action="{{ route('pages.destroy', $page) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                                            title="Delete" 
                                                                            onclick="return confirm('Are you sure you want to delete this page?')">
                                                                        <i class="ri-delete-bin-line"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="card-footer">
                                    {{ $pages->links() }}
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="ri-file-text-line" style="font-size: 4rem; color: #6c757d;"></i>
                                    </div>
                                    <h5 class="text-muted">No pages found</h5>
                                    <p class="text-muted">Get started by creating your first page or use the page builder.</p>
                                    <div class="btn-group">
                                        <a href="{{ route('pages.create') }}" class="btn btn-primary">
                                            <i class="ri-add-line me-1"></i>
                                            Create Your First Page
                                        </a>
                                        <a href="{{ route('page.builder') }}" class="btn btn-success">
                                            <i class="ri-tools-line me-1"></i>
                                            Use Page Builder
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select All functionality
            const selectAllCheckbox = document.getElementById('selectAllPages');
            const pageCheckboxes = document.querySelectorAll('.page-checkbox');

            selectAllCheckbox.addEventListener('change', function() {
                pageCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Individual checkbox change
            pageCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const checkedBoxes = document.querySelectorAll('.page-checkbox:checked');
                    selectAllCheckbox.checked = checkedBoxes.length === pageCheckboxes.length;
                    selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < pageCheckboxes.length;
                });
            });
        });
    </script>
@endsection
