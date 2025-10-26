@extends('twill::layouts.main')

@section('title', 'Menu Management')

@section('content')
<div class="container-fluid" style="padding-top: 100px;padding-bottom:100px">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Menu Management</h2>
                    <p class="text-muted mb-0">Edit your menu below, or create a new menu. Do not forget to save your changes!</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary">
                        <i class="ri-search-line me-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Left Column: Add Menu Items -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Add menu items</h5>
                </div>
                <div class="card-body p-0">
                    <!-- Pages Section -->
                    <div class="menu-category">
                        <div class="category-header" data-bs-toggle="collapse" data-bs-target="#pagesCollapse">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="ri-file-line me-2"></i>Pages</span>
                                <i class="ri-arrow-down-s-line"></i>
                            </div>
                        </div>
                        <div class="collapse show" id="pagesCollapse">
                            <div class="category-content">
                                <div class="nav nav-tabs nav-justified mb-3" role="tablist">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#mostRecent">Most Recent</button>
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#viewAll">View All</button>
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#searchPages">Search</button>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="mostRecent">
                                        <div class="menu-items-list">
                                            <div class="menu-item-checkbox">
                                                <input type="checkbox" id="page1" class="form-check-input">
                                                <label for="page1" class="form-check-label">Home — Elementor</label>
                                            </div>
                                            <div class="menu-item-checkbox">
                                                <input type="checkbox" id="page2" class="form-check-input">
                                                <label for="page2" class="form-check-label">About — Elementor</label>
                                            </div>
                                            <div class="menu-item-checkbox">
                                                <input type="checkbox" id="page3" class="form-check-input">
                                                <label for="page3" class="form-check-label">Services — Elementor</label>
                                            </div>
                                            <div class="menu-item-checkbox">
                                                <input type="checkbox" id="page4" class="form-check-input">
                                                <label for="page4" class="form-check-label">Contact — Elementor</label>
                                            </div>
                                            <div class="menu-item-checkbox">
                                                <input type="checkbox" id="page5" class="form-check-input">
                                                <label for="page5" class="form-check-label">Blog — Elementor</label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="selectAll">
                                                <label for="selectAll" class="form-check-label">Select All</label>
                                            </div>
                                            <button class="btn btn-primary btn-sm" onclick="addToMenu()">Add to Menu</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Posts Section -->
                    <div class="menu-category">
                        <div class="category-header" data-bs-toggle="collapse" data-bs-target="#postsCollapse">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="ri-article-line me-2"></i>Posts</span>
                                <i class="ri-arrow-down-s-line"></i>
                            </div>
                        </div>
                        <div class="collapse" id="postsCollapse">
                            <div class="category-content">
                                <p class="text-muted p-3">No posts available</p>
                            </div>
                        </div>
                    </div>

                    <!-- Custom Links Section -->
                    <div class="menu-category">
                        <div class="category-header" data-bs-toggle="collapse" data-bs-target="#customLinksCollapse">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="ri-link me-2"></i>Custom Links</span>
                                <i class="ri-arrow-down-s-line"></i>
                            </div>
                        </div>
                        <div class="collapse" id="customLinksCollapse">
                            <div class="category-content p-3">
                                <div class="mb-3">
                                    <label class="form-label">URL</label>
                                    <input type="url" class="form-control" placeholder="https://">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Link Text</label>
                                    <input type="text" class="form-control" placeholder="Link Text">
                                </div>
                                <button class="btn btn-primary btn-sm" onclick="addCustomLink()">Add to Menu</button>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Section -->
                    <div class="menu-category">
                        <div class="category-header" data-bs-toggle="collapse" data-bs-target="#categoriesCollapse">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="ri-folder-line me-2"></i>Categories</span>
                                <i class="ri-arrow-down-s-line"></i>
                            </div>
                        </div>
                        <div class="collapse" id="categoriesCollapse">
                            <div class="category-content">
                                <p class="text-muted p-3">No categories available</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Menu Structure -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Menu structure</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Menu Name</label>
                        <input type="text" class="form-control" value="Main Menu" id="menuName">
                    </div>
                    
                    <div class="alert alert-info mb-3">
                        <h6><i class="ri-information-line me-2"></i>How to Create Submenus:</h6>
                        <ul class="mb-0 small">
                            <li><strong>Regular reordering:</strong> Drag and drop items normally</li>
                            <li><strong>Create submenu:</strong> Hold <kbd>Shift</kbd> or <kbd>Ctrl</kbd> while dragging to create submenus</li>
                            <li><strong>Nested submenus:</strong> You can create multiple levels of submenus</li>
                            <li><strong>Visual feedback:</strong> Green dashed border indicates submenu drop zone</li>
                        </ul>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="bulkSelect">
                            <label for="bulkSelect" class="form-check-label">Bulk Select</label>
                        </div>
                    </div>

                    <!-- Menu Items List -->
                    <div class="menu-structure" id="menuStructure">
                        <div class="menu-item" data-id="1">
                            <div class="menu-item-content">
                                <div class="menu-item-title">Home</div>
                                <div class="menu-item-type">Custom Link</div>
                            </div>
                            <div class="menu-item-actions">
                                <i class="ri-arrow-down-s-line"></i>
                            </div>
                        </div>
                        
                        <div class="menu-item" data-id="2">
                            <div class="menu-item-content">
                                <div class="menu-item-title">About</div>
                                <div class="menu-item-type">Custom Link</div>
                            </div>
                            <div class="menu-item-actions">
                                <i class="ri-arrow-down-s-line"></i>
                            </div>
                        </div>
                        
                        <div class="menu-item" data-id="3">
                            <div class="menu-item-content">
                                <div class="menu-item-title">Services</div>
                                <div class="menu-item-type">Custom Link</div>
                            </div>
                            <div class="menu-item-actions">
                                <i class="ri-arrow-down-s-line"></i>
                            </div>
                        </div>
                        
                        <div class="menu-item" data-id="4">
                            <div class="menu-item-content">
                                <div class="menu-item-title">Projects</div>
                                <div class="menu-item-type">Custom Link</div>
                            </div>
                            <div class="menu-item-actions">
                                <i class="ri-arrow-down-s-line"></i>
                            </div>
                        </div>
                        
                        <div class="menu-item" data-id="5">
                            <div class="menu-item-content">
                                <div class="menu-item-title">Contact</div>
                                <div class="menu-item-type">Custom Link</div>
                            </div>
                            <div class="menu-item-actions">
                                <i class="ri-arrow-down-s-line"></i>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="bulkSelectBottom">
                            <label for="bulkSelectBottom" class="form-check-label">Bulk Select</label>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button class="btn btn-primary" onclick="saveMenu()">Save Menu</button>
                        <button class="btn btn-outline-danger" onclick="deleteMenu()">Delete Menu</button>
                        <button class="btn btn-outline-info" onclick="testSubmenuCreation()">Test Submenu</button>
                        <button class="btn btn-outline-success" onclick="createSubmenuManually()">Create Submenu</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Menu Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMenuModalLabel">
                    <i class="ri-add-line me-2"></i>Add Menu Item
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addMenuForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="menuTitle" class="form-label">Menu Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="menuTitle" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="menuUrl" class="form-label">URL</label>
                                <input type="text" class="form-control" id="menuUrl" name="url" placeholder="/page-url">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="menuIcon" class="form-label">Icon</label>
                                <select class="form-select" id="menuIcon" name="icon">
                                    <option value="">Select Icon</option>
                                    <option value="ri-home-line">Home</option>
                                    <option value="ri-user-line">User</option>
                                    <option value="ri-settings-line">Settings</option>
                                    <option value="ri-file-line">File</option>
                                    <option value="ri-image-line">Image</option>
                                    <option value="ri-mail-line">Mail</option>
                                    <option value="ri-phone-line">Phone</option>
                                    <option value="ri-global-line">Global</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="menuOrder" class="form-label">Order</label>
                                <input type="number" class="form-control" id="menuOrder" name="order" value="0" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="menuDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="menuDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="parentMenu" class="form-label">Parent Menu</label>
                                <select class="form-select" id="parentMenu" name="parent_id">
                                    <option value="">No Parent (Top Level)</option>
                                    <!-- Parent options will be loaded here -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="menuActive" name="is_active" checked>
                                    <label class="form-check-label" for="menuActive">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line me-1"></i>Save Menu Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Menu Modal -->
