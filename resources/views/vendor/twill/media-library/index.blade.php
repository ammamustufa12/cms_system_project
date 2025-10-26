@extends('twill::layouts.main')

@section('title', 'Media Library')

@section('content')
<div class="container-fluid" style="padding-top: 100px;padding-bottom:100px">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Media Library</h2>
                    <p class="text-muted mb-0">Manage your media files and assets</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="refreshMedia()">
                        <i class="ri-refresh-line me-1"></i> Refresh
                    </button>
                    <button class="btn btn-primary" onclick="showUploadModal()">
                        <i class="ri-upload-line me-1"></i> Add Media File
                    </button>
                    <button class="btn btn-purple" onclick="showAIGenerateModal()">
                        <i class="ri-magic-line me-1"></i> Generate with AI
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="ri-question-line me-1"></i> Help
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="ri-book-line me-2"></i>Documentation</a></li>
                            <li><a class="dropdown-item" href="#"><i class="ri-video-line me-2"></i>Video Tutorials</a></li>
                            <li><a class="dropdown-item" href="#"><i class="ri-customer-service-line me-2"></i>Support</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Information Banners -->
    <div class="row mb-4">
        <div class="col-12">
            <!-- Permalink Warning -->
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="ri-alert-line me-2"></i>
                <strong>Permalink Notice:</strong> Plain permalink is not supported with MetForm. We recommend to use post name as your permalink settings.
                <button type="button" class="btn btn-sm btn-primary ms-3" onclick="changePermalink()">Change Permalink</button>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>

            <!-- Contribution Request -->
            <div class="alert alert-info border-start border-5 border-danger" role="alert">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="alert-heading mb-2">Want to shape the future of web creation?</h6>
                        <p class="mb-0">Become a super contributor by helping us understand how you use our service to enhance your experience and improve our product. <a href="#" class="alert-link">Learn more</a></p>
                    </div>
                    <div class="ms-3">
                        <button class="btn btn-primary btn-sm me-2" onclick="becomeContributor()">Sure! I'd love to help</button>
                        <button class="btn btn-outline-secondary btn-sm" onclick="dismissContribution()">No thanks</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Media Controls -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <!-- View Toggle -->
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary active" onclick="setViewMode('grid')" id="gridViewBtn">
                            <i class="ri-grid-line"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="setViewMode('list')" id="listViewBtn">
                            <i class="ri-list-check"></i>
                        </button>
                    </div>

                    <!-- Media Type Filter -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" id="mediaTypeFilter">
                            <i class="ri-check-line me-1"></i> All media items
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="filterByType('all')">All media items</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterByType('image')">Images</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterByType('video')">Videos</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterByType('audio')">Audio</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterByType('document')">Documents</a></li>
                        </ul>
                    </div>

                    <!-- Date Filter -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" id="dateFilter">
                            <i class="ri-check-line me-1"></i> All dates
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="filterByDate('all')">All dates</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterByDate('today')">Today</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterByDate('week')">This week</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterByDate('month')">This month</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterByDate('year')">This year</a></li>
                        </ul>
                    </div>

                    <!-- Bulk Select -->
                    <button class="btn btn-outline-primary" onclick="toggleBulkSelect()" id="bulkSelectBtn">
                        <i class="ri-checkbox-multiple-line me-1"></i> Bulk select
                    </button>
                </div>

                <!-- Search -->
                <div class="d-flex align-items-center">
                    <div class="input-group" style="width: 300px;">
                        <span class="input-group-text"><i class="ri-search-line"></i></span>
                        <input type="text" class="form-control" id="searchMedia" placeholder="Search media">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Media Grid/List -->
    <div class="row">
        <div class="col-12">
            <div class="media-container" id="mediaContainer">
                <!-- Media items will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Bulk Actions Bar -->
    <div class="row mt-4" id="bulkActionsBar" style="display: none;">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span id="selectedCount">0</span> items selected
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm" onclick="bulkDownload()">
                                <i class="ri-download-line me-1"></i> Download
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="bulkEdit()">
                                <i class="ri-edit-line me-1"></i> Edit
                            </button>
                            <button class="btn btn-outline-danger btn-sm" onclick="bulkDelete()">
                                <i class="ri-delete-bin-line me-1"></i> Delete
                            </button>
                            <button class="btn btn-outline-secondary btn-sm" onclick="clearSelection()">
                                <i class="ri-close-line me-1"></i> Clear
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">
                    <i class="ri-upload-line me-2"></i>Upload Media Files
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="upload-area" id="uploadArea">
                    <div class="upload-content">
                        <i class="ri-upload-cloud-2-line upload-icon"></i>
                        <h5>Drop files here or click to upload</h5>
                        <p class="text-muted">Supports: JPEG, JPG, PNG, WebP, AVIF images and PDF, DOC, TXT documents</p>
                        <div class="file-restrictions">
                            <small class="text-info">
                                <i class="ri-information-line me-1"></i>
                                Max file size: 10MB | Allowed formats: Images (JPEG, JPG, PNG, WebP, AVIF) + Documents (PDF, DOC, TXT, XLS, PPT)
                            </small>
                        </div>
                        <input type="file" id="fileInput" multiple accept="image/jpeg,image/jpg,image/png,image/webp,image/avif,.pdf,.doc,.docx,.txt,.docx,.xls,.xlsx,.ppt,.pptx" style="display: none;">
                        <button class="btn btn-primary" onclick="document.getElementById('fileInput').click()">
                            <i class="ri-folder-open-line me-1"></i> Choose Files
                        </button>
                    </div>
                </div>
                <div class="upload-progress mt-3" id="uploadProgress" style="display: none;">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                    </div>
                    <small class="text-muted">Uploading files...</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="startUpload()">Upload Files</button>
            </div>
        </div>
    </div>
