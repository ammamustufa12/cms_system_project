@extends('twill::layouts.main')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Activity Logs</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Activity Logs</li>
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
                        <h4 class="card-title mb-0">Recent Activity</h4>
                    </div>

                    <div class="card-body">
                        <div class="listjs-table" id="activityLogList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm">
                                    <div class="d-flex justify-content-sm-end">
                                        <div class="search-box ms-2">
                                            <input type="text" class="form-control search" placeholder="Search by action...">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive table-card mt-3 mb-1">
                                <table class="table align-middle table-nowrap" id="activityLogsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>User</th>
                                            <th>Action</th>
                                            <th>Model</th>
                                            <th>Description</th>
                                            <th>Changes</th>
                                            <th>IP</th>
                                            <th>User Agent</th>
                                            <th>Logged At</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($logs as $log)
                                            <tr>
                                                <td>{{ $log->id }}</td>
                                                <td>{{ $log->user->name ?? 'System' }}</td>
                                                <td><span class="badge bg-info text-dark">{{ $log->action }}</span></td>
                                                <td>{{ class_basename($log->model_type) }} (ID: {{ $log->model_id }})</td>
                                                <td>{{ $log->description ?? '-' }}</td>
                                                <td style="max-width: 300px;">
                                                    @if ($log->changes)
                                                        <pre class="mb-0 small">{{ json_encode($log->changes, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>{{ $log->ip_address }}</td>
                                                <td class="text-truncate" style="max-width: 200px;" title="{{ $log->user_agent }}">
                                                    {{ \Illuminate\Support\Str::limit($log->user_agent, 50) }}
                                                </td>
                                                <td>{{ $log->created_at->format('d M, Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                @if ($logs->isEmpty())
                                    <div class="noresult">
                                        <div class="text-center">
                                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                colors="primary:#121331,secondary:#08a88a"
                                                style="width:75px;height:75px"></lord-icon>
                                            <h5 class="mt-2">No Logs Found</h5>
                                            <p class="text-muted mb-0">No recent activity recorded.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-end">
                                {{ $logs->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div> <!-- end card -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />

<!-- Bootstrap Datepicker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/css/bootstrap-datepicker.min.css" />
@endpush

@push('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap Datepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/js/bootstrap-datepicker.min.js"></script>

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

<script>
    $(document).ready(function() {
        $('#date-field').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    });
</script>

{{-- <script src="{{ twillAsset('main-dashboard.js') }}" crossorigin></script> --}}
@endpush
{{-- 


@push('extra_js')
    <script src="{{ twillAsset('main-dashboard.js') }}" crossorigin></script>
@endpush --}}
