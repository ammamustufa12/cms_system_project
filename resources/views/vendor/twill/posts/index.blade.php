@extends('twill::layouts.main')

@section('title', 'Blog Posts Management')

@section('content')
<div class="container-fluid" style="padding-top: 100px;padding-bottom:100px">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Blog Posts</h2>
                    <p class="text-muted mb-0">Manage your blog posts and articles</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="refreshPosts()">
                        <i class="ri-refresh-line me-1"></i> Refresh
                    </button>
                    <button class="btn btn-primary" onclick="showAddPostModal()">
                        <i class="ri-add-line me-1"></i> Add New Post
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="ri-search-line"></i></span>
                <input type="text" class="form-control" id="searchPosts" placeholder="Search posts...">
            </div>
        </div>
        <div class="col-md-3">
            <select class="form-select" id="categoryFilter">
                <option value="">All Categories</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select" id="statusFilter">
                <option value="">All Status</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
                <option value="archived">Archived</option>
            </select>
        </div>
    </div>

    <!-- Blog Posts List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th width="10%">Featured Image</th>
                                    <th width="25%">Title</th>
                                    <th width="15%">Category</th>
                                    <th width="10%">Author</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Date</th>
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="postsTableBody">
                                <!-- Posts will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="row mt-4">
        <div class="col-12">
            <nav aria-label="Posts pagination">
                <ul class="pagination justify-content-center" id="postsPagination">
                    <!-- Pagination will be loaded here -->
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Add/Edit Post Modal -->
<div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="postModalLabel">
                    <i class="ri-article-line me-2"></i>Add New Post
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="postForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="postTitle" class="form-label">Post Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="postTitle" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="postSlug" class="form-label">URL Slug</label>
                                <input type="text" class="form-control" id="postSlug" name="slug" placeholder="auto-generated-from-title">
                            </div>
                            <div class="mb-3">
                                <label for="postContent" class="form-label">Content</label>
                                <textarea class="form-control" id="postContent" name="content" rows="10" placeholder="Write your blog post content here..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="postExcerpt" class="form-label">Excerpt</label>
                                <textarea class="form-control" id="postExcerpt" name="excerpt" rows="3" placeholder="Brief description of the post..."></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="postStatus" class="form-label">Status</label>
                                <select class="form-select" id="postStatus" name="status">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                    <option value="archived">Archived</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="postCategory" class="form-label">Category</label>
                                <select class="form-select" id="postCategory" name="category_id">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="postAuthor" class="form-label">Author</label>
                                <input type="text" class="form-control" id="postAuthor" name="author" value="Admin">
                            </div>
                            <div class="mb-3">
                                <label for="postTags" class="form-label">Tags</label>
                                <input type="text" class="form-control" id="postTags" name="tags" placeholder="tag1, tag2, tag3">
                            </div>
                            <div class="mb-3">
                                <label for="postFeaturedImage" class="form-label">Featured Image</label>
                                <input type="file" class="form-control" id="postFeaturedImage" name="featured_image" accept="image/*">
                                <div class="mt-2" id="imagePreview"></div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="postFeatured" name="is_featured">
                                    <label class="form-check-label" for="postFeatured">
                                        Featured Post
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line me-1"></i>Save Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Post Detail Modal -->
<div class="modal fade" id="postDetailModal" tabindex="-1" aria-labelledby="postDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="postDetailModalLabel">
                    <i class="ri-eye-line me-2"></i>Post Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="postDetailContent">
                <!-- Post details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editPost()">Edit Post</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Blog Posts Styles */
.post-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    transition: all 0.3s ease;
    margin-bottom: 20px;
}

.post-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.post-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
}

.post-title {
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.post-meta {
    font-size: 0.85rem;
    color: #6c757d;
}

.status-badge {
    font-size: 0.75rem;
    padding: 4px 8px;
    border-radius: 12px;
}

.status-published {
    background: #d4edda;
    color: #155724;
}

.status-draft {
    background: #fff3cd;
    color: #856404;
}

.status-archived {
    background: #f8d7da;
    color: #721c24;
}

.category-badge {
    background: #e3f2fd;
    color: #1976d2;
    font-size: 0.75rem;
    padding: 2px 6px;
    border-radius: 8px;
}

.action-buttons {
    display: flex;
    gap: 5px;
}

.action-buttons .btn {
    padding: 4px 8px;
    font-size: 0.8rem;
}

/* Modal styles */
.modal-xl {
    max-width: 1200px;
}

/* Image preview */
#imagePreview img {
    max-width: 200px;
    max-height: 150px;
    border-radius: 6px;
    border: 1px solid #dee2e6;
}

