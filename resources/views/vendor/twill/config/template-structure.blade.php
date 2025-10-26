@extends('twill::layouts.main')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Template Structure</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Template Structure Settings</h5>
                        </div>
                        <div class="card-body">
                            <p>Configure template structure settings here.</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Template Engine</label>
                                        <select class="form-select">
                                            <option>Blade</option>
                                            <option>Twig</option>
                                            <option>Handlebars</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Layout Type</label>
                                        <select class="form-select">
                                            <option>Fixed Width</option>
                                            <option>Fluid Width</option>
                                            <option>Responsive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Header Style</label>
                                        <select class="form-select">
                                            <option>Fixed Header</option>
                                            <option>Sticky Header</option>
                                            <option>Static Header</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Sidebar Position</label>
                                        <select class="form-select">
                                            <option>Left Sidebar</option>
                                            <option>Right Sidebar</option>
                                            <option>No Sidebar</option>
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






