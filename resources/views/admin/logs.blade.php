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
            <form role="search" method="get">
                <div class="input-group mb-3">
                    <input class="form-control fs-3" name="searchLogs" type="search" aria-label="Search"
                        aria-describedby="searchbutton" placeholder="Search a name or action...">
                    <button class="btn btn-outline-primary fs-3 px-5" id="searchbutton" type="submit">Search</button>
                    <a class="btn btn-outline-secondary fs-3 px-5" id="clearbutton" type="button"
                        href="/logs?searchLogs=">Clear</a>
                </div>
            </form>

            <div class="table-responsive-lg fs-4" style="min-height: 70vh; max-height: 70vh; overflow-y: scroll;">
                <table class="table table table-light table-hover mt-3 align-middle">
                    <thead style="position: sticky; top: 0;">
                        <tr>
                            <th style="width: 5%" scope="col">User ID</th>
                            <th style="width: 5%" scope="col">Usertype</th>
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
                                <td>{{ $log->usertype }}</td>
                                <td>{{ $log->firstname }} {{ $log->lastname }}</td>
                                <td>{{ $log->log_title }}</td>
                                <td>{{ $log->log_description }}</td>
                                <td>{{ Carbon\Carbon::create($log->log_created_at)->format('D - M d, Y h:i a') }}</td>
                            </tr>
                        @empty
                            <div>
                                <h4 style="color: red">NO LOGS FOUND!</h4>
                            </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $logs->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
