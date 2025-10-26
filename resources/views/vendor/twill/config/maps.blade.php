@extends('twill::layouts.main')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Maps</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Maps Settings</h5>
                        </div>
                        <div class="card-body">
                            <p>Configure maps settings here.</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Map Provider</label>
                                        <select class="form-select">
                                            <option>Google Maps</option>
                                            <option>OpenStreetMap</option>
                                            <option>Bing Maps</option>
                                            <option>Mapbox</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Map Style</label>
                                        <select class="form-select">
                                            <option>Default</option>
                                            <option>Satellite</option>
                                            <option>Terrain</option>
                                            <option>Hybrid</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Default Zoom</label>
                                        <select class="form-select">
                                            <option>1 (World)</option>
                                            <option>5 (Country)</option>
                                            <option>10 (City)</option>
                                            <option>15 (Street)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">API Key</label>
                                        <input type="text" class="form-control" placeholder="Enter API key">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary">Save Maps</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection






