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
                    <h4 class="mb-sm-0">Professional Page Builder - {{ $page->title }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pages.index') }}">Pages</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pages.edit', $page) }}">{{ $page->title }}</a></li>
                            <li class="breadcrumb-item active">Professional Builder</li>
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
                                    <i class="ri-palette-line me-2"></i>
                                    Professional Page Builder
                                </h5>
                                <small class="text-muted">Create beautiful pages with professional templates</small>
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

                    <!-- Template Selection -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-layout-2-line me-2"></i>
                                        Choose a Template
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <div class="template-card" data-template="hero">
                                                <div class="template-preview">
                                                    <div class="template-content">
                                                        <h3>Hero Section</h3>
                                                        <p>Perfect for landing pages</p>
                                                        <button class="btn btn-primary">Get Started</button>
                                                    </div>
                                                </div>
                                                <div class="template-info">
                                                    <h6>Hero Section</h6>
                                                    <small class="text-muted">Landing page template</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="template-card" data-template="about">
                                                <div class="template-preview">
                                                    <div class="template-content">
                                                        <h3>About Us</h3>
                                                        <p>Tell your story</p>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <h5>Mission</h5>
                                                                <p>Our mission statement</p>
                                                            </div>
                                                            <div class="col-6">
                                                                <h5>Vision</h5>
                                                                <p>Our vision for the future</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="template-info">
                                                    <h6>About Us</h6>
                                                    <small class="text-muted">Company information</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="template-card" data-template="services">
                                                <div class="template-preview">
                                                    <div class="template-content">
                                                        <h3>Our Services</h3>
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <h6>Service 1</h6>
                                                                <p>Description</p>
                                                            </div>
                                                            <div class="col-4">
                                                                <h6>Service 2</h6>
                                                                <p>Description</p>
                                                            </div>
                                                            <div class="col-4">
                                                                <h6>Service 3</h6>
                                                                <p>Description</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="template-info">
                                                    <h6>Services</h6>
                                                    <small class="text-muted">Service showcase</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="template-card" data-template="contact">
                                                <div class="template-preview">
                                                    <div class="template-content">
                                                        <h3>Contact Us</h3>
                                                        <form>
                                                            <div class="mb-2">
                                                                <input type="text" class="form-control" placeholder="Name">
                                                            </div>
                                                            <div class="mb-2">
                                                                <input type="email" class="form-control" placeholder="Email">
                                                            </div>
                                                            <div class="mb-2">
                                                                <textarea class="form-control" placeholder="Message"></textarea>
                                                            </div>
                                                            <button class="btn btn-primary">Send</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="template-info">
                                                    <h6>Contact</h6>
                                                    <small class="text-muted">Contact form</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Content Types Section -->
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <h6 class="text-muted mb-3">Your Content Types</h6>
                                            <div class="row">
                                                @php
                                                    $contentTypes = \App\Services\ContentTypePageBuilderService::getContentTypesForPageBuilder();
                                                @endphp
                                                @foreach($contentTypes as $contentType)
                                                    <div class="col-md-3 mb-3">
                                                        <div class="template-card content-type-card" data-template="content-type" data-content-type="{{ $contentType['slug'] }}">
                                                            <div class="template-preview">
                                                                <div class="template-content">
                                                                    {!! $contentType['preview_html'] !!}
                                                                </div>
                                                            </div>
                                                            <div class="template-info">
                                                                <h6>{{ $contentType['name'] }}</h6>
                                                                <small class="text-muted">{{ $contentType['fields_count'] }} fields</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Builder Canvas -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-edit-line me-2"></i>
                                        Page Editor
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div id="pageEditor" class="page-editor">
                                        <div class="editor-placeholder">
                                            <i class="ri-layout-2-line" style="font-size: 3rem; color: #6c757d;"></i>
                                            <p class="text-muted mt-2">Select a template above to start building</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .template-card {
            border: 2px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s;
        }

        .template-card:hover {
            border-color: #007bff;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .template-card.selected {
            border-color: #28a745;
            background: rgba(40, 167, 69, 0.1);
        }

        .template-preview {
            height: 200px;
            background: #f8f9fa;
            padding: 20px;
            overflow: hidden;
        }

        .template-content {
            transform: scale(0.5);
            transform-origin: top left;
            width: 200%;
            height: 200%;
        }

        .template-info {
            padding: 15px;
            background: white;
        }

        .page-editor {
            min-height: 500px;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            background: #f8f9fa;
        }

        .editor-placeholder {
            text-align: center;
            padding: 50px 20px;
        }

        .editable-content {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 20px;
            margin: 10px 0;
            position: relative;
        }

        .editable-content:hover {
            border-color: #007bff;
        }

        .editable-content:focus {
            outline: none;
            border-color: #28a745;
            box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.25);
        }

        .content-type-card {
            border-left: 4px solid #007bff;
        }

        .content-type-card:hover {
            border-left-color: #28a745;
        }

        .content-type-preview {
            font-size: 0.8rem;
        }

        .preview-header h6 {
            margin: 0;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .preview-field {
            margin-bottom: 8px;
        }

        .preview-field label {
            font-size: 0.75rem;
            font-weight: 500;
            margin-bottom: 2px;
            display: block;
        }

        .preview-more {
            text-align: center;
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px solid #dee2e6;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editor = document.getElementById('pageEditor');
            const saveBtn = document.getElementById('saveBtn');
            const previewBtn = document.getElementById('previewBtn');
            let currentTemplate = null;

            // Template data
            const templates = {
                hero: `
                    <div class="hero-section text-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <div class="container">
                            <h1 class="display-4 fw-bold mb-4">Welcome to Our Website</h1>
                            <p class="lead mb-4">We provide amazing solutions for your business needs</p>
                            <button class="btn btn-light btn-lg">Get Started Today</button>
                        </div>
                    </div>
                `,
                about: `
                    <div class="about-section py-5">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h2 class="mb-4">About Our Company</h2>
                                    <p class="lead">We are passionate about delivering exceptional results for our clients.</p>
                                    <p>Our team of experts works tirelessly to ensure your success. We believe in building long-term relationships and providing value that exceeds expectations.</p>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <h5>Our Mission</h5>
                                            <p>To deliver innovative solutions that help businesses grow and succeed in today's competitive market.</p>
                                        </div>
                                        <div class="col-6">
                                            <h5>Our Vision</h5>
                                            <p>To be the leading provider of digital solutions and services worldwide.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                services: `
                    <div class="services-section py-5">
                        <div class="container">
                            <h2 class="text-center mb-5">Our Services</h2>
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="ri-code-s-slash-line" style="font-size: 3rem; color: #007bff;"></i>
                                            <h5 class="card-title mt-3">Web Development</h5>
                                            <p class="card-text">Custom websites and web applications built with modern technologies.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="ri-smartphone-line" style="font-size: 3rem; color: #28a745;"></i>
                                            <h5 class="card-title mt-3">Mobile Apps</h5>
                                            <p class="card-text">Native and cross-platform mobile applications for iOS and Android.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="ri-palette-line" style="font-size: 3rem; color: #ffc107;"></i>
                                            <h5 class="card-title mt-3">UI/UX Design</h5>
                                            <p class="card-text">Beautiful and intuitive user interfaces that enhance user experience.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                contact: `
                    <div class="contact-section py-5">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h2 class="mb-4">Get in Touch</h2>
                                    <p class="lead">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
                                    <div class="contact-info">
                                        <div class="mb-3">
                                            <i class="ri-phone-line me-2"></i>
                                            <span>+1 (555) 123-4567</span>
                                        </div>
                                        <div class="mb-3">
                                            <i class="ri-mail-line me-2"></i>
                                            <span>info@company.com</span>
                                        </div>
                                        <div class="mb-3">
                                            <i class="ri-map-pin-line me-2"></i>
                                            <span>123 Business Street, City, State 12345</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <form>
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" placeholder="Your name">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" placeholder="your@email.com">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Subject</label>
                                            <input type="text" class="form-control" placeholder="Subject">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Message</label>
                                            <textarea class="form-control" rows="4" placeholder="Your message"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Send Message</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            };

            // Template selection
            document.querySelectorAll('.template-card').forEach(card => {
                card.addEventListener('click', function() {
                    // Remove previous selection
                    document.querySelectorAll('.template-card').forEach(c => c.classList.remove('selected'));
                    
                    // Select current template
                    this.classList.add('selected');
                    
                    // Load template
                    const templateType = this.dataset.template;
                    const contentType = this.dataset.contentType;
                    loadTemplate(templateType, contentType);
                });
            });

            function loadTemplate(templateType, contentTypeSlug = null) {
                currentTemplate = templateType;
                let template = templates[templateType];
                
                // Handle content type templates
                if (templateType === 'content-type' && contentTypeSlug) {
                    const contentTypes = @json(\App\Services\ContentTypePageBuilderService::getContentTypesForPageBuilder());
                    const contentType = contentTypes.find(ct => ct.slug === contentTypeSlug);
                    if (contentType) {
                        template = contentType.component_html;
                    }
                }
                
                if (template) {
                    editor.innerHTML = `
                        <div class="editable-content" contenteditable="true">
                            ${template}
                        </div>
                    `;
                    
                    // Make content editable
                    const editableContent = editor.querySelector('.editable-content');
                    editableContent.addEventListener('input', function() {
                        // Content has been edited
                    });
                }
            }

            // Save functionality
            saveBtn.addEventListener('click', function() {
                const content = editor.innerHTML;
                
                fetch(`{{ route('pages.save-builder-content', $page) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        builder_content: content,
                        builder_type: 'professional',
                        css_content: '',
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
            previewBtn.addEventListener('click', function() {
                const content = editor.innerHTML;
                const previewWindow = window.open('', '_blank');
                previewWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Preview - {{ $page->title }}</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                        <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
                    </head>
                    <body>
                        ${content}
                    </body>
                    </html>
                `);
            });
        });
    </script>
@endsection