</div>

<!-- AI Generate Modal -->
<div class="modal fade" id="aiGenerateModal" tabindex="-1" aria-labelledby="aiGenerateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aiGenerateModalLabel">
                    <i class="ri-magic-line me-2"></i>Generate with AI
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="aiPrompt" class="form-label">Describe what you want to generate</label>
                    <textarea class="form-control" id="aiPrompt" rows="3" placeholder="e.g., A modern logo for a tech startup, A hero image for a travel blog, etc."></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="aiType" class="form-label">Media Type</label>
                        <select class="form-select" id="aiType">
                            <option value="image">Image</option>
                            <option value="logo">Logo</option>
                            <option value="icon">Icon</option>
                            <option value="banner">Banner</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="aiStyle" class="form-label">Style</label>
                        <select class="form-select" id="aiStyle">
                            <option value="modern">Modern</option>
                            <option value="vintage">Vintage</option>
                            <option value="minimalist">Minimalist</option>
                            <option value="corporate">Corporate</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-purple" onclick="generateWithAI()">
                    <i class="ri-magic-line me-1"></i> Generate
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Media Details Modal -->
<div class="modal fade" id="mediaDetailsModal" tabindex="-1" aria-labelledby="mediaDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaDetailsModalLabel">
                    <i class="ri-image-line me-2"></i>Media Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="mediaDetailsContent">
                <!-- Media details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editMedia()">Edit</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Media Library Styles */
.media-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    padding: 20px 0;
}

.media-item {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
}

.media-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.media-item.selected {
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}

.media-thumbnail {
    width: 100%;
    height: 150px;
    background-size: cover;
    background-position: center;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.media-thumbnail img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
}

.media-type-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
}

.media-checkbox {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(255,255,255,0.9);
    border-radius: 4px;
    padding: 2px;
}

