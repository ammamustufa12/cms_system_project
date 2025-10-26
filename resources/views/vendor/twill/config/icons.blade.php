@extends('twill::layouts.main')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Icons</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Icons Settings</h5>
                        </div>
                        <div class="card-body">
                            <p>Configure icons settings here.</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Icon Library</label>
                                        <select class="form-select">
                                            <option>Boxicons</option>
                                            <option>Font Awesome</option>
                                            <option>Feather Icons</option>
                                            <option>Material Icons</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Icon Size</label>
                                        <select class="form-select">
                                            <option>Small (16px)</option>
                                            <option>Medium (24px)</option>
                                            <option>Large (32px)</option>
                                            <option>Extra Large (48px)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Icon Style</label>
                                        <select class="form-select">
                                            <option>Outlined</option>
                                            <option>Filled</option>
                                            <option>Rounded</option>
                                            <option>Sharp</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Icon Color</label>
                                        <input type="color" class="form-control form-control-color" value="#556ee6">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary">Save Icons</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection






