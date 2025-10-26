@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Edit Data Type</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.data-types.index') }}">Data Types</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                        <h5 class="card-title mb-0">Edit Data Type: {{ $dataType->name }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.data-types.update', $dataType) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $dataType->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Data Type <span class="text-danger">*</span></label>
                                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                            <option value="text" {{ old('type', $dataType->type) == 'text' ? 'selected' : '' }}>Text</option>
                                            <option value="number" {{ old('type', $dataType->type) == 'number' ? 'selected' : '' }}>Number</option>
                                            <option value="date" {{ old('type', $dataType->type) == 'date' ? 'selected' : '' }}>Date</option>
                                            <option value="boolean" {{ old('type', $dataType->type) == 'boolean' ? 'selected' : '' }}>Boolean</option>
                                            <option value="email" {{ old('type', $dataType->type) == 'email' ? 'selected' : '' }}>Email</option>
                                            <option value="select" {{ old('type', $dataType->type) == 'select' ? 'selected' : '' }}>Select</option>
                                            <option value="textarea" {{ old('type', $dataType->type) == 'textarea' ? 'selected' : '' }}>Textarea</option>
                                            <option value="file" {{ old('type', $dataType->type) == 'file' ? 'selected' : '' }}>File</option>
                                            <option value="image" {{ old('type', $dataType->type) == 'image' ? 'selected' : '' }}>Image</option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3">{{ old('description', $dataType->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="is_required" class="form-label">Required Field</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_required" name="is_required" 
                                                   value="1" {{ old('is_required', $dataType->is_required) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_required">
                                                This field is required
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="default_value" class="form-label">Default Value</label>
                                        <input type="text" class="form-control @error('default_value') is-invalid @enderror" 
                                               id="default_value" name="default_value" value="{{ old('default_value', $dataType->default_value) }}">
                                        @error('default_value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                            <option value="active" {{ old('status', $dataType->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $dataType->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="sort_order" class="form-label">Sort Order</label>
                                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                               id="sort_order" name="sort_order" value="{{ old('sort_order', $dataType->sort_order) }}" min="0">
                                        @error('sort_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="{{ route('admin.data-types.show', $dataType) }}" class="btn btn-info">
                                        <i class="ri-eye-line me-1"></i> View
                                    </a>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.data-types.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-save-line me-1"></i> Update Data Type
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection









