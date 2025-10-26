@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Category Groups</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Category Groups</li>
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
                            <h4 class="mb-0">{{ $categoryGroups->total() }}</h4>
                            <small class="text-muted">Total Groups</small>
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
                            <h4 class="mb-0">{{ $categoryGroups->where('is_active', true)->count() }}</h4>
                            <small class="text-muted">Active</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Groups Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Category Groups List</h5>
                            <a href="{{ route('admin.category-groups.create') }}" class="btn btn-primary">
                                <i class="ri-add-line me-1"></i> Add Category Group
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

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Categories Count</th>
                                        <th>Status</th>
                                        <th>Sort Order</th>
                                        <th>Color</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categoryGroups as $group)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($group->icon)
                                                    <i class="{{ $group->icon }} me-2" style="color: {{ $group->color }}"></i>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $group->name }}</h6>
                                                    <small class="text-muted">{{ $group->slug }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ Str::limit($group->description ?: 'No description', 50) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $group->categories_count }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $group->is_active ? 'success' : 'secondary' }}">
                                                {{ $group->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $group->sort_order }}</td>
                                        <td>
                                            @if($group->color)
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle me-2" style="width: 20px; height: 20px; background-color: {{ $group->color }};"></div>
                                                    <span class="text-muted">{{ $group->color }}</span>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.category-groups.show', $group) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('admin.category-groups.edit', $group) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <form action="{{ route('admin.category-groups.toggle-status', $group) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-{{ $group->is_active ? 'warning' : 'success' }}" 
                                                            title="{{ $group->is_active ? 'Deactivate' : 'Activate' }}">
                                                        <i class="ri-{{ $group->is_active ? 'pause' : 'play' }}-line"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.category-groups.destroy', $group) }}" method="POST" class="d-inline" id="delete-form-{{ $group->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $group->id }}, '{{ addslashes($group->name) }}')">
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
                                                <p>No category groups found. <a href="{{ route('admin.category-groups.create') }}">Create your first category group</a></p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($categoryGroups->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $categoryGroups->links() }}
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
                        <p class="text-muted mb-4">Now that you have category groups set up, let's create categories within these groups.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
                                <i class="ri-list-check me-1"></i> Manage Categories
                            </a>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary">
                                <i class="ri-add-line me-1"></i> Create Category
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
function confirmDelete(groupId, groupName) {
    console.log('Delete clicked for category group:', groupId, groupName);
    
    if (confirm(`Are you sure you want to delete "${groupName}"? This action cannot be undone.`)) {
        console.log('User confirmed deletion');
        const form = document.getElementById('delete-form-' + groupId);
        console.log('Form found:', form);
        
        if (form) {
            console.log('Submitting form...');
            form.submit();
        } else {
            console.error('Form not found for category group ID:', groupId);
            alert('Error: Form not found. Please try again.');
        }
    } else {
        console.log('User cancelled deletion');
    }
}
</script>
@endpush









