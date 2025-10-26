@extends('twill::layouts.main')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">User Management</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">User Management Settings</h5>
                        </div>
                        <div class="card-body">
                            <p>Configure user management settings here.</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Default User Role</label>
                                        <select class="form-select">
                                            <option>User</option>
                                            <option>Admin</option>
                                            <option>Manager</option>
                                            <option>Editor</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">User Registration</label>
                                        <select class="form-select">
                                            <option>Enabled</option>
                                            <option>Disabled</option>
                                            <option>Admin Approval Required</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Email Verification</label>
                                        <select class="form-select">
                                            <option>Required</option>
                                            <option>Optional</option>
                                            <option>Disabled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Two-Factor Authentication</label>
                                        <select class="form-select">
                                            <option>Optional</option>
                                            <option>Required for Admins</option>
                                            <option>Required for All</option>
                                            <option>Disabled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary">Save Settings</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

