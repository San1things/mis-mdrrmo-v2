@extends('admin.components.adminlayout')
@section('content')
    <div class="container-xl mt-3">
        <div class="admin-header d-flex align-items-center mb-3 border-bottom border-dark">
            <div class="header-title p-2 flex-grow-1">
                <h1>Announcements</h1>
                <p>Announce what is a seminar, events or anything on public.</p>
            </div>
            <div class="header-export pe-3">
                <a class="btn btn-primary px-4 py-3 addannouncement-btn" data-bs-toggle="modal"
                    data-bs-target="#announcementAddUpdateModal" href="#">
                    <i class="bi bi-megaphone"></i>
                    <span>Announce</span>
                </a>
            </div>
        </div>
        <div class="admin-content">

            @isset($alert)
                <center>
                    <div class="alert alert-dismissible fade show fs-3 alert-{{ !empty($alerts[$alert]) ? $alerts[$alert][1] : '' }}"
                        role="alert">
                        {{ !empty($alerts[$alert]) ? $alerts[$alert][0] : 'error' }}
                        <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
                    </div>
                </center>
            @endisset

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
                                <a class="{{ request('type') === null ? 'nav-link active' : 'nav-link' }}"
                                    href="?type=&searchAnnouncement={{ $qstring['searchAnnouncement'] }}"
                                    aria-current="page">View
                                    All</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="{{ request('type') === 'Seminar' ? 'nav-link active' : 'nav-link ' }}"
                                    href="?type=Seminar&searchAnnouncement={{ $qstring['searchAnnouncement'] }}">Seminars</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="{{ request('type') === 'Event' ? 'nav-link active' : 'nav-link' }}"
                                    href="?type=Event&searchAnnouncement={{ $qstring['searchAnnouncement'] }}">Events</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="{{ request('type') === 'other' ? 'nav-link active' : 'nav-link' }}"
                                    href="?type=other&searchAnnouncement={{ $qstring['searchAnnouncement'] }}">Other</a>
                            </li>
                        </ul>
                        <form class="d-flex" role="search" method="get">
                            <input name="type" type="hidden" value="{{ $qstring['type'] }}">
                            <input class="form-control me-3 fs-4" name="searchAnnouncement" type="search" value=""
                                aria-label="Search" placeholder="Search">
                            <button class="btn btn-outline-primary me-2 fs-4" type="submit">Search</button>
                            <a class="btn btn-outline-secondary fs-4" href="/adminannouncements">Clear</a>
                        </form>
                    </div>
                </div>
            </nav>
            <div class="table-responsive-lg fs-4" style="max-height: 59vh; min-height: 59vh; overflow-y:scroll;">
                <table class="table table table-light table-hover mt-3 align-middle">
                    <thead class="table">
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
                                <td>{{ Carbon\Carbon::create($announcement->created_at)->format('M d, Y h:m a') }}</td>
                                <td>
                                    <a class="btn btn-primary updateannouncement-btn" data-bs-toggle="modal"
                                        data-bs-target="#announcementAddUpdateModal" data-id="{{ $announcement->id }}"
                                        data-announcementname="{{ $announcement->announcement_name }}"
                                        data-announcementdescription="{{ $announcement->announcement_description }}"
                                        data-announcementlink="{{ $announcement->announcement_link }}"
                                        data-announcementtype="{{ $announcement->announcement_type }}" href="#">
                                        <i class="bi bi-pencil-square"></i></a>
                                    <a class="btn btn-danger deleteitem-btn" data-bs-toggle="modal"
                                        data-bs-target="#inventoryDeleteModal" data-id=""><i
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
            {{ $announcements->links('pagination::bootstrap-5') }}
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
                <form id="modalForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fs-4" for="announcementname">Announcement Name:</label>
                            <input class="form-control fs-3" id="announcementname" name="announcementname"
                                type="text" placeholder="Announcement Name*" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-4" for="announcementdescription">Description:</label>
                            <textarea class="form-control fs-3" id="announcementdescription" name="announcementdescription"
                                placeholder="Announcement Description*" required></textarea>
                        </div>
                        <div class="announcement-image-container">
                            <div class="mb-3">
                                <label class="form-label fs-4" for="formFile">Image Header:</label>
                                <input class="form-control fs-3" id="formFile" name="announcementimage" type="file"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-4" for="announcementdescription">Link(leave it blank if
                                none):</label>
                            <input class="form-control fs-3" id="announcementlink" name="announcementlink"
                                placeholder="ex. facebook link for extra information"></input>
                        </div>
                        <div class="mb-3">
                            <select class="form-select fs-3" id="announcementtype" name="announcementtype" required>
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

@push('scripts')
    <script>
        $(document).ready(function() {

            $('.addannouncement-btn').on('click', function() {
                $('#announcementname').val('')
                $('#announcementdescription').val('')
                $('#announcementtype').val('')
                $('#announcementlink').val('')
                $('.announcement-image-container').css("display", "block")
                $('.btn-save').text('Create Announcement')
                $('#modalForm').attr('action', '/adminpostannouncement')
            })

            $('.updateannouncement-btn').on('click', function() {
                let id = $(this).data('id')
                $('#announcementname').val($(this).data('announcementname'))
                $('#announcementdescription').val($(this).data('announcementdescription'))
                $('#announcementtype').val($(this).data('announcementtype'))
                $('#announcementlink').val($(this).data('announcementlink'))
                $('.announcement-image-container').css("display", "none")
                $('.btn-save').text('Update Announcement')
                $('#modalForm').attr('action', '/adminupdateannouncement?id=' + id)
            })
        })
    </script>
@endpush
