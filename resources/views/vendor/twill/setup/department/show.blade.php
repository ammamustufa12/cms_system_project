@extends('twill::layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Department Details</h4>
                    <div>
                        <a href="{{ route('setup.department.edit', $department) }}" class="btn btn-warning">
                            <i class="ri-edit-line"></i> Edit
                        </a>
                        <a href="{{ route('setup.department.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Department Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $department->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Company:</strong></td>
                                    <td>{{ $department->company->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Manager:</strong></td>
                                    <td>{{ $department->manager->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Budget:</strong></td>
                                    <td>{{ $department->budget ? '$' . number_format($department->budget) : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Description</h5>
                            <p>{{ $department->description ?? 'No description available' }}</p>
                            
                            <h5 class="mt-4">Employees ({{ $department->employees->count() }})</h5>
                            @if($department->employees->count() > 0)
                                <ul class="list-group">
                                    @foreach($department->employees as $employee)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $employee->first_name }} {{ $employee->last_name }}
                                            <span class="badge bg-primary">{{ $employee->position }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No employees assigned to this department.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
