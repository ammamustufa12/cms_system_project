@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Edit Profile</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.profiles.index') }}">Profiles</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.profiles.show', $profile) }}">{{ $profile->name }}</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid px-5">
        <form action="{{ route('admin.profiles.update', $profile) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Profile Picture Section -->
                <div class="col-12 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="card-title mb-0">Profile Picture</h5>
                        </div>
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
                        <div class="card-body text-center">
                            <div class="position-relative d-inline-block">
                                @if($profile->avatar)
                                    <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Profile" class="rounded-circle border border-4 border-light" 
                                         style="width: 120px; height: 120px; object-fit: cover;" id="avatar-preview">
                                @else
                                    <div class="bg-primary rounded-circle border border-4 border-light d-flex align-items-center justify-content-center" 
                                         style="width: 120px; height: 120px;" id="avatar-preview">
                                        <i class="ri-user-line text-white" style="font-size: 3rem;"></i>
                                    </div>
                                @endif
                                <label for="avatar" class="position-absolute bottom-0 end-0 btn btn-primary btn-sm rounded-circle" 
                                       style="width: 35px; height: 35px; padding: 0;">
                                    <i class="ri-camera-line"></i>
                                </label>
                                <input type="file" class="d-none" id="avatar" name="avatar" accept="image/*" onchange="previewImage(this)">
                            </div>
                            <p class="text-muted mt-2 mb-0">Click the camera icon to change profile picture</p>
                        </div>
                    </div>
                </div>
                
                <!-- Basic Information -->
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="card-title mb-0">Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $profile->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $profile->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone', $profile->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                            <option value="active" {{ old('status', $profile->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $profile->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="2">{{ old('address', $profile->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">About</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4">{{ old('description', $profile->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Information -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="card-title mb-0">Additional Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Job Title</label>
                                <input type="text" class="form-control" id="title" name="custom_fields[title]" 
                                       value="{{ old('custom_fields.title', $profile->custom_fields['title'] ?? '') }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="company" class="form-label">Company</label>
                                <input type="text" class="form-control" id="company" name="custom_fields[company]" 
                                       value="{{ old('custom_fields.company', $profile->custom_fields['company'] ?? '') }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="followers" class="form-label">Followers Count</label>
                                <input type="number" class="form-control" id="followers" name="custom_fields[followers]" 
                                       value="{{ old('custom_fields.followers', $profile->custom_fields['followers'] ?? '') }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="following" class="form-label">Following Count</label>
                                <input type="number" class="form-control" id="following" name="custom_fields[following]" 
                                       value="{{ old('custom_fields.following', $profile->custom_fields['following'] ?? '') }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="completion_percentage" class="form-label">Profile Completion %</label>
                                <input type="number" class="form-control" id="completion_percentage" name="custom_fields[completion_percentage]" 
                                       min="0" max="100" value="{{ old('custom_fields.completion_percentage', $profile->custom_fields['completion_percentage'] ?? '30') }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="sort_order" class="form-label">Sort Order</label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" 
                                       value="{{ old('sort_order', $profile->sort_order) }}" min="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Social Links Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="card-title mb-0">Social Links</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="facebook" class="form-label">Facebook</label>
                                        <input type="url" class="form-control" id="facebook" name="social_links[facebook]" 
                                               value="{{ old('social_links.facebook', $profile->social_links['facebook'] ?? '') }}" 
                                               placeholder="https://facebook.com/username">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="twitter" class="form-label">Twitter</label>
                                        <input type="url" class="form-control" id="twitter" name="social_links[twitter]" 
                                               value="{{ old('social_links.twitter', $profile->social_links['twitter'] ?? '') }}" 
                                               placeholder="https://twitter.com/username">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="linkedin" class="form-label">LinkedIn</label>
                                        <input type="url" class="form-control" id="linkedin" name="social_links[linkedin]" 
                                               value="{{ old('social_links.linkedin', $profile->social_links['linkedin'] ?? '') }}" 
                                               placeholder="https://linkedin.com/in/username">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="instagram" class="form-label">Instagram</label>
                                        <input type="url" class="form-control" id="instagram" name="social_links[instagram]" 
                                               value="{{ old('social_links.instagram', $profile->social_links['instagram'] ?? '') }}" 
                                               placeholder="https://instagram.com/username">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="youtube" class="form-label">YouTube</label>
                                        <input type="url" class="form-control" id="youtube" name="social_links[youtube]" 
                                               value="{{ old('social_links.youtube', $profile->social_links['youtube'] ?? '') }}" 
                                               placeholder="https://youtube.com/c/username">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="github" class="form-label">GitHub</label>
                                        <input type="url" class="form-control" id="github" name="social_links[github]" 
                                               value="{{ old('social_links.github', $profile->social_links['github'] ?? '') }}" 
                                               placeholder="https://github.com/username">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('admin.profiles.show', $profile) }}" class="btn btn-info">
                                <i class="ri-eye-line me-1"></i> View Profile
                            </a>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.profiles.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i> Update Profile
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                // Replace div with img
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Profile';
                img.className = 'rounded-circle border border-4 border-light';
                img.style.cssText = 'width: 120px; height: 120px; object-fit: cover;';
                img.id = 'avatar-preview';
                preview.parentNode.replaceChild(img, preview);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
