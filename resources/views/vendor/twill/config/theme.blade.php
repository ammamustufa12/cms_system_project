@extends('twill::layouts.main')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Theme</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Theme Settings</h5>
                        </div>
                        <div class="card-body">
                            <p>Configure theme settings here.</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Theme Mode</label>
                                        <select class="form-select">
                                            <option>Light Theme</option>
                                            <option>Dark Theme</option>
                                            <option>Auto (System)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Theme Style</label>
                                        <select class="form-select">
                                            <option>Default</option>
                                            <option>Modern</option>
                                            <option>Classic</option>
                                            <option>Minimal</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Border Radius</label>
                                        <select class="form-select">
                                            <option>None (0px)</option>
                                            <option>Small (4px)</option>
                                            <option>Medium (8px)</option>
                                            <option>Large (12px)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Shadow Style</label>
                                        <select class="form-select">
                                            <option>None</option>
                                            <option>Light</option>
                                            <option>Medium</option>
                                            <option>Heavy</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary">Save Theme</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection






