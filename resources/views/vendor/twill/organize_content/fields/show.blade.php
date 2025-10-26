@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">{{ $field->label }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.fields.index') }}">Fields</a></li>
                        <li class="breadcrumb-item active">{{ $field->label }}</li>
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
                                <h5 class="card-title mb-0">Field Details</h5>
                                <small class="text-muted">View and manage field information</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.fields.edit', $field) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-edit-line me-1"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.fields.copy', $field) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-sm">
                                        <i class="ri-file-copy-line me-1"></i> Copy
                                    </button>
                                </form>
                                @if($field->is_active)
                                    <form method="POST" action="{{ route('admin.fields.deactivate', $field) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            <i class="ri-pause-line me-1"></i> Deactivate
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.fields.activate', $field) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="ri-play-line me-1"></i> Activate
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.fields.index') }}" class="btn btn-outline-secondary btn-sm">
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
                                                <td class="fw-bold" style="width: 30%;">Field Name:</td>
                                                <td>{{ $field->label }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Alias:</td>
                                                <td><code>{{ $field->alias }}</code></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Type:</td>
                                                <td><span class="badge bg-info">{{ ucfirst($field->type) }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Field Group:</td>
                                                <td>{{ $field->fieldGroup->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Viewable:</td>
                                                <td>
                                                    <span class="badge bg-{{ $field->viewable == 'public' ? 'success' : ($field->viewable == 'private' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($field->viewable) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Status:</td>
                                                <td>
                                                    <span class="badge bg-{{ $field->is_active ? 'success' : 'danger' }}">
                                                        {{ $field->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Sort Order:</td>
                                                <td>{{ $field->sort_order ?? 0 }}</td>
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
                                                <td>{{ $field->created_at->format('M d, Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Updated:</td>
                                                <td>{{ $field->updated_at->format('M d, Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <!-- Field Preview -->
                                <div class="mb-4">
                                    <h6 class="fw-bold text-primary">Field Preview</h6>
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            @if($field->type == 'text')
                                                <input type="text" class="form-control" placeholder="{{ $field->label }}" disabled>
                                            @elseif($field->type == 'textarea')
                                                <textarea class="form-control" rows="3" placeholder="{{ $field->label }}" disabled></textarea>
                                            @elseif($field->type == 'number')
                                                <input type="number" class="form-control" placeholder="{{ $field->label }}" disabled>
                                            @elseif($field->type == 'email')
                                                <input type="email" class="form-control" placeholder="{{ $field->label }}" disabled>
                                            @elseif($field->type == 'date')
                                                <input type="date" class="form-control" disabled>
                                            @elseif($field->type == 'checkbox')
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" disabled>
                                                    <label class="form-check-label">{{ $field->label }}</label>
                                                </div>
                                            @elseif($field->type == 'select')
                                                <select class="form-select" disabled>
                                                    <option>{{ $field->label }}</option>
                                                </select>
                                            @else
                                                <input type="text" class="form-control" placeholder="{{ $field->label }}" disabled>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if($field->description)
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">Description</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-0">{{ $field->description }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Field Configuration -->
                        @if($field->field_config)
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">Field Configuration</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <pre class="mb-0">{{ json_encode($field->field_config, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Validation Rules -->
                        @if($field->validation_rules)
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">Validation Rules</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <pre class="mb-0">{{ json_encode($field->validation_rules, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Usage Statistics -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">Usage Statistics</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <h4 class="mb-1">0</h4>
                                            <small>Content Items</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h4 class="mb-1">0</h4>
                                            <small>Active Usage</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body text-center">
                                            <h4 class="mb-1">0</h4>
                                            <small>Total Values</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body text-center">
                                            <h4 class="mb-1">0</h4>
                                            <small>Last Used</small>
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










