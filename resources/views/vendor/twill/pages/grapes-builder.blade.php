@extends('twill::layouts.main')

@section('appTypeClass', 'body--form')

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    <style>
        .gjs-one-bg { background-color: #f8f9fa; }
        .gjs-two-color { color: #495057; }
        .gjs-three-bg { background-color: #007bff; }
        .gjs-four-color { color: #007bff; }
        .gjs-five-bg { background-color: #28a745; }
        .gjs-six-color { color: #28a745; }
    </style>
@endpush

@section('content')
    <div class="page-content">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">GrapesJS Page Builder - {{ $page->title }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pages.index') }}">Pages</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pages.edit', $page) }}">{{ $page->title }}</a></li>
                            <li class="breadcrumb-item active">GrapesJS Builder</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Builder Header -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">
                                    <i class="ri-grape-line me-2"></i>
                                    GrapesJS Page Builder
                                </h5>
                                <small class="text-muted">Professional drag-and-drop page builder</small>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-primary" id="previewBtn">
                                    <i class="ri-eye-line me-1"></i>Preview
                                </button>
                                <button type="button" class="btn btn-outline-success" id="saveBtn">
                                    <i class="ri-save-line me-1"></i>Save
                                </button>
                                <a href="{{ route('pages.edit', $page) }}" class="btn btn-outline-secondary">
                                    <i class="ri-arrow-left-line me-1"></i>Back to Edit
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- GrapesJS Builder -->
                    <div class="card">
                        <div class="card-body p-0">
                            <div id="gjs"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/grapesjs/dist/grapes.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editor = grapesjs.init({
                container: '#gjs',
                height: '600px',
                width: '100%',
                storageManager: false,
                plugins: [],
                pluginsOpts: {},
                blockManager: {
                    appendTo: '.blocks-container'
                },
                layerManager: {
                    appendTo: '.layers-container'
                },
                traitManager: {
                    appendTo: '.traits-container'
                },
                selectorManager: {
                    appendTo: '.styles-container'
                },
                panels: {
                    defaults: [
                        {
                            id: 'layers',
                            el: '.panel__right',
                            resizable: {
                                maxDim: 350,
                                minDim: 200,
                                tc: 0,
                                cl: 1,
                                cr: 0,
                                bc: 0,
                                keyWidth: 'flex-basis',
                            },
                        },
                        {
                            id: 'panel-switcher',
                            el: '.panel__switcher',
                            buttons: [
                                {
                                    id: 'show-layers',
                                    active: true,
                                    label: 'Layers',
                                    command: 'show-layers',
                                    togglable: false,
                                },
                                {
                                    id: 'show-style',
                                    active: true,
                                    label: 'Styles',
                                    command: 'show-styles',
                                    togglable: false,
                                },
                                {
                                    id: 'show-traits',
                                    active: true,
                                    label: 'Settings',
                                    command: 'show-traits',
                                    togglable: false,
                                }
                            ],
                        },
                        {
                            id: 'panel-devices',
                            el: '.panel__devices',
                            buttons: [
                                {
                                    id: 'device-desktop',
                                    label: 'Desktop',
                                    command: 'set-device-desktop',
                                    active: true,
                                    togglable: false,
                                },
                                {
                                    id: 'device-tablet',
                                    label: 'Tablet',
                                    command: 'set-device-tablet',
                                    togglable: false,
                                },
                                {
                                    id: 'device-mobile',
                                    label: 'Mobile',
                                    command: 'set-device-mobile',
                                    togglable: false,
                                }
                            ],
                        }
                    ]
                },
                deviceManager: {
                    devices: [
                        {
                            name: 'Desktop',
                            width: '',
                        },
                        {
                            name: 'Tablet',
                            width: '768px',
                            widthMedia: '992px',
                        },
                        {
                            name: 'Mobile',
                            width: '320px',
                            widthMedia: '768px',
                        }
                    ]
                },
                commands: {
                    'show-layers': {
                        getRowEl(editor) { return editor.getContainer().closest('.editor-row'); },
                        getLayersEl(row) { return row.querySelector('.layers-container') },

                        run(editor, sender) {
                            const rowEl = this.getRowEl(editor);
                            const layersEl = this.getLayersEl(rowEl);
                            layersEl.style.display = '';
                        },
                        stop(editor, sender) {
                            const rowEl = this.getRowEl(editor);
                            const layersEl = this.getLayersEl(rowEl);
                            layersEl.style.display = 'none';
                        },
                    },
                    'show-styles': {
                        getRowEl(editor) { return editor.getContainer().closest('.editor-row'); },
                        getStyleEl(row) { return row.querySelector('.styles-container') },

                        run(editor, sender) {
                            const rowEl = this.getRowEl(editor);
                            const styleEl = this.getStyleEl(rowEl);
                            styleEl.style.display = '';
                        },
                        stop(editor, sender) {
                            const rowEl = this.getRowEl(editor);
                            const styleEl = this.getStyleEl(rowEl);
                            styleEl.style.display = 'none';
                        },
                    },
                    'show-traits': {
                        getRowEl(editor) { return editor.getContainer().closest('.editor-row'); },
                        getTraitsEl(row) { return row.querySelector('.traits-container') },

                        run(editor, sender) {
                            const rowEl = this.getRowEl(editor);
                            const traitsEl = this.getTraitsEl(rowEl);
                            traitsEl.style.display = '';
                        },
                        stop(editor, sender) {
                            const rowEl = this.getRowEl(editor);
                            const traitsEl = this.getTraitsEl(rowEl);
                            traitsEl.style.display = 'none';
                        },
                    },
                    'set-device-desktop': {
                        run: editor => editor.setDevice('Desktop')
                    },
                    'set-device-tablet': {
                        run: editor => editor.setDevice('Tablet')
                    },
                    'set-device-mobile': {
                        run: editor => editor.setDevice('Mobile')
                    }
                },
                canvas: {
                    styles: [
                        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'
                    ]
                }
            });

            // Add custom blocks
            editor.BlockManager.add('hero-section', {
                label: 'Hero Section',
                category: 'Sections',
                content: `
                    <div class="hero-section text-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <div class="container">
                            <h1 class="display-4 fw-bold mb-4">Welcome to Our Website</h1>
                            <p class="lead mb-4">We provide amazing solutions for your business needs</p>
                            <button class="btn btn-light btn-lg">Get Started Today</button>
                        </div>
                    </div>
                `
            });

            // Add content type blocks
            const contentTypes = @json(\App\Services\ContentTypePageBuilderService::getContentTypesForPageBuilder());
            contentTypes.forEach(contentType => {
                editor.BlockManager.add('content-type-' + contentType.slug, {
                    label: contentType.name,
                    category: 'Content Types',
                    content: contentType.component_html
                });
            });

            editor.BlockManager.add('content-section', {
                label: 'Content Section',
                category: 'Sections',
                content: `
                    <div class="py-5">
                        <div class="container">
                            <h2>Section Title</h2>
                            <p>This is a content section. Add your content here.</p>
                        </div>
                    </div>
                `
            });

            editor.BlockManager.add('card-section', {
                label: 'Card Section',
                category: 'Sections',
                content: `
                    <div class="py-5">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Card Title</h5>
                                            <p class="card-text">Card content goes here.</p>
                                            <a href="#" class="btn btn-primary">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Card Title</h5>
                                            <p class="card-text">Card content goes here.</p>
                                            <a href="#" class="btn btn-primary">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Card Title</h5>
                                            <p class="card-text">Card content goes here.</p>
                                            <a href="#" class="btn btn-primary">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            });

            // Load existing content if available
            @if($page->content)
                editor.setComponents('{{ addslashes($page->content) }}');
            @endif

            // Save functionality
            document.getElementById('saveBtn').addEventListener('click', function() {
                const html = editor.getHtml();
                const css = editor.getCss();
                
                fetch(`{{ route('pages.save-builder-content', $page) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        builder_content: html,
                        builder_type: 'grapes',
                        css_content: css,
                        js_content: ''
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Page saved successfully!');
                    } else {
                        alert('Error saving page: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error saving page');
                });
            });

            // Preview functionality
            document.getElementById('previewBtn').addEventListener('click', function() {
                const html = editor.getHtml();
                const css = editor.getCss();
                const previewWindow = window.open('', '_blank');
                previewWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Preview - {{ $page->title }}</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                        <style>${css}</style>
                    </head>
                    <body>
                        ${html}
                    </body>
                    </html>
                `);
            });
        });
    </script>
@endsection
