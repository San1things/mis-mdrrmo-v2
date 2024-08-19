@extends('admin.components.adminlayout')
@section('content')
    <div class="container-xl mt-3">

        <div class="admin-header d-flex align-items-center mb-2 border-bottom border-dark">
            <div class="header-title p-2 flex-grow-1">
                <h2>{{ $adminprofile->firstname }} {{ $adminprofile->lastname }}</h2>
                <p>MDRRMO Morong: {{ $adminprofile->usertype }}</p>
            </div>
            <div class="header-export pe-3">
                <button class="btn btn-primary px-4 py-3 fs-2 editadminprof-btn" type="button">
                    <span>Edit Profile</span>
                </button>

            </div>
        </div>

        <div class="admin-content" style="max-height: 80vh; overflow-y:scroll;">
            @isset($alert)
                <center>
                    <div class="alert alert-dismissible fs-2 py-5 fade show alert-{{ !empty($alerts[$alert]) ? $alerts[$alert][1] : '' }}"
                        role="alert">
                        {{ !empty($alerts[$alert]) ? $alerts[$alert][0] : '' }}
                        <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
                    </div>
                </center>
            @endisset

            <div class="disable-true">
                <div class="mb-3">
                    <label class="form-label fs-5" for="floatingInput">Email:</label>
                    <input class="form-control fs-3" type="email" value="{{ $adminprofile->email }}" placeholder="Email*"
                        disabled="disabled" required></input>
                </div>
                <div class="mb-3">
                    <label class="form-label fs-5" for="floatingInput">Username:</label>
                    <input class="form-control fs-3" type="text" value="{{ $adminprofile->username }}"
                        placeholder="Username*" disabled="disabled" required></input>
                </div>
                @if ($adminprofile->usertype == 'admin')
                    <div class="mb-3">
                        <label class="form-label fs-5" for="floatingInput">Usertype:</label>
                        <select class="form-select fs-3" disabled="disabled">
                            <option value="{{ $adminprofile->usertype }}" hidden>{{ $adminprofile->usertype }}</option>
                            <option value="admin">admin</option>
                            <option value="staff">staff</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-5" for="floatingInput">Usertype:</label>
                        <select class="form-select fs-3" disabled="disabled">
                            <option value="{{ $adminprofile->team }}" hidden>{{ $adminprofile->team }}</option>
                            <option value="Team A">Team A</option>
                            <option value="Team B">Team B</option>
                            <option value="Team C">Team C</option>
                            <option value="undefined">undefined</option>
                        </select>
                    </div>
                @endif
                <div class="my-3 pt-3">
                    <label class="form-label fs-5" for="floatingInput">Full Name:</label>
                    <div class="input-group">
                        <input class="form-control fs-3" type="text" value="{{ $adminprofile->firstname }}"
                            placeholder="First Name*" disabled="disabled" required>
                        <input class="form-control fs-3" type="text" value="{{ $adminprofile->lastname }}"
                            placeholder="Last Name*" disabled="disabled" required></input>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fs-5" for="floatingInput">Gender:</label>
                    <select class="form-select fs-3" disabled="disabled">
                        <option value="{{ $adminprofile->gender }}" hidden>{{ $adminprofile->gender }}</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="LGBTQIA+">LGBTQIA+</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fs-5" for="floatingInput">Address:</label>
                    <input class="form-control fs-3" value="{{ $adminprofile->address }}" placeholder="ex. Morong, Rizal*"
                        disabled="disabled" required></input>
                </div>
                <div class="mb-3">
                    <label class="form-label fs-5" for="floatingInput">Birthday:</label>
                    <input class="form-control fs-3" type="date" value="{{ $adminprofile->bday }}" disabled="disabled"
                        required></input>

                </div>
                <div class="mb-3">
                    <label class="form-label fs-5" for="floatingInput">Contact:</label>
                    <div class="input-group">
                        <span class="input-group-text fs-3">Philippines(+63)</span>
                        <input class="form-control fs-3" type="number" value="{{ $adminprofile->contact }}"
                            placeholder="Mobile Number*" pattern="^\d{10}$"
                            onKeyPress="if(this.value.length==10) return false;" maxlength="10" min="0"
                            disabled="disabled" required></input>
                    </div>
                </div>
            </div>
            <div class="disable-false" style="display: none">
                <form action="/adminupdateprofile" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fs-5" for="floatingInput">Email:</label>
                        <input class="form-control fs-3" id="email" name="email" type="email"
                            value="{{ $adminprofile->email }}" placeholder="Email*" required></input>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-5" for="floatingInput">Username:</label>
                        <input class="form-control fs-3" id="username" name="username" type="text"
                            value="{{ $adminprofile->username }}" placeholder="Username*" required></input>
                    </div>
                    @if ($adminprofile->usertype == 'admin')
                        <div class="mb-3">
                            <label class="form-label fs-5" for="floatingInput">Usertype:</label>
                            <select class="form-select fs-3" id="usertype" name="usertype">
                                <option value="{{ $adminprofile->usertype }}" hidden>{{ $adminprofile->usertype }}
                                </option>
                                <option value="admin">admin</option>
                                <option value="staff">staff</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-5" for="floatingInput">Usertype:</label>
                            <select class="form-select fs-3" id="team" name="team">
                                <option value="{{ $adminprofile->team }}" hidden>{{ $adminprofile->team }}</option>
                                <option value="Team A">Team A</option>
                                <option value="Team B">Team B</option>
                                <option value="Team C">Team C</option>
                                <option value="undefined">undefined</option>
                            </select>
                        </div>
                    @endif
                    <div class="my-3 pt-3">
                        <label class="form-label fs-5" for="floatingInput">Full Name:</label>
                        <div class="input-group">
                            <input class="form-control fs-3" id="firstname" name="firstname" type="text"
                                value="{{ $adminprofile->firstname }}" placeholder="First Name*" required>
                            <input class="form-control fs-3" id="lastname" name="lastname" type="text"
                                value="{{ $adminprofile->lastname }}" placeholder="Last Name*" required></input>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-5" for="floatingInput">Gender:</label>
                        <select class="form-select fs-3" id="gender" name="gender">
                            <option value="{{ $adminprofile->gender }}" hidden>{{ $adminprofile->gender }}</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="LGBTQIA+">LGBTQIA+</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-5" for="floatingInput">Address:</label>
                        <input class="form-control fs-3" id="address" name="address"
                            value="{{ $adminprofile->address }}" placeholder="ex. Morong, Rizal*" required></input>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-5" for="floatingInput">Birthday:</label>
                        <input class="form-control fs-3" id="birthday" name="birthday" type="date"
                            value="{{ $adminprofile->bday }}" required></input>

                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-5" for="floatingInput">Contact:</label>
                        <div class="input-group">
                            <span class="input-group-text fs-3">Philippines(+63)</span>
                            <input class="form-control fs-3" id="contact" name="contact" type="number"
                                value="{{ $adminprofile->contact }}" placeholder="Mobile Number*" pattern="^\d{10}$"
                                onKeyPress="if(this.value.length==10) return false;" maxlength="10" min="0"
                                required></input>
                        </div>
                    </div>
                    <button class="btn btn-primary fs-4 btn-save px-5 py-3 saveadminprof-btn" type="submit"
                        style="display: none">
                        Save changes
                    </button>
                </form>
            </div>
            <div class="adminprofilepasswords border-black border-top py-3 mt-3 eye-add-pass" style="display: none">
                <form action="/adminupdatepassword" method="POST">
                    @csrf
                    <h5>Change password:</h5>
                    <div class="mb-3">
                        <label class="form-label fs-5" for="floatingInput">Password:</label>
                        <input class="form-control fs-3" id="profilepassword1" name="profilepassword1" type="password"
                            placeholder="Password*" required><i class="bi bi-eye-fill" id="eye-logo1"></i></input>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-5" for="floatingInput">Confirm Password:</label>
                        <input class="form-control fs-3" id="profilepassword2" name="profilepassword2" type="password"
                            placeholder="Confirm Password*" required><i class="bi bi-eye-fill"
                            id="eye-logo2"></i></input>
                    </div>
                    <button class="btn btn-primary fs-4 btn-save px-5 py-3" type="submit">Change Password</button>

                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                let disabled = "true";
                $('.editadminprof-btn').on('click', function() {
                    if (disabled === "true") {
                        $('.editadminprof-btn').text('Cancel')
                        $('.disable-true').attr('style', 'display: none')
                        $('.disable-false').attr('style', 'display: block')
                        $('.saveadminprof-btn').attr('style', 'display: block')
                        $('.adminprofilepasswords').attr('style', 'display: block')
                        disabled = "false";
                    } else {
                        $('.editadminprof-btn').text('Edit Profile')
                        $('.disable-true').attr('style', 'display: block')
                        $('.disable-false').attr('style', 'display: none')
                        $('.saveadminprof-btn').attr('style', 'display: none')
                        $('.adminprofilepasswords').attr('style', 'display: none')
                        disabled = "true";
                    }
                })

                $('#eye-logo1').on('click', function() {
                    if ($('#profilepassword1').attr('type') == 'password') {
                        $('#profilepassword1').attr('type', 'text')
                        $('#eye-logo1').removeClass('bi bi-eye-fill')
                        $('#eye-logo1').addClass('bi bi-eye-slash-fill')
                    } else if ($('#profilepassword1').attr('type') == 'text') {
                        $('#profilepassword1').attr('type', 'password')
                        $('#eye-logo1').removeClass('bi bi-eye-slash-fill')
                        $('#eye-logo1').addClass('bi bi-eye-fill')
                    }
                })
                $('#eye-logo2').on('click', function() {
                    if ($('#profilepassword2').attr('type') == 'password') {
                        $('#profilepassword2').attr('type', 'text')
                        $('#eye-logo2').removeClass('bi bi-eye-fill')
                        $('#eye-logo2').addClass('bi bi-eye-slash-fill')
                    } else if ($('#profilepassword2').attr('type') == 'text') {
                        $('#profilepassword2').attr('type', 'password')
                        $('#eye-logo2').removeClass('bi bi-eye-slash-fill')
                        $('#eye-logo2').addClass('bi bi-eye-fill')
                    }
                })
            })
        </script>
    @endpush
@endsection