.media-actions {
    position: absolute;
    top: 10px;
    right: 10px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.media-item:hover .media-actions {
    opacity: 1;
}

.media-actions .btn {
    padding: 4px 8px;
    font-size: 0.8rem;
}

.ai-generated-badge {
    position: absolute;
    top: 10px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 4px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.ai-generated-badge i {
    font-size: 0.8rem;
}

.media-content {
    padding: 15px;
}

.media-title {
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 5px;
    color: #333;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.media-meta {
    font-size: 0.8rem;
    color: #6c757d;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.media-size {
    font-weight: 500;
}

.media-date {
    color: #999;
}

/* Upload Area */
.upload-area {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 40px;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.upload-area:hover {
    border-color: #007bff;
    background: #f8f9ff;
}

.upload-area.dragover {
    border-color: #007bff;
    background: #e3f2fd;
}

.upload-icon {
    font-size: 3rem;
    color: #6c757d;
    margin-bottom: 15px;
}

.upload-content h5 {
    margin-bottom: 10px;
    color: #333;
}

.file-restrictions {
    margin: 10px 0;
    padding: 8px 12px;
    background: #e3f2fd;
    border-radius: 6px;
    border-left: 3px solid #2196f3;
}

.file-restrictions small {
    font-size: 0.85rem;
    line-height: 1.4;
}

/* List View */
.media-list {
    display: none;
}

.media-list .media-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    padding: 15px;
}

.media-list .media-thumbnail {
    width: 80px;
    height: 80px;
    margin-right: 15px;
    border-radius: 6px;
}

.media-list .media-content {
    flex: 1;
    padding: 0;
}

.media-list .media-title {
    font-size: 1rem;
    white-space: normal;
    margin-bottom: 5px;
}

.media-list .media-meta {
    font-size: 0.9rem;
}

/* Bulk Actions */
#bulkActionsBar {
    position: sticky;
    bottom: 20px;
    z-index: 1000;
}

/* Alert Styles */
.alert-info.border-start {
    border-left: 5px solid #dc3545 !important;
}

.btn-purple {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
}

.btn-purple:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    color: white;
}

/* Progress Bar */
.progress {
    height: 8px;
    border-radius: 4px;
}

/* Media Type Icons */
.media-type-icon.image { background: #28a745; }
.media-type-icon.video { background: #dc3545; }
.media-type-icon.audio { background: #ffc107; color: #333; }
.media-type-icon.document { background: #6c757d; }

/* Responsive Design */
@media (max-width: 768px) {
    .media-container {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
    }
    
    .media-thumbnail {
        height: 120px;
    }
    
    .d-flex.gap-2 {
        flex-wrap: wrap;
    }
}

/* Loading Animation */
.loading {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
}

.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state h5 {
    margin-bottom: 10px;
    color: #495057;
}

.empty-state p {
    margin-bottom: 0;
}
</style>

<script>
// Media Library Management
let mediaFiles = [];
let selectedMedia = [];
let currentView = 'grid';
let currentFilters = {
    type: 'all',
    date: 'all',
    search: ''
};

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeMediaLibrary();
});

function initializeMediaLibrary() {
    loadMediaFiles();
    setupEventListeners();
    renderMedia();
}

function loadMediaFiles() {
    // Load from localStorage or API
    const savedMedia = localStorage.getItem('mediaFiles');
    if (savedMedia) {
        try {
            mediaFiles = JSON.parse(savedMedia);
            console.log('Loaded media files:', mediaFiles.length);
        } catch (e) {
            console.error('Error loading media files:', e);
            mediaFiles = [];
        }
    } else {
        // Sample media files
        mediaFiles = [
            {
                id: 1,
                name: 'business-meeting.jpg',
                title: 'Business Meeting',
                type: 'image',
                size: '2.4 MB',
                url: '/images/sample-1.jpg',
                thumbnail: '/images/sample-1.jpg',
                created_at: '2024-01-15',
                modified_at: '2024-01-15',
                alt_text: 'Business professionals in a meeting',
                description: 'Professional business meeting scene'
            },
            {
                id: 2,
                name: 'company-logo.png',
                title: 'Company Logo',
                type: 'image',
                size: '156 KB',
                url: '/images/logo-1.png',
                thumbnail: '/images/logo-1.png',
                created_at: '2024-01-14',
                modified_at: '2024-01-14',
                alt_text: 'Company logo design',
                description: 'Modern company logo'
            },
            {
                id: 3,
                name: 'product-demo.mp4',
                title: 'Product Demo Video',
                type: 'video',
                size: '15.2 MB',
                url: '/videos/demo.mp4',
                thumbnail: '/images/video-thumb.jpg',
                created_at: '2024-01-13',
                modified_at: '2024-01-13',
                alt_text: 'Product demonstration video',
                description: 'Product demonstration video'
            },
            {
                id: 4,
                name: 'background-music.mp3',
                title: 'Background Music',
                type: 'audio',
                size: '3.8 MB',
                url: '/audio/music.mp3',
                thumbnail: '/images/audio-thumb.jpg',
                created_at: '2024-01-12',
                modified_at: '2024-01-12',
                alt_text: 'Background music track',
                description: 'Background music for videos'
            },
            {
                id: 5,
                name: 'company-brochure.pdf',
                title: 'Company Brochure',
                type: 'document',
                size: '1.2 MB',
                url: '/documents/brochure.pdf',
                thumbnail: '/images/pdf-thumb.jpg',
                created_at: '2024-01-11',
                modified_at: '2024-01-11',
                alt_text: 'Company brochure document',
                description: 'Company information brochure'
            }
        ];
        
        // Save initial data
        saveMediaFiles();
    }
    
    renderMedia();
}

function saveMediaFiles() {
    try {
        localStorage.setItem('mediaFiles', JSON.stringify(mediaFiles));
        console.log('Media files saved:', mediaFiles.length);
    } catch (e) {
        console.error('Error saving media files:', e);
        showNotification('Error saving media files!', 'error');
    }
}

function setupEventListeners() {
    // Search functionality
    document.getElementById('searchMedia').addEventListener('input', function() {
        currentFilters.search = this.value;
        renderMedia();
    });
    
    // File input change
    document.getElementById('fileInput').addEventListener('change', function() {
        handleFileSelection(this.files);
    });
    
    // Upload area drag and drop
    const uploadArea = document.getElementById('uploadArea');
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.add('dragover');
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('dragover');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFileSelection(files);
        }
    });
    
    // Click to upload
    uploadArea.addEventListener('click', function() {
        document.getElementById('fileInput').click();
    });
}

function renderMedia() {
    const container = document.getElementById('mediaContainer');
    const filteredMedia = getFilteredMedia();
    
    if (filteredMedia.length === 0) {
        container.innerHTML = `
            <div class="col-12">
                <div class="empty-state">
                    <i class="ri-image-line"></i>
                    <h5>No media files found</h5>
                    <p>Upload your first media file to get started.</p>
                </div>
            </div>
        `;
        return;
    }
    
    if (currentView === 'grid') {
        renderGridView(filteredMedia);
    } else {
        renderListView(filteredMedia);
    }
}

function renderGridView(media) {
    const container = document.getElementById('mediaContainer');
    container.className = 'media-container';
    
    container.innerHTML = media.map(item => `
        <div class="media-item ${selectedMedia.includes(item.id) ? 'selected' : ''}" 
             onclick="toggleMediaSelection(${item.id})" 
             ondblclick="viewMediaDetails(${item.id})">
            <div class="media-thumbnail" style="background-image: url('${item.thumbnail}')">
                <div class="media-type-icon ${item.type}">
                    <i class="ri-${getTypeIcon(item.type)}-line"></i>
                </div>
                ${item.ai_generated ? '<div class="ai-generated-badge"><i class="ri-magic-line"></i> AI</div>' : ''}
                <div class="media-checkbox" style="display: ${selectedMedia.length > 0 ? 'block' : 'none'};">
                    <input type="checkbox" ${selectedMedia.includes(item.id) ? 'checked' : ''} 
                           onchange="toggleMediaSelection(${item.id})">
                </div>
                <div class="media-actions">
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteMediaItem(${item.id}); event.stopPropagation();" title="Delete">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>
            </div>
            <div class="media-content">
                <div class="media-title" title="${item.title}">${item.title}</div>
                <div class="media-meta">
                    <span class="media-size">${item.size}</span>
                    <span class="media-date">${formatDate(item.created_at)}</span>
                </div>
            </div>
        </div>
    `).join('');
}

function renderListView(media) {
    const container = document.getElementById('mediaContainer');
    container.className = 'media-list';
    
    container.innerHTML = media.map(item => `
        <div class="media-item ${selectedMedia.includes(item.id) ? 'selected' : ''}" 
             onclick="toggleMediaSelection(${item.id})" 
             ondblclick="viewMediaDetails(${item.id})">
            <div class="media-thumbnail" style="background-image: url('${item.thumbnail}')">
                <div class="media-type-icon ${item.type}">
                    <i class="ri-${getTypeIcon(item.type)}-line"></i>
                </div>
            </div>
            <div class="media-content">
                <div class="media-title">${item.title}</div>
                <div class="media-meta">
                    <span class="media-size">${item.size}</span>
                    <span class="media-date">${formatDate(item.created_at)}</span>
                </div>
            </div>
            <div class="media-checkbox">
                <input type="checkbox" ${selectedMedia.includes(item.id) ? 'checked' : ''} 
                       onchange="toggleMediaSelection(${item.id})">
            </div>
        </div>
    `).join('');
}

