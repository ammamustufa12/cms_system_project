@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Data Types</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Types</li>
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
                            <i class="ri-database-2-line fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ $dataTypes->total() }}</h4>
                            <small class="text-muted">Total Data Types</small>
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
                            <h4 class="mb-0">{{ $dataTypes->where('status', 'active')->count() }}</h4>
                            <small class="text-muted">Active</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Types Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Data Types List</h5>
                            <a href="{{ route('admin.data-types.create') }}" class="btn btn-primary">
                                <i class="ri-add-line me-1"></i> Add Data Type
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
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Required</th>
                                        <th>Status</th>
                                        <th>Sort Order</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dataTypes as $dataType)
                                    <tr>
                                        <td>{{ $dataType->id }}</td>
                                        <td>{{ $dataType->name }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ ucfirst($dataType->type) }}</span>
                                        </td>
                                        <td>
                                            @if($dataType->is_required)
                                                <span class="badge bg-danger">Required</span>
                                            @else
                                                <span class="badge bg-secondary">Optional</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $dataType->status == 'active' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($dataType->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $dataType->sort_order }}</td>
                                        <td>{{ $dataType->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.data-types.show', $dataType) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('admin.data-types.edit', $dataType) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <form action="{{ route('admin.data-types.destroy', $dataType) }}" method="POST" class="d-inline" id="delete-form-{{ $dataType->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $dataType->id }}, '{{ addslashes($dataType->name) }}')">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                                
                                                <!-- Alternative delete method without JavaScript -->
                                                <form action="{{ route('admin.data-types.destroy', $dataType) }}" method="POST" class="d-inline" style="display: none;" id="delete-form-alt-{{ $dataType->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="ri-database-2-line fa-3x mb-3"></i>
                                                <p>No data types found. <a href="{{ route('admin.data-types.create') }}">Create your first data type</a></p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($dataTypes->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $dataTypes->links() }}
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
                        <h5 class="card-title mb-3">Next Step: Create User Profiles</h5>
                        <p class="text-muted mb-4">Now that you have data types defined, let's create user profiles that will use these data structures.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('admin.profiles.index') }}" class="btn btn-primary">
                                <i class="ri-user-line me-1"></i> Manage Profiles
                            </a>
                            <a href="{{ route('admin.profiles.create') }}" class="btn btn-outline-primary">
                                <i class="ri-add-line me-1"></i> Create Profile
                            </a>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="ri-information-line me-1"></i>
                                Profiles define user types and their associated data fields.
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
function confirmDelete(dataTypeId, dataTypeName) {
    console.log('Delete clicked for data type:', dataTypeId, dataTypeName);
    
    if (confirm(`Are you sure you want to delete "${dataTypeName}"? This action cannot be undone.`)) {
        console.log('User confirmed deletion');
        
        // Try main form first
        let form = document.getElementById('delete-form-' + dataTypeId);
        console.log('Main form found:', form);
        
        if (!form) {
            // Try alternative form
            form = document.getElementById('delete-form-alt-' + dataTypeId);
            console.log('Alternative form found:', form);
        }
        
        if (form) {
            console.log('Submitting form...');
            form.submit();
        } else {
            console.error('No form found for data type ID:', dataTypeId);
            alert('Error: Form not found. Please try again.');
        }
    } else {
        console.log('User cancelled deletion');
    }
}

// Fallback: Direct form submission if JavaScript fails
function directDelete(dataTypeId) {
    const form = document.getElementById('delete-form-alt-' + dataTypeId);
    if (form) {
        form.submit();
    }
}
</script>
@endpush