<div class="modal fade" id="editMenuModal" tabindex="-1" aria-labelledby="editMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuModalLabel">
                    <i class="ri-edit-line me-2"></i>Edit Menu Item
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editMenuForm">
                <input type="hidden" id="editMenuId" name="id">
                <div class="modal-body">
                    <!-- Same form fields as add modal -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editMenuTitle" class="form-label">Menu Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editMenuTitle" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editMenuUrl" class="form-label">URL</label>
                                <input type="text" class="form-control" id="editMenuUrl" name="url">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editMenuIcon" class="form-label">Icon</label>
                                <select class="form-select" id="editMenuIcon" name="icon">
                                    <option value="">Select Icon</option>
                                    <option value="ri-home-line">Home</option>
                                    <option value="ri-user-line">User</option>
                                    <option value="ri-settings-line">Settings</option>
                                    <option value="ri-file-line">File</option>
                                    <option value="ri-image-line">Image</option>
                                    <option value="ri-mail-line">Mail</option>
                                    <option value="ri-phone-line">Phone</option>
                                    <option value="ri-global-line">Global</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editMenuOrder" class="form-label">Order</label>
                                <input type="number" class="form-control" id="editMenuOrder" name="order" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editMenuDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editMenuDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editParentMenu" class="form-label">Parent Menu</label>
                                <select class="form-select" id="editParentMenu" name="parent_id">
                                    <option value="">No Parent (Top Level)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="editMenuActive" name="is_active">
                                    <label class="form-check-label" for="editMenuActive">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line me-1"></i>Update Menu Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Menu Management Styles */
