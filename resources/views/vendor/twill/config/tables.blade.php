@extends('twill::layouts.main')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Tables</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Tables Settings</h5>
                        </div>
                        <div class="card-body">
                            <p>Configure tables settings here.</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Table Style</label>
                                        <select class="form-select">
                                            <option>Default</option>
                                            <option>Bordered</option>
                                            <option>Striped</option>
                                            <option>Hover</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Pagination</label>
                                        <select class="form-select">
                                            <option>Enabled</option>
                                            <option>Disabled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Search Function</label>
                                        <select class="form-select">
                                            <option>Enabled</option>
                                            <option>Disabled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Sorting</label>
                                        <select class="form-select">
                                            <option>Enabled</option>
                                            <option>Disabled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary">Save Tables</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection






