@extends('twill::layouts.main')

@section('appTypeClass', 'body--listing')

@section('content')
    <div class="page-content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">{{ $contentType->name }} Items</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('content-types.index') }}">Content Types</a></li>
                            <li class="breadcrumb-item active">Content Items</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Stats Row -->
                    @php
                        $totalItems = $items->total();
                        $publishedCount = $items->where('status', 'published')->count();
                        $draftCount = $items->where('status', 'draft')->count();
                        $archivedCount = $items->where('status', 'archived')->count();
                    @endphp

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0">{{ $totalItems }}</h4>
                                            <p class="mb-0">Total Items</p>
                                        </div>
                                        <div class="ms-3">
                                            <i class="fas fa-file-alt fa-2x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0">{{ $publishedCount }}</h4>
                                            <p class="mb-0">Published</p>
                                        </div>
                                        <div class="ms-3">
                                            <i class="fas fa-globe fa-2x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0">{{ $draftCount }}</h4>
                                            <p class="mb-0">Drafts</p>
                                        </div>
                                        <div class="ms-3">
                                            <i class="fas fa-edit fa-2x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-secondary text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0">{{ $archivedCount }}</h4>
                                            <p class="mb-0">Archived</p>
                                        </div>
                                        <div class="ms-3">
                                            <i class="fas fa-archive fa-2x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="card mb-4">
                        <div class="card-body">
                            <form method="GET" class="row g-3">
                                <div class="col-md-4">
                                    <label for="search" class="form-label">Search</label>
                                    <input type="text" class="form-control" id="search" name="search"
                                        value="{{ request('search') }}" placeholder="Search by title...">
                                </div>
                                <div class="col-md-2">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="">All Status</option>
                                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft
                                        </option>
                                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>
                                            Published</option>
                                        <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>
                                            Archived</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="sort" class="form-label">Sort By</label>
                                    <select class="form-select" id="sort" name="sort">
                                        <option value="created_at"
                                            {{ request('sort', 'created_at') === 'created_at' ? 'selected' : '' }}>Created
                                            Date</option>
                                        <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title
                                        </option>
                                        <option value="updated_at"
                                            {{ request('sort') === 'updated_at' ? 'selected' : '' }}>Updated Date</option>
                                        <option value="published_at"
                                            {{ request('sort') === 'published_at' ? 'selected' : '' }}>Published Date
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="order" class="form-label">Order</label>
                                    <select class="form-select" id="order" name="order">
                                        <option value="desc" {{ request('order', 'desc') === 'desc' ? 'selected' : '' }}>
                                            Descending</option>
                                        <option value="asc" {{ request('order') === 'asc' ? 'selected' : '' }}>Ascending
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-search">Search</i>
                                    </button>
                                    <a href="{{ route('content-types.content-items.index', $contentType->slug) }}"
                                        class="btn btn-outline-secondary">
                                        <i class="fas fa-times">Reset</i>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div> --}}
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="GET" class="row g-3" id="searchForm"
                                action="{{ route('content-types.content-items.index', ['contentType' => $contentType->slug]) }}">

                                <!-- Hidden input to track button click -->
                                <input type="hidden" name="search_submitted" value="0" id="searchSubmitted">

                                <!-- Search -->
                                <div class="col-md-4">
                                    <label for="search" class="form-label">Search</label>
                                    <input type="text" class="form-control" id="search" name="search"
                                        value="{{ request('search') }}" placeholder="Search by title...">
                                </div>

                                <!-- Status -->
                                <div class="col-md-2">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="">All Status</option>
                                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft
                                        </option>
                                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>
                                            Published</option>
                                        <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>
                                            Archived</option>
                                    </select>
                                </div>

                                <!-- Sort -->
                                <div class="col-md-2">
                                    <label for="sort" class="form-label">Sort By</label>
                                    <select class="form-select" id="sort" name="sort">
                                        <option value="created_at"
                                            {{ request('sort', 'created_at') === 'created_at' ? 'selected' : '' }}>Created
                                            Date</option>
                                        <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title
                                        </option>
                                        <option value="updated_at"
                                            {{ request('sort') === 'updated_at' ? 'selected' : '' }}>Updated Date</option>
                                        <option value="published_at"
                                            {{ request('sort') === 'published_at' ? 'selected' : '' }}>Published Date
                                        </option>
                                    </select>
                                </div>

                                <!-- Order -->
                                <div class="col-md-2">
                                    <label for="order" class="form-label">Order</label>
                                    <select class="form-select" id="order" name="order">
                                        <option value="desc" {{ request('order', 'desc') === 'desc' ? 'selected' : '' }}>
                                            Descending</option>
                                        <option value="asc" {{ request('order') === 'asc' ? 'selected' : '' }}>Ascending
                                        </option>
                                    </select>
                                </div>

                                <!-- Buttons -->
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn me-2" id="searchButton"
                                        style="background-color: #405189 !important; border-color: #405189 !important; color: #fff;">
                                        <i class="fas fa-search me-1"></i> Search
                                    </button>
                                    <a href="{{ route('content-types.content-items.index', ['contentType' => $contentType->slug]) }}"
                                        class="btn"
                                        style="background-color: transparent !important; border-color: #405189 !important; color: #405189;">
                                        <i class="fas fa-times me-1"></i> Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if ($items->count() > 0)
                        <!-- Bulk Actions -->
                        <div class="card mb-3">
                            <div class="card-body py-2">
                                <form id="bulkActionForm" method="POST"
                                    action="{{ route('content-types.content-items.bulk-action', $contentType->slug) }}">
                                    @csrf
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAll">
                                                <label class="form-check-label" for="selectAll">
                                                    Select All
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-select form-select-sm" name="action" required>
                                                <option value="">Bulk Actions</option>
                                                <option value="publish">Publish</option>
                                                <option value="unpublish">Unpublish</option>
                                                <option value="archive">Archive</option>
                                                <option value="delete">Delete</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-sm btn-outline-primary" disabled
                                                id="bulkActionBtn">
                                                Apply
                                            </button>
                                        </div>
                                        <div class="col-md-5 text-end">
                                            <a href="{{ route('content-types.content-items.create', $contentType->slug) }}"
                                                class="btn text-capitalize"
                                                style="background-color: #405189 !important; border-color: #405189 !important; color: #fff;">add</a>
                                            <span class="badge bg-light text-dark" id="selectedCount">0 selected</span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- View Toggle -->

                        <!-- List View (Hidden by default) -->
                        <div>
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50">
                                                    <input type="checkbox" id="selectAllList" class="form-check-input">
                                                </th>
                                                <th>Title</th>
                                                <th>Status</th>
                                                @php

                                                    $fieldsSchema = is_array($contentType->fields_schema) ? $contentType->fields_schema :
                                                        json_decode($contentType->fields_schema, true) ?? [];

                                                    $fieldData = $item->field_data ?? [];
                                                    // $previewFields = array_slice($fieldsSchema, 0, 2, true);

                                                    $listFields = array_slice($fieldsSchema, 0, 2, true);
                                                @endphp
                                                @foreach ($listFields as $fieldKey => $field)
                                                    <th>{{ $field['name'] ?? $field['label'] ?? ucfirst(str_replace('_', ' ', $fieldKey)) }}</th>
                                                @endforeach
                                                <th>Dates</th>
                                                <th width="150">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $item)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input item-checkbox"
                                                            name="items[]" value="{{ $item->id }}">
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('content-types.content-items.show', [$contentType->slug, $item->id]) }}"
                                                            class="text-decoration-none fw-bold">
                                                            {{ Str::limit($item->title, 40) }}
                                                        </a>
                                                        <br>
                                                        <small class="text-muted">{{ $item->slug }}</small>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $statusColors[$item->status] ?? 'success' }}">
                                                            {{ ucfirst($item->status) }}
                                                        </span>
                                                    </td>
                                                    @foreach ($listFields as $fieldKey => $field)
                                                        <td>
                                                            @if (isset($item->field_data[$fieldKey]))
                                                                {!! App\Services\FormRendererService::renderDisplayValue($fieldKey, $field, $item->field_data[$fieldKey]) !!}
                                                            @else
                                                                <span class="text-muted">—</span>
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                    <td>
                                                        <small class="text-muted">
                                                            <strong>Updated:</strong>
                                                            {{ $item->updated_at->format('M j, Y g:i A') }}<br>
                                                            <strong>Created:</strong>
                                                            {{ $item->created_at->format('M j, Y g:i A') }}
                                                            @if ($item->published_at)
                                                                <br><strong>Published:</strong>
                                                                {{ $item->published_at->format('M j, Y g:i A') }}
                                                            @endif
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="{{ route('content-types.content-items.edit', [$contentType->slug, $item->id]) }}"
                                                                class="btn btn-outline-primary btn-sm" title="Edit">
                                                                <i class="fas fa-edit">Edit</i>
                                                            </a>
                                                            {{-- <a href="{{ route('content-types.content-items.show', [$contentType->slug, $item->id]) }}"
                                                                class="btn btn-outline-secondary btn-sm" title="View">
                                                                <i class="fas fa-eye">View</i>
                                                            </a> --}}
                                                            @if ($item->status === 'draft')
                                                                {{-- <button class="btn btn-outline-success btn-sm"
                                                                    onclick="quickPublish({{ $item->id }})"
                                                                    title="Quick Publish">
                                                                    <i class="fas fa-globe"></i>
                                                                </button> --}}
                                                            @endif
                                                            <button class="btn btn-outline-danger btn-sm"
                                                                onclick="deleteItem({{ $item->id }}, '{{ $item->title }}')"
                                                                title="Delete">
                                                                <i class="fas fa-trash">Delete</i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <p class="text-muted mb-0">
                                    Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of
                                    {{ $items->total() }} results
                                </p>
                            </div>
                            <div>
                                {{ $items->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-file-alt fa-4x text-muted"></i>
                                </div>
                                <h4 class="text-muted mb-3">No Content Items Yet</h4>
                                <p class="text-muted mb-4">
                                    Start creating content items for your <strong>{{ $contentType->name }}</strong> content
                                    type.
                                </p>
                                @php
                                    $fieldsSchema = is_array($contentType->fields_schema)
                                        ? $contentType->fields_schema
                                        : json_decode($contentType->fields_schema, true);
                                @endphp
                                @if (count($fieldsSchema ?? []) > 0)
                                    <a href="{{ route('content-types.content-items.create', $contentType->slug) }}"
                                        class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Create Your First Item
                                    </a>
                                @else
                                    <p class="text-warning mb-3">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Please add fields to this content type first.
                                    </p>
                                    <a href="{{ route('content-types.manage-fields', $contentType->slug) }}"
                                        class="btn btn-warning">
                                        <i class="fas fa-cog me-2"></i>Add Fields
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete <strong id="deleteItemName"></strong>?</p>
                        <p class="text-danger small">This action cannot be undone and will delete all associated files.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form id="deleteForm" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete Item</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // View toggle functionality
            const viewButtons = document.querySelectorAll('[data-view]');
            const gridView = document.getElementById('gridView');
            const listView = document.getElementById('listView');

            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const view = this.dataset.view;

                    // Update active button
                    viewButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    // Toggle views
                    if (view === 'grid') {
                        gridView.classList.remove('d-none');
                        listView.classList.add('d-none');
                    } else {
                        gridView.classList.add('d-none');
                        listView.classList.remove('d-none');
                    }

                    // Store preference
                    localStorage.setItem('contentItemsView', view);
                });
            });

            // Load saved view preference
            const savedView = localStorage.getItem('contentItemsView');
            if (savedView) {
                document.querySelector(`[data-view="${savedView}"]`)?.click();
            }

            // Select all functionality
            const selectAllCheckbox = document.getElementById('selectAll');
            const selectAllListCheckbox = document.getElementById('selectAllList');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            const bulkActionBtn = document.getElementById('bulkActionBtn');
            const selectedCount = document.getElementById('selectedCount');

            function updateBulkActions() {
                const checkedItems = document.querySelectorAll('.item-checkbox:checked');
                const count = checkedItems.length;

                selectedCount.textContent = `${count} selected`;
                bulkActionBtn.disabled = count === 0;

                // Update select all checkboxes
                [selectAllCheckbox, selectAllListCheckbox].forEach(checkbox => {
                    if (checkbox) {
                        checkbox.indeterminate = count > 0 && count < itemCheckboxes.length;
                        checkbox.checked = count === itemCheckboxes.length;
                    }
                });
            }

            // Select all checkboxes
            [selectAllCheckbox, selectAllListCheckbox].forEach(checkbox => {
                if (checkbox) {
                    checkbox.addEventListener('change', function() {
                        itemCheckboxes.forEach(item => {
                            item.checked = this.checked;
                        });
                        updateBulkActions();
                    });
                }
            });

            // Individual checkboxes
            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActions);
            });

            // Bulk action form submission
            const bulkActionForm = document.getElementById('bulkActionForm');
            if (bulkActionForm) {
                bulkActionForm.addEventListener('submit', function(e) {
                    const checkedItems = document.querySelectorAll('.item-checkbox:checked');
                    const action = this.querySelector('select[name="action"]').value;

                    if (checkedItems.length === 0) {
                        e.preventDefault();
                        alert('Please select at least one item.');
                        return;
                    }

                    let confirmMessage =
                        `Are you sure you want to ${action} ${checkedItems.length} item(s)?`;
                    if (action === 'delete') {
                        confirmMessage += ' This action cannot be undone.';
                    }

                    if (!confirm(confirmMessage)) {
                        e.preventDefault();
                        return;
                    }

                    // Add selected items to form
                    checkedItems.forEach(checkbox => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'items[]';
                        input.value = checkbox.value;
                        this.appendChild(input);
                    });
                });
            }

            // Search form auto-submit with debounce
            const searchInput = document.getElementById('search');
            let searchTimeout;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        this.form.submit();
                    }, 800);
                });
            }

            // Status and sort filters auto-submit
            const filterSelects = document.querySelectorAll('#status, #sort, #order');
            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    this.form.submit();
                });
            });

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Card hover effects
            document.querySelectorAll('.content-item-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.12)';
                    this.style.transition = 'all 0.2s ease';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15)';
                });
            });
        });

        // Delete item function
        function deleteItem(itemId, itemTitle) {
            document.getElementById('deleteItemName').textContent = itemTitle;
            document.getElementById('deleteForm').action =
                `{{ route('content-types.content-items.index', $contentType->slug) }}/${itemId}`;

            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }

        // Quick publish function
        function quickPublish(itemId) {
            if (confirm('Publish this item?')) {
                fetch(`{{ route('content-types.content-items.index', $contentType->slug) }}/${itemId}/quick-publish`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Item published successfully!', 'success');
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            showToast('Error publishing item', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Error publishing item', 'error');
                    });
            }
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type === 'error' ? 'danger' : type} position-fixed top-0 end-0 m-3`;
            toast.style.zIndex = '9999';
            toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
    `;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    </script> --}}

    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Search form handling - BUTTON CLICK ONLY
    const searchForm = document.querySelector('form[method="GET"]');
    const searchButton = document.getElementById('searchButton'); // Use ID instead
    const searchInput = document.getElementById('search');
    const searchSubmitted = document.getElementById('searchSubmitted');
    
    // Handle search button click
    if (searchButton) {
        searchButton.addEventListener('click', function() {
            console.log('Search button clicked'); // Debug log
            searchSubmitted.value = '1';
            searchForm.submit();
        });
    }
    
    // Handle Enter key in search input
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                console.log('Enter key pressed'); // Debug log
                searchSubmitted.value = '1';
                searchForm.submit();
            }
        });
    }
    
    // Keep filter auto-submit for status, sort, order (NOT search input)
    const filterSelects = document.querySelectorAll('#status, #sort, #order');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            searchSubmitted.value = '0'; // Not a search submission
            searchForm.submit();
        });
    });

    // View toggle functionality
    const viewButtons = document.querySelectorAll('[data-view]');
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');

    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const view = this.dataset.view;

            // Update active button
            viewButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Toggle views
            if (view === 'grid') {
                gridView.classList.remove('d-none');
                listView.classList.add('d-none');
            } else {
                gridView.classList.add('d-none');
                listView.classList.remove('d-none');
            }

            // Store preference
            localStorage.setItem('contentItemsView', view);
        });
    });

    // Load saved view preference
    const savedView = localStorage.getItem('contentItemsView');
    if (savedView) {
        document.querySelector(`[data-view="${savedView}"]`)?.click();
    }

    // Select all functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const selectAllListCheckbox = document.getElementById('selectAllList');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const bulkActionBtn = document.getElementById('bulkActionBtn');
    const selectedCount = document.getElementById('selectedCount');

    function updateBulkActions() {
        const checkedItems = document.querySelectorAll('.item-checkbox:checked');
        const count = checkedItems.length;

        selectedCount.textContent = `${count} selected`;
        bulkActionBtn.disabled = count === 0;

        // Update select all checkboxes
        [selectAllCheckbox, selectAllListCheckbox].forEach(checkbox => {
            if (checkbox) {
                checkbox.indeterminate = count > 0 && count < itemCheckboxes.length;
                checkbox.checked = count === itemCheckboxes.length;
            }
        });
    }

    // Select all checkboxes
    [selectAllCheckbox, selectAllListCheckbox].forEach(checkbox => {
        if (checkbox) {
            checkbox.addEventListener('change', function() {
                itemCheckboxes.forEach(item => {
                    item.checked = this.checked;
                });
                updateBulkActions();
            });
        }
    });

    // Individual checkboxes
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });

    // Bulk action form submission
    const bulkActionForm = document.getElementById('bulkActionForm');
    if (bulkActionForm) {
        bulkActionForm.addEventListener('submit', function(e) {
            const checkedItems = document.querySelectorAll('.item-checkbox:checked');
            const action = this.querySelector('select[name="action"]').value;

            if (checkedItems.length === 0) {
                e.preventDefault();
                alert('Please select at least one item.');
                return;
            }

            let confirmMessage =
                `Are you sure you want to ${action} ${checkedItems.length} item(s)?`;
            if (action === 'delete') {
                confirmMessage += ' This action cannot be undone.';
            }

            if (!confirm(confirmMessage)) {
                e.preventDefault();
                return;
            }

            // Add selected items to form
            checkedItems.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'items[]';
                input.value = checkbox.value;
                this.appendChild(input);
            });
        });
    }

    // REMOVED: Search form auto-submit with debounce
    // No longer auto-submitting search input
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Card hover effects
    document.querySelectorAll('.content-item-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.12)';
            this.style.transition = 'all 0.2s ease';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15)';
        });
    });
});