/* Table styles */
.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.table td {
    vertical-align: middle;
}

/* Search and filter styles */
.input-group-text {
    background: #f8f9fa;
    border-color: #dee2e6;
}

.form-select, .form-control {
    border-color: #dee2e6;
}

.form-select:focus, .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Pagination styles */
.pagination .page-link {
    color: #007bff;
    border-color: #dee2e6;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
}

/* Responsive design */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.85rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .post-image {
        width: 40px;
        height: 40px;
    }
}
</style>

<script>
// Blog Posts Management
let blogPosts = [];
let blogCategories = [];
let currentPage = 1;
let postsPerPage = 10;
let currentFilter = {
    search: '',
    category: '',
    status: ''
};

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeBlogPosts();
});

function initializeBlogPosts() {
    loadBlogPosts();
    loadBlogCategories();
    setupEventListeners();
}

function loadBlogPosts() {
    // Load from localStorage or API
    const savedPosts = localStorage.getItem('blogPosts');
    if (savedPosts) {
        blogPosts = JSON.parse(savedPosts);
    } else {
        // Sample blog posts
        blogPosts = [
            {
                id: 1,
                title: 'Getting Started with Web Development',
                slug: 'getting-started-web-development',
                content: 'Web development is an exciting field that combines creativity with technical skills...',
                excerpt: 'Learn the basics of web development and start your journey as a developer.',
                author: 'Admin',
                category_id: 1,
                category_name: 'Web Development',
                status: 'published',
                featured_image: '/images/sample-post-1.jpg',
                tags: ['web development', 'programming', 'tutorial'],
                is_featured: true,
                created_at: '2024-01-15',
                updated_at: '2024-01-15'
            },
            {
                id: 2,
                title: 'Advanced JavaScript Techniques',
                slug: 'advanced-javascript-techniques',
                content: 'JavaScript is a powerful programming language that continues to evolve...',
                excerpt: 'Explore advanced JavaScript concepts and modern development practices.',
                author: 'Admin',
                category_id: 2,
                category_name: 'JavaScript',
                status: 'published',
                featured_image: '/images/sample-post-2.jpg',
                tags: ['javascript', 'programming', 'advanced'],
                is_featured: false,
                created_at: '2024-01-20',
                updated_at: '2024-01-20'
            },
            {
                id: 3,
                title: 'CSS Grid vs Flexbox: Which to Use?',
                slug: 'css-grid-vs-flexbox',
                content: 'Both CSS Grid and Flexbox are powerful layout systems...',
                excerpt: 'A comprehensive comparison of CSS Grid and Flexbox layout systems.',
                author: 'Admin',
                category_id: 1,
                category_name: 'Web Development',
                status: 'draft',
                featured_image: '/images/sample-post-3.jpg',
                tags: ['css', 'layout', 'web design'],
                is_featured: false,
                created_at: '2024-01-25',
                updated_at: '2024-01-25'
            }
        ];
    }
    
    renderPostsTable();
    updatePagination();
}

function loadBlogCategories() {
    const savedCategories = localStorage.getItem('blogCategories');
    if (savedCategories) {
        blogCategories = JSON.parse(savedCategories);
    } else {
        // Sample categories
        blogCategories = [
            { id: 1, name: 'Web Development', slug: 'web-development', description: 'Articles about web development' },
            { id: 2, name: 'JavaScript', slug: 'javascript', description: 'JavaScript tutorials and tips' },
            { id: 3, name: 'CSS', slug: 'css', description: 'CSS techniques and best practices' },
            { id: 4, name: 'PHP', slug: 'php', description: 'PHP development articles' },
            { id: 5, name: 'Laravel', slug: 'laravel', description: 'Laravel framework tutorials' }
        ];
    }
    
    populateCategoryFilter();
    populateCategorySelect();
}

