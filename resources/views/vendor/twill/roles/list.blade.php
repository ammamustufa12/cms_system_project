@extends('twill::layouts.main')

@section('content')
<style>
    .navbar-brand-box {
        margin-top: 25px;
        text-align: center;
        transition: all .1s ease-out;
    }
</style>

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Role Management</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">RoleManagement</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- Alerts -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Add, Edit & Remove</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                                id="create-btn" data-bs-target="#addRoleModal">
                                                <i class="ri-add-line align-bottom me-1"></i> Add
                                            </button>
                                            <button class="btn btn-soft-danger" onClick="deleteMultiple()"><i
                                                    class="ri-delete-bin-2-line"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <input type="text" class="form-control search" placeholder="Search...">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap" id="rolesTable">
                                        <table class="table table-bordered table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Slug</th>
                                                    <th>Permissions</th>
                                                    <th>Created At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($roles as $role)
                                                    <tr>
                                                        <td>{{ $role->name }}</td>
                                                        <td>{{ $role->slug }}</td>
                                                        <td>
                                                            @foreach ($role->permissions ?? [] as $perm)
                                                                <span
                                                                    class="badge bg-info text-dark">{{ $perm }}</span>
                                                            @endforeach
                                                        </td>
                                                        <td>{{ $role->created_at->format('d M Y') }}</td>
                                                        <td>
                                                            <!-- Edit Button -->
                                                            <button class="btn btn-sm btn-primary edit-role-btn"
                                                                data-bs-toggle="modal" data-bs-target="#editRoleModal"
                                                                data-id="{{ $role->id }}"
                                                                data-name="{{ $role->name }}"
                                                                data-slug="{{ $role->slug }}"
                                                                data-permissions='@json($role->permissions)'>
                                                                Edit
                                                            </button>

                                                            <!-- Delete Form -->
                                                            <form action="{{ route('roles.destroy', $role->id) }}"
                                                                method="POST" onsubmit="return confirm('Are you sure?');"
                                                                style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-danger">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">No roles found.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        <div class="noresult" style="display: none">
                                            <div class="text-center">
                                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                    colors="primary:#121331,secondary:#08a88a"
                                                    style="width:75px;height:75px"></lord-icon>
                                                <h5 class="mt-2">Sorry! No Result Found</h5>
                                                <p class="text-muted mb-0">We've searched more than 150+ Orders We
                                                    did not find any orders for you search.</p>
                                            </div>
                                        </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <div class="pagination-wrap hstack gap-2">
                                        <a class="page-item pagination-prev disabled" href="javascript:void(0);">
                                            Previous
                                        </a>
                                        <ul class="pagination listjs-pagination mb-0"></ul>
                                        <a class="page-item pagination-next" href="javascript:void(0);">
                                            Next
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end col -->
            </div>

            <!-- Add/Edit Modal -->
            <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="addRoleModalLabel">Add Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('roles.store') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="role-name-field" class="form-label">Role Name</label>
                                    <input type="text" name="name" id="role-name-field" class="form-control"
                                        placeholder="Enter Role Name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="role-slug-field" class="form-label">Slug</label>
                                    <input type="text" name="slug" id="role-slug-field" class="form-control"
                                        placeholder="Enter Slug (e.g. admin, manager)" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Permissions</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]"
                                            value="add_user" id="permAddUser">
                                        <label class="form-check-label" for="permAddUser">Add User</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]"
                                            value="edit_user" id="permEditUser">
                                        <label class="form-check-label" for="permEditUser">Edit User</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]"
                                            value="delete_user" id="permDeleteUser">
                                        <label class="form-check-label" for="permDeleteUser">Delete User</label>
                                    </div>
                                    <!-- Add more permissions as needed -->
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" id="add-role-btn">Add Role</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <!-- Edit Role Modal -->
            <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form method="POST" id="editRoleForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header bg-light">
                                <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Role Name</label>
                                    <input type="text" name="name" id="edit-role-name" class="form-control"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" name="slug" id="edit-role-slug" class="form-control"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Permissions</label>
                                    @php
                                        $permissions = ['add_user', 'edit_user', 'delete_user'];
                                    @endphp
                                    @foreach ($permissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission }}"
                                                class="form-check-input edit-perm" id="edit_{{ $permission }}">
                                            <label class="form-check-label"
                                                for="edit_{{ $permission }}">{{ ucwords(str_replace('_', ' ', $permission)) }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update Role</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            

        </div>
        <!-- container-fluid -->
    </div>
@stop

<script>
    $(document).ready(function() {
        $('#date-field').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    });
</script>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<!-- Bootstrap Datepicker CSS -->
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/css/bootstrap-datepicker.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap Datepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/js/bootstrap-datepicker.min.js"></script>

@push('extra_js')
    <script src="{{ twillAsset('main-dashboard.js') }}" crossorigin></script>
@endpush
