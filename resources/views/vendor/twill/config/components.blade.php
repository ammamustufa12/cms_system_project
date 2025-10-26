@extends('twill::layouts.main')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Components</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Components Settings</h5>
                        </div>
                        <div class="card-body">
                            <p>Configure components settings here.</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Button Style</label>
                                        <select class="form-select">
                                            <option>Rounded</option>
                                            <option>Square</option>
                                            <option>Pill</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Card Style</label>
                                        <select class="form-select">
                                            <option>Default</option>
                                            <option>Bordered</option>
                                            <option>Shadow</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Modal Style</label>
                                        <select class="form-select">
                                            <option>Center</option>
                                            <option>Top</option>
                                            <option>Bottom</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Alert Style</label>
                                        <select class="form-select">
                                            <option>Bordered</option>
                                            <option>Filled</option>
                                            <option>Minimal</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary">Save Components</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection






