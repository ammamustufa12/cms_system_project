@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Category Details</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
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
                                @if($category->icon)
                                    <i class="{{ $category->icon }} me-2" style="color: {{ $category->color }}"></i>
                                @endif
                                {{ $category->name }}
                            </h5>
                            <div class="btn-group">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-edit-line me-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" id="delete-form-show">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteShow('{{ $category->name }}')">
                                        <i class="ri-delete-bin-line me-1"></i> Delete
                                    </button>
                                </form>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">
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
                                        <td>{{ $category->id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Name:</td>
                                        <td>{{ $category->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Slug:</td>
                                        <td><code>{{ $category->slug }}</code></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Category Group:</td>
                                        <td>
                                            <span class="badge bg-info">{{ $category->categoryGroup->name }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Parent Category:</td>
                                        <td>
                                            @if($category->parent)
                                                <span class="text-muted">{{ $category->parent->name }}</span>
                                            @else
                                                <span class="text-muted">Root Category</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Children Count:</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $category->children_count }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Status:</td>
                                        <td>
                                            <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">
                                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Sort Order:</td>
                                        <td>{{ $category->sort_order }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Created:</td>
                                        <td>{{ $category->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Updated:</td>
                                        <td>{{ $category->updated_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                @if($category->icon || $category->color)
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Visual Settings</h6>
                                        @if($category->icon)
                                            <div class="mb-3">
                                                <i class="{{ $category->icon }} fa-3x" style="color: {{ $category->color ?: '#007bff' }}"></i>
                                            </div>
                                        @endif
                                        @if($category->color)
                                            <div class="mb-2">
                                                <strong>Color:</strong>
                                                <span class="badge" style="background-color: {{ $category->color }}; color: white;">
                                                    {{ $category->color }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        @if($category->description)
                        <div class="mt-4">
                            <h6 class="fw-bold">Description:</h6>
                            <div class="bg-light p-3 rounded">
                                {{ $category->description }}
                            </div>
                        </div>
                        @endif

                        @if($category->meta_title || $category->meta_description || $category->meta_keywords)
                        <div class="mt-4">
                            <h6 class="fw-bold">SEO Information:</h6>
                            <div class="bg-light p-3 rounded">
                                @if($category->meta_title)
                                    <div class="mb-2">
                                        <strong>Meta Title:</strong> {{ $category->meta_title }}
                                    </div>
                                @endif
                                @if($category->meta_description)
                                    <div class="mb-2">
                                        <strong>Meta Description:</strong> {{ $category->meta_description }}
                                    </div>
                                @endif
                                @if($category->meta_keywords)
                                    <div class="mb-2">
                                        <strong>Meta Keywords:</strong> {{ $category->meta_keywords }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if($category->children && $category->children->count() > 0)
                        <div class="mt-4">
                            <h6 class="fw-bold">Sub Categories:</h6>
                            <div class="row">
                                @foreach($category->children as $child)
                                <div class="col-md-6 mb-2">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body py-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>{{ $child->name }}</span>
                                                <span class="badge bg-{{ $child->is_active ? 'success' : 'secondary' }}">
                                                    {{ $child->is_active ? 'Active' : 'Inactive' }}
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
function confirmDeleteShow(categoryName) {
    if (confirm(`Are you sure you want to delete "${categoryName}"? This action cannot be undone.`)) {
        document.getElementById('delete-form-show').submit();
    }
}
</script>
@endpush









