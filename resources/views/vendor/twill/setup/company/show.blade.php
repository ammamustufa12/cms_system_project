@extends('twill::layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Company Details</h4>
                    <div>
                        <a href="{{ route('setup.company.edit', $company) }}" class="btn btn-warning">
                            <i class="ri-edit-line"></i> Edit
                        </a>
                        <a href="{{ route('setup.company.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Basic Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $company->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $company->email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td>{{ $company->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Website:</strong></td>
                                    <td>{{ $company->website ? '<a href="' . $company->website . '" target="_blank">' . $company->website . '</a>' : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $company->status == 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($company->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Address</h5>
                            <p>{{ $company->address ?? 'No address available' }}</p>
                            
                            <h5 class="mt-4">Description</h5>
                            <p>{{ $company->description ?? 'No description available' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
