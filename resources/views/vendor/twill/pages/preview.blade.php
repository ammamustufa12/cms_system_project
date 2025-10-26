<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->meta_title ?: $page->title }}</title>
    
    @if($page->meta_description)
        <meta name="description" content="{{ $page->meta_description }}">
    @endif

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
        }
        .preview-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 1rem 0;
            margin-bottom: 2rem;
        }
        .preview-actions {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        .content {
            max-width: 800px;
            margin: 0 auto;
        }
        .featured-image {
            max-height: 400px;
            object-fit: cover;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Preview Actions -->
    <div class="preview-actions">
        <div class="btn-group" role="group">
            <a href="{{ route('pages.edit', $page) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('pages.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Preview Header -->
    <div class="preview-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Page Preview</h4>
                            <small class="text-muted">{{ $page->title }}</small>
                        </div>
                        <div>
                            <span class="badge bg-{{ $page->status === 'published' ? 'success' : 'warning' }}">
                                {{ ucfirst($page->status) }}
                            </span>
                            @if($page->is_homepage)
                                <span class="badge bg-primary ms-1">
                                    <i class="bi bi-house"></i> Homepage
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="container">
        <div class="content">
            <article>
                <header class="mb-4">
                    <h1 class="display-4">{{ $page->title }}</h1>
                    
                    @if($page->excerpt)
                        <p class="lead text-muted">{{ $page->excerpt }}</p>
                    @endif

                    @if($page->featured_image)
                        <div class="mb-4">
                            <img src="{{ $page->featured_image }}" alt="{{ $page->title }}" class="featured-image rounded">
                        </div>
                    @endif
                </header>

                <div class="content-body">
                    {!! nl2br(e($page->content)) !!}
                </div>
            </article>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-5 py-4 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="text-muted mb-0">
                        <small>
                            This is a preview of your page. 
                            <a href="{{ route('pages.edit', $page) }}" class="text-decoration-none">Edit this page</a> 
                            or 
                            <a href="{{ route('pages.index') }}" class="text-decoration-none">go back to pages</a>.
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
