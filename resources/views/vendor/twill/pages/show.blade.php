@extends('twill::layouts.main')

@section('appTypeClass', 'body--form')

@section('content')
    <div class="page-content">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">View Page: {{ $page->title }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pages.index') }}">Pages</a></li>
                            <li class="breadcrumb-item active">View</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <!-- Main Content -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-file-text-line me-2"></i>
                                        Page Content
                                    </h5>
                                    <div>
                                        <a href="{{ route('pages.edit', $page) }}" class="btn btn-primary btn-sm">
                                            <i class="ri-edit-line me-1"></i>
                                            Edit Page
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h1 class="mb-3">{{ $page->title }}</h1>
                                    
                                    @if($page->excerpt)
                                        <div class="alert alert-info">
                                            <strong>Excerpt:</strong> {{ $page->excerpt }}
                                        </div>
                                    @endif

                                    @if($page->featured_image)
                                        <div class="mb-4">
                                            <img src="{{ $page->featured_image }}" alt="{{ $page->title }}" class="img-fluid rounded">
                                        </div>
                                    @endif

                                    <div class="content">
                                        {!! nl2br(e($page->content)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            <!-- Page Info -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-information-line me-2"></i>
                                        Page Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <small class="text-muted">Status</small>
                                            <div>
                                                <span class="badge bg-{{ $page->status_badge_class }}">
                                                    {{ ucfirst($page->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Homepage</small>
                                            <div>
                                                @if($page->is_homepage)
                                                    <span class="badge bg-primary">
                                                        <i class="ri-home-line me-1"></i>Yes
                                                    </span>
                                                @else
                                                    <span class="text-muted">No</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <small class="text-muted">Slug</small>
                                            <div><code>{{ $page->slug }}</code></div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Sort Order</small>
                                            <div><span class="badge bg-info">{{ $page->sort_order }}</span></div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <small class="text-muted">Created</small>
                                            <div>{{ $page->created_at->format('M d, Y H:i') }}</div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Updated</small>
                                            <div>{{ $page->updated_at->format('M d, Y H:i') }}</div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="mb-3">
                                        <small class="text-muted">Page URL</small>
                                        <div>
                                            <a href="{{ $page->url }}" target="_blank" class="text-decoration-none">
                                                {{ $page->url }} <i class="ri-external-link-line"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SEO Info -->
                            @if($page->meta_title || $page->meta_description)
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-search-line me-2"></i>
                                            SEO Information
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        @if($page->meta_title)
                                            <div class="mb-3">
                                                <small class="text-muted">Meta Title</small>
                                                <div>{{ $page->meta_title }}</div>
                                            </div>
                                        @endif

                                        @if($page->meta_description)
                                            <div class="mb-3">
                                                <small class="text-muted">Meta Description</small>
                                                <div>{{ $page->meta_description }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-settings-3-line me-2"></i>
                                        Actions
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('pages.edit', $page) }}" class="btn btn-primary">
                                            <i class="ri-edit-line me-1"></i>
                                            Edit Page
                                        </a>
                                        
                                        <a href="{{ route('pages.preview', $page) }}" class="btn btn-outline-info" target="_blank">
                                            <i class="ri-eye-line me-1"></i>
                                            Preview Page
                                        </a>

                                        <form action="{{ route('pages.toggle-status', $page) }}" method="POST" class="d-grid">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-{{ $page->status === 'published' ? 'warning' : 'success' }}">
                                                <i class="ri-{{ $page->status === 'published' ? 'eye-off-line' : 'eye-line' }} me-1"></i>
                                                {{ $page->status === 'published' ? 'Unpublish' : 'Publish' }}
                                            </button>
                                        </form>

                                        @if(!$page->is_homepage)
                                            <form action="{{ route('pages.set-homepage', $page) }}" method="POST" class="d-grid">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-warning" 
                                                        onclick="return confirm('Set this page as homepage?')">
                                                    <i class="ri-home-line me-1"></i>
                                                    Set as Homepage
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('pages.index') }}" class="btn btn-outline-secondary">
                                            <i class="ri-arrow-left-line me-1"></i>
                                            Back to Pages
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
