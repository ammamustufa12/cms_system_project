@extends('twill::layouts.main')

@section('title', 'Blog Categories Management')

@section('content')
<div class="container-fluid" style="padding-top: 100px;padding-bottom:100px">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Blog Categories</h2>
                    <p class="text-muted mb-0">Manage your blog categories and organize your content</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="refreshCategories()">
                        <i class="ri-refresh-line me-1"></i> Refresh
                    </button>
                    <button class="btn btn-primary" onclick="showAddCategoryModal()">
                        <i class="ri-add-line me-1"></i> Add New Category
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="ri-search-line"></i></span>
                <input type="text" class="form-control" id="searchCategories" placeholder="Search categories...">
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="row" id="categoriesGrid">
        <!-- Categories will be loaded here -->
    </div>

    <!-- Categories Table View -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Categories List</h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-sm active" onclick="toggleView('table')">
                            <i class="ri-table-line me-1"></i> Table
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="toggleView('grid')">
                            <i class="ri-grid-line me-1"></i> Grid
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="categoriesTable">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">
                                        <input type="checkbox" class="form-check-input" id="selectAllCategories">
                                    </th>
                                    <th width="10%">Color</th>
                                    <th width="25%">Name</th>
                                    <th width="20%">Slug</th>
                                    <th width="30%">Description</th>
                                    <th width="10%">Posts Count</th>
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="categoriesTableBody">
                                <!-- Categories will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">
                    <i class="ri-price-tag-3-line me-2"></i>Add New Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="categoryForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="categoryName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="categorySlug" class="form-label">URL Slug</label>
                                <input type="text" class="form-control" id="categorySlug" name="slug" placeholder="auto-generated-from-name">
                            </div>
                            <div class="mb-3">
                                <label for="categoryDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="categoryDescription" name="description" rows="4" placeholder="Describe this category..."></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="categoryColor" class="form-label">Category Color</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" id="categoryColor" name="color" value="#007bff">
                                    <span class="input-group-text" id="colorPreview">#007bff</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="categoryIcon" class="form-label">Icon</label>
                                <select class="form-select" id="categoryIcon" name="icon">
                                    <option value="ri-price-tag-3-line">Tag</option>
                                    <option value="ri-code-line">Code</option>
                                    <option value="ri-palette-line">Design</option>
                                    <option value="ri-database-line">Database</option>
                                    <option value="ri-server-line">Server</option>
                                    <option value="ri-smartphone-line">Mobile</option>
                                    <option value="ri-global-line">Web</option>
                                    <option value="ri-tools-line">Tools</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="categoryActive" name="is_active" checked>
                                    <label class="form-check-label" for="categoryActive">
                                        Active
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="categoryParent" class="form-label">Parent Category</label>
                                <select class="form-select" id="categoryParent" name="parent_id">
                                    <option value="">No Parent (Top Level)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line me-1"></i>Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Category Detail Modal -->
<div class="modal fade" id="categoryDetailModal" tabindex="-1" aria-labelledby="categoryDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryDetailModalLabel">
                    <i class="ri-eye-line me-2"></i>Category Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="categoryDetailContent">
                <!-- Category details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editCategory()">Edit Category</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Categories Styles */
.category-card {
    border: 1px solid #dee2e6;
    border-radius: 12px;
    transition: all 0.3s ease;
    margin-bottom: 20px;
    background: white;
    overflow: hidden;
}

.category-card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    transform: translateY(-5px);
}

