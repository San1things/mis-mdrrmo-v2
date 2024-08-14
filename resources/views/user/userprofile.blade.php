@extends('user.components.userlayout')
@section('resident_content')
    <div class="container-xl">
        <section class="profile-content">
            <center>
                <div class="profile-title">
                    <h2>Hello! {{ $userinfo[1] }} {{ $userinfo[2] }}.</h2>
                </div>
                <img src="{{ asset('images/publicpics/hello-userprof.png') }}" alt="headerpic" height="200px">
            </center>
            <div class="profile-edit border-black border-top py-3 mt-5">
                <div class="san1-editprof-container">
                    <button class="btn btn-dark fs-4 btn-save px-5 py-3 editprof-btn">Edit profile</button>
                </div>
                <div class="mb-3">
                    <label class="form-label fs-5" for="floatingInput">Email:</label>
                    <input class="form-control fs-3" id="email" name="email" type="email"
                        value="{{ $userinfo[3] }}" placeholder="Email*" disabled="disabled" required></input>
                </div>
                <div class="mb-3">
                    <label class="form-label fs-5" for="floatingInput">Username:</label>
                    <input class="form-control fs-3" id="username" name="username" type="text"
                        value="{{ $userinfo[5] }}" placeholder="Username*" disabled="disabled" required></input>
                </div>
                <div class="my-3 pt-3">
                    <label class="form-label fs-5" for="floatingInput">Full Name:</label>
                    <div class="input-group">
                        <input class="form-control fs-3" id="firstname" name="firstname" type="text"
                            value="{{ $userinfo[1] }}" placeholder="First Name*" disabled="disabled" required>
                        <input class="form-control fs-3" id="lastname" name="lastname" type="text"
                            value="{{ $userinfo[2] }}" placeholder="Last Name*" disabled="disabled" required></input>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fs-5" for="floatingInput">Gender:</label>
                    <select class="form-select fs-3" id="gender" name="gender" disabled="disabled">
                        <option value="{{ $userinfo[6] }}" hidden>{{ $userinfo[6] }}</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="LGBTQIA+">LGBTQIA+</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fs-5" for="floatingInput">Address:</label>
                    <input class="form-control fs-3" id="address" name="address" value="{{ $userinfo[7] }}"
                        placeholder="ex. Morong, Rizal*" disabled="disabled" required></input>
                </div>
                <div class="mb-3">
                    <label class="form-label fs-5" for="floatingInput">Birthday:</label>
                    <input class="form-control fs-3" id="birthday" name="birthday" type="date"
                        value="{{ $userinfo[8] }}" disabled="disabled"></input>

                </div>
                <div class="mb-3">
                    <label class="form-label fs-5" for="floatingInput">Contact:</label>
                    <div class="input-group">
                        <span class="input-group-text fs-3">Philippines(+63)</span>
                        <input class="form-control fs-3" id="contact" name="contact" value="{{ $userinfo[9] }}"
                            placeholder="Mobile Number*" pattern="/^-?\d+\.?\d*$/"
                            onKeyPress="if(this.value.length==10) return false;" maxlength="10" disabled="disabled"
                            required></input>
                    </div>
                </div>
                <button class="btn btn-dark fs-4 btn-save px-5 py-3 saveprof-btn" type="submit" style="display: none">Save
                    changes</button>

                <form action="" method="POST"></form>
                @csrf
                <div class="userprofilepasswords border-black border-top py-3 mt-5 eye-add-pass" style="display: none">
                    <h3>Change password:</h3>
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
                    <button class="btn btn-dark fs-4 btn-save px-5 py-3" type="submit">Change Password</button>
                </div>
            </div>
        </section>
    </div>

    @push('userscripts')
        <script>
            $(document).ready(function() {
                let disabled = "true";
                $('.editprof-btn').on('click', function() {
                    if (disabled === "true") {
                        $('.editprof-btn').text('Cancel')
                        $('#email').removeAttr('disabled')
                        $('#username').removeAttr('disabled')
                        $('#firstname').removeAttr('disabled')
                        $('#lastname').removeAttr('disabled')
                        $('#gender').removeAttr('disabled')
                        $('#address').removeAttr('disabled')
                        $('#birthday').removeAttr('disabled')
                        $('#contact').removeAttr('disabled')
                        $('.saveprof-btn').attr('style', 'display: block')
                        $('.userprofilepasswords').attr('style', 'display: block')
                        disabled = "false";
                    } else {
                        $('.editprof-btn').text('Edit profile')
                        $('#email').attr('disabled', 'disabled')
                        $('#username').attr('disabled', 'disabled')
                        $('#firstname').attr('disabled', 'disabled')
                        $('#lastname').attr('disabled', 'disabled')
                        $('#gender').attr('disabled', 'disabled')
                        $('#address').attr('disabled', 'disabled')
                        $('#birthday').attr('disabled', 'disabled')
                        $('#contact').attr('disabled', 'disabled')
                        $('.saveprof-btn').attr('style', 'display: none')
                        $('.userprofilepasswords').attr('style', 'display: none')
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