function getFilteredMedia() {
    return mediaFiles.filter(media => {
        const matchesType = currentFilters.type === 'all' || media.type === currentFilters.type;
        const matchesSearch = !currentFilters.search || 
            media.title.toLowerCase().includes(currentFilters.search.toLowerCase()) ||
            media.name.toLowerCase().includes(currentFilters.search.toLowerCase());
        
        return matchesType && matchesSearch;
    });
}

function getTypeIcon(type) {
    const icons = {
        'image': 'image',
        'video': 'video',
        'audio': 'music',
        'document': 'file'
    };
    return icons[type] || 'file';
}

function setViewMode(mode) {
    currentView = mode;
    
    // Update button states
    document.getElementById('gridViewBtn').classList.toggle('active', mode === 'grid');
    document.getElementById('listViewBtn').classList.toggle('active', mode === 'list');
    
    renderMedia();
}

function filterByType(type) {
    currentFilters.type = type;
    document.getElementById('mediaTypeFilter').innerHTML = 
        `<i class="ri-check-line me-1"></i> ${type === 'all' ? 'All media items' : type.charAt(0).toUpperCase() + type.slice(1)}`;
    renderMedia();
}

function filterByDate(date) {
    currentFilters.date = date;
    document.getElementById('dateFilter').innerHTML = 
        `<i class="ri-check-line me-1"></i> ${date === 'all' ? 'All dates' : date.charAt(0).toUpperCase() + date.slice(1)}`;
    renderMedia();
}

function toggleBulkSelect() {
    const isBulkMode = selectedMedia.length > 0;
    if (isBulkMode) {
        clearSelection();
    } else {
        // Show checkboxes
        document.querySelectorAll('.media-checkbox').forEach(checkbox => {
            checkbox.style.display = 'block';
        });
    }
}

function toggleMediaSelection(id) {
    if (selectedMedia.includes(id)) {
        selectedMedia = selectedMedia.filter(mediaId => mediaId !== id);
    } else {
        selectedMedia.push(id);
    }
    
    updateBulkActionsBar();
    renderMedia();
}

function clearSelection() {
    selectedMedia = [];
    updateBulkActionsBar();
    document.querySelectorAll('.media-checkbox').forEach(checkbox => {
        checkbox.style.display = 'none';
    });
    renderMedia();
}

function updateBulkActionsBar() {
    const bulkBar = document.getElementById('bulkActionsBar');
    const selectedCount = document.getElementById('selectedCount');
    
    if (selectedMedia.length > 0) {
        bulkBar.style.display = 'block';
        selectedCount.textContent = selectedMedia.length;
    } else {
        bulkBar.style.display = 'none';
    }
}

function showUploadModal() {
    new bootstrap.Modal(document.getElementById('uploadModal')).show();
}

function showAIGenerateModal() {
    new bootstrap.Modal(document.getElementById('aiGenerateModal')).show();
}

function handleFileSelection(files) {
    if (files.length === 0) return;
    
    // Validate files
    const validationResult = validateFiles(files);
    if (!validationResult.valid) {
        showNotification(validationResult.message, 'error');
        return;
    }
    
    const progressBar = document.getElementById('uploadProgress');
    progressBar.style.display = 'block';
    
    let progress = 0;
    const interval = setInterval(() => {
        progress += 10;
        progressBar.querySelector('.progress-bar').style.width = progress + '%';
        
        if (progress >= 100) {
            clearInterval(interval);
            
            // Process and save files
            processUploadedFiles(files);
            
            setTimeout(() => {
                progressBar.style.display = 'none';
                progressBar.querySelector('.progress-bar').style.width = '0%';
                bootstrap.Modal.getInstance(document.getElementById('uploadModal')).hide();
                showNotification('Files uploaded successfully!', 'success');
            }, 500);
        }
    }, 100);
}

