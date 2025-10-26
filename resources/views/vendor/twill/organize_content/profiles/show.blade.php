@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Profile Details</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.profiles.index') }}">Profiles</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid px-5">
        <!-- Profile Banner -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm overflow-hidden">
                    <!-- Profile Banner Background -->
                    <div class="position-relative" style="height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="position-absolute top-0 end-0 p-3">
                            <a href="{{ route('admin.profiles.edit', $profile) }}" class="btn btn-success btn-sm">
                                <i class="ri-edit-line me-1"></i> Edit Profile
                            </a>
                        </div>
                        
                        <!-- Profile Picture -->
                        <div class="position-absolute" style="bottom: -60px; left: 30px;">
                            <div class="position-relative">
                                @if($profile->avatar)
                                    <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Profile" class="rounded-circle border border-4 border-white" 
                                         style="width: 120px; height: 120px; object-fit: cover;">
                                @else
                                    <div class="bg-primary rounded-circle border border-4 border-white d-flex align-items-center justify-content-center" 
                                         style="width: 120px; height: 120px;">
                                        <i class="ri-user-line text-white" style="font-size: 3rem;"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Profile Info -->
                    <div class="card-body pt-5">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-8">
                                <div class="d-flex align-items-start">
                                    <div class="ms-4">
                                        <h3 class="mb-1">{{ $profile->name }}</h3>
                                        <p class="text-muted mb-2">
                                            <i class="ri-briefcase-line me-1"></i>
                                            {{ $profile->custom_fields['title'] ?? 'Profile Owner' }}
                                        </p>
                                        @if($profile->address)
                                        <p class="text-muted mb-2">
                                            <i class="ri-map-pin-line me-1"></i>
                                            {{ $profile->address }}
                                        </p>
                                        @endif
                                        @if($profile->custom_fields['company'])
                                        <p class="text-muted mb-0">
                                            <i class="ri-building-line me-1"></i>
                                            {{ $profile->custom_fields['company'] }}
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="text-center">
                                            <h4 class="mb-0 text-primary">{{ $profile->custom_fields['followers'] ?? '0' }}</h4>
                                            <small class="text-muted">Followers</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center">
                                            <h4 class="mb-0 text-primary">{{ $profile->custom_fields['following'] ?? '0' }}</h4>
                                            <small class="text-muted">Following</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <ul class="nav nav-tabs nav-tabs-custom" id="profileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                                    <i class="ri-dashboard-line me-1"></i> Overview
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="activities-tab" data-bs-toggle="tab" data-bs-target="#activities" type="button" role="tab">
                                    <i class="ri-activity-line me-1"></i> Activities
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="projects-tab" data-bs-toggle="tab" data-bs-target="#projects" type="button" role="tab">
                                    <i class="ri-folder-line me-1"></i> Projects
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab">
                                    <i class="ri-file-text-line me-1"></i> Documents
                                </button>
                            </li>
                        </ul>
                        
                        <div class="tab-content p-4" id="profileTabsContent">
                            <!-- Overview Tab -->
                            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                                <div class="row">
                                    <!-- Complete Your Profile Section -->
                                    <div class="col-12 mb-4">
                                        <div class="card border-0 bg-light">
                                            <div class="card-body">
                                                <h5 class="card-title">Complete Your Profile</h5>
                                                <div class="progress mb-3" style="height: 8px;">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $profile->custom_fields['completion_percentage'] ?? '30' }}%"></div>
                                                </div>
                                                <p class="text-muted mb-0">{{ $profile->custom_fields['completion_percentage'] ?? '30' }}% Complete</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Info Section -->
                                    <div class="col-12">
                                        <h5 class="mb-3">Info</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td class="fw-bold" style="width: 120px;">Full Name:</td>
                                                        <td>{{ $profile->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">Mobile:</td>
                                                        <td>{{ $profile->phone ?: 'Not provided' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">E-mail:</td>
                                                        <td>{{ $profile->email ?: 'Not provided' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">Location:</td>
                                                        <td>{{ $profile->address ?: 'Not provided' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                @if($profile->description)
                                                <h6 class="fw-bold">About</h6>
                                                <p class="text-muted">{{ $profile->description }}</p>
                                                @endif
                                                
                                                @if($profile->social_links && count($profile->social_links) > 0)
                                                <h6 class="fw-bold">Social Links</h6>
                                                <div class="d-flex gap-2">
                                                    @foreach($profile->social_links as $platform => $url)
                                                        <a href="{{ $url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                            <i class="ri-{{ $platform }}-line"></i> {{ ucfirst($platform) }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Activities Tab -->
                            <div class="tab-pane fade" id="activities" role="tabpanel">
                                <h5 class="mb-3">Recent Activities</h5>
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-primary"></div>
                                        <div class="timeline-content">
                                            <h6 class="timeline-title">Profile Updated</h6>
                                            <p class="timeline-text">Profile information was updated</p>
                                            <small class="text-muted">{{ $profile->updated_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-success"></div>
                                        <div class="timeline-content">
                                            <h6 class="timeline-title">Profile Created</h6>
                                            <p class="timeline-text">New profile was created</p>
                                            <small class="text-muted">{{ $profile->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Projects Tab -->
                            <div class="tab-pane fade" id="projects" role="tabpanel">
                                <h5 class="mb-3">Projects</h5>
                                <div class="text-center py-5">
                                    <i class="ri-folder-line text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-3">No projects available</p>
                                </div>
                            </div>
                            
                            <!-- Documents Tab -->
                            <div class="tab-pane fade" id="documents" role="tabpanel">
                                <h5 class="mb-3">Documents</h5>
                                <div class="text-center py-5">
                                    <i class="ri-file-text-line text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-3">No documents available</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #e9ecef;
}

.timeline-title {
    margin-bottom: 5px;
    font-weight: 600;
}

.timeline-text {
    margin-bottom: 5px;
    color: #6c757d;
}
</style>
@endsection