.menu-category {
    border-bottom: 1px solid #e9ecef;
}

.menu-category:last-child {
    border-bottom: none;
}

.category-header {
    padding: 15px 20px;
    background: #f8f9fa;
    cursor: pointer;
    transition: background-color 0.3s ease;
    border-bottom: 1px solid #e9ecef;
}

.category-header:hover {
    background: #e9ecef;
}

.category-header i {
    transition: transform 0.3s ease;
}

.category-header[aria-expanded="true"] i {
    transform: rotate(180deg);
}

.category-content {
    padding: 0;
}

.menu-items-list {
    max-height: 300px;
    overflow-y: auto;
    padding: 15px 20px;
}

.menu-item-checkbox {
    display: flex;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f1f3f4;
}

.menu-item-checkbox:last-child {
    border-bottom: none;
}

.menu-item-checkbox .form-check-input {
    margin-right: 10px;
}

.menu-item-checkbox .form-check-label {
    margin: 0;
    font-size: 0.9rem;
    color: #495057;
    cursor: pointer;
}

/* Menu Structure Styles */
.menu-structure {
    border: 1px solid #dee2e6;
    border-radius: 6px;
    background: #f8f9fa;
    min-height: 200px;
}

.menu-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    margin: 5px;
    cursor: move;
    transition: all 0.3s ease;
    position: relative;
}

.menu-item:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-color: #007bff;
}

.menu-item.dragging {
    opacity: 0.7;
    transform: rotate(2deg);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.menu-item-content {
    flex: 1;
}

.menu-item-title {
    font-weight: 500;
    color: #333;
    margin: 0;
    font-size: 0.95rem;
}

.menu-item-type {
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 2px;
}

.menu-item-actions {
    color: #6c757d;
    cursor: pointer;
    padding: 5px;
    border-radius: 3px;
    transition: all 0.3s ease;
}

.menu-item-actions:hover {
    color: #007bff;
    background: #f8f9ff;
}

/* Drag and Drop Styles */
.menu-structure.drag-over {
    border-color: #28a745;
    background: #f8fff8;
}

.menu-item.drag-over {
    border-color: #28a745;
    background: #f8fff8;
}

/* Responsive Design */
@media (max-width: 768px) {
    .col-md-4,
    .col-md-8 {
        margin-bottom: 20px;
    }
    
    .menu-item {
        padding: 10px 12px;
    }
    
    .menu-item-title {
        font-size: 0.9rem;
    }
    
    .menu-item-type {
        font-size: 0.75rem;
    }
}

/* Animation for menu items */
.menu-item {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Custom scrollbar for menu items list */
.menu-items-list::-webkit-scrollbar {
    width: 6px;
}

.menu-items-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.menu-items-list::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.menu-items-list::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Tab styles */
.nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    font-size: 0.85rem;
    padding: 8px 12px;
}

.nav-tabs .nav-link.active {
    color: #007bff;
    background: transparent;
    border-bottom: 2px solid #007bff;
}

.nav-tabs .nav-link:hover {
    border: none;
    color: #007bff;
}

/* Button styles */
.btn-primary {
    background: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background: #0056b3;
    border-color: #0056b3;
}

.btn-outline-danger {
    color: #dc3545;
    border-color: #dc3545;
}

.btn-outline-danger:hover {
    background: #dc3545;
    border-color: #dc3545;
}

/* Form styles */
.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}

/* Card styles */
.card {
    border: 1px solid #dee2e6;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    font-weight: 500;
}

/* Empty state */
.menu-structure:empty::before {
    content: "No menu items. Add items from the left panel.";
    display: block;
    text-align: center;
    color: #6c757d;
    padding: 40px 20px;
    font-style: italic;
}

/* Menu Options */
.menu-item-options {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 10;
    padding: 10px;
}

.menu-options {
    display: flex;
    gap: 5px;
}

.menu-options .btn {
    flex: 1;
    font-size: 0.8rem;
    padding: 4px 8px;
}

