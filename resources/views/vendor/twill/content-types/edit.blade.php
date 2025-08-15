@extends('twill::layouts.main')

@section('content')
    <div class="page-content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Edit Content Types</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('content-types.index') }}">Content Type</a></li>
                            <li class="breadcrumb-item active">Edit Content Types</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <form action="{{ route('content-types.update', $contentType) }}" method="POST" id="contentTypeForm">
                @csrf
                @method('PUT')
                <!-- Header -->

                <div class="row">
                    <!-- Left Column: Basic Info -->
                    <div class="col-lg-12">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                            </div>
                            <div class="card-body">
                                <!-- Name Field -->
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold">Content Type Name *</label>
                                    <input type="text"
                                        class="generate-slug form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $contentType->name) }}"
                                        placeholder="e.g., Blog Posts, Team Members" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Slug Field -->
                                <div class="mb-3">
                                    <label for="slug" class="form-label fw-bold">Slug</label>
                                    <input type="text"
                                        class="slug-input form-control @error('slug') is-invalid @enderror" id="slug"
                                        name="slug" value="{{ old('slug', $contentType->slug) }}"
                                        placeholder="Auto-generated from name">
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">URL-friendly version (auto-generated if empty)</div>
                                </div>

                                <!-- Description Field -->
                                <div class="mb-3">
                                    <label for="description" class="form-label fw-bold">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="4" placeholder="Describe what this content type is used for">{{ old('description', $contentType->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label fw-bold">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" name="status">
                                        <option value="active"
                                            {{ old('status', (string) $contentType->status) == 'active' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="inactive"
                                            {{ old('status', (string) $contentType->status) == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>

                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
