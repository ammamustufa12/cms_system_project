@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Profiles</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profiles</li>
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
                            <i class="ri-user-line fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ $profiles->total() }}</h4>
                            <small class="text-muted">Total Profiles</small>
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
                            <h4 class="mb-0">{{ $profiles->where('status', 'active')->count() }}</h4>
                            <small class="text-muted">Active</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profiles Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Profiles List</h5>
                            <a href="{{ route('admin.profiles.create') }}" class="btn btn-primary">
                                <i class="ri-add-line me-1"></i> Add Profile
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
                                        <th>ID</th>
                                        <th>Avatar</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Sort Order</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($profiles as $profile)
                                    <tr>
                                        <td>{{ $profile->id }}</td>
                                        <td>
                                            @if($profile->avatar)
                                                <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Avatar" class="rounded-circle" width="40" height="40">
                                            @else
                                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="ri-user-line text-white"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $profile->name }}</td>
                                        <td>{{ $profile->email ?: 'N/A' }}</td>
                                        <td>{{ $profile->phone ?: 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $profile->status == 'active' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($profile->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $profile->sort_order }}</td>
                                        <td>{{ $profile->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.profiles.show', $profile) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('admin.profiles.edit', $profile) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <form action="{{ route('admin.profiles.destroy', $profile) }}" method="POST" class="d-inline" id="delete-form-{{ $profile->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $profile->id }}, '{{ addslashes($profile->name) }}')">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="ri-user-line fa-3x mb-3"></i>
                                                <p>No profiles found. <a href="{{ route('admin.profiles.create') }}">Create your first profile</a></p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($profiles->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $profiles->links() }}
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
                        <h5 class="card-title mb-3">Next Step: Organize Content with Categories</h5>
                        <p class="text-muted mb-4">Now that you have profiles set up, let's organize your content with category groups and categories.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('admin.category-groups.index') }}" class="btn btn-primary">
                                <i class="ri-folder-line me-1"></i> Manage Category Groups
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary">
                                <i class="ri-list-check me-1"></i> Manage Categories
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
function confirmDelete(profileId, profileName) {
    console.log('Delete clicked for profile:', profileId, profileName);
    
    if (confirm(`Are you sure you want to delete "${profileName}"? This action cannot be undone.`)) {
        console.log('User confirmed deletion');
        const form = document.getElementById('delete-form-' + profileId);
        console.log('Form found:', form);
        
        if (form) {
            console.log('Submitting form...');
            form.submit();
        } else {
            console.error('Form not found for profile ID:', profileId);
            alert('Error: Form not found. Please try again.');
        }
    } else {
        console.log('User cancelled deletion');
    }
}
</script>
@endpush
