@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Industries</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Industries</li>
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
                            <i class="ri-building-line fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ $industries->total() }}</h4>
                            <small class="text-muted">Total Industries</small>
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
                            <h4 class="mb-0">{{ $industries->where('status', 'active')->count() }}</h4>
                            <small class="text-muted">Active</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Industries Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Industries List</h5>
                            <a href="{{ route('admin.industries.create') }}" class="btn btn-primary">
                                <i class="ri-add-line me-1"></i> Add Industry
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

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Sort Order</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($industries as $industry)
                                    <tr>
                                        <td>{{ $industry->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($industry->icon)
                                                    <i class="{{ $industry->icon }} me-2" style="color: {{ $industry->color }}"></i>
                                                @endif
                                                {{ $industry->name }}
                                            </div>
                                        </td>
                                        <td>{{ Str::limit($industry->description, 50) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $industry->status == 'active' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($industry->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $industry->sort_order }}</td>
                                        <td>{{ $industry->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.industries.show', $industry) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('admin.industries.edit', $industry) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                {{-- <form action="{{ route('admin.industries.destroy', $industry) }}" method="POST" class="d-inline" id="delete-form-{{ $industry->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $industry->id }}, '{{ addslashes($industry->name) }}')">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form> --}}
                                                
                                                <!-- Test delete button (remove after testing) -->
                                                <form action="{{ route('admin.industries.destroy', $industry) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Test delete - Are you sure?')">
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
                                                <i class="ri-building-line fa-3x mb-3"></i>
                                                <p>No industries found. <a href="{{ route('admin.industries.create') }}">Create your first industry</a></p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($industries->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $industries->links() }}
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
                        <h5 class="card-title mb-3">Next Step: Define Data Types</h5>
                        <p class="text-muted mb-4">Now that you have industries set up, let's define the data types that will be used across your system.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('admin.data-types.index') }}" class="btn btn-primary">
                                <i class="ri-database-2-line me-1"></i> Manage Data Types
                            </a>
                            <a href="{{ route('admin.data-types.create') }}" class="btn btn-outline-primary">
                                <i class="ri-add-line me-1"></i> Create Data Type
                            </a>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="ri-information-line me-1"></i>
                                Data types define the structure and validation rules for your content fields.
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
function confirmDelete(industryId, industryName) {
    console.log('Delete clicked for industry:', industryId, industryName);
    
    if (confirm(`Are you sure you want to delete "${industryName}"? This action cannot be undone.`)) {
        console.log('User confirmed deletion');
        
        // Try main form first
        let form = document.getElementById('delete-form-' + industryId);
        console.log('Main form found:', form);
        
        if (!form) {
            // Try alternative form
            form = document.getElementById('delete-form-alt-' + industryId);
            console.log('Alternative form found:', form);
        }
        
        if (form) {
            console.log('Submitting form...');
            form.submit();
        } else {
            console.error('No form found for industry ID:', industryId);
            alert('Error: Form not found. Please try again.');
        }
    } else {
        console.log('User cancelled deletion');
    }
}

// Fallback: Direct form submission if JavaScript fails
function directDelete(industryId) {
    const form = document.getElementById('delete-form-alt-' + industryId);
    if (form) {
        form.submit();
    }
}
</script>
@endpush
