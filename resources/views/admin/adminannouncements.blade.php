@extends('admin.components.layout')
@section('content')
    <div class="container-xl mt-3">
        <div class="admin-header d-flex align-items-center mb-3">
            <div class="header-title p-2 flex-grow-1">
                <h1>Announcements</h1>
                <p>Announce what is a seminar, events or anything on public.</p>
            </div>
            <div class="header-export pe-3">
                <a class="btn btn-primary px-4 py-2 me-2" href="{{ route('generate-user-pdf', request()->query()) }}">
                    <i class="bi bi-file-earmark-arrow-down-fill"></i>
                    <span>Export</span>
                </a>
                <a class="btn btn-primary px-4 py-2 addannouncement-btn" data-bs-toggle="modal"
                    data-bs-target="#announcementAddUpdateModal" href="#">
                    <i class="bi bi-plus-lg"></i>
                    <span>Add</span>
                </a>
            </div>
        </div>
        <div class="admin-content">
            <h3>All announcements({{ $annCount }})</h3>
            <nav class="navbar navbar-expand-lg bg-body-tertiary p-3">
                <div class="container-xl">
                    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        type="button" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item border">
                                <a class="{{ request('category') === null ? 'nav-link active' : 'nav-link' }}"
                                    href="?category=&searchItem=" aria-current="page">View
                                    All</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="{{ request('type') === 'seminars' ? 'nav-link active' : 'nav-link ' }}"
                                    href="?type=seminars&searchAnnouncement=">Seminars</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="{{ request('type') === 'events' ? 'nav-link active' : 'nav-link' }}"
                                    href="?type=events&searchAnnouncement=">Events</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="{{ request('type') === 'other' ? 'nav-link active' : 'nav-link' }}"
                                    href="?type=other&searchAnnouncement=">Other</a>
                            </li>
                        </ul>
                        <form class="d-flex" role="search" method="get">
                            <input class="form-control me-3 fs-4" name="searchItem" type="search" value=""
                                aria-label="Search" placeholder="Search">
                            <button class="btn btn-outline-primary me-2 fs-4" type="submit">Search</button>
                            <a class="btn btn-outline-secondary fs-4" href="?&searchAnnouncement=">Clear</a>
                        </form>
                    </div>
                </div>
            </nav>
            <div class="table-responsive-lg fs-4">
                <table class="table table table-light table-hover mt-3 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 10%" scope="col-4">Type</th>
                            <th style="width: 20%" scope="col-4">Announcement Name</th>
                            <th style="width: 50%" scope="col-4">Description</th>
                            <th style="width: 10%" scope="col-4">Created at</th>
                            <th scope="col-1"style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($announcements as $announcement)
                            <tr>
                                <td>{{ $announcement->announcement_type }}</td>
                                <td>{{ $announcement->announcement_name }}</td>
                                <td>{{ $announcement->announcement_description }}</td>
                                <td>{{ $announcement->created_at }}</td>
                                <td>
                                    <a class="btn btn-primary updateitem-btn" data-bs-toggle="modal"
                                        data-bs-target="#announcementAddUpdateModal" data-id="{{ $announcement->id }}"
                                        data-announcementname="{{ $announcement->announcement_name }}"
                                        data-announcementdescription="{{ $announcement->announcement_description }}"
                                        data-announcementlink="{{ $announcement->announcement_link }}"
                                        data-announcementtype="{{ $announcement->announcement_type }}" href="#">
                                        <i class="bi bi-pencil-square"></i></a>
                                    <a class="btn btn-danger deleteitem-btn" data-bs-toggle="modal"
                                        data-bs-target="#inventoryDeleteModal" data-id="{{ }}"><i
                                            class="bi bi-trash3-fill"></i></a>
                                </td>
                            </tr>
                        @empty
                            <div>
                                <h4 style="color: red">NO ANNOUNCEMENT FOUND!</h4>
                            </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="announcementAddUpdateModal" aria-labelledby="exampleModalLabel" aria-hidden="true"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTitle"></h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <form id="modalForm" action="" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fs-4" for="announcementname">Announcement Name:</label>
                            <input class="form-control fs-3" id="announcementname" name="announcementname"
                                type="text">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-4" for="announcementdescription">Description:</label>
                            <input class="form-control fs-3" id="announcementdescription"
                                name="announcementdescription"></input>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-4" for="formFile">Image Header:</label>
                            <input class="form-control fs-3" id="formFile" type="file">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-4" for="announcementdescription">Link (if you have extra
                                info):</label>
                            <input class="form-control fs-3" id="announcementdescription"
                                name="announcementdescription"></input>
                        </div>
                        <div class="mb-3">
                            <select class="form-select fs-3" id="announcementtype" name="announcementtype">
                                <option value="" hidden>Announcement type</option>
                                <option value="Seminar">Seminar</option>
                                <option value="Event">Event</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary fs-3 btn-save" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
