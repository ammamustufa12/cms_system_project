@extends('twill::layouts.main')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">UserManagement</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">UserManagement</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

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
                                                id="create-btn" data-bs-target="#showModal"><i
                                                    class="ri-add-line align-bottom me-1"></i> Add</button>
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
                                    <table class="table align-middle table-nowrap" id="customerTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="width: 50px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll">
                                                    </div>
                                                </th>
                                                <th class="sort" data-sort="customer_name">Name</th>
                                                <th class="sort" data-sort="email">Email</th>
                                                {{-- <th class="sort" data-sort="phone">Phone</th> --}}
                                                <th class="sort" data-sort="joining_date">Joining Date</th>
                                                <th class="sort" data-sort="role">Role</th>
                                                <th class="sort" data-sort="status">Status</th>
                                                <th class="sort" data-sort="action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($users as $user)
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                                value="{{ $user->id }}">
                                                        </div>
                                                    </th>
                                                    <td class="id" style="display:none;">
                                                        <a href="javascript:void(0);"
                                                            class="fw-medium link-primary">#U{{ $user->id }}</a>
                                                    </td>
                                                    <td class="customer_name">{{ $user->name }}</td>
                                                    <td class="email">{{ $user->email }}</td>
                                                    {{-- <td class="phone">{{ $user->phone }}</td>  --}}
                                                    <td class="date">
                                                        {{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}
                                                    </td>
                                                    <td class="role">
                                                        {{ optional($user->role)->name ?? '-' }}
                                                    </td>
                                                    <td class="status">
                                                        <span
                                                            class="badge {{ $user->published ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} text-uppercase">
                                                            {{ $user->published ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <div class="edit">
                                                                <button class="btn btn-sm btn-success edit-item-btn"
                                                                    data-bs-toggle="modal" data-bs-target="#showModal"
                                                                    data-id="{{ $user->id }}">Edit</button>
                                                            </div>
                                                            <!-- Delete Button -->
                                                            <div class="remove">
                                                                {{-- <button class="btn btn-sm btn-danger remove-item-btn"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#deleteRecordModal"
                                                                    data-id="{{ $user->id }}">
                                                                    Remove
                                                                </button> --}}
                                                                                <button class="btn btn-danger btn-sm remove-item-btn" data-bs-toggle="modal" data-bs-target="#deleteRecordModal" data-id="{{ $user->id }}">Delete</button>

                                                            </div>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
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
            <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="showModalLabel">Add User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form class="tablelist-form" action="{{ route('users.store') }}" method="POST"
                            autocomplete="off">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="id" id="id-field" />

                                <div class="mb-3">
                                    <label for="customername-field" class="form-label">Customer Name</label>
                                    <input type="text" name="name" id="customername-field" class="form-control"
                                        placeholder="Enter Name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email-field" class="form-label">Email</label>
                                    <input type="email" name="email" id="email-field" class="form-control"
                                        placeholder="Enter Email" required>
                                </div>

                                {{-- <div class="mb-3">
                                    <label for="phone-field" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone-field" class="form-control" placeholder="Enter Phone no." required>

                                </div> --}}

                                <div class="mb-3">
                                    <label for="date-field" class="form-label">Joining Date</label>
                                    <input type="date" name="joining_date" id="date-field" class="form-control"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="status-field" class="form-label">Status</label>
                                    <select name="status" id="status-field" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Block">Block</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="role-field" class="form-label">Role</label>
                                    <select name="role_id" id="role-field" class="form-control" required>
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" id="add-btn">Add Customer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Delete Modal -->
        <!-- Delete Confirmation Modal -->
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteRecordModal" tabindex="-1" aria-labelledby="deleteRecordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="deleteUserForm">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRecordLabel">Delete Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>




            <!-- Script -->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const showModal = new bootstrap.Modal(document.getElementById('showModal'));

                    document.querySelectorAll('.edit-item-btn').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const row = btn.closest('tr');
                            const id = btn.dataset.id;
                            const name = row.querySelector('.customer_name')?.textContent.trim();
                            const email = row.querySelector('.email')?.textContent.trim();
                            const phone = row.querySelector('.phone')?.textContent.trim();
                            const date = row.querySelector('.date')?.textContent.trim();
                            const status = row.querySelector('.status .badge')?.textContent.trim();
                            const role = row.dataset.role || 'user';

                            document.getElementById('id-field').value = id;
                            document.getElementById('customername-field').value = name;
                            document.getElementById('email-field').value = email;
                            document.getElementById('phone-field').value = phone;
                            document.getElementById('date-field').value = formatDateForInput(date);
                            document.getElementById('status-field').value = (status === 'Active') ?
                                'Active' : 'Block';
                            document.getElementById('role-field').value = role;

                            document.getElementById('add-btn').textContent = 'Update Customer';
                            document.getElementById('showModalLabel').textContent = 'Edit User';
                        });
                    });

                    document.getElementById('create-btn').addEventListener('click', () => {
                        document.querySelector('.tablelist-form').reset();
                        document.getElementById('id-field').value = '';
                        document.getElementById('add-btn').textContent = 'Add Customer';
                        document.getElementById('showModalLabel').textContent = 'Add User';
                    });

                    function formatDateForInput(dateStr) {
                        const parts = dateStr.split(' ');
                        if (parts.length === 3) {
                            const day = parts[0].padStart(2, '0');
                            const month = new Date(`${parts[1]} 1, 2000`).getMonth() + 1;
                            const year = parts[2];
                            return `${year}-${String(month).padStart(2, '0')}-${day}`;
                        }
                        return '';
                    }
                });
            </script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".remove-item-btn");
    const deleteForm = document.getElementById("deleteUserForm");

    deleteButtons.forEach(button => {
        button.addEventListener("click", function () {
            const userId = this.getAttribute("data-id");
            // Set action URL with admin prefix and user ID
            deleteForm.setAttribute("action", `/admin/users/${userId}`);
        });
    });

    deleteForm.addEventListener('submit', function () {
        // Optional: disable submit button to prevent double submit
        this.querySelector('button[type="submit"]').disabled = true;
    });
});
</script>


            <!-- Modal -->
            <!-- Modal -->
            <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="showModalLabel">Add Customer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                id="close-modal"></button>
                        </div>

                        <form class="tablelist-form" action="{{ route('users.store') }}" method="POST"
                            autocomplete="off">
                            @csrf
                            <div class="modal-body">

                                <!-- Hidden ID for edit (optional) -->
                                <input type="hidden" name="id" id="id-field" />

                                <!-- Customer Name -->
                                <div class="mb-3">
                                    <label for="customername-field" class="form-label">Customer Name</label>
                                    <input type="text" name="name" id="customername-field" class="form-control"
                                        placeholder="Enter Name" required>
                                    <div class="invalid-feedback">Please enter a customer name.</div>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email-field" class="form-label">Email</label>
                                    <input type="email" name="email" id="email-field" class="form-control"
                                        placeholder="Enter Email" required>
                                    <div class="invalid-feedback">Please enter an email.</div>
                                </div>

                                <!-- Phone -->
                                <div class="mb-3">
                                    <label for="phone-field" class="form-label">Phone</label>
                                    <input type="text" name="phone" id="phone-field" class="form-control"
                                        placeholder="Enter Phone no." required>
                                    <div class="invalid-feedback">Please enter a phone number.</div>
                                </div>

                                <!-- Joining Date -->
                                <div class="mb-3">
                                    <label for="date-field" class="form-label">Joining Date</label>
                                    <input type="date" name="joining_date" id="date-field" class="form-control"
                                        placeholder="Select Date" required>
                                    <div class="invalid-feedback">Please select a joining date.</div>
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status-field" class="form-label">Status</label>
                                    <select name="status" id="status-field" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Block">Block</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a status.</div>
                                </div>

                                <!-- Role -->
                                <div class="mb-3">
                                    <label for="role-field" class="form-label">Role</label>
                                      <select name="role_id" id="role-field" class="form-control" required>
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a role.</div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" id="add-btn">Add Customer</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>




        </div>
        <!-- container-fluid -->
    </div>
@stop

{{-- @section('initialStore')
    window['{{ config('twill.js_namespace') }}'].STORE.datatable = {}

    window['{{ config('twill.js_namespace') }}'].STORE.datatable.mine = {!! json_encode($myActivityData) !!}
    window['{{ config('twill.js_namespace') }}'].STORE.datatable.all = {!! json_encode($allActivityData) !!}

    window['{{ config('twill.js_namespace') }}'].STORE.datatable.data = window['{{ config('twill.js_namespace') }}'].STORE.datatable.all
    window['{{ config('twill.js_namespace') }}'].STORE.datatable.columns = {!! json_encode($tableColumns) !!}
@stop
 --}}
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
