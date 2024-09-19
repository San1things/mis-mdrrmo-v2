@extends('admin.components.adminlayout')
@section('content')
    <div class="container-xl mt-3">
        <div class="admin-header d-flex align-items-center mb-3 border-bottom border-dark">
            <div class="header-title p-2 flex-grow-1">
                <h1>Users</h1>
                <p>All the person handling the system.</p>
            </div>
            <div class="header-export pe-3">
                <a class="btn btn-primary px-4 py-2 me-2 printuser-btn"
                    href="{{ route('generate-user-pdf', request()->query()) }}">
                    <i class="bi bi-file-earmark-arrow-down-fill"></i>
                    <span>Export</span>
                </a>
                <a class="btn btn-primary px-4 py-2 adduser-btn" data-bs-toggle="modal" data-bs-target="#userAddUpdateModal"
                    href="#">
                    <i class="bi bi-person-fill-add"></i>
                    <span>Add</span>
                </a>
            </div>
        </div>
        <div class="container p-4 mt-2 mb-4 jlcard-container">
            <div class="row row-cols-1 row-cols-lg-3 gy-3">
                <div class="col">
                    <div class="card text-bg-light mb-3">
                        <div class="card-body users-card-body">
                            <h1 class="card-title users-card-title">{{ $OrgUserCount }}</h1>
                            <p class="card-text users-card-text">Org Users.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-bg-light mb-3">
                        <div class="card-body users-card-body">
                            <h1 class="card-title users-card-title">{{ $otherCount }}</h1>
                            <p class="card-text users-card-text">Resident Users.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-bg-light mb-3">
                        <div class="card-body users-card-body">
                            <h1 class="card-title users-card-title">{{ $subscriberCount }}</h1>
                            <p class="card-text users-card-text">Subscribers.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="admin-content">
            @isset($alert)
                <center>
                    <div class="alert alert-dismissible fs-2 py-5 fade show alert-{{ !empty($alerts[$alert]) ? $alerts[$alert][1] : '' }}"
                        role="alert">
                        {{ !empty($alerts[$alert]) ? $alerts[$alert][0] : '' }}
                        <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
                    </div>
                </center>
            @endisset


            <h3>All users({{ $allCount }})</h3>
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-xl">
                    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        type="button" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item border">
                                <a class="nav-link" href="?usertype=&searchUser={{ $qstring['searchUser'] }}"
                                    aria-current="page"
                                    style="{{ request('usertype') === null ? 'font-weight: 700' : '' }}">View
                                    All</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="nav-link" href="?usertype=admin&searchUser={{ $qstring['searchUser'] }}"
                                    style="{{ request('usertype') === 'admin' ? 'font-weight: 700' : '' }}">Admins</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="nav-link" href="?usertype=staff&searchUser={{ $qstring['searchUser'] }}"
                                    style="{{ request('usertype') === 'staff' ? 'font-weight: 700' : '' }}">Staffs</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="nav-link" href="?usertype=other&searchUser={{ $qstring['searchUser'] }}"
                                    style="{{ request('usertype') === 'other' ? 'font-weight: 700' : '' }}">Others</a>
                            </li>
                        </ul>
                        <form class="d-flex" role="search" method="get">
                            <input name="usertype" type="hidden" value="{{ $qstring['usertype'] }}">
                            <input class="form-control me-3 fs-4" name="searchUser" type="search"
                                value="{{ request('searchUser') }}" aria-label="Search" placeholder="Search">
                            <button class="btn btn-outline-primary me-2 fs-4" type="submit">Search</button>
                            <a class="btn btn-outline-secondary fs-4" href="/users">Clear</a>
                        </form>
                    </div>
                </div>
            </nav>
            <div class="table-responsive-lg fs-4">
                <table class="table table table-light table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col-1">Email</th>
                            <th scope="col-1">First Name</th>
                            <th scope="col-1">Last Name</th>
                            <th scope="col-1">Usertype</th>
                            <th scope="col-1">Username</th>
                            <th scope="col-1">Status</th>
                            <th scope="col-1">Team</th>
                            <th scope="col-1">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="{{ $user->status == 'inactive' ? 'table-danger' : '' }}">
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->firstname }}</td>
                                <td>{{ $user->lastname }}</td>
                                <td>{{ $user->usertype }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->status }}</td>
                                <td>{{ $user->team }}</td>
                                <td>
                                    <a class="btn btn-primary updateuser-btn" data-id="{{ $user->id }}"
                                        data-firstname="{{ $user->firstname }}" data-bs-toggle="modal"
                                        data-bs-target="#userAddUpdateModal" data-lastname="{{ $user->lastname }}"
                                        data-email="{{ $user->email }}" data-usertype="{{ $user->usertype }}"
                                        data-username="{{ $user->username }}" data-gender="{{ $user->gender }}"
                                        data-address="{{ $user->address }}" data-birthday="{{ $user->bday }}"
                                        data-contact="{{ $user->contact }}" data-team="{{ $user->team }}"
                                        href="#"><i class="bi bi-pencil-square"></i></a>

                                    @if ($user->status == 'active')
                                        <a class="btn btn-danger lockuser-btn" data-id="{{ $user->id }}"
                                            data-bs-toggle="modal" data-bs-target="#userLockUnlockModal">
                                            <i class="bi bi-lock-fill"></i></a>
                                    @elseif ($user->status == 'inactive')
                                        <a class="btn btn-primary unlockuser-btn" data-id="{{ $user->id }}"
                                            data-bs-toggle="modal" data-bs-target="#userLockUnlockModal">
                                            <i class="bi bi-unlock-fill"></i></a>
                                    @endif

                                </td>
                            </tr>
                        @empty
                            <div>
                                <h4 style="color: red">NO USER FOUND!</h4>
                            </div>
                        @endforelse
                    </tbody>
                </table>
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="userAddUpdateModal" aria-labelledby="exampleModalLabel" aria-hidden="true"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-3" id="modalTitle"></h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalForm1" action="" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fs-5" for="floatingInput">Email:</label>
                            <input class="form-control fs-4" id="email" name="email" type="email"
                                placeholder="Email*" required></input>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-5" for="floatingInput">Username:</label>
                            <input class="form-control fs-4" id="username" name="username" type="text"
                                placeholder="Username*" required></input>
                        </div>
                        <div class="addpasswords eye-add-pass">
                            <div class="mb-3">
                                <label class="form-label fs-5" for="floatingInput">Password:</label>
                                <input class="form-control fs-4" id="addpassword1" name="addpassword1" type="password"
                                    placeholder="Password*" required><i class="bi bi-eye-fill"
                                    id="eye-logo1"></i></input>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fs-5" for="floatingInput">Confirm Password:</label>
                                <input class="form-control fs-4" id="addpassword2" name="addpassword2" type="password"
                                    placeholder="Confirm Password*" required><i class="bi bi-eye-fill"
                                    id="eye-logo2"></i></input>
                            </div>
                        </div>
                        <div class="mb-3">
                            <select class="form-select fs-4" id="usertype" name="usertype">
                                <option value="" hidden>Usertype*</option>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                                <option value="resident">Resident</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="my-3 pt-3 border-black border-top">
                            <label class="form-label fs-5" for="floatingInput">Full Name:</label>
                            <div class="input-group">
                                <input class="form-control fs-4" id="firstname" name="firstname" type="text"
                                    placeholder="First Name*" required>
                                <input class="form-control fs-4" id="lastname" name="lastname" placeholder="Last Name*"
                                    required></input>
                            </div>
                        </div>
                        <div class="mb-3">
                            <select class="form-select fs-4" id="gender" name="gender">
                                <option value="" hidden>Gender*</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="LGBTQIA+">LGBTQIA+</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-5" for="floatingInput">Address:</label>
                            <input class="form-control fs-4" id="address" name="address"
                                placeholder="ex. Morong, Rizal*" required></input>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-5" for="floatingInput">Birthday:</label>
                            <input class="form-control fs-4" id="birthday" name="birthday" type="date"></input>

                        </div>
                        <label class="form-label fs-5" for="floatingInput">Contact:</label>
                        <div class="input-group mb-4">
                            <span class="input-group-text fs-3" id="basic-addon1">Phillippines (+63)</span>
                            <input class="form-control fs-3" id="contact" name="contact" type="number"
                                aria-label="Username" aria-describedby="basic-addon1" placeholder="Mobile #*">
                        </div>
                        <div class="mb-3">
                            <select class="form-select fs-4" id="team" name="team">
                                <option value="" hidden>Team*</option>
                                <option value="team a">Team A</option>
                                <option value="team b">Team B</option>
                                <option value="team c">Team C</option>
                                <option value="undefined">No Team/Not an Employee</option>
                            </select>
                        </div>
                        <button class="btn btn-primary fs-3 btn-save px-5 py-2" type="submit">Save
                            changes</button>
                    </form>
                    <form id="modalForm2" action="" method="post">
                        @csrf
                        <div class="updatepasswords eye-update-pass border-top border-black">
                            <div class="mb-3">
                                <label class="form-label fs-3" for="floatingInput">UPDATE PASSWORD:</label>
                                <input class="form-control fs-4" id="updatepassword1" name="updatepassword1"
                                    type="password" placeholder="Password*" required><i class="bi bi-eye-fill"
                                    id="eye-logo3"></i></input>
                            </div>
                            <div class="mb-3">
                                <input class="form-control fs-4" id="updatepassword2" name="updatepassword2"
                                    type="password" placeholder="Confirm Password*" required><i class="bi bi-eye-fill"
                                    id="eye-logo4"></i></input>
                            </div>
                            <button class="btn btn-primary fs-3 btn-save-password px-5 py-2" type="submit">Change
                                Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="userLockUnlockModal" aria-labelledby="exampleModalLabel" aria-hidden="true"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <form id="modalForm" action="" method="post">
                    @csrf
                    <div class="modal-body ms-2">
                        <h6 class="modal-text"></h6>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger fs-3 btn-lock-unlock px-5 py-2" type="submit"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('.adduser-btn').on('click', function() {
                $('#firstname').val('')
                $('#lastname').val('')
                $('#email').val('')
                $('#usertype').val('')
                $('#username').val('')
                $('.addpasswords').css("display", "block")
                $('#addpassword1, #addpassword2').attr('required', true)
                $('.updatepasswords').css("display", "none")
                $('#addpassword1').val('')
                $('#addpassword2').val('')
                $('#gender').val('')
                $('#birthday').val('')
                $('#contact').val('')
                $('#address').val('')
                $('#team').val('')
                $('.btn-save').text('ADD')
                $('#modalTitle').text('ADD USER')
                $('#modalForm1').attr('action', '/adduser')
            })

            $('.updateuser-btn').on('click', function() {
                let id = $(this).data('id');
                $('#firstname').val($(this).data('firstname'))
                $('#lastname').val($(this).data('lastname'))
                $('#email').val($(this).data('email'))
                $('#usertype').val($(this).data('usertype'))
                $('#username').val($(this).data('username'))
                $('.addpasswords').css("display", "none")
                $('#addpassword1, #addpassword2').removeAttr('required')
                $('.updatepasswords').css("display", "block")
                $('#gender').val($(this).data('gender'))
                $('#birthday').val($(this).data('birthday'))
                $('#contact').val($(this).data('contact'))
                $('#address').val($(this).data('address'))
                $('#team').val($(this).data('team'))
                $('.btn-save').text('UPDATE')
                $('#modalTitle').text('UPDATE USER')
                $('#modalForm1').attr('action', '/updateuserdetails?id=' + id)
                $('#modalForm2').attr('action', '/updateuserpassword?id=' + id)
            })

            $('.lockuser-btn').on('click', function() {
                let id = $(this).data('id');
                $('.btn-lock-unlock').text('LOCK');
                $('.modal-text').text('Are you sure you want to lock this user?');
                $('#modalForm').attr('action', '/lockuser?id=' + id)
            })

            $('.unlockuser-btn').on('click', function() {
                let id = $(this).data('id');
                $('.btn-lock-unlock').text('UNLOCK')
                $('.btn-lock-unlock').attr('class', 'btn btn-primary fs-3 btn-lock-unlock px-5 py-2')
                $('.modal-text').text('Are you sure you want to unlock this user?');
                $('#modalForm').attr('action', '/unlockuser?id=' + id)
            })

            $('#eye-logo1').on('click', function() {
                if ($('#addpassword1').attr('type') == 'password') {
                    $('#addpassword1').attr('type', 'text')
                    $('#eye-logo1').removeClass('bi bi-eye-fill')
                    $('#eye-logo1').addClass('bi bi-eye-slash-fill')
                } else if ($('#addpassword1').attr('type') == 'text') {
                    $('#addpassword1').attr('type', 'password')
                    $('#eye-logo1').removeClass('bi bi-eye-slash-fill')
                    $('#eye-logo1').addClass('bi bi-eye-fill')
                }
            })
            $('#eye-logo2').on('click', function() {
                if ($('#addpassword2').attr('type') == 'password') {
                    $('#addpassword2').attr('type', 'text')
                    $('#eye-logo2').removeClass('bi bi-eye-fill')
                    $('#eye-logo2').addClass('bi bi-eye-slash-fill')
                } else if ($('#addpassword2').attr('type') == 'text') {
                    $('#addpassword2').attr('type', 'password')
                    $('#eye-logo2').removeClass('bi bi-eye-slash-fill')
                    $('#eye-logo2').addClass('bi bi-eye-fill')
                }
            })
            $('#eye-logo3').on('click', function() {
                if ($('#updatepassword1').attr('type') == 'password') {
                    $('#updatepassword1').attr('type', 'text')
                    $('#eye-logo3').removeClass('bi bi-eye-fill')
                    $('#eye-logo3').addClass('bi bi-eye-slash-fill')
                } else if ($('#updatepassword1').attr('type') == 'text') {
                    $('#updatepassword1').attr('type', 'password')
                    $('#eye-logo3').removeClass('bi bi-eye-slash-fill')
                    $('#eye-logo3').addClass('bi bi-eye-fill')
                }
            })
            $('#eye-logo4').on('click', function() {
                if ($('#updatepassword2').attr('type') == 'password') {
                    $('#updatepassword2').attr('type', 'text')
                    $('#eye-logo4').removeClass('bi bi-eye-fill')
                    $('#eye-logo4').addClass('bi bi-eye-slash-fill')
                } else if ($('#updatepassword2').attr('type') == 'text') {
                    $('#updatepassword2').attr('type', 'password')
                    $('#eye-logo4').removeClass('bi bi-eye-slash-fill')
                    $('#eye-logo4').addClass('bi bi-eye-fill')
                }
            })
        })
    </script>
@endpush