.category-header {
    padding: 20px;
    background: linear-gradient(135deg, var(--category-color, #007bff), var(--category-color-light, #0056b3));
    color: white;
    position: relative;
}

.category-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.1;
}

.category-icon {
    font-size: 2rem;
    margin-bottom: 10px;
    display: block;
}

.category-name {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
}

.category-meta {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-top: 5px;
}

.category-body {
    padding: 20px;
}

.category-description {
    color: #6c757d;
    margin-bottom: 15px;
    line-height: 1.5;
}

.category-stats {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background: #f8f9fa;
    border-top: 1px solid #dee2e6;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--category-color, #007bff);
    display: block;
}

.stat-label {
    font-size: 0.8rem;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.category-actions {
    position: absolute;
    top: 15px;
    right: 15px;
    display: flex;
    gap: 5px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.category-card:hover .category-actions {
    opacity: 1;
}

.category-actions .btn {
    padding: 6px 10px;
    font-size: 0.8rem;
    border-radius: 6px;
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

.category-color-preview {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 2px solid #dee2e6;
    display: inline-block;
}

.category-badge {
    font-size: 0.75rem;
    padding: 4px 8px;
    border-radius: 12px;
    font-weight: 500;
}

/* Form styles */
.form-control-color {
    height: 38px;
    padding: 6px;
}

#colorPreview {
    font-family: monospace;
    font-size: 0.9rem;
}

/* Responsive design */
@media (max-width: 768px) {
    .category-card {
        margin-bottom: 15px;
    }
    
    .category-header {
        padding: 15px;
    }
    
    .category-body {
        padding: 15px;
    }
    
    .category-stats {
        padding: 10px 15px;
    }
    
    .table-responsive {
        font-size: 0.85rem;
    }
}

/* Animation for category cards */
.category-card {
    animation: slideInUp 0.5s ease-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Empty state */
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
// Blog Categories Management
let blogCategories = [];
let currentView = 'table';
let currentSearch = '';

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeCategories();
});

function initializeCategories() {
    loadCategories();
    setupEventListeners();
}

function loadCategories() {
    // Load from localStorage or API
    const savedCategories = localStorage.getItem('blogCategories');
    if (savedCategories) {
        blogCategories = JSON.parse(savedCategories);
    } else {
        // Sample categories
        blogCategories = [
            {
                id: 1,
                name: 'Web Development',
                slug: 'web-development',
                description: 'Articles about web development, HTML, CSS, JavaScript, and modern frameworks.',
                color: '#007bff',
                icon: 'ri-code-line',
                is_active: true,
                parent_id: null,
                posts_count: 15,
                created_at: '2024-01-01'
            },
            {
                id: 2,
                name: 'JavaScript',
                slug: 'javascript',
                description: 'JavaScript tutorials, tips, and advanced concepts.',
                color: '#f7df1e',
                icon: 'ri-javascript-line',
                is_active: true,
                parent_id: 1,
                posts_count: 8,
                created_at: '2024-01-02'
            },
            {
                id: 3,
                name: 'CSS',
                slug: 'css',
                description: 'CSS techniques, layouts, animations, and best practices.',
                color: '#1572b6',
                icon: 'ri-palette-line',
                is_active: true,
                parent_id: 1,
                posts_count: 12,
                created_at: '2024-01-03'
            },
            {
                id: 4,
                name: 'PHP',
                slug: 'php',
                description: 'PHP development, Laravel framework, and backend programming.',
                color: '#777bb4',
                icon: 'ri-server-line',
                is_active: true,
                parent_id: null,
                posts_count: 6,
                created_at: '2024-01-04'
            },
            {
                id: 5,
                name: 'Laravel',
                slug: 'laravel',
                description: 'Laravel framework tutorials, tips, and best practices.',
                color: '#ff2d20',
                icon: 'ri-tools-line',
                is_active: true,
                parent_id: 4,
                posts_count: 9,
                created_at: '2024-01-05'
            }
        ];
    }
    
    renderCategories();
    populateParentSelect();
}

function setupEventListeners() {
    // Search functionality
    document.getElementById('searchCategories').addEventListener('input', function() {
        currentSearch = this.value;
        renderCategories();
    });
    
    // Color picker
    document.getElementById('categoryColor').addEventListener('change', function() {
        document.getElementById('colorPreview').textContent = this.value;
    });
    
    // Select all checkbox
    document.getElementById('selectAllCategories').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('#categoriesTableBody input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    
    // Form submission
    document.getElementById('categoryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        saveCategory();
    });
}

function renderCategories() {
    const filteredCategories = getFilteredCategories();
    
    if (currentView === 'grid') {
        renderCategoriesGrid(filteredCategories);
    } else {
        renderCategoriesTable(filteredCategories);
    }
}

function renderCategoriesGrid(categories) {
    const grid = document.getElementById('categoriesGrid');
    
    if (categories.length === 0) {
        grid.innerHTML = `
            <div class="col-12">
                <div class="empty-state">
                    <i class="ri-price-tag-3-line"></i>
                    <h5>No categories found</h5>
                    <p>Create your first category to get started.</p>
                </div>
            </div>
        `;
        return;
    }
    
    grid.innerHTML = categories.map(category => `
        <div class="col-md-6 col-lg-4">
            <div class="category-card" style="--category-color: ${category.color}; --category-color-light: ${lightenColor(category.color, 20)}">
                <div class="category-header">
                    <div class="category-actions">
                        <button class="btn btn-sm btn-light" onclick="viewCategory(${category.id})" title="View">
                            <i class="ri-eye-line"></i>
                        </button>
                        <button class="btn btn-sm btn-light" onclick="editCategory(${category.id})" title="Edit">
                            <i class="ri-edit-line"></i>
                        </button>
                        <button class="btn btn-sm btn-light" onclick="deleteCategory(${category.id})" title="Delete">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                    <i class="${category.icon} category-icon"></i>
                    <h4 class="category-name">${category.name}</h4>
                    <div class="category-meta">
                        ${category.parent_id ? 'Subcategory' : 'Main Category'} • ${category.posts_count} posts
                    </div>
                </div>
                <div class="category-body">
                    <p class="category-description">${category.description || 'No description available'}</p>
                </div>
                <div class="category-stats">
                    <div class="stat-item">
                        <span class="stat-number">${category.posts_count}</span>
                        <span class="stat-label">Posts</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">${category.is_active ? 'Active' : 'Inactive'}</span>
                        <span class="stat-label">Status</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">${formatDate(category.created_at)}</span>
                        <span class="stat-label">Created</span>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

function renderCategoriesTable(categories) {
    const tbody = document.getElementById('categoriesTableBody');
    
    if (categories.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-4">
                    <i class="ri-price-tag-3-line text-muted" style="font-size: 3rem;"></i>
                    <h5 class="text-muted mt-3">No categories found</h5>
                    <p class="text-muted">Create your first category to get started.</p>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = categories.map(category => `
        <tr>
            <td>
                <input type="checkbox" class="form-check-input" value="${category.id}">
            </td>
            <td>
                <div class="category-color-preview" style="background-color: ${category.color}"></div>
            </td>
            <td>
                <div class="d-flex align-items-center">
                    <i class="${category.icon} me-2" style="color: ${category.color}"></i>
                    <div>
                        <div class="fw-semibold">${category.name}</div>
                        ${category.parent_id ? '<small class="text-muted">Subcategory</small>' : ''}
                    </div>
                </div>
            </td>
            <td>
                <code>${category.slug}</code>
            </td>
            <td>
                <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    ${category.description || 'No description'}
                </div>
            </td>
            <td>
                <span class="badge bg-primary">${category.posts_count}</span>
            </td>
            <td>
                <div class="d-flex gap-1">
                    <button class="btn btn-sm btn-outline-primary" onclick="viewCategory(${category.id})" title="View">
                        <i class="ri-eye-line"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-success" onclick="editCategory(${category.id})" title="Edit">
                        <i class="ri-edit-line"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteCategory(${category.id})" title="Delete">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function getFilteredCategories() {
    return blogCategories.filter(category => {
        const matchesSearch = !currentSearch || 
            category.name.toLowerCase().includes(currentSearch.toLowerCase()) ||
            category.description.toLowerCase().includes(currentSearch.toLowerCase()) ||
            category.slug.toLowerCase().includes(currentSearch.toLowerCase());
        
        return matchesSearch;
    });
}

function toggleView(view) {
    currentView = view;
    
    // Update button states
    document.querySelectorAll('.btn-group .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // Show/hide elements
    if (view === 'grid') {
        document.getElementById('categoriesGrid').style.display = 'block';
        document.getElementById('categoriesTable').closest('.card').style.display = 'none';
    } else {
        document.getElementById('categoriesGrid').style.display = 'none';
        document.getElementById('categoriesTable').closest('.card').style.display = 'block';
    }
    
    renderCategories();
}

function populateParentSelect() {
    const select = document.getElementById('categoryParent');
    select.innerHTML = '<option value="">No Parent (Top Level)</option>' +
        blogCategories.filter(cat => !cat.parent_id).map(category => 
            `<option value="${category.id}">${category.name}</option>`
        ).join('');
}

function showAddCategoryModal() {
    document.getElementById('categoryModalLabel').innerHTML = '<i class="ri-price-tag-3-line me-2"></i>Add New Category';
    document.getElementById('categoryForm').reset();
    document.getElementById('categoryForm').setAttribute('data-mode', 'add');
    document.getElementById('colorPreview').textContent = '#007bff';
    new bootstrap.Modal(document.getElementById('categoryModal')).show();
}

function editCategory(id) {
    const category = blogCategories.find(c => c.id === id);
    if (!category) return;
    
    document.getElementById('categoryModalLabel').innerHTML = '<i class="ri-edit-line me-2"></i>Edit Category';
    document.getElementById('categoryForm').setAttribute('data-mode', 'edit');
    document.getElementById('categoryForm').setAttribute('data-id', id);
    
    // Populate form
    document.getElementById('categoryName').value = category.name;
    document.getElementById('categorySlug').value = category.slug;
    document.getElementById('categoryDescription').value = category.description;
    document.getElementById('categoryColor').value = category.color;
    document.getElementById('categoryIcon').value = category.icon;
    document.getElementById('categoryActive').checked = category.is_active;
    document.getElementById('categoryParent').value = category.parent_id || '';
    document.getElementById('colorPreview').textContent = category.color;
    
    new bootstrap.Modal(document.getElementById('categoryModal')).show();
}

function viewCategory(id) {
    const category = blogCategories.find(c => c.id === id);
    if (!category) return;
    
    const content = `
        <div class="row">
            <div class="col-md-4">
                <div class="text-center">
                    <div class="category-color-preview mx-auto mb-3" style="width: 80px; height: 80px; background-color: ${category.color}"></div>
                    <h4>${category.name}</h4>
                    <p class="text-muted">${category.slug}</p>
                </div>
            </div>
            <div class="col-md-8">
                <h6>Description:</h6>
                <p>${category.description || 'No description available'}</p>
                
                <h6>Details:</h6>
                <ul class="list-unstyled">
                    <li><strong>Status:</strong> ${category.is_active ? 'Active' : 'Inactive'}</li>
                    <li><strong>Posts Count:</strong> ${category.posts_count}</li>
                    <li><strong>Parent Category:</strong> ${category.parent_id ? getCategoryName(category.parent_id) : 'None'}</li>
                    <li><strong>Created:</strong> ${formatDate(category.created_at)}</li>
                </ul>
            </div>
        </div>
    `;
    
    document.getElementById('categoryDetailContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('categoryDetailModal')).show();
}

function saveCategory() {
    const form = document.getElementById('categoryForm');
    const formData = new FormData(form);
    const mode = form.getAttribute('data-mode');
    
    const categoryData = {
        name: formData.get('name'),
        slug: formData.get('slug') || generateSlug(formData.get('name')),
        description: formData.get('description'),
        color: formData.get('color'),
        icon: formData.get('icon'),
        is_active: formData.get('is_active') === 'on',
        parent_id: formData.get('parent_id') ? parseInt(formData.get('parent_id')) : null
    };
    
    if (mode === 'add') {
        categoryData.id = Date.now();
        categoryData.posts_count = 0;
        categoryData.created_at = new Date().toISOString().split('T')[0];
        
        blogCategories.push(categoryData);
    } else {
        const id = parseInt(form.getAttribute('data-id'));
        const categoryIndex = blogCategories.findIndex(c => c.id === id);
        if (categoryIndex !== -1) {
            categoryData.id = id;
            categoryData.posts_count = blogCategories[categoryIndex].posts_count;
            categoryData.created_at = blogCategories[categoryIndex].created_at;
            
            blogCategories[categoryIndex] = categoryData;
        }
    }
    
    // Save to localStorage
    localStorage.setItem('blogCategories', JSON.stringify(blogCategories));
    
    // Close modal and refresh
    bootstrap.Modal.getInstance(document.getElementById('categoryModal')).hide();
    renderCategories();
    
    showNotification(`Category ${mode === 'add' ? 'created' : 'updated'} successfully!`, 'success');
}

function deleteCategory(id) {
    if (confirm('Are you sure you want to delete this category?')) {
        // Check if category has posts
        const category = blogCategories.find(c => c.id === id);
        if (category && category.posts_count > 0) {
            showNotification('Cannot delete category with posts!', 'error');
            return;
        }
        
        blogCategories = blogCategories.filter(category => category.id !== id);
        localStorage.setItem('blogCategories', JSON.stringify(blogCategories));
        renderCategories();
        showNotification('Category deleted successfully!', 'success');
    }
}

function refreshCategories() {
    loadCategories();
    showNotification('Categories refreshed!', 'success');
}

function getCategoryName(id) {
    const category = blogCategories.find(c => c.id === id);
    return category ? category.name : 'Unknown';
}

function generateSlug(name) {
    return name.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
}

function lightenColor(color, percent) {
    const num = parseInt(color.replace("#", ""), 16);
    const amt = Math.round(2.55 * percent);
    const R = (num >> 16) + amt;
    const G = (num >> 8 & 0x00FF) + amt;
    const B = (num & 0x0000FF) + amt;
    return "#" + (0x1000000 + (R < 255 ? R < 1 ? 0 : R : 255) * 0x10000 +
        (G < 255 ? G < 1 ? 0 : G : 255) * 0x100 +
        (B < 255 ? B < 1 ? 0 : B : 255)).toString(16).slice(1);
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
