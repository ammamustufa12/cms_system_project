@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Categories</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Categories</li>
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
                            <i class="ri-folder-line fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ $categories->total() }}</h4>
                            <small class="text-muted">Total Categories</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-success text-white rounded-3 p-3 me-3">
                            <i class="ri-eye-line fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ $categories->where('is_active', true)->count() }}</h4>
                            <small class="text-muted">Active</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-info text-white rounded-3 p-3 me-3">
                            <i class="ri-folder-open-line fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ $categories->whereNull('parent_id')->count() }}</h4>
                            <small class="text-muted">Root Categories</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-warning text-white rounded-3 p-3 me-3">
                            <i class="ri-folder-2-line fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ $categories->whereNotNull('parent_id')->count() }}</h4>
                            <small class="text-muted">Sub Categories</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Categories List</h5>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                <i class="ri-add-line me-1"></i> Add Category
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Search and Filters -->
                        <form method="GET" class="row mb-4">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-search-line"></i></span>
                                    <input type="text" class="form-control" name="search" placeholder="Search categories..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="category_group_id">
                                    <option value="">All Category Groups</option>
                                    @foreach($categoryGroups as $group)
                                        <option value="{{ $group->id }}" {{ request('category_group_id') == $group->id ? 'selected' : '' }}>
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="parent_id">
                                    <option value="">All Parent Categories</option>
                                    @foreach($parentCategories as $parent)
                                        <option value="{{ $parent->id }}" {{ request('parent_id') == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="status">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-search-line"></i> Filter
                                    </button>
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                                        <i class="ri-refresh-line"></i>
                                    </a>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Category Group</th>
                                        <th>Parent</th>
                                        <th>Children</th>
                                        <th>Status</th>
                                        <th>Sort Order</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories as $category)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($category->icon)
                                                    <i class="{{ $category->icon }} me-2" style="color: {{ $category->color }};"></i>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $category->name }}</h6>
                                                    <small class="text-muted">{{ $category->slug }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $category->categoryGroup->name }}</span>
                                        </td>
                                        <td>
                                            @if($category->parent)
                                                <span class="text-muted">{{ $category->parent->name }}</span>
                                            @else
                                                <span class="text-muted">Root Category</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $category->children_count }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">
                                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $category->sort_order }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-{{ $category->is_active ? 'warning' : 'success' }}" 
                                                            title="{{ $category->is_active ? 'Deactivate' : 'Activate' }}">
                                                        <i class="ri-{{ $category->is_active ? 'pause' : 'play' }}-line"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" id="delete-form-{{ $category->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $category->id }}, '{{ addslashes($category->name) }}')">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="ri-folder-line fa-3x mb-3"></i>
                                                <p>No categories found. <a href="{{ route('admin.categories.create') }}">Create your first category</a></p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($categories->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $categories->appends(request()->query())->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Next Steps Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm bg-gradient">
                    <div class="card-body text-center py-4">
                        <h5 class="card-title mb-3">Next Step: Manage Categories</h5>
                        <p class="text-muted mb-4">Now that you have categories set up, you can create more categories or manage your existing ones.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                <i class="ri-add-line me-1"></i> Create Category
                            </a>
                            <a href="{{ route('admin.category-groups.index') }}" class="btn btn-outline-primary">
                                <i class="ri-folder-settings-line me-1"></i> Manage Category Groups
                            </a>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="ri-information-line me-1"></i>
                                Categories help organize and structure your content for better management.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(categoryId, categoryName) {
    console.log('Delete clicked for category:', categoryId, categoryName);
    
    if (confirm(`Are you sure you want to delete "${categoryName}"? This action cannot be undone.`)) {
        console.log('User confirmed deletion');
        const form = document.getElementById('delete-form-' + categoryId);
        console.log('Form found:', form);
        
        if (form) {
            console.log('Submitting form...');
            form.submit();
        } else {
            console.error('Form not found for category ID:', categoryId);
            alert('Error: Form not found. Please try again.');
        }
    } else {
        console.log('User cancelled deletion');
    }
}
</script>
@endpush
