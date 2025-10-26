@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Category Group Details</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.category-groups.index') }}">Category Groups</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                @if($categoryGroup->icon)
                                    <i class="{{ $categoryGroup->icon }} me-2" style="color: {{ $categoryGroup->color }}"></i>
                                @endif
                                {{ $categoryGroup->name }}
                            </h5>
                            <div class="btn-group">
                                <a href="{{ route('admin.category-groups.edit', $categoryGroup) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-edit-line me-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.category-groups.destroy', $categoryGroup) }}" method="POST" class="d-inline" id="delete-form-show">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteShow('{{ $categoryGroup->name }}')">
                                        <i class="ri-delete-bin-line me-1"></i> Delete
                                    </button>
                                </form>
                                <a href="{{ route('admin.category-groups.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="ri-arrow-left-line me-1"></i> Back
                                </a>
                            </div>
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

                        <div class="row">
                            <div class="col-md-8">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold" style="width: 150px;">ID:</td>
                                        <td>{{ $categoryGroup->id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Name:</td>
                                        <td>{{ $categoryGroup->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Slug:</td>
                                        <td><code>{{ $categoryGroup->slug }}</code></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Status:</td>
                                        <td>
                                            <span class="badge bg-{{ $categoryGroup->is_active ? 'success' : 'secondary' }}">
                                                {{ $categoryGroup->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Sort Order:</td>
                                        <td>{{ $categoryGroup->sort_order }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Categories Count:</td>
                                        <td>
                                            <span class="badge bg-info">{{ $categoryGroup->categories_count }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Created:</td>
                                        <td>{{ $categoryGroup->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Updated:</td>
                                        <td>{{ $categoryGroup->updated_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                @if($categoryGroup->icon || $categoryGroup->color)
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Visual Settings</h6>
                                        @if($categoryGroup->icon)
                                            <div class="mb-3">
                                                <i class="{{ $categoryGroup->icon }} fa-3x" style="color: {{ $categoryGroup->color ?: '#007bff' }}"></i>
                                            </div>
                                        @endif
                                        @if($categoryGroup->color)
                                            <div class="mb-2">
                                                <strong>Color:</strong>
                                                <span class="badge" style="background-color: {{ $categoryGroup->color }}; color: white;">
                                                    {{ $categoryGroup->color }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        @if($categoryGroup->description)
                        <div class="mt-4">
                            <h6 class="fw-bold">Description:</h6>
                            <div class="bg-light p-3 rounded">
                                {{ $categoryGroup->description }}
                            </div>
                        </div>
                        @endif

                        @if($categoryGroup->categories && $categoryGroup->categories->count() > 0)
                        <div class="mt-4">
                            <h6 class="fw-bold">Categories in this group:</h6>
                            <div class="row">
                                @foreach($categoryGroup->categories as $category)
                                <div class="col-md-6 mb-2">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body py-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>{{ $category->name }}</span>
                                                <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">
                                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDeleteShow(categoryGroupName) {
    if (confirm(`Are you sure you want to delete "${categoryGroupName}"? This action cannot be undone.`)) {
        document.getElementById('delete-form-show').submit();
    }
}
</script>
@endpush