/* Notification styles */
.notification {
    animation: slideInRight 0.3s ease-out;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Drag and drop visual feedback */
.menu-item.dragging {
    opacity: 0.7;
    transform: rotate(2deg);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    z-index: 1000;
}

.menu-structure.drag-over {
    border-color: #28a745;
    background: #f8fff8;
}

.menu-item.drag-over {
    border-color: #28a745;
    background: #f8fff8;
}

/* Enhanced Sub-menu styling with better visual hierarchy */
.menu-item.level-0 {
    background: #ffffff;
    border-left: 4px solid #007bff;
    margin: 5px;
}

.menu-item.level-1 {
    background: #f8f9fa;
    border-left: 4px solid #28a745;
    margin: 3px 5px 3px 30px;
    border-radius: 4px;
}

.menu-item.level-2 {
    background: #e3f2fd;
    border-left: 4px solid #ffc107;
    margin: 3px 5px 3px 55px;
    border-radius: 4px;
}

.menu-item.level-3 {
    background: #fff3cd;
    border-left: 4px solid #fd7e14;
    margin: 3px 5px 3px 80px;
    border-radius: 4px;
}

.menu-item.level-4 {
    background: #f8d7da;
    border-left: 4px solid #dc3545;
    margin: 3px 5px 3px 105px;
    border-radius: 4px;
}

/* Submenu indicators */
.submenu-indicator {
    font-size: 0.75rem;
    color: #6c757d;
    background: #e9ecef;
    padding: 2px 6px;
    border-radius: 10px;
    margin-left: 8px;
}

.level-indicator {
    font-size: 0.7rem;
    color: #495057;
    background: #dee2e6;
    padding: 1px 4px;
    border-radius: 8px;
    margin-left: 5px;
}

.submenu-arrow {
    color: #007bff;
    margin-right: 5px;
    font-size: 0.9rem;
}

/* Enhanced drag and drop visual feedback */
.drop-zone-top {
    border-top: 3px solid #007bff !important;
    background: #e3f2fd !important;
}

.drop-zone-bottom {
    border-bottom: 3px solid #007bff !important;
    background: #e3f2fd !important;
}

.drop-zone-submenu {
    border: 2px dashed #28a745 !important;
    background: #e8f5e8 !important;
    position: relative;
}

.drop-zone-submenu::after {
    content: "Drop here to create submenu";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #28a745;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
    z-index: 10;
}

/* Sub-menu indicators */
.menu-item-title::before {
    content: '';
    display: inline-block;
    width: 0;
    height: 0;
    margin-right: 8px;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-top: 4px solid #6c757d;
    vertical-align: middle;
}

.menu-item[data-level="0"] .menu-item-title::before {
    display: none;
}

/* Modal styling */
.modal {
    background: rgba(0,0,0,0.5);
}

.modal-dialog {
    margin-top: 10vh;
}

.modal-content {
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
}

.modal-header {
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    border-radius: 8px 8px 0 0;
}

.modal-footer {
    background: #f8f9fa;
    border-top: 1px solid #dee2e6;
    border-radius: 0 0 8px 8px;
}

/* Drag and drop visual feedback for sub-menus */
.menu-item.drag-over[data-level="0"] {
    border-color: #007bff;
    background: #e3f2fd;
}

.menu-item.drag-over[data-level="1"] {
    border-color: #28a745;
    background: #e8f5e8;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .menu-options {
        flex-direction: column;
    }
    
    .menu-options .btn {
        margin-bottom: 5px;
    }
    
    .menu-item-options {
        position: relative;
        top: auto;
        left: auto;
        right: auto;
        margin-top: 10px;
    }
    
    /* Reduce indentation on mobile */
    .menu-item[data-level="1"] {
        margin-left: 10px;
    }
    
    .menu-item[data-level="2"] {
        margin-left: 20px;
    }
    
    .menu-item[data-level="3"] {
        margin-left: 30px;
    }
    
    .menu-item[data-level="4"] {
        margin-left: 40px;
    }
}
</style>

<script>
// Menu Management JavaScript
let menuItems = [];
let selectedItems = [];

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeMenuManagement();
});

function initializeMenuManagement() {
    // Load existing menu items
    loadMenuItems();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize drag and drop
    initializeDragAndDrop();
}

function loadMenuItems() {
    // Load from localStorage or API
    const savedMenu = localStorage.getItem('menuItems');
    if (savedMenu) {
        menuItems = JSON.parse(savedMenu);
    } else {
        // Default menu items
        menuItems = [
            {
                id: 1,
                title: 'Home',
                url: '/',
                type: 'Custom Link',
                order: 1,
                is_active: true
            },
            {
                id: 2,
                title: 'About',
                url: '/about',
                type: 'Custom Link',
                order: 2,
                is_active: true
            },
            {
                id: 3,
                title: 'Services',
                url: '/services',
                type: 'Custom Link',
                order: 3,
                is_active: true
            },
            {
                id: 4,
                title: 'Projects',
                url: '/projects',
                type: 'Custom Link',
                order: 4,
                is_active: true
            },
            {
                id: 5,
                title: 'Contact',
                url: '/contact',
                type: 'Custom Link',
                order: 5,
                is_active: true
            }
        ];
    }
    
    renderMenuStructure();
}

