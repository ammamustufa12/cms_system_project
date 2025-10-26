{{-- resources/views/vendor/twill/content-types/preview-layout.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $contentType->name }} - Layout Preview</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS from template -->
    <style>
        {!! $css !!}

        /* Additional preview styles */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .preview-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 1rem 0;
            margin-bottom: 2rem;
        }

        .preview-badge {
            display: inline-block;
            background: #6f42c1;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .field-wrapper {
            margin-bottom: 1.5rem;
            padding: 1rem;
            border-left: 4px solid #0d6efd;
            background: #f8f9fa;
            border-radius: 0 0.375rem 0.375rem 0;
        }

        .field-wrapper label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .field-value,
        .field-content {
            color: #212529;
            margin: 0;
        }

        .field-image {
            max-width: 100%;
            height: auto;
            border-radius: 0.375rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .gallery-item {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 0.375rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: transform 0.2s ease;
        }

        .gallery-item:hover {
            transform: scale(1.02);
        }

        .field-date {
            color: #6c757d;
            font-family: 'Monaco', 'Consolas', monospace;
        }

        .field-number {
            font-weight: 600;
            color: #198754;
        }

        .field-selection {
            background: #e9ecef;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }

        .field-checkbox {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .field-checkbox span {
            background: #d1ecf1;
            color: #0c5460;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }

        /* Sample data indicators */
        .sample-indicator {
            position: relative;
        }

        .sample-indicator::after {
            content: "Sample Data";
            position: absolute;
            top: -0.5rem;
            right: -0.5rem;
            background: #ffc107;
            color: #000;
            font-size: 0.75rem;
            padding: 0.125rem 0.375rem;
            border-radius: 0.25rem;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <!-- Preview Header -->
    <div class="preview-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 mb-1">{{ $contentType->name }} - Layout Preview</h1>
                    <p class="text-muted mb-0">Template: <strong>{{ $template }}</strong></p>
                </div>
                <div>
                    <span class="preview-badge">Preview Mode</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Area -->
    <div class="container">
        <div class="sample-indicator">
            {!! $html !!}
        </div>

        <!-- Sample Data Reference -->
        <div class="mt-5 pt-4 border-top">
            <h5 class="text-muted">Sample Data Reference</h5>
            <div class="row">
                @if (!empty($sampleData))
                    @foreach ($sampleData as $index => $item)
                        <div class="col-lg-4 mb-3">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Sample Item {{ $index + 1 }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            @foreach ((array) $item as $key => $value)
                                                <tr>
                                                    <td class="fw-semibold">{{ $key }}</td>
                                                    <td>
                                                        @if (is_array($value))
                                                            @if (isset($value[0]) && is_string($value[0]) && strpos($value[0], 'http') === 0)
                                                                <small class="text-muted">{{ count($value) }}
                                                                    images</small>
                                                            @else
                                                                <small
                                                                    class="text-muted">{{ implode(', ', $value) }}</small>
                                                            @endif
                                                        @elseif(is_bool($value))
                                                            <span
                                                                class="badge bg-{{ $value ? 'success' : 'secondary' }}">
                                                                {{ $value ? 'Yes' : 'No' }}
                                                            </span>
                                                        @else
                                                            <small
                                                                class="text-muted">{{ Str::limit($value, 50) }}</small>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="alert alert-info">
                            <h6 class="alert-heading">No Sample Data Available</h6>
                            <p class="mb-0">Please add fields to your content type to see sample data in the preview.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Add some interactive preview features
        document.addEventListener('DOMContentLoaded', function() {
            // Highlight field wrappers on hover
            document.querySelectorAll('.field-wrapper').forEach(wrapper => {
                wrapper.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#e3f2fd';
                    this.style.borderLeftColor = '#2196f3';
                });

                wrapper.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '#f8f9fa';
                    this.style.borderLeftColor = '#0d6efd';
                });
            });

            // Add click to copy functionality for sample data
            document.querySelectorAll('.table td:last-child').forEach(cell => {
                cell.style.cursor = 'pointer';
                cell.title = 'Click to copy';

                cell.addEventListener('click', function() {
                    const text = this.textContent.trim();
                    navigator.clipboard.writeText(text).then(() => {
                        // Show feedback
                        const originalBg = this.style.backgroundColor;
                        this.style.backgroundColor = '#d4edda';
                        setTimeout(() => {
                            this.style.backgroundColor = originalBg;
                        }, 500);
                    });
                });
            });
        });
    </script>
</body>

</html>
