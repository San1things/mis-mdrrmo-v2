@extends('admin.components.adminlayout')
@section('content')
    <div class="container-xl mt-3">
        <div class="admin-header d-flex align-items-center border-bottom border-dark">
            <div class="header-title p-2 flex-grow-1">
                <h1>Messages</h1>
                <p>Inbox. ({{ $messageCount }})</p>
            </div>
            <div class="header-export pe-3">
                <a class="btn btn-primary px-4 py-2 me-2" href="#">
                    <i class="bi bi-file-earmark-arrow-down-fill"></i>
                    <span>Export</span>
                </a>
            </div>
        </div>

        <div class="admin-content">
            <nav class="navbar navbar-expand-lg bg-body-light p-3">
                <div class="container-xl">
                    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        type="button" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item border">
                                <a class="nav-link" href="?sender=&searchMessage={{ $qstring['searchMessage'] }}"
                                    aria-current="page"
                                    style="{{ request('sender') === null ? 'font-weight: 700;' : '' }}">View
                                    All</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="nav-link" href="?sender=user&searchMessage={{ $qstring['searchMessage'] }}"
                                    style="{{ request('sender') === 'user' ? 'font-weight: 700;' : '' }}">User Messages</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="nav-link" href="?sender=unknown&searchMessage={{ $qstring['searchMessage'] }}"
                                    style="{{ request('sender') === 'unknown' ? 'font-weight: 700;' : '' }}">Unknown
                                    Messages</a>
                            </li>
                        </ul>
                        <form class="d-flex" role="search" method="get">
                            <input name="category" type="hidden" value="{{ $qstring['sender'] }}">
                            <input class="form-control me-3 fs-4" name="searchMessage" type="search" value=""
                                aria-label="Search" placeholder="Search">
                            <button class="btn btn-outline-primary me-2 fs-4" type="submit">Search</button>
                            <a class="btn btn-outline-secondary fs-4" href="?category=&searchMessage=">Clear</a>
                        </form>
                    </div>
                </div>
            </nav>
        </div>

    </div>
@endsection
