@extends('twill::layouts.main')

@section('content')
<div class="container-fluid">
    <!-- Top Header Bar -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded">
                <div>
                    <h2 class="mb-1 fw-bold">COMPANY</h2>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Configuration</a></li>
                            <li class="breadcrumb-item active">Company</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown me-3">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            20
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">10</a></li>
                            <li><a class="dropdown-item" href="#">20</a></li>
                            <li><a class="dropdown-item" href="#">50</a></li>
                        </ul>
                    </div>
                    <div class="btn-group me-3" role="group">
                        <button type="button" class="btn btn-outline-secondary btn-sm active" id="listView">
                            <i class="ri-list-check"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="gridView">
                            <i class="ri-grid-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Add Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="search-box" style="width: 400px;">
                    <div class="position-relative">
                        <input type="text" class="form-control form-control-lg" placeholder="Q Search for a company..." id="companySearch" style="border-radius: 25px; padding-left: 20px; padding-right: 50px;">
                        <i class="ri-search-line position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                    </div>
                </div>
                <a href="{{ route('setup.company.create') }}" class="btn btn-primary btn-lg px-4">
                    <i class="ri-add-line me-1"></i> + Add Company
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ri-check-circle-line me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Main Content Area -->
        <div class="col-lg-8">
            <div class="row" id="companiesList">
                @forelse($companies as $company)
                    <div class="col-md-6 col-lg-12 mb-4 company-card" data-company-id="{{ $company->id }}">
                        <div class="card h-100 company-item shadow-sm" style="cursor: pointer; border: 1px solid #e9ecef;">
                            <div class="card-body p-4">
                                <!-- Company Header -->
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="company-logo me-3" style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                            <span class="text-white fw-bold fs-4">{{ substr($company->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <h5 class="mb-1 fw-bold">{{ $company->name }}</h5>
                                            <small class="text-muted">{{ Str::limit($company->description, 25) }}</small>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="ri-more-2-line"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('setup.company.show', $company) }}"><i class="ri-eye-line me-2"></i>View</a></li>
                                            <li><a class="dropdown-item" href="{{ route('setup.company.edit', $company) }}"><i class="ri-edit-line me-2"></i>Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('setup.company.destroy', $company) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="ri-delete-bin-line me-2"></i>Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <!-- Company Type Badge -->
                                <div class="mb-3">
                                    <span class="badge bg-{{ $company->status == 'active' ? 'success' : 'danger' }} rounded-pill px-3 py-2">
                                        {{ $company->status == 'active' ? 'Parent Company' : 'Inactive Company' }}
                                    </span>
                                </div>
                                
                                <!-- Company Details -->
                                <div class="company-details">
                                    @if($company->phone)
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="ri-phone-line text-muted me-2"></i>
                                            <small class="text-dark">Main Phone: {{ $company->phone }}</small>
                                        </div>
                                    @endif
                                    
                                    @if($company->email)
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="ri-mail-line text-muted me-2"></i>
                                            <small class="text-dark">Email: {{ $company->email }}</small>
                                        </div>
                                    @endif
                                    
                                    @if($company->address)
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="ri-map-pin-line text-muted me-2"></i>
                                            <small class="text-dark">{{ Str::limit($company->address, 60) }}</small>
                                        </div>
                                    @endif
                                    
                                    @if($company->website)
                                        <div class="d-flex align-items-center">
                                            <i class="ri-global-line text-muted me-2"></i>
                                            <small><a href="{{ $company->website }}" target="_blank" class="text-decoration-none text-primary">{{ $company->website }}</a></small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="card-footer bg-transparent border-0 p-3">
                                <div class="d-flex justify-content-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('setup.company.show', $company) }}" class="btn btn-outline-info btn-sm" title="View">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                        <a href="{{ route('setup.company.edit', $company) }}" class="btn btn-outline-warning btn-sm" title="Edit">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-secondary btn-sm" title="Location">
                                            <i class="ri-map-pin-line"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-secondary btn-sm" title="Building">
                                            <i class="ri-building-line"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="ri-building-line text-muted" style="font-size: 4rem;"></i>
                            <h4 class="mt-3 text-muted">No Companies Found</h4>
                            <p class="text-muted">Start by adding your first company to the system.</p>
                            <a href="{{ route('setup.company.create') }}" class="btn btn-primary">
                                <i class="ri-add-line me-1"></i>Add First Company
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- Right Sidebar -->
        <div class="col-lg-4">
            <div class="card" id="companyDetailsSidebar" style="display: none;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Company Details</h5>
                </div>
                <div class="card-body" id="companyDetailsContent">
                    <!-- Company details will be loaded here -->
                </div>
            </div>
            
            <!-- Default message when no company is selected -->
            <div class="card" id="defaultSidebar">
                <div class="card-body text-center py-5">
                    <i class="ri-building-line text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">Select a Company</h5>
                    <p class="text-muted">Click on any company card to view its details here.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Company card click handler
    document.querySelectorAll('.company-item').forEach(card => {
        card.addEventListener('click', function(e) {
            // Don't trigger if clicking on buttons or dropdowns
            if (e.target.closest('button') || e.target.closest('a') || e.target.closest('.dropdown')) {
                return;
            }
            
            const companyId = this.closest('.company-card').dataset.companyId;
            loadCompanyDetails(companyId);
        });
    });
    
    // Search functionality
    document.getElementById('companySearch').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('.company-card').forEach(card => {
            const companyName = card.querySelector('h5').textContent.toLowerCase();
            const companyDescription = card.querySelector('small').textContent.toLowerCase();
            
            if (companyName.includes(searchTerm) || companyDescription.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    // View toggle functionality
    document.getElementById('listView').addEventListener('click', function() {
        document.getElementById('companiesList').className = 'col-md-12';
        this.classList.add('active');
        document.getElementById('gridView').classList.remove('active');
    });
    
    document.getElementById('gridView').addEventListener('click', function() {
        document.getElementById('companiesList').className = 'col-md-6 col-lg-4 mb-4';
        this.classList.add('active');
        document.getElementById('listView').classList.remove('active');
    });
});

function loadCompanyDetails(companyId) {
    // Hide default sidebar and show details sidebar
    document.getElementById('defaultSidebar').style.display = 'none';
    document.getElementById('companyDetailsSidebar').style.display = 'block';
    
    // Show loading state
    document.getElementById('companyDetailsContent').innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Loading company details...</p>
        </div>
    `;
    
    // Make AJAX call to get company details
    fetch(`/admin/setup/company/${companyId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const company = data.company;
                document.getElementById('companyDetailsContent').innerHTML = `
                    <div class="text-center mb-4">
                        <div class="company-logo mx-auto mb-3" style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                            <span class="text-white fw-bold fs-2">${company.name.charAt(0).toUpperCase()}</span>
                        </div>
                        <h4 class="mb-1">${company.name}</h4>
                        <p class="text-muted mb-0">${company.email || 'No Contact Person'}</p>
                        <div class="d-flex justify-content-center mt-2">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary btn-sm" title="Website"><i class="ri-global-line"></i></button>
                                <button class="btn btn-outline-secondary btn-sm" title="Email"><i class="ri-mail-line"></i></button>
                                <button class="btn btn-outline-secondary btn-sm" title="Calendar"><i class="ri-calendar-line"></i></button>
                                <button class="btn btn-outline-secondary btn-sm" title="Documents"><i class="ri-file-text-line"></i></button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="fw-bold">Information</h6>
                        <p class="small text-muted">${company.description || 'No description available for this company.'}</p>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <small class="text-muted d-block">Status</small>
                            <div class="fw-medium">
                                <span class="badge bg-${company.status === 'active' ? 'success' : 'danger'} rounded-pill">
                                    ${company.status.charAt(0).toUpperCase() + company.status.slice(1)}
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Location</small>
                            <div class="fw-medium">${company.address ? company.address.split(',')[0] : 'Not specified'}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Phone</small>
                            <div class="fw-medium">${company.phone || 'Not provided'}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Rating</small>
                            <div class="fw-medium">4.0 <i class="ri-star-fill text-warning"></i></div>
                        </div>
                        <div class="col-12">
                            <small class="text-muted d-block">Website</small>
                            <div class="fw-medium">
                                ${company.website ? `<a href="${company.website}" target="_blank" class="text-decoration-none">${company.website}</a>` : 'Not provided'}
                            </div>
                        </div>
                        <div class="col-12">
                            <small class="text-muted d-block">Contact Email</small>
                            <div class="fw-medium">${company.email || 'Not provided'}</div>
                        </div>
                        <div class="col-12">
                            <small class="text-muted d-block">Since</small>
                            <div class="fw-medium">${company.created_at ? new Date(company.created_at).getFullYear() : 'Unknown'}</div>
                        </div>
                        <div class="col-12">
                            <small class="text-muted d-block">Address</small>
                            <div class="fw-medium">${company.address || 'Not provided'}</div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-grid gap-2">
                        <a href="/admin/setup/company/${company.id}" class="btn btn-outline-primary btn-sm">
                            <i class="ri-eye-line me-1"></i> View Details
                        </a>
                        <a href="/admin/setup/company/${company.id}/edit" class="btn btn-outline-warning btn-sm">
                            <i class="ri-edit-line me-1"></i> Edit Company
                        </a>
                        <button class="btn btn-outline-secondary btn-sm">
                            <i class="ri-settings-3-line me-1"></i> Settings
                        </button>
                    </div>
                `;
            } else {
                document.getElementById('companyDetailsContent').innerHTML = `
                    <div class="text-center py-4">
                        <i class="ri-error-warning-line text-danger" style="font-size: 3rem;"></i>
                        <h5 class="mt-3 text-danger">Error Loading Details</h5>
                        <p class="text-muted">Unable to load company details. Please try again.</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('companyDetailsContent').innerHTML = `
                <div class="text-center py-4">
                    <i class="ri-error-warning-line text-danger" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-danger">Error Loading Details</h5>
                    <p class="text-muted">Unable to load company details. Please try again.</p>
                </div>
            `;
        });
}
</script>
@endsection
