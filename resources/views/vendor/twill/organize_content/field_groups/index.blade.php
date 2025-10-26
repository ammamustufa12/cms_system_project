@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Field Groups</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Field Groups</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid px-5">
        <div class="row">
            <!-- Left Column - Field Groups List -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Field Group</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.field-groups.create') }}" class="btn btn-success btn-sm">
                                    <i class="ri-add-line me-1"></i> New
                                </a>
                                <button class="btn btn-primary btn-sm">
                                    <i class="ri-edit-line me-1"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm">
                                    <i class="ri-delete-bin-line me-1"></i> X Delete
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Search and Pagination -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="input-group" style="width: 300px;">
                                    <span class="input-group-text"><i class="ri-search-line"></i></span>
                                    <input type="text" class="form-control" placeholder="Search Field Groups">
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <select class="form-select form-select-sm" style="width: auto;">
                                    <option>10</option>
                                    <option>25</option>
                                    <option>50</option>
                                </select>
                                <span class="text-muted">v</span>
                            </div>
                        </div>

                        <!-- Field Group Description -->
                        <div class="mb-4">
                            <h6 class="fw-bold">Field Group</h6>
                            <p class="text-muted">Organize fields together into a group; it will make it easier to find fields when you need them</p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Field Groups List -->
                        <div class="list-group">
                            <!-- All Fields Filter -->
                            <div class="list-group-item list-group-item-action active border-0 bg-primary text-white mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">All Fields</span>
                                </div>
                            </div>

                            @forelse($fieldGroups as $fieldGroup)
                            <div class="list-group-item border-0 mb-2" style="border-left: 4px solid #007bff !important;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="ri-drag-move-2-line text-muted"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">{{ $fieldGroup->name }}</h6>
                                            <p class="mb-1 text-muted small">
                                                {{ Str::limit($fieldGroup->description ?: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text', 80) }}
                                            </p>
                                            <div class="d-flex gap-2">
                                                <span class="badge bg-info">{{ $fieldGroup->source_badge }}</span>
                                                <span class="text-muted small">ID: {{ $fieldGroup->id }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        @if($fieldGroup->is_active)
                                            <form action="{{ route('admin.field-groups.deactivate', $fieldGroup) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    <i class="ri-pause-line me-1"></i> Disable
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.field-groups.activate', $fieldGroup) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="ri-play-line me-1"></i> Activate
                                                </button>
                                            </form>
                                        @endif
                                        <span class="badge bg-{{ $fieldGroup->is_active ? 'success' : 'secondary' }}">
                                            {{ $fieldGroup->status_badge }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-5">
                                <i class="ri-folder-line fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No field groups found. <a href="{{ route('admin.field-groups.create') }}">Create your first field group</a></p>
                            </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        @if($fieldGroups->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $fieldGroups->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Field Group Details -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Field Group</h5>
                            <div class="d-flex gap-2">
                                <span class="badge bg-info">SOURCE CENTRALIZED</span>
                                <span class="text-muted small">ID: 1</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 mb-3">
                            <button class="btn btn-success btn-sm">
                                <i class="ri-check-line me-1"></i> Active
                            </button>
                            <button class="btn btn-secondary btn-sm">
                                <i class="ri-pause-line me-1"></i> Disable
                            </button>
                        </div>

                        <!-- Title Field -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Title:</label>
                            <input type="text" class="form-control" value="Water" readonly>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Description</label>
                            <div class="bg-light p-3 rounded">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text
                            </div>
                        </div>

                        <!-- Access Section -->
                        <div class="border rounded p-3">
                            <h6 class="fw-bold mb-2">Access</h6>
                            <p class="text-muted small mb-3">control who has viewing access to this group</p>
                            <div class="mb-3">
                                <label class="form-label">Access Rights:</label>
                                <select class="form-select form-select-sm">
                                    <option>Public</option>
                                    <option>Private</option>
                                    <option>Restricted</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Next Steps Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm bg-gradient">
                    <div class="card-body text-center py-4">
                        <h5 class="card-title mb-3">Next Step: Manage Individual Fields</h5>
                        <p class="text-muted mb-4">Now that you have field groups set up, let's manage individual fields and their configurations.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('admin.fields.index') }}" class="btn btn-primary">
                                <i class="ri-list-check me-1"></i> Manage Fields
                            </a>
                            <a href="{{ route('admin.field-manager.install') }}" class="btn btn-outline-primary">
                                <i class="ri-download-line me-1"></i> Install More Field Types
                            </a>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="ri-information-line me-1"></i>
                                Individual fields define the specific data collection points for your content.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

