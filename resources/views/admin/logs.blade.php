@extends('admin.components.adminlayout')
@section('content')
    <div class="container-xl mt-3">
        <div class="admin-header d-flex align-items-center mb-3 border-bottom border-dark">
            <div class="header-title p-2 flex-grow-1">
                <h2>System Logs</h2>
                <p>All of the system's recent activity.</p>
            </div>
            <div class="header-export pe-3">
                <a class="btn btn-primary px-4 py-2" href="#">
                    <i class="bi bi-file-earmark-arrow-down-fill"></i>
                    <span>Export</span>
                </a>
            </div>
        </div>

        <div class="admin-content">
            <div class="table-responsive-lg fs-4">
                <table class="table table table-light table-hover mt-3 align-middle">
                    <thead>
                        <tr>
                            <th style="width: 10%" scope="col">User ID</th>
                            <th style="width: 15%" scope="col">Name</th>
                            <th style="width: 15%" scope="col">Action</th>
                            <th style="width: 50%" scope="col">Description</th>
                            <th style="width: 10%" scope="col">DateTime</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td>{{ $log->user_id }}</td>
                                <td>{{ $log->firstname }}</td>
                                <td>{{ $log->log_title }}</td>
                                <td>{{ $log->log_description }}</td>
                                <td>{{ Carbon\Carbpn::create($log->created_at)->format('M d, Y || h:m a') }}</td>
                            </tr>
                        @empty
                            <div>
                                <h4 style="color: red">NO LOGS FOUND!</h4>
                            </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
