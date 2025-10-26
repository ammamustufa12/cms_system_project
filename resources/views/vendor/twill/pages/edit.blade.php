@extends('twill::layouts.main')

@section('appTypeClass', 'body--form')

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="page-content">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Edit Page: {{ $page->title }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pages.index') }}">Pages</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('pages.update', $page) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Main Content -->
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-edit-line me-2"></i>
                                            Page Content
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Title -->
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Page Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                                   id="title" name="title" value="{{ old('title', $page->title) }}" required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Slug -->
                                        <div class="mb-3">
                                            <label for="slug" class="form-label">Slug</label>
                                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                                   id="slug" name="slug" value="{{ old('slug', $page->slug) }}"
                                                   placeholder="Auto-generated from title">
                                            <div class="form-text">Leave empty to auto-generate from title</div>
                                            @error('slug')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Content -->
                                        <div class="mb-3">
                                            <label for="content" class="form-label">Page Content</label>
                                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                                      id="content" name="content" rows="15" 
                                                      placeholder="Write your page content here...">{{ old('content', $page->content) }}</textarea>
                                            @error('content')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Excerpt -->
                                        <div class="mb-3">
                                            <label for="excerpt" class="form-label">Excerpt</label>
                                            <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                                      id="excerpt" name="excerpt" rows="3" 
                                                      placeholder="Brief description of the page...">{{ old('excerpt', $page->excerpt) }}</textarea>
                                            <div class="form-text">Short description that appears in page listings</div>
                                            @error('excerpt')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="col-lg-4">
                                <!-- Publish Settings -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-settings-3-line me-2"></i>
                                            Publish Settings
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Status -->
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                                <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>Published</option>
                                                <option value="archived" {{ old('status', $page->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Homepage -->
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_homepage" name="is_homepage" value="1" 
                                                       {{ old('is_homepage', $page->is_homepage) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_homepage">
                                                    Set as Homepage
                                                </label>
                                            </div>
                                            <div class="form-text">This page will be displayed as the website homepage</div>
                                        </div>

                                        <!-- Sort Order -->
                                        <div class="mb-3">
                                            <label for="sort_order" class="form-label">Sort Order</label>
                                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $page->sort_order) }}" min="0">
                                            <div class="form-text">Lower numbers appear first</div>
                                            @error('sort_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Featured Image -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-image-line me-2"></i>
                                            Featured Image
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="featured_image" class="form-label">Image URL</label>
                                            <input type="url" class="form-control @error('featured_image') is-invalid @enderror" 
                                                   id="featured_image" name="featured_image" value="{{ old('featured_image', $page->featured_image) }}"
                                                   placeholder="https://example.com/image.jpg">
                                            @error('featured_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div id="imagePreview" class="text-center">
                                            @if($page->featured_image)
                                                <img id="previewImg" src="{{ $page->featured_image }}" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                            @else
                                                <div id="noImage" class="text-muted">
                                                    <i class="ri-image-line" style="font-size: 3rem;"></i>
                                                    <p>No image selected</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- SEO Settings -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-search-line me-2"></i>
                                            SEO Settings
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Meta Title -->
                                        <div class="mb-3">
                                            <label for="meta_title" class="form-label">Meta Title</label>
                                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                                   id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}"
                                                   placeholder="SEO title for search engines">
                                            @error('meta_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Meta Description -->
                                        <div class="mb-3">
                                            <label for="meta_description" class="form-label">Meta Description</label>
                                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                                      id="meta_description" name="meta_description" rows="3" 
                                                      placeholder="SEO description for search engines">{{ old('meta_description', $page->meta_description) }}</textarea>
                                            @error('meta_description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Page Info -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-information-line me-2"></i>
                                            Page Information
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <small class="text-muted">Created</small>
                                                <div>{{ $page->created_at->format('M d, Y') }}</div>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Updated</small>
                                                <div>{{ $page->updated_at->format('M d, Y') }}</div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div>
                                            <small class="text-muted">Page URL</small>
                                            <div>
                                                <a href="{{ $page->url }}" target="_blank" class="text-decoration-none">
                                                    {{ $page->url }} <i class="ri-external-link-line"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <a href="{{ route('pages.index') }}" class="btn btn-secondary me-2">
                                                    <i class="ri-arrow-left-line me-1"></i>
                                                    Back to Pages
                                                </a>
                                                <a href="{{ route('pages.preview', $page) }}" class="btn btn-outline-info me-2" target="_blank">
                                                    <i class="ri-eye-line me-1"></i>
                                                    Preview
                                                </a>
                                                
                                                <!-- Page Builder Buttons -->
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-tools-line me-1"></i>
                                                        Page Builders
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="{{ route('pages.page-builder', $page) }}">
                                                            <i class="ri-tools-line me-2"></i>Main Page Builder
                                                        </a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item" href="{{ route('pages.advanced-builder', $page) }}">
                                                            <i class="ri-code-s-slash-line me-2"></i>Advanced Builder
                                                        </a></li>
                                                        <li><a class="dropdown-item" href="{{ route('pages.professional-builder', $page) }}">
                                                            <i class="ri-palette-line me-2"></i>Professional Builder
                                                        </a></li>
                                                        <li><a class="dropdown-item" href="{{ route('pages.working-builder', $page) }}">
                                                            <i class="ri-hammer-line me-2"></i>Working Builder
                                                        </a></li>
                                                        <li><a class="dropdown-item" href="{{ route('pages.grapes-builder', $page) }}">
                                                            <i class="ri-grape-line me-2"></i>GrapesJS Builder
                                                        </a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div>
                                                <button type="submit" name="action" value="save" class="btn btn-primary me-2">
                                                    <i class="ri-save-line me-1"></i>
                                                    Update Page
                                                </button>
                                                <button type="submit" name="action" value="save_and_continue" class="btn btn-success">
                                                    <i class="ri-save-2-line me-1"></i>
                                                    Save & Continue
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-generate slug from title
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');
            
            titleInput.addEventListener('input', function() {
                if (!slugInput.value || slugInput.dataset.autoGenerated === 'true') {
                    const slug = this.value
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .trim('-');
                    slugInput.value = slug;
                    slugInput.dataset.autoGenerated = 'true';
                }
            });

            // Manual slug editing
            slugInput.addEventListener('input', function() {
                this.dataset.autoGenerated = 'false';
            });

            // Image preview
            const imageInput = document.getElementById('featured_image');
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const noImage = document.getElementById('noImage');

            imageInput.addEventListener('input', function() {
                if (this.value) {
                    previewImg.src = this.value;
                    previewImg.style.display = 'block';
                    if (noImage) noImage.style.display = 'none';
                } else {
                    previewImg.style.display = 'none';
                    if (noImage) noImage.style.display = 'block';
                }
            });

            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const title = document.getElementById('title').value.trim();
                if (!title) {
                    e.preventDefault();
                    alert('Please enter a page title.');
                    document.getElementById('title').focus();
                }
            });
        });
    </script>
@endsection
