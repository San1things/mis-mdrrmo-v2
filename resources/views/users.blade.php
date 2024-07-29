@extends('templates.template')
@section('content')
    <div class="container-xl mt-3">
        <div class="users-header d-flex align-items-center mb-3">
            <div class="header-title p-2 flex-grow-1">
                <h1>Users</h1>
                <p>All the person handling the system.</p>
            </div>
            <div class="header-export pe-3">
                <a class="btn btn-primary px-4 py-2 me-2" href="{{ route('generate-user-pdf', request()->query()) }}">
                    <i class="bi bi-file-earmark-arrow-down-fill"></i>
                    <span>Export</span>
                </a>
                <a class="btn btn-primary px-4 py-2" href="#"">
                    <i class="bi bi-person-fill-add"></i>
                    <span>Add</span>
                </a>
            </div>
        </div>
        <div class="container p-4 mt-2 mb-4 jlcard-container">
            <div class="row row-cols-1 row-cols-lg-3 gy-3">
                <div class="col">
                    <div class="card text-bg-light mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $adminCount }}</h5>
                            <p class="card-text">Admins.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-bg-light mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $staffCount }}</h5>
                            <p class="card-text">Staffs.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-bg-light mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $otherCount }}</h5>
                            <p class="card-text">Others.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="users-table">
            <h1>All users({{ $allCount }})</h1>
            <nav class="navbar navbar-expand-lg bg-body-tertiary pb-3">
                <div class="container-xl">
                    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        type="button" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item border">
                                <a class="{{ request('usertype') === null ? 'nav-link active' : 'nav-link' }}"
                                    href="?usertype=&searchUser={{ $qstring['searchUser'] }}" aria-current="page">View
                                    All</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="{{ request('usertype') === 'admin' ? 'nav-link active' : 'nav-link' }}"
                                    href="?usertype=admin&searchUser={{ $qstring['searchUser'] }}">Admins</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="{{ request('usertype') === 'staff' ? 'nav-link active' : 'nav-link' }}"
                                    href="?usertype=staff&searchUser={{ $qstring['searchUser'] }}">Staffs</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="{{ request('usertype') === 'other' ? 'nav-link active' : 'nav-link' }}"
                                    href="?usertype=other&searchUser={{ $qstring['searchUser'] }}">Others</a>
                            </li>
                        </ul>
                        <form class="d-flex" role="search" method="get">
                            <input name="usertype" type="hidden" value="{{ $qstring['usertype'] }}">
                            <input class="form-control me-3 fs-4" name="searchUser" type="search"
                                value="{{ request('searchUser') }}" aria-label="Search" placeholder="Search">
                            <button class="btn btn-outline-success me-2 fs-4" type="submit">Search</button>
                            <a class="btn btn-outline-secondary fs-4" href="?usertype=&searchUser=">Clear</a>
                        </form>
                    </div>
                </div>
            </nav>
            <div class="table-responsive-lg fs-4">
                <table class="table table table-light table-hover mt-5 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col-1">First Name</th>
                            <th scope="col-1">Last Name</th>
                            <th scope="col-1">Email</th>
                            <th scope="col-1">Usertype</th>
                            <th scope="col-1">Username</th>
                            <th scope="col-1">Password</th>
                            <th scope="col-1">Gender</th>
                            <th scope="col-1">Birthday</th>
                            <th scope="col-1">Contact #</th>
                            <th scope="col-1">Team</th>
                            <th scope="col-1">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tbl_users as $user)
                            <tr>
                                <td>{{ $user->firstname }}</td>
                                <td>{{ $user->lastname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->usertype }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->password }}</td>
                                <td>{{ $user->gender }}</td>
                                <td>{{ $user->bday }}</td>
                                <td>{{ $user->contact }}</td>
                                <td>{{ $user->team }}</td>
                                <td>
                                    <a class="btn btn-primary updateuser-btn" data-id="{{ $user->id }}"
                                        data-firstname="{{ $user->firstname }}" data-bs-toggle="modal"
                                        data-bs-target="#userUpdateModal" data-lastname="{{ $user->lastname }}"
                                        data-email="{{ $user->email }}" data-usertype="{{ $user->usertype }}"
                                        data-username="{{ $user->username }}" data-password="{{ $user->password }}"
                                        data-gender="{{ $user->gender }}" data-birthday="{{ $user->bday }}"
                                        data-contact="{{ $user->contact }}" data-team="{{ $user->team }}"
                                        href="#"><i class="bi bi-pencil-square"></i></a>
                                    <a class="btn btn-danger delete-btn"><i class="bi bi-trash3-fill"></i></a>
                                </td>
                            </tr>
                        @empty
                            <div>
                                <h1>NO USER FOUND!</h1>
                            </div>
                        @endforelse
                    </tbody>
                </table>
                {{ $tbl_users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="userUpdateModal" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTitle">Update User</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <form id="modalForm" action="/adduser" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input class="form-control fs-4" id="firstname" name="firstname" type="text">
                            <label for="floatingInput">First Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control fs-4" id="lastname" name="lastname"></input>
                            <label for="floatingInput">Last Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control fs-4" id="email" name="email"></input>
                            <label for="floatingInput">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control fs-4" id="usertype" name="usertype"></input>
                            <label for="floatingInput">Usertype</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control fs-4" id="username" name="username"></input>
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control fs-4" id="password" name="password"></input>
                            <label for="floatingInput">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control fs-4" id="gender" name="gender"></input>
                            <label for="floatingInput">Gender</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control fs-4" id="birthday" name="birthday"></input>
                            <label for="floatingInput">Birthday</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control fs-4" id="contact" name="contact"></input>
                            <label for="floatingInput">Contact</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control fs-4" id="team" name="team"></input>
                            <label for="floatingInput">Team</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary fs-3 btn-save" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="loadingModal" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body d-flex justify-content-center my-5">
                    <div class="dot-spinner">
                        <div class="dot-spinner__dot"></div>
                        <div class="dot-spinner__dot"></div>
                        <div class="dot-spinner__dot"></div>
                        <div class="dot-spinner__dot"></div>
                        <div class="dot-spinner__dot"></div>
                        <div class="dot-spinner__dot"></div>
                        <div class="dot-spinner__dot"></div>
                        <div class="dot-spinner__dot"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.updateuser-btn').on('click', function() {
                let id = $(this).data('id');
                $('#firstname').val($(this).data('firstname'))
                $('#lastname').val($(this).data('lastname'))
                $('#email').val($(this).data('email'))
                $('#usertype').val($(this).data('usertype'))
                $('#username').val($(this).data('username'))
                $('#password').val($(this).data('password'))
                $('#gender').val($(this).data('gender'))
                $('#birthday').val($(this).data('birthday'))
                $('#contact').val($(this).data('contact'))
                $('#team').val($(this).data('team'))
                $('#modalTitle').text('UPDATE')
                $('#modalForm').attr('action', '/updateuser?id=' + id)
            })

            $('.btn-save').on('click', function(e) {
                e.preventDefault();
                $("#userUpdateModal").modal('hide');
                $("#loadingModal").modal('show');
                setTimeout(function() {
                    $("#loadingModal").modal('hide');
                    $('#modalForm').submit();
                }, 1500);
            })
        })
    </script>
@endpush
