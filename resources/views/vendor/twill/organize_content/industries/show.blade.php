@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Industry Details</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.industries.index') }}">Industries</a></li>
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
                                @if($industry->icon)
                                    <i class="{{ $industry->icon }} me-2" style="color: {{ $industry->color }}"></i>
                                @endif
                                {{ $industry->name }}
                            </h5>
                            <div class="btn-group">
                                <a href="{{ route('admin.industries.edit', $industry) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-edit-line me-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.industries.destroy', $industry) }}" method="POST" class="d-inline" id="delete-form-show">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteShow('{{ $industry->name }}')">
                                        <i class="ri-delete-bin-line me-1"></i> Delete
                                    </button>
                                </form>
                                <a href="{{ route('admin.industries.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="ri-arrow-left-line me-1"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold" style="width: 150px;">ID:</td>
                                        <td>{{ $industry->id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Name:</td>
                                        <td>{{ $industry->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Slug:</td>
                                        <td><code>{{ $industry->slug }}</code></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Status:</td>
                                        <td>
                                            <span class="badge bg-{{ $industry->status == 'active' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($industry->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Sort Order:</td>
                                        <td>{{ $industry->sort_order }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Created:</td>
                                        <td>{{ $industry->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Updated:</td>
                                        <td>{{ $industry->updated_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                @if($industry->icon || $industry->color)
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Visual Settings</h6>
                                        @if($industry->icon)
                                            <div class="mb-3">
                                                <i class="{{ $industry->icon }} fa-3x" style="color: {{ $industry->color ?: '#007bff' }}"></i>
                                            </div>
                                        @endif
                                        @if($industry->color)
                                            <div class="mb-2">
                                                <strong>Color:</strong>
                                                <span class="badge" style="background-color: {{ $industry->color }}; color: white;">
                                                    {{ $industry->color }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        @if($industry->description)
                        <div class="mt-4">
                            <h6 class="fw-bold">Description:</h6>
                            <div class="bg-light p-3 rounded">
                                {{ $industry->description }}
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
function confirmDeleteShow(industryName) {
    if (confirm(`Are you sure you want to delete "${industryName}"? This action cannot be undone.`)) {
        document.getElementById('delete-form-show').submit();
    }
}
</script>
@endpush