function validateFiles(files) {
    const allowedImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/avif'];
    const allowedDocumentTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'];
    const maxFileSize = 10 * 1024 * 1024; // 10MB
    
    const allowedTypes = [...allowedImageTypes, ...allowedDocumentTypes];
    
    for (let file of files) {
        // Check file type
        if (!allowedTypes.includes(file.type)) {
            return {
                valid: false,
                message: `File "${file.name}" is not supported. Only JPEG, JPG, PNG, WebP, AVIF images and PDF, DOC, TXT documents are allowed.`
            };
        }
        
        // Check file size
        if (file.size > maxFileSize) {
            return {
                valid: false,
                message: `File "${file.name}" is too large. Maximum file size is 10MB.`
            };
        }
    }
    
    return { valid: true };
}

function processUploadedFiles(files) {
    Array.from(files).forEach((file, index) => {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const newMediaFile = {
                id: Date.now() + index,
                name: file.name,
                title: file.name.split('.')[0],
                type: getFileType(file.type),
                size: formatFileSize(file.size),
                url: e.target.result,
                thumbnail: e.target.result,
                created_at: new Date().toISOString().split('T')[0],
                modified_at: new Date().toISOString().split('T')[0],
                alt_text: file.name.split('.')[0],
                description: `Uploaded ${file.name}`
            };
            
            // Add to media files array
            mediaFiles.unshift(newMediaFile);
            
            // Save to localStorage
            saveMediaFiles();
            
            // Refresh the display
            renderMedia();
        };
        
        reader.readAsDataURL(file);
    });
}

