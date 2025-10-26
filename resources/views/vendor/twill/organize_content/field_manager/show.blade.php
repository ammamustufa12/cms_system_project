@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">{{ $fieldManager->name }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.field-manager.index') }}">Field Manager</a></li>
                        <li class="breadcrumb-item active">{{ $fieldManager->name }}</li>
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
                                <h5 class="card-title mb-0">Field Type Details</h5>
                                <small class="text-muted">View and manage field type information</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.field-manager.edit', $fieldManager) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-edit-line me-1"></i> Edit
                                </a>
                                @if($fieldManager->is_installed)
                                    <form method="POST" action="{{ route('admin.field-manager.uninstall', $fieldManager) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            <i class="ri-uninstall-line me-1"></i> Uninstall
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.field-manager.install', $fieldManager) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="ri-download-line me-1"></i> Install
                                        </button>
                                    </form>
                                @endif
                                @if($fieldManager->is_active)
                                    <form method="POST" action="{{ route('admin.field-manager.deactivate', $fieldManager) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            <i class="ri-pause-line me-1"></i> Deactivate
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.field-manager.activate', $fieldManager) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="ri-play-line me-1"></i> Activate
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.field-manager.index') }}" class="btn btn-outline-secondary btn-sm">
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
                                                <td>{{ $fieldManager->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Type:</td>
                                                <td><span class="badge bg-info">{{ ucfirst($fieldManager->type) }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Source:</td>
                                                <td>
                                                    <span class="badge bg-{{ $fieldManager->source == 'centralized' ? 'primary' : ($fieldManager->source == 'local' ? 'success' : 'warning') }}">
                                                        {{ ucfirst($fieldManager->source) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Version:</td>
                                                <td>{{ $fieldManager->version ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Author:</td>
                                                <td>{{ $fieldManager->author ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Status:</td>
                                                <td>
                                                    <span class="badge bg-{{ $fieldManager->is_active ? 'success' : 'danger' }}">
                                                        {{ $fieldManager->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Installed:</td>
                                                <td>
                                                    <span class="badge bg-{{ $fieldManager->is_installed ? 'success' : 'secondary' }}">
                                                        {{ $fieldManager->is_installed ? 'Yes' : 'No' }}
                                                    </span>
                                                </td>
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
                                                <td>{{ $fieldManager->created_at->format('M d, Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Updated:</td>
                                                <td>{{ $fieldManager->updated_at->format('M d, Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                @if($fieldManager->install_file_path)
                                <div class="mb-4">
                                    <h6 class="fw-bold text-primary">Installation File</h6>
                                    <div class="alert alert-info">
                                        <i class="ri-file-zip-line me-2"></i>
                                        <strong>File Path:</strong> {{ $fieldManager->install_file_path }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        @if($fieldManager->description)
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">Description</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-0">{{ $fieldManager->description }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($fieldManager->install_instructions)
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">Installation Instructions</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <pre class="mb-0">{{ $fieldManager->install_instructions }}</pre>
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
                                            <small>Fields Using This Type</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h4 class="mb-1">0</h4>
                                            <small>Content Types</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body text-center">
                                            <h4 class="mb-1">0</h4>
                                            <small>Active Fields</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body text-center">
                                            <h4 class="mb-1">0</h4>
                                            <small>Total Usage</small>
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