function setupEventListeners() {
    // Select All functionality
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.menu-item-checkbox input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    
    // Add to Menu button
    document.querySelector('button[onclick="addToMenu()"]')?.addEventListener('click', addToMenu);
    
    // Save Menu button
    document.querySelector('button:contains("Save Menu")')?.addEventListener('click', saveMenu);
    
    // Delete Menu button
    document.querySelector('button:contains("Delete Menu")')?.addEventListener('click', deleteMenu);
    
    // Menu item actions
    document.querySelectorAll('.menu-item-actions').forEach(action => {
        action.addEventListener('click', function() {
            const menuItem = this.closest('.menu-item');
            toggleMenuItemOptions(menuItem);
        });
    });
    
    // Custom Links form
    const customLinksForm = document.querySelector('#customLinksCollapse form');
    if (customLinksForm) {
        customLinksForm.addEventListener('submit', function(e) {
            e.preventDefault();
            addCustomLink();
        });
    }
}

function addToMenu() {
    const selectedCheckboxes = document.querySelectorAll('.menu-item-checkbox input[type="checkbox"]:checked');
    
    selectedCheckboxes.forEach(checkbox => {
        const label = checkbox.nextElementSibling;
        const title = label.textContent.split(' — ')[0];
        const type = label.textContent.includes('Elementor') ? 'Page' : 'Custom Link';
        
        const newItem = {
            id: Date.now() + Math.random(),
            title: title,
            url: type === 'Page' ? `/${title.toLowerCase()}` : '#',
            type: type,
            order: menuItems.length + 1,
            is_active: true
        };
        
        menuItems.push(newItem);
        checkbox.checked = false;
    });
    
    renderMenuStructure();
    showNotification('Items added to menu successfully!', 'success');
}

function addCustomLink() {
    const urlInput = document.querySelector('#customLinksCollapse input[type="url"]');
    const textInput = document.querySelector('#customLinksCollapse input[type="text"]');
    
    if (!urlInput.value || !textInput.value) {
        showNotification('Please fill in both URL and Link Text', 'error');
        return;
    }
    
    const newItem = {
        id: Date.now(),
        title: textInput.value,
        url: urlInput.value,
        type: 'Custom Link',
        order: menuItems.length + 1,
        is_active: true
    };
    
    menuItems.push(newItem);
    renderMenuStructure();
    
    // Clear form
    urlInput.value = '';
    textInput.value = '';
    
    showNotification('Custom link added to menu!', 'success');
}

function renderMenuStructure() {
    const container = document.getElementById('menuStructure');
    if (!container) return;
    
    // Sort by order
    const sortedItems = menuItems.sort((a, b) => a.order - b.order);
    
    container.innerHTML = '';
    
    if (sortedItems.length === 0) {
        container.innerHTML = '<div class="text-center py-4 text-muted">No menu items. Add items from the left panel.</div>';
        return;
    }
    
    // Render hierarchical structure
    renderMenuHierarchy(sortedItems, container, 0);
    
    // Save to localStorage
    localStorage.setItem('menuItems', JSON.stringify(menuItems));
}

function renderMenuHierarchy(items, container, level) {
    items.forEach(item => {
        const menuItemElement = createMenuItemElement(item, level);
        container.appendChild(menuItemElement);
        
        // Render children if they exist
        if (item.children && item.children.length > 0) {
            const sortedChildren = item.children.sort((a, b) => a.order - b.order);
            renderMenuHierarchy(sortedChildren, container, level + 1);
        }
    });
}

function createMenuItemElement(item, level = 0) {
    const div = document.createElement('div');
    div.className = 'menu-item';
    div.draggable = true;
    div.dataset.id = item.id;
    div.dataset.level = level;
    
    // Add visual indicators for submenu levels
    const levelClass = `level-${level}`;
    div.classList.add(levelClass);
    
    // Create indentation for sub-items
    const indentPx = level * 25;
    const indentStyle = level > 0 ? `style="margin-left: ${indentPx}px; padding-left: 15px;"` : '';
    
    // Create submenu indicator
    const submenuIndicator = item.children && item.children.length > 0 ? 
        `<span class="submenu-indicator">(${item.children.length} sub-items)</span>` : '';
    
    // Create level indicator
    const levelIndicator = level > 0 ? `<span class="level-indicator">Level ${level}</span>` : '';
    
    div.innerHTML = `
        <div class="menu-item-content" ${indentStyle}>
            <div class="menu-item-header">
                <div class="menu-item-title">
                    ${level > 0 ? '<i class="ri-arrow-right-s-line submenu-arrow"></i>' : ''}${item.title}
                    ${submenuIndicator}
                </div>
                <div class="menu-item-meta">
                    <span class="menu-item-type">${item.type}</span>
                    ${levelIndicator}
                </div>
            </div>
        </div>
        <div class="menu-item-actions">
            <i class="ri-arrow-down-s-line"></i>
        </div>
    `;
    
    // Add event listeners
    div.addEventListener('dragstart', handleDragStart);
    div.addEventListener('dragover', handleDragOver);
    div.addEventListener('drop', handleDrop);
    div.addEventListener('dragend', handleDragEnd);
    
    return div;
}

