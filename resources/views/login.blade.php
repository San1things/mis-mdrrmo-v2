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

    <center>
        <div class="container-xl login-content">
            <div class="login-container">
                <div class="login-image">
                    <img src="{{ asset('images/publicpics/logo.png') }}" alt="">
                </div>
                <a href="/"><i class="bi bi-arrow-bar-left"></i>HOMEPAGE</a>
                <h4>| LOG-IN</h4>
                <div class="login-inputs">
                    <div class="alert alert-danger" role="alert">
                        A simple danger alert—check it out!A simple danger alert—check it out!A simple danger
                        alert—check it out!
                    </div>
                    <form action="#" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input class="form-control" id="floatingInput" type="email" required
                                placeholder="name@example.com">
                            <label for="floatingInput">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control eye-password" id="floatingPassword" type="password" placeholder="Password"
                                required><i class="bi bi-eye-fill" id="eye-logo"></i>
                            <label for="floatingPassword">Password</label>
                        </div>
                        <button class="btn btn-primary" type="submit">Log in</button>
                    </form>
                </div>
                <p>Don't have an account? <a href="/register">Register</a> here.</p>
            </div>
        </div>
    </center>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#eye-logo').on('click', function(){
                if($('.eye-password').attr('type') == 'password'){
                    $('.eye-password').attr('type', 'text')
                    $('#eye-logo').removeClass('bi bi-eye-fill')
                    $('#eye-logo').addClass('bi bi-eye-slash-fill')
                }else if($('.eye-password').attr('type') == 'text'){
                    $('.eye-password').attr('type', 'password')
                    $('#eye-logo').removeClass('bi bi-eye-slash-fill')
                    $('#eye-logo').addClass('bi bi-eye-fill')
                }
            })
        })
    </script>
</body>

</html>
