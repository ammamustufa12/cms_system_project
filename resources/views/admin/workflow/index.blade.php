@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">CMS Setup Workflow</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Workflow</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid px-5">
        <!-- Progress Overview -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-4">
                        <h5 class="card-title mb-3">Setup Progress</h5>
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="progress mb-3" style="height: 20px;">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: {{ $progressPercentage }}%" 
                                         aria-valuenow="{{ $progressPercentage }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        {{ number_format($progressPercentage, 1) }}%
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h3 class="mb-0 text-success">{{ $completedSteps }}/{{ $totalSteps }}</h3>
                                <small class="text-muted">Steps Completed</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Workflow Steps -->
        <div class="row">
            @foreach($workflowSteps as $index => $step)
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card border-0 shadow-sm h-100 {{ $step['status'] === 'completed' ? 'border-success' : '' }}">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-{{ $step['color'] }} text-white rounded-3 p-3 me-3">
                                <i class="{{ $step['icon'] }} fa-lg"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="card-title mb-1">{{ $step['title'] }}</h6>
                                <p class="text-muted small mb-2">{{ $step['description'] }}</p>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-{{ $step['status'] === 'completed' ? 'success' : 'secondary' }} me-2">
                                        {{ $step['count'] }} {{ Str::plural('item', $step['count']) }}
                                    </span>
                                    @if($step['status'] === 'completed')
                                        <i class="ri-check-line text-success"></i>
                                    @else
                                        <i class="ri-time-line text-muted"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route($step['route']) }}" 
                               class="btn btn-{{ $step['status'] === 'completed' ? 'outline-success' : 'primary' }} btn-sm">
                                @if($step['status'] === 'completed')
                                    <i class="ri-eye-line me-1"></i> View
                                @else
                                    <i class="ri-arrow-right-line me-1"></i> Start
                                @endif
                            </a>
                            
                            @if($step['status'] === 'completed')
                                <small class="text-success">
                                    <i class="ri-check-line me-1"></i> Complete
                                </small>
                            @else
                                <small class="text-muted">
                                    <i class="ri-time-line me-1"></i> Pending
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body text-center py-4">
                        <h5 class="card-title mb-3">Quick Actions</h5>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="{{ route('admin.industries.create') }}" class="btn btn-outline-primary">
                                <i class="ri-building-line me-1"></i> Add Industry
                            </a>
                            <a href="{{ route('admin.data-types.create') }}" class="btn btn-outline-info">
                                <i class="ri-database-2-line me-1"></i> Add Data Type
                            </a>
                            <a href="{{ route('admin.profiles.create') }}" class="btn btn-outline-success">
                                <i class="ri-user-line me-1"></i> Add Profile
                            </a>
                            <a href="{{ route('admin.category-groups.create') }}" class="btn btn-outline-warning">
                                <i class="ri-folder-line me-1"></i> Add Category Group
                            </a>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-secondary">
                                <i class="ri-list-check me-1"></i> Add Category
                            </a>
                            <a href="{{ route('admin.field-manager.install') }}" class="btn btn-outline-danger">
                                <i class="ri-download-line me-1"></i> Install Field Type
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Help Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">Workflow Guide</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold">Setup Order</h6>
                                <ol class="text-muted">
                                    <li>Start with <strong>Industries</strong> to define your business sectors</li>
                                    <li>Create <strong>Data Types</strong> for field validation rules</li>
                                    <li>Set up <strong>Profiles</strong> for different user types</li>
                                    <li>Organize content with <strong>Category Groups</strong></li>
                                    <li>Create <strong>Categories</strong> within groups</li>
                                    <li>Install <strong>Field Types</strong> for content structure</li>
                                    <li>Group fields with <strong>Field Groups</strong></li>
                                    <li>Manage individual <strong>Fields</strong></li>
                                </ol>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold">Tips</h6>
                                <ul class="text-muted">
                                    <li>Each step builds upon the previous ones</li>
                                    <li>You can revisit any completed step to make changes</li>
                                    <li>Use the sidebar navigation to jump between sections</li>
                                    <li>All pages are interconnected for easy workflow</li>
                                    <li>Progress is automatically tracked</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