function initializeDragAndDrop() {
    const menuStructure = document.getElementById('menuStructure');
    if (!menuStructure) return;
    
    menuStructure.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.add('drag-over');
    });
    
    menuStructure.addEventListener('dragleave', function(e) {
        // Only remove drag-over if we're leaving the container entirely
        if (!this.contains(e.relatedTarget)) {
            this.classList.remove('drag-over');
        }
    });
    
    menuStructure.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('drag-over');
    });
    
    // Add drag enter/leave for better visual feedback
    menuStructure.addEventListener('dragenter', function(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    });
}

function handleDragStart(e) {
    this.classList.add('dragging');
    e.dataTransfer.setData('text/plain', this.dataset.id);
    console.log('Drag started:', this.dataset.id);
}

function handleDragOver(e) {
    e.preventDefault();
    e.stopPropagation();
    this.classList.add('drag-over');
    
    // Add visual feedback for drop zones
    const rect = this.getBoundingClientRect();
    const midpoint = rect.top + rect.height / 2;
    
    // Remove existing drop zone classes
    this.classList.remove('drop-zone-top', 'drop-zone-bottom', 'drop-zone-submenu');
    
    if (e.clientY < midpoint) {
        this.classList.add('drop-zone-top');
    } else {
        if (e.shiftKey || e.ctrlKey) {
            this.classList.add('drop-zone-submenu');
        } else {
            this.classList.add('drop-zone-bottom');
        }
    }
}

function handleDrop(e) {
    e.preventDefault();
    e.stopPropagation();
    this.classList.remove('drag-over');
    
    const draggedId = e.dataTransfer.getData('text/plain');
    const draggedElement = document.querySelector(`[data-id="${draggedId}"]`);
    
    if (draggedElement && draggedElement !== this) {
        const draggedItem = findMenuItemById(draggedId);
        const targetItem = findMenuItemById(this.dataset.id);
        
        if (!draggedItem || !targetItem) {
            console.log('Items not found:', {draggedItem, targetItem, draggedId, targetId: this.dataset.id});
            return;
        }
        
        // Check if we're creating a sub-menu
        const rect = this.getBoundingClientRect();
        const midpoint = rect.top + rect.height / 2;
        const isSubMenu = e.clientY > midpoint && (e.shiftKey || e.ctrlKey); // Shift/Ctrl + drop = sub-menu
        
        // Visual feedback for drop zones
        this.classList.remove('drop-zone-top', 'drop-zone-bottom', 'drop-zone-submenu');
        
        console.log('Drop operation:', {isSubMenu, shiftKey: e.shiftKey, ctrlKey: e.ctrlKey, clientY: e.clientY, midpoint});
        
        if (isSubMenu) {
            // Create sub-menu
            createSubMenu(draggedItem, targetItem);
            showNotification(`"${draggedItem.title}" added as submenu of "${targetItem.title}"`, 'success');
        } else {
            // Regular reordering
            const container = this.closest('.menu-structure');
            if (e.clientY < midpoint) {
                container.insertBefore(draggedElement, this);
            } else {
                container.insertBefore(draggedElement, this.nextSibling);
            }
            updateMenuOrder();
        }
    }
}

function createSubMenu(childItem, parentItem) {
    // Check if we're trying to make a parent its own child
    if (childItem.id === parentItem.id) {
        showNotification('Cannot make an item a submenu of itself!', 'error');
        return;
    }
    
    // Check if we're trying to make a parent a child of its own child (circular reference)
    if (isCircularReference(childItem, parentItem)) {
        showNotification('Cannot create circular reference in menu structure!', 'error');
        return;
    }
    
    // Remove child from its current position (main menu or other parent)
    removeItemFromCurrentPosition(childItem);
    
    // Initialize children array if it doesn't exist
    if (!parentItem.children) {
        parentItem.children = [];
    }
    
    // Add child to parent
    childItem.parentId = parentItem.id;
    childItem.order = parentItem.children.length + 1;
    childItem.level = (parentItem.level || 0) + 1;
    parentItem.children.push(childItem);
    
    // Re-render the menu
    renderMenuStructure();
}

function isCircularReference(childItem, parentItem) {
    // Check if parentItem is a descendant of childItem
    function checkDescendants(item, targetId) {
        if (item.children) {
            for (let child of item.children) {
                if (child.id === targetId) return true;
                if (checkDescendants(child, targetId)) return true;
            }
        }
        return false;
    }
    
    return checkDescendants(childItem, parentItem.id);
}

function removeItemFromCurrentPosition(item) {
    // Remove from main menu
    menuItems = menuItems.filter(menuItem => menuItem.id !== item.id);
    
    // Remove from any parent's children
    for (let parent of menuItems) {
        if (parent.children) {
            parent.children = parent.children.filter(child => child.id !== item.id);
        }
    }
}

