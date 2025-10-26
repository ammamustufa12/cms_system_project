@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">{{ $fieldGroup->name }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.field-groups.index') }}">Field Groups</a></li>
                        <li class="breadcrumb-item active">{{ $fieldGroup->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid px-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">Field Group Details</h5>
                                <small class="text-muted">View and manage field group information</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.field-groups.edit', $fieldGroup) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-edit-line me-1"></i> Edit
                                </a>
                                @if($fieldGroup->is_active)
                                    <form method="POST" action="{{ route('admin.field-groups.deactivate', $fieldGroup) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            <i class="ri-pause-line me-1"></i> Deactivate
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.field-groups.activate', $fieldGroup) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="ri-play-line me-1"></i> Activate
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.field-groups.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="ri-arrow-left-line me-1"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="fw-bold text-primary">Basic Information</h6>
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-bold" style="width: 30%;">Name:</td>
                                                <td>{{ $fieldGroup->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Source:</td>
                                                <td>
                                                    <span class="badge bg-{{ $fieldGroup->source == 'centralized' ? 'primary' : ($fieldGroup->source == 'local' ? 'success' : 'warning') }}">
                                                        {{ ucfirst($fieldGroup->source) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Access Rights:</td>
                                                <td>
                                                    <span class="badge bg-{{ $fieldGroup->access_rights == 'public' ? 'success' : ($fieldGroup->access_rights == 'private' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($fieldGroup->access_rights) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Status:</td>
                                                <td>
                                                    <span class="badge bg-{{ $fieldGroup->is_active ? 'success' : 'danger' }}">
                                                        {{ $fieldGroup->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Sort Order:</td>
                                                <td>{{ $fieldGroup->sort_order ?? 0 }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="fw-bold text-primary">Timestamps</h6>
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-bold" style="width: 30%;">Created:</td>
                                                <td>{{ $fieldGroup->created_at->format('M d, Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Updated:</td>
                                                <td>{{ $fieldGroup->updated_at->format('M d, Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if($fieldGroup->description)
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">Description</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-0">{{ $fieldGroup->description }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Fields in this Group -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">Fields in this Group</h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Field Name</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($fieldGroup->fields as $field)
                                        <tr>
                                            <td>{{ $field->id }}</td>
                                            <td>{{ $field->label }}</td>
                                            <td><span class="badge bg-info">{{ ucfirst($field->type) }}</span></td>
                                            <td>
                                                <span class="badge bg-{{ $field->is_active ? 'success' : 'danger' }}">
                                                    {{ $field->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.fields.show', $field) }}" class="btn btn-outline-primary">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                    <a href="{{ route('admin.fields.edit', $field) }}" class="btn btn-outline-secondary">
                                                        <i class="ri-edit-line"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-3">
                                                <div class="text-muted">
                                                    <i class="ri-database-2-line fa-2x mb-2"></i>
                                                    <p class="mb-0">No fields in this group yet</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Statistics -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">Statistics</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <h4 class="mb-1">{{ $fieldGroup->fields->count() }}</h4>
                                            <small>Total Fields</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h4 class="mb-1">{{ $fieldGroup->fields->where('is_active', true)->count() }}</h4>
                                            <small>Active Fields</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body text-center">
                                            <h4 class="mb-1">{{ $fieldGroup->fields->where('is_active', false)->count() }}</h4>
                                            <small>Inactive Fields</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body text-center">
                                            <h4 class="mb-1">{{ $fieldGroup->fields->where('viewable', 'public')->count() }}</h4>
                                            <small>Public Fields</small>
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
</div>
@endsection

