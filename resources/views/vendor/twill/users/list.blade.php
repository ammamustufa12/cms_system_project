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

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">User Management</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">User Management</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Add, Edit & Remove</h4>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="ri-add-line align-bottom me-1"></i> Add User
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap" id="userTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll">
                                            </div>
                                        </th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="chk_child" value="{{ $user->id }}">
                                            </div>
                                        </td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone ?? '-' }}</td>
                                        <td>{{ optional($user->role)->name ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <!-- Edit button can open an edit modal (to implement) -->
                                                <button class="btn btn-sm btn-success" disabled>Edit</button>

                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($users->isEmpty())
                                <p class="text-center mt-3">No users found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('users.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="modal-body">

          <div class="row g-3">
            <div class="col-md-6">
              <label for="first_name" class="form-label">First Name*</label>
              <input type="text" class="form-control" name="first_name" required>
            </div>

            <div class="col-md-6">
              <label for="last_name" class="form-label">Last Name*</label>
              <input type="text" class="form-control" name="last_name" required>
            </div>

            <div class="col-md-6">
              <label for="username" class="form-label">Username*</label>
              <input type="text" class="form-control" name="username" required>
            </div>

            <div class="col-md-6">
              <label for="email" class="form-label">Email*</label>
              <input type="email" class="form-control" name="email" required>
            </div>

            <div class="col-md-6">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" minlength="6">
              <small class="form-text text-muted">Leave blank if you want to set later</small>
            </div>

            <div class="col-md-6">
              <label for="phone" class="form-label">Phone</label>
              <input type="text" class="form-control" name="phone">
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <textarea class="form-control" name="address" rows="2"></textarea>
            </div>

            <div class="col-12">
              <label for="photo" class="form-label">Photo URL</label>
  <input type="file" class="form-control" name="photo" accept="image/*">
            </div>

            <div class="col-12">
              <label for="role_id" class="form-label">Role</label>
              <select name="role_id" class="form-select">
                <option value="">-- Select Role --</option>
                @foreach($roles as $role)
                  <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                @endforeach
              </select>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save User</button>
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>


    </div>
</div>
@endsection