function handleDragEnd(e) {
    this.classList.remove('dragging');
    document.querySelectorAll('.menu-item').forEach(item => {
        item.classList.remove('drag-over');
    });
}

function updateMenuOrder() {
    const menuItemsElements = document.querySelectorAll('.menu-item');
    menuItemsElements.forEach((element, index) => {
        const id = parseInt(element.dataset.id);
        const item = menuItems.find(item => item.id === id);
        if (item) {
            item.order = index + 1;
        }
    });
    
    renderMenuStructure();
}

function toggleMenuItemOptions(menuItem) {
    // Toggle menu item options (edit, delete, etc.)
    const options = menuItem.querySelector('.menu-item-options');
    if (options) {
        options.remove();
    } else {
        const itemId = menuItem.dataset.id;
        const item = menuItems.find(item => item.id == itemId);
        const isSubMenu = item && item.parentId;
        
        const optionsDiv = document.createElement('div');
        optionsDiv.className = 'menu-item-options';
        optionsDiv.innerHTML = `
            <div class="menu-options">
                <button class="btn btn-sm btn-outline-primary" onclick="editMenuItem(${itemId})">
                    <i class="ri-edit-line"></i> Edit
                </button>
                ${isSubMenu ? `
                    <button class="btn btn-sm btn-outline-warning" onclick="moveToMainMenu(${itemId})">
                        <i class="ri-arrow-up-line"></i> Move to Main
                    </button>
                ` : `
                    <button class="btn btn-sm btn-outline-info" onclick="showSubMenuOptions(${itemId})">
                        <i class="ri-arrow-down-line"></i> Make Sub-menu
                    </button>
                `}
                <button class="btn btn-sm btn-outline-danger" onclick="deleteMenuItem(${itemId})">
                    <i class="ri-delete-bin-line"></i> Delete
                </button>
            </div>
        `;
        menuItem.appendChild(optionsDiv);
    }
}

function editMenuItem(id) {
    const item = menuItems.find(item => item.id === id);
    if (!item) return;
    
    const newTitle = prompt('Edit menu item title:', item.title);
    if (newTitle && newTitle !== item.title) {
        item.title = newTitle;
        renderMenuStructure();
        showNotification('Menu item updated!', 'success');
    }
}

function deleteMenuItem(id) {
    if (confirm('Are you sure you want to delete this menu item?')) {
        // Remove from main menu
        menuItems = menuItems.filter(item => item.id !== id);
        
        // Remove from any sub-menus
        menuItems.forEach(item => {
            if (item.children) {
                item.children = item.children.filter(child => child.id !== id);
            }
        });
        
        renderMenuStructure();
        showNotification('Menu item deleted!', 'success');
    }
}

function moveToMainMenu(id) {
    const item = findMenuItemById(id);
    if (!item) return;
    
    // Remove from parent's children
    const parent = findMenuItemById(item.parentId);
    if (parent && parent.children) {
        parent.children = parent.children.filter(child => child.id !== id);
    }
    
    // Add to main menu
    item.parentId = null;
    item.order = menuItems.length + 1;
    menuItems.push(item);
    
    renderMenuStructure();
    showNotification(`"${item.title}" moved to main menu!`, 'success');
}