function getFileType(mimeType) {
    if (mimeType.startsWith('image/')) return 'image';
    if (mimeType.startsWith('video/')) return 'video';
    if (mimeType.startsWith('audio/')) return 'audio';
    if (mimeType.includes('pdf')) return 'document';
    if (mimeType.includes('word') || mimeType.includes('text')) return 'document';
    if (mimeType.includes('excel') || mimeType.includes('spreadsheet')) return 'document';
    if (mimeType.includes('powerpoint') || mimeType.includes('presentation')) return 'document';
    return 'document';
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function startUpload() {
    const fileInput = document.getElementById('fileInput');
    if (fileInput.files.length > 0) {
        handleFileSelection(fileInput.files);
    }
}

function generateWithAI() {
    const prompt = document.getElementById('aiPrompt').value;
    const type = document.getElementById('aiType').value;
    const style = document.getElementById('aiStyle').value;
    
    if (!prompt.trim()) {
        showNotification('Please enter a description for AI generation', 'error');
        return;
    }
    
    // Show loading state
    showNotification('AI generation started...', 'info');
    bootstrap.Modal.getInstance(document.getElementById('aiGenerateModal')).hide();
    
    // Generate AI content
    generateAIContent(prompt, type, style);
}

function generateAIContent(prompt, type, style) {
    // Create a realistic AI-generated image using placeholder services
    const imageUrl = generatePlaceholderImage(prompt, type, style);
    
    // Simulate AI processing time
    setTimeout(() => {
        const newMediaFile = {
            id: Date.now(),
            name: `ai-generated-${type}-${Date.now()}.png`,
            title: `AI Generated: ${prompt}`,
            type: 'image',
            size: '2.1 MB',
            url: imageUrl,
            thumbnail: imageUrl,
            created_at: new Date().toISOString().split('T')[0],
            modified_at: new Date().toISOString().split('T')[0],
            alt_text: `AI generated ${type}: ${prompt}`,
            description: `AI generated ${type} with ${style} style: ${prompt}`,
            ai_generated: true,
            ai_prompt: prompt,
            ai_style: style
        };
        
        // Add to media files array
        mediaFiles.unshift(newMediaFile);
        
        // Save to localStorage
        saveMediaFiles();
        
        // Refresh the display
        renderMedia();
        
        showNotification('AI-generated media created successfully!', 'success');
    }, 2000);
}

function generatePlaceholderImage(prompt, type, style) {
    // Use placeholder.com or picsum.photos for realistic images
    const baseUrl = 'https://picsum.photos/800/600';
    const seed = prompt.toLowerCase().replace(/\s+/g, '-');
    
    // Different image categories based on prompt keywords
    let category = 'nature';
    if (prompt.toLowerCase().includes('logo') || prompt.toLowerCase().includes('brand')) {
        category = 'business';
    } else if (prompt.toLowerCase().includes('person') || prompt.toLowerCase().includes('people')) {
        category = 'people';
    } else if (prompt.toLowerCase().includes('tech') || prompt.toLowerCase().includes('computer')) {
        category = 'technology';
    } else if (prompt.toLowerCase().includes('food') || prompt.toLowerCase().includes('restaurant')) {
        category = 'food';
    }
    
    // Generate different images based on category
    const categorySeeds = {
        'business': [1, 2, 3, 4, 5],
        'people': [10, 11, 12, 13, 14],
        'technology': [20, 21, 22, 23, 24],
        'food': [30, 31, 32, 33, 34],
        'nature': [40, 41, 42, 43, 44]
    };
    
    const randomSeed = categorySeeds[category][Math.floor(Math.random() * categorySeeds[category].length)];
    
    return `https://picsum.photos/seed/${randomSeed}/800/600`;
}

function viewMediaDetails(id) {
    const media = mediaFiles.find(m => m.id === id);
    if (!media) return;
    
    const content = `
        <div class="row">
            <div class="col-md-6">
                <div class="media-preview">
                    <img src="${media.thumbnail}" alt="${media.title}" class="img-fluid rounded">
                </div>
            </div>
            <div class="col-md-6">
                <h5>${media.title}</h5>
                <p class="text-muted">${media.description || 'No description available'}</p>
                
                <div class="media-info">
                    <div class="row mb-2">
                        <div class="col-4"><strong>Type:</strong></div>
                        <div class="col-8">${media.type.charAt(0).toUpperCase() + media.type.slice(1)}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Size:</strong></div>
                        <div class="col-8">${media.size}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Created:</strong></div>
                        <div class="col-8">${formatDate(media.created_at)}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Modified:</strong></div>
                        <div class="col-8">${formatDate(media.modified_at)}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Alt Text:</strong></div>
                        <div class="col-8">${media.alt_text || 'Not set'}</div>
                    </div>
                    ${media.ai_generated ? `
                    <div class="row mb-2">
                        <div class="col-4"><strong>AI Generated:</strong></div>
                        <div class="col-8">
                            <span class="badge bg-gradient-primary">Yes</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>AI Prompt:</strong></div>
                        <div class="col-8">${media.ai_prompt}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>AI Style:</strong></div>
                        <div class="col-8">${media.ai_style}</div>
                    </div>
                    ` : ''}
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('mediaDetailsContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('mediaDetailsModal')).show();
}

function editMedia() {
    showNotification('Edit functionality coming soon!', 'info');
}

function bulkDownload() {
    showNotification(`Downloading ${selectedMedia.length} files...`, 'info');
}

function bulkEdit() {
    showNotification(`Editing ${selectedMedia.length} files...`, 'info');
}

function bulkDelete() {
    if (confirm(`Are you sure you want to delete ${selectedMedia.length} files?`)) {
        mediaFiles = mediaFiles.filter(media => !selectedMedia.includes(media.id));
        saveMediaFiles();
        clearSelection();
        renderMedia();
        showNotification('Files deleted successfully!', 'success');
    }
}

function refreshMedia() {
    loadMediaFiles();
    showNotification('Media library refreshed!', 'success');
}

function deleteMediaItem(id) {
    if (confirm('Are you sure you want to delete this media file?')) {
        mediaFiles = mediaFiles.filter(media => media.id !== id);
        saveMediaFiles();
        renderMedia();
        showNotification('Media file deleted successfully!', 'success');
    }
}

function changePermalink() {
    showNotification('Redirecting to permalink settings...', 'info');
}

function becomeContributor() {
    showNotification('Thank you for your interest in contributing!', 'success');
}

function dismissContribution() {
    showNotification('Contribution request dismissed', 'info');
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px;';
    
    const icon = type === 'error' ? 'ri-error-warning-line' : 
                 type === 'success' ? 'ri-check-line' : 
                 type === 'info' ? 'ri-information-line' : 'ri-notification-line';
    
    notification.innerHTML = `
        <i class="${icon} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds for errors, 3 seconds for others
    const timeout = type === 'error' ? 5000 : 3000;
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, timeout);
}
</script>
@endsection
