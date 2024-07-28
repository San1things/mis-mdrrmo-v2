@extends('templates.template')
@section('content')
    <div class="container-xl mt-4">

        <div class="users-header d-flex align-items-center mb-3">
            <div class="header-title p-2 flex-grow-1">
                <h1>Inventory</h1>
                <p>All the items information is here.</p>
            </div>
            <div class="header-export pe-3">
                <a href="{{ route('generate-pdf', request()->query()) }}">
                    <i class="bi bi-file-earmark-arrow-down-fill"></i>
                    <span>Export</span>
                </a>
            </div>
        </div>

        <div class="users-table">
            <h1>All items</h1>
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
                                <a class="nav-link"
                                    href="?usertype=&searchUser=" aria-current="page">View
                                    All</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="nav-link"
                                    href="?usertype=admin&searchUser=">Admins</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="nav-link"
                                    href="?usertype=staff&searchUser=">Staffs</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="nav-link"
                                    href="?usertype=other&searchUser=">Others</a>
                            </li>
                        </ul>
                        <form class="d-flex" role="search" method="get">
                            <input name="usertype" type="hidden" value="">
                            <input class="form-control me-3 fs-4" name="searchUser" type="search" value=""
                                aria-label="Search" placeholder="Search">
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
                            <th scope="col-1"></th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        @forelse ($tbl_users as $users)
                            <tr>
                                <td>{{ $users->firstname }}</td>
                                <td>{{ $users->lastname }}</td>
                                <td>{{ $users->email }}</td>
                                <td>{{ $users->usertype }}</td>
                                <td>{{ $users->username }}</td>
                                <td>{{ $users->password }}</td>
                                <td>{{ $users->gender }}</td>
                                <td>{{ $users->bday }}</td>
                                <td>{{ $users->contact }}</td>
                                <td>{{ $users->team }}</td>
                                <td>
                                    <a class="btn btn-primary update-btn" href="#">
                                        <i class="bi bi-pencil-square"></i></a>
                                    <a class="btn btn-danger delete-btn"><i class="bi bi-trash3-fill"></i></a>
                                </td>
                            </tr>
                        @empty
                            <div>
                                <h1>NO USER FOUND!</h1>
                            </div>
                        @endforelse
                    </tbody> --}}
                </table>
            </div>
        </div>

    </div>
@endsection
