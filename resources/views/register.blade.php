<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Management Information System</title>
    <link type="image/x-icon" href="{{ asset('mddrmo_favicon.ico') }}" rel="icon">
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poetsen+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet"
        integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>

<body>

    <div class="container-xl register-content">
        <div class="register-container">
            <center>
                <div class="register-image">

                    <img src="{{ asset('images/publicpics/logo.png') }}" alt="">
                    <h4>| REGISTER</h4>

                </div>
                <a href="/"><i class="bi bi-arrow-bar-left"></i>HOMEPAGE</a>
                <div class="register-inputs">

                    @isset($alert)
                        <div class="alert fs-5 alert-{{ empty(!$alerts[$alert]) ? $alerts[$alert][1] : '' }}"
                            role="alert">
                            <strong>{{ empty(!$alerts[$alert]) ? $alerts[$alert][2] : 'error' }}</strong>
                            {{ empty(!$alerts[$alert]) ? $alerts[$alert][0] : '' }}
                        </div>
                    @endisset

                    <form action="/registerprocess" method="POST">
                        @csrf
                        <input class="form-control mb-4 fs-3" id="Email" name="email" type="email"
                            placeholder="Email*">
                        <input class="form-control mb-4 fs-3" id="Username" name="username" type="text"
                            placeholder="Username*">
                        <div class="eye-show1">
                            <input class="form-control mb-4 fs-3 eye-password1" id="Password" name="password"
                                type="password" placeholder="Password*">
                            <i class="bi bi-eye-fill" id="eye-logo1"></i>
                        </div>
                        <div class="eye-show2">
                            <input class="form-control mb-4 fs-3 eye-password2" id="ConfirmPassword"
                                name="confirmpassword" type="password" placeholder="Confirm Password*">
                            <i class="bi bi-eye-fill" id="eye-logo2"></i>
                        </div>
                        <div class="input-group mb-3">
                            <input class="form-control fs-3" id="Fullname" name="firstname" type="text"
                                placeholder="First Name*">
                            <input class="form-control fs-3" name="lastname" type="text" placeholder="Last Name*">
                        </div>
                        <label class="fs-5 jl-label" for="Birthday">Birthday:</label>
                        <input class="form-control mb-4 fs-3" id="Birthday" name="bday" type="date">
                        <select class="form-select fs-3 mb-4" id="Gender" name="gender">
                            <option value="" selected hidden>Gender*</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="LGBTQIA+">LGBTQIA+</option>
                        </select>
                        <input class="form-control mb-4 fs-3" id="Address" name="address" type="text"
                            placeholder="ex. Morong, Rizal">
                        <div class="input-group mb-4">
                            <span class="input-group-text fs-3" id="basic-addon1">Phillippines (+63)</span>
                            <input class="form-control fs-3" type="number" name="contact" aria-label="Username"
                                aria-describedby="basic-addon1" placeholder="Contact #*">
                        </div>
                        <button class="btn btn-primary" type="submit">Register</button>
                    </form>
                </div>
                <p>Already have an account? <a href="/login">Login</a> here.</p>
            </center>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#eye-logo1').on('click', function() {
                if ($('.eye-password1').attr('type') == 'password') {
                    $('.eye-password1').attr('type', 'text')
                    $('#eye-logo1').removeClass('bi bi-eye-fill')
                    $('#eye-logo1').addClass('bi bi-eye-slash-fill')
                } else if ($('.eye-password1').attr('type') == 'text') {
                    $('.eye-password1').attr('type', 'password')
                    $('#eye-logo1').removeClass('bi bi-eye-slash-fill')
                    $('#eye-logo1').addClass('bi bi-eye-fill')
                }
            })

            $('#eye-logo2').on('click', function() {
                if ($('.eye-password2').attr('type') == 'password') {
                    $('.eye-password2').attr('type', 'text')
                    $('#eye-logo2').removeClass('bi bi-eye-fill')
                    $('#eye-logo2').addClass('bi bi-eye-slash-fill')
                } else if ($('.eye-password2').attr('type') == 'text') {
                    $('.eye-password2').attr('type', 'password')
                    $('#eye-logo2').removeClass('bi bi-eye-slash-fill')
                    $('#eye-logo2').addClass('bi bi-eye-fill')
                }
            })
        })
    </script>
</body>

</html>