// Delete item function
function deleteItem(itemId, itemTitle) {
    document.getElementById('deleteItemName').textContent = itemTitle;
    document.getElementById('deleteForm').action =
        `{{ route('content-types.content-items.index', $contentType->slug) }}/${itemId}`;

    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Quick publish function
function quickPublish(itemId) {
    if (confirm('Publish this item?')) {
        fetch(`{{ route('content-types.content-items.index', $contentType->slug) }}/${itemId}/quick-publish`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Item published successfully!', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('Error publishing item', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error publishing item', 'error');
            });
    }
}

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'error' ? 'danger' : type} position-fixed top-0 end-0 m-3`;
    toast.style.zIndex = '9999';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
    `;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>

    <style>
        .content-item-card {
            transition: all 0.2s ease;
            border: 1px solid #e3e6f0;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .content-item-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
        }

        .field-preview {
            font-size: 0.875rem;
            max-height: 60px;
            overflow: hidden;
            line-height: 1.3;
            word-break: break-word;
        }

        .field-preview img {
            max-width: 60px;
            max-height: 40px;
            object-fit: cover;
            border-radius: 4px;
        }

        .field-preview .badge {
            font-size: 0.7rem;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #5a5c69;
            background-color: #f8f9fc;
            font-size: 0.875rem;
        }

        .table td {
            vertical-align: middle;
            font-size: 0.875rem;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }

        .btn-group-sm>.btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .dropdown-toggle::after {
            display: none;
        }

        .opacity-75 {
            opacity: 0.75;
        }

        /* Status colors */
        .bg-success {
            background-color: #1cc88a !important;
        }

        .bg-warning {
            background-color: #f6c23e !important;
            color: #212529 !important;
        }

        .bg-secondary {
            background-color: #858796 !important;
        }

        .bg-primary {
            background-color: #4e73df !important;
        }

        /* Card styling */
        .card {
            border: 1px solid #e3e6f0;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }

        .card-footer {
            background-color: #f8f9fc;
            border-top: 1px solid #e3e6f0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .content-item-card {
                margin-bottom: 1rem;
            }

            .btn-group {
                display: flex;
                flex-direction: column;
            }

            .btn-group>.btn {
                margin-bottom: 0.25rem;
                border-radius: 0.375rem !important;
            }

            .col-md-4,
            .col-md-3,
            .col-md-2 {
                margin-bottom: 1rem;
            }
        }

        /* List view enhancements */
        #listView .table-responsive {
            border-radius: 0.375rem;
            overflow: hidden;
        }

        #listView .table {
            margin-bottom: 0;
        }

        #listView .table td {
            padding: 0.75rem;
            border-color: #e3e6f0;
        }

        /* Search and filter styling */
        .card-body .row.g-3 {
            align-items: end;
        }

        .form-label {
            font-weight: 600;
            color: #5a5c69;
            margin-bottom: 0.5rem;
        }

        /* Custom scrollbar */
        .table-responsive::-webkit-scrollbar {
            height: 6px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Bulk actions styling */
        #bulkActionForm .card-body {
            background-color: #f8f9fc;
        }

        #selectedCount {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        /* Animation for cards */
        .content-item-card {
            animation: fadeInUp 0.3s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* View toggle buttons */
        #viewToggle .btn-group .btn {
            border-color: #d1d3e2;
        }

        #viewToggle .btn-group .btn.active {
            background-color: #5a6c7d;
            border-color: #5a6c7d;
            color: white;
        }

        #viewToggle .btn-group .btn:hover:not(.active) {
            background-color: #f8f9fc;
            border-color: #d1d3e2;
        }

        /* Empty state styling */
        .card-body.text-center.py-5 {
            padding: 3rem 1.5rem !important;
        }

        .fa-4x {
            font-size: 4rem;
            opacity: 0.3;
        }

        /* Toast positioning */
        .position-fixed {
            position: fixed !important;
        }

        .top-0 {
            top: 0 !important;
        }

        .end-0 {
            right: 0 !important;
        }

        .m-3 {
            margin: 1rem !important;
        }

        /* Dropdown menu styling */
        .dropdown-menu {
            border: 1px solid #e3e6f0;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
        }

        .dropdown-item:hover {
            background-color: #f8f9fc;
        }

        .dropdown-item.text-danger:hover {
            background-color: #f8d7da;
            color: #721c24 !important;
        }

        /* Pagination styling */
        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            color: #5a6c7d;
            border-color: #d1d3e2;
        }

        .page-link:hover {
            color: #4e73df;
            background-color: #f8f9fc;
            border-color: #d1d3e2;
        }

        .page-item.active .page-link {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        /* Stats cards */
        .card.bg-primary,
        .card.bg-success,
        .card.bg-warning,
        .card.bg-secondary {
            border: none;
        }

        .card.bg-warning .card-body h4,
        .card.bg-warning .card-body p {
            color: #212529 !important;
        }

        /* Form controls */
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .form-select:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .form-check-input:checked {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        /* Button styling */
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }

        .btn-success {
            background-color: #1cc88a;
            border-color: #1cc88a;
        }

        .btn-success:hover {
            background-color: #17a673;
            border-color: #17a673;
        }

        .btn-warning {
            background-color: #f6c23e;
            border-color: #f6c23e;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #f4b619;
            border-color: #f4b619;
            color: #212529;
        }

        /* Text colors */
        .text-primary {
            color: #4e73df !important;
        }

        .text-success {
            color: #1cc88a !important;
        }

        .text-warning {
            color: #f6c23e !important;
        }

        .text-danger {
            color: #e74a3b !important;
        }

        .text-muted {
            color: #858796 !important;
        }

        /* Link styling */
        a {
            color: #4e73df;
            text-decoration: none;
        }

        a:hover {
            color: #2e59d9;
        }

        /* Card title in grid view */
        .card-title a {
            color: #5a5c69;
            font-weight: 600;
        }

        .card-title a:hover {
            color: #4e73df;
        }

        /* Small text adjustments */
        small {
            font-size: 0.75rem;
        }

        /* Border utilities */
        .border-top {
            border-top: 1px solid #e3e6f0 !important;
        }

        /* Spacing utilities */
        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .me-2 {
            margin-right: 0.5rem !important;
        }

        .ms-2 {
            margin-left: 0.5rem !important;
        }

        /* Display utilities */
        .d-none {
            display: none !important;
        }

        .d-flex {
            display: flex !important;
        }

        .align-items-center {
            align-items: center !important;
        }

        .justify-content-between {
            justify-content: space-between !important;
        }

        .text-end {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .w-100 {
            width: 100% !important;
        }

        .h-100 {
            height: 100% !important;
        }

        .flex-grow-1 {
            flex-grow: 1 !important;
        }

        .mt-auto {
            margin-top: auto !important;
        }
    </style>
@endsection