function showSubMenuOptions(id) {
    const item = findMenuItemById(id);
    if (!item) return;
    
    // Show available parent options
    const availableParents = menuItems.filter(parent => 
        parent.id !== id && !parent.parentId
    );
    
    if (availableParents.length === 0) {
        showNotification('No available parent items!', 'error');
        return;
    }
    
    const parentOptions = availableParents.map(parent => 
        `<option value="${parent.id}">${parent.title}</option>`
    ).join('');
    
    const modal = document.createElement('div');
    modal.className = 'modal fade show';
    modal.style.display = 'block';
    modal.innerHTML = `
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Make Sub-menu</h5>
                    <button type="button" class="btn-close" onclick="this.closest('.modal').remove()"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Select Parent Menu:</label>
                    <select class="form-select" id="parentSelect">
                        ${parentOptions}
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="this.closest('.modal').remove()">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="makeSubMenu(${id})">Make Sub-menu</button>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
}

function makeSubMenu(id) {
    const parentId = document.getElementById('parentSelect').value;
    const item = findMenuItemById(id);
    const parent = findMenuItemById(parentId);
    
    if (!item || !parent) return;
    
    // Remove from main menu
    menuItems = menuItems.filter(menuItem => menuItem.id !== id);
    
    // Add to parent's children
    if (!parent.children) parent.children = [];
    item.parentId = parentId;
    item.order = parent.children.length + 1;
    parent.children.push(item);
    
    // Close modal
    document.querySelector('.modal').remove();
    
    renderMenuStructure();
    showNotification(`"${item.title}" made sub-menu of "${parent.title}"!`, 'success');
}

function findMenuItemById(id) {
    // Convert id to number for comparison
    const searchId = parseInt(id);
    
    // Search in main menu
    let item = menuItems.find(item => parseInt(item.id) === searchId);
    if (item) return item;
    
    // Search in sub-menus recursively
    function searchInChildren(parent) {
        if (parent.children) {
            for (let child of parent.children) {
                if (parseInt(child.id) === searchId) return child;
                const found = searchInChildren(child);
                if (found) return found;
            }
        }
        return null;
    }
    
    for (let parent of menuItems) {
        const found = searchInChildren(parent);
        if (found) return found;
    }
    
    return null;
}

function saveMenu() {
    const menuName = document.getElementById('menuName').value;
    
    if (!menuName.trim()) {
        showNotification('Please enter a menu name', 'error');
        return;
    }
    
    // Save to localStorage
    const menuData = {
        name: menuName,
        items: menuItems,
        updated_at: new Date().toISOString()
    };
    
    localStorage.setItem('menuData', JSON.stringify(menuData));
    
    // Here you would typically save to server
    // fetch('/admin/menu/save', {
    //     method: 'POST',
    //     headers: { 'Content-Type': 'application/json' },
    //     body: JSON.stringify(menuData)
    // });
    
    showNotification('Menu saved successfully!', 'success');
}

function deleteMenu() {
    if (confirm('Are you sure you want to delete the entire menu? This action cannot be undone.')) {
        menuItems = [];
        localStorage.removeItem('menuItems');
        localStorage.removeItem('menuData');
        renderMenuStructure();
        showNotification('Menu deleted!', 'success');
    }
}

function showNotification(message, type) {
    // Remove existing notifications
    document.querySelectorAll('.notification').forEach(n => n.remove());
    
    const notification = document.createElement('div');
    notification.className = `notification alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
    notification.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Collapse functionality
document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(trigger => {
    trigger.addEventListener('click', function() {
        const target = document.querySelector(this.getAttribute('data-bs-target'));
        if (target) {
            const isCollapsed = target.classList.contains('show');
            if (isCollapsed) {
                target.classList.remove('show');
                this.setAttribute('aria-expanded', 'false');
            } else {
                target.classList.add('show');
                this.setAttribute('aria-expanded', 'true');
            }
        }
    });
});

// Tab functionality
document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
    tab.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Remove active from all tabs
        document.querySelectorAll('.nav-link').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('show', 'active'));
        
        // Add active to clicked tab
        this.classList.add('active');
        const target = document.querySelector(this.getAttribute('data-bs-target'));
        if (target) {
            target.classList.add('show', 'active');
        }
    });
});
</script>

<script>
// Test function for submenu creation
function testSubmenuCreation() {
    if (menuItems.length < 2) {
        showNotification('Need at least 2 menu items to create submenu!', 'error');
        return;
    }
    
    // Create a simple submenu for testing
    const parentItem = menuItems[0];
    const childItem = menuItems[1];
    
    createSubMenu(childItem, parentItem);
    showNotification('Test submenu created! Check the menu structure.', 'success');
}

// Simple submenu creation without drag and drop
function createSubmenuManually() {
    if (menuItems.length < 2) {
        showNotification('Need at least 2 menu items to create submenu!', 'error');
        return;
    }
    
    // Show available items for selection
    const parentOptions = menuItems.map((item, index) => 
        `<option value="${item.id}">${item.title}</option>`
    ).join('');
    
    const childOptions = menuItems.map((item, index) => 
        `<option value="${item.id}">${item.title}</option>`
    ).join('');
    
    const modal = document.createElement('div');
    modal.className = 'modal fade show';
    modal.style.display = 'block';
    modal.innerHTML = `
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Submenu</h5>
                    <button type="button" class="btn-close" onclick="this.closest('.modal').remove()"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Parent Item:</label>
                        <select class="form-select" id="parentSelect">
                            ${parentOptions}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select Child Item:</label>
                        <select class="form-select" id="childSelect">
                            ${childOptions}
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="this.closest('.modal').remove()">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="createSubmenuFromSelection()">Create Submenu</button>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
}

function createSubmenuFromSelection() {
    const parentId = document.getElementById('parentSelect').value;
    const childId = document.getElementById('childSelect').value;
    
    if (parentId === childId) {
        showNotification('Cannot make an item a submenu of itself!', 'error');
        return;
    }
    
    const parentItem = findMenuItemById(parentId);
    const childItem = findMenuItemById(childId);
    
    if (!parentItem || !childItem) {
        showNotification('Items not found!', 'error');
        return;
    }
    
    createSubMenu(childItem, parentItem);
    document.querySelector('.modal').remove();
    showNotification(`"${childItem.title}" made submenu of "${parentItem.title}"!`, 'success');
}
</script>
@endsection