function setupEventListeners() {
    // Search functionality
    document.getElementById('searchPosts').addEventListener('input', function() {
        currentFilter.search = this.value;
        filterPosts();
    });
    
    // Category filter
    document.getElementById('categoryFilter').addEventListener('change', function() {
        currentFilter.category = this.value;
        filterPosts();
    });
    
    // Status filter
    document.getElementById('statusFilter').addEventListener('change', function() {
        currentFilter.status = this.value;
        filterPosts();
    });
    
    // Select all checkbox
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('#postsTableBody input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    
    // Form submission
    document.getElementById('postForm').addEventListener('submit', function(e) {
        e.preventDefault();
        savePost();
    });
}

function renderPostsTable() {
    const tbody = document.getElementById('postsTableBody');
    const filteredPosts = getFilteredPosts();
    const startIndex = (currentPage - 1) * postsPerPage;
    const endIndex = startIndex + postsPerPage;
    const paginatedPosts = filteredPosts.slice(startIndex, endIndex);
    
    if (paginatedPosts.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8" class="text-center py-4">
                    <i class="ri-article-line text-muted" style="font-size: 3rem;"></i>
                    <h5 class="text-muted mt-3">No posts found</h5>
                    <p class="text-muted">Create your first blog post to get started.</p>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = paginatedPosts.map(post => `
        <tr>
            <td>
                <input type="checkbox" class="form-check-input" value="${post.id}">
            </td>
            <td>
                <img src="${post.featured_image || '/images/no-image.jpg'}" alt="${post.title}" class="post-image">
            </td>
            <td>
                <div class="post-title">${post.title}</div>
                <div class="post-meta">${post.excerpt || 'No excerpt'}</div>
            </td>
            <td>
                <span class="category-badge">${post.category_name || 'Uncategorized'}</span>
            </td>
            <td>${post.author}</td>
            <td>
                <span class="status-badge status-${post.status}">${post.status.charAt(0).toUpperCase() + post.status.slice(1)}</span>
            </td>
            <td>${formatDate(post.created_at)}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn btn-sm btn-outline-primary" onclick="viewPost(${post.id})" title="View">
                        <i class="ri-eye-line"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-success" onclick="editPost(${post.id})" title="Edit">
                        <i class="ri-edit-line"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deletePost(${post.id})" title="Delete">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function getFilteredPosts() {
    return blogPosts.filter(post => {
        const matchesSearch = !currentFilter.search || 
            post.title.toLowerCase().includes(currentFilter.search.toLowerCase()) ||
            post.content.toLowerCase().includes(currentFilter.search.toLowerCase());
        
        const matchesCategory = !currentFilter.category || 
            post.category_id == currentFilter.category;
        
        const matchesStatus = !currentFilter.status || 
            post.status === currentFilter.status;
        
        return matchesSearch && matchesCategory && matchesStatus;
    });
}

function filterPosts() {
    currentPage = 1;
    renderPostsTable();
    updatePagination();
}

function updatePagination() {
    const filteredPosts = getFilteredPosts();
    const totalPages = Math.ceil(filteredPosts.length / postsPerPage);
    const pagination = document.getElementById('postsPagination');
    
    if (totalPages <= 1) {
        pagination.innerHTML = '';
        return;
    }
    
    let paginationHTML = '';
    
    // Previous button
    paginationHTML += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Previous</a>
        </li>
    `;
    
    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
            paginationHTML += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                </li>
            `;
        } else if (i === currentPage - 3 || i === currentPage + 3) {
            paginationHTML += '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }
    
    // Next button
    paginationHTML += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Next</a>
        </li>
    `;
    
    pagination.innerHTML = paginationHTML;
}

function changePage(page) {
    const filteredPosts = getFilteredPosts();
    const totalPages = Math.ceil(filteredPosts.length / postsPerPage);
    
    if (page >= 1 && page <= totalPages) {
        currentPage = page;
        renderPostsTable();
        updatePagination();
    }
}

function populateCategoryFilter() {
    const select = document.getElementById('categoryFilter');
    select.innerHTML = '<option value="">All Categories</option>' +
        blogCategories.map(category => 
            `<option value="${category.id}">${category.name}</option>`
        ).join('');
}

function populateCategorySelect() {
    const select = document.getElementById('postCategory');
    select.innerHTML = '<option value="">Select Category</option>' +
        blogCategories.map(category => 
            `<option value="${category.id}">${category.name}</option>`
        ).join('');
}

function showAddPostModal() {
    document.getElementById('postModalLabel').innerHTML = '<i class="ri-article-line me-2"></i>Add New Post';
    document.getElementById('postForm').reset();
    document.getElementById('postForm').setAttribute('data-mode', 'add');
    new bootstrap.Modal(document.getElementById('postModal')).show();
}

function editPost(id) {
    const post = blogPosts.find(p => p.id === id);
    if (!post) return;
    
    document.getElementById('postModalLabel').innerHTML = '<i class="ri-edit-line me-2"></i>Edit Post';
    document.getElementById('postForm').setAttribute('data-mode', 'edit');
    document.getElementById('postForm').setAttribute('data-id', id);
    
    // Populate form
    document.getElementById('postTitle').value = post.title;
    document.getElementById('postSlug').value = post.slug;
    document.getElementById('postContent').value = post.content;
    document.getElementById('postExcerpt').value = post.excerpt;
    document.getElementById('postStatus').value = post.status;
    document.getElementById('postCategory').value = post.category_id;
    document.getElementById('postAuthor').value = post.author;
    document.getElementById('postTags').value = post.tags ? post.tags.join(', ') : '';
    document.getElementById('postFeatured').checked = post.is_featured;
    
    new bootstrap.Modal(document.getElementById('postModal')).show();
}

function viewPost(id) {
    const post = blogPosts.find(p => p.id === id);
    if (!post) return;
    
    const content = `
        <div class="row">
            <div class="col-md-4">
                <img src="${post.featured_image || '/images/no-image.jpg'}" alt="${post.title}" class="img-fluid rounded">
            </div>
            <div class="col-md-8">
                <h4>${post.title}</h4>
                <p class="text-muted">By ${post.author} on ${formatDate(post.created_at)}</p>
                <p><strong>Status:</strong> <span class="status-badge status-${post.status}">${post.status.charAt(0).toUpperCase() + post.status.slice(1)}</span></p>
                <p><strong>Category:</strong> <span class="category-badge">${post.category_name || 'Uncategorized'}</span></p>
                <p><strong>Tags:</strong> ${post.tags ? post.tags.map(tag => `<span class="badge bg-secondary me-1">${tag}</span>`).join('') : 'None'}</p>
                <p><strong>Featured:</strong> ${post.is_featured ? 'Yes' : 'No'}</p>
            </div>
        </div>
        <hr>
        <div class="mt-3">
            <h6>Excerpt:</h6>
            <p>${post.excerpt || 'No excerpt available'}</p>
        </div>
        <div class="mt-3">
            <h6>Content:</h6>
            <div style="max-height: 300px; overflow-y: auto; border: 1px solid #dee2e6; padding: 15px; border-radius: 6px;">
                ${post.content}
            </div>
        </div>
    `;
    
    document.getElementById('postDetailContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('postDetailModal')).show();
}

function savePost() {
    const form = document.getElementById('postForm');
    const formData = new FormData(form);
    const mode = form.getAttribute('data-mode');
    
    const postData = {
        title: formData.get('title'),
        slug: formData.get('slug') || generateSlug(formData.get('title')),
        content: formData.get('content'),
        excerpt: formData.get('excerpt'),
        status: formData.get('status'),
        category_id: parseInt(formData.get('category_id')) || null,
        author: formData.get('author'),
        tags: formData.get('tags').split(',').map(tag => tag.trim()).filter(tag => tag),
        is_featured: formData.get('is_featured') === 'on',
        featured_image: formData.get('featured_image') ? URL.createObjectURL(formData.get('featured_image')) : null
    };
    
    if (mode === 'add') {
        postData.id = Date.now();
        postData.created_at = new Date().toISOString().split('T')[0];
        postData.updated_at = new Date().toISOString().split('T')[0];
        
        // Get category name
        const category = blogCategories.find(c => c.id === postData.category_id);
        postData.category_name = category ? category.name : 'Uncategorized';
        
        blogPosts.unshift(postData);
    } else {
        const id = parseInt(form.getAttribute('data-id'));
        const postIndex = blogPosts.findIndex(p => p.id === id);
        if (postIndex !== -1) {
            postData.id = id;
            postData.created_at = blogPosts[postIndex].created_at;
            postData.updated_at = new Date().toISOString().split('T')[0];
            
            // Get category name
            const category = blogCategories.find(c => c.id === postData.category_id);
            postData.category_name = category ? category.name : 'Uncategorized';
            
            blogPosts[postIndex] = postData;
        }
    }
    
    // Save to localStorage
    localStorage.setItem('blogPosts', JSON.stringify(blogPosts));
    
    // Close modal and refresh
    bootstrap.Modal.getInstance(document.getElementById('postModal')).hide();
    renderPostsTable();
    updatePagination();
    
    showNotification(`Post ${mode === 'add' ? 'created' : 'updated'} successfully!`, 'success');
}

function deletePost(id) {
    if (confirm('Are you sure you want to delete this post?')) {
        blogPosts = blogPosts.filter(post => post.id !== id);
        localStorage.setItem('blogPosts', JSON.stringify(blogPosts));
        renderPostsTable();
        updatePagination();
        showNotification('Post deleted successfully!', 'success');
    }
}

function refreshPosts() {
    loadBlogPosts();
    showNotification('Posts refreshed!', 'success');
}

function generateSlug(title) {
    return title.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
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
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endsection
