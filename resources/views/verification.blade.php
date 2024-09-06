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

    <div class="container-xl verification-content">
        <div class="verification-container">
            <center>
                <div class="verification-image">

                    <img src="{{ asset('images/publicpics/logo.png') }}" alt="">
                    <h4>| OTP VERIFICATION</h4>

                </div>
                <a href="/"><i class="bi bi-arrow-bar-left"></i>HOMEPAGE</a>
                <div class="verification-inputs">

                    @isset($alert)
                        <div class="alert fs-5 alert-{{ empty(!$alerts[$alert]) ? $alerts[$alert][1] : '' }}"
                            role="alert">
                            <strong>{{ empty(!$alerts[$alert]) ? $alerts[$alert][2] : 'error' }}</strong>
                            {{ empty(!$alerts[$alert]) ? $alerts[$alert][0] : '' }}
                        </div>
                    @endisset

                    <form action="/verificationprocess" method="POST">
                        @csrf
                        <input class="form-control mb-4 fs-3" id="otp" name="otp" type="text"
                            placeholder="OTP Code*" required>
                        <input class="form-control mb-4 fs-3" id="otp_token" name="otp_token" type="text"
                            value="{{ $otptoken }}" hidden>
                        <button class="btn btn-primary" type="submit">Confirm</button>
                    </form>
                </div>
                <div class="request-otp-container">
                    <p>Didn't receive a code? <a id="request-link" href="#">Request</a></p>
                </div>
            </center>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            let countDown = 60;
            let otptoken = $('#otp_token').val();
            var timer;

            console.log('#otp_token');

            function startCountdown() {
                $('#request-link').text('Request sent(' + countDown + ')');
                $('#request-link').addClass('disable-link');
                $('#request-link').off('click');

                timer = setInterval(() => {
                    countDown--;
                    $('#request-link').text('Request sent(' + countDown + ')');

                    if (countDown === 0) {
                        countDown = 60;
                        clearInterval(timer);
                        $('#request-link').removeClass('disable-link');
                        $('#request-link').text('Request');
                        $('#request-link').on('click', handleRequest);
                    }
                }, 1000);
            }

            function handleRequest(event) {
                event.preventDefault();
                startCountdown();

                $.ajax({
                    url: '/requestotp?otp_token=' + otptoken,
                    type: 'GET',
                    success: function(response) {
                        $('#ajaxResult').html(response);
                    },
                    error: function(xhr, status, error) {
                        $('#ajaxResult').html('An error occurred while processing your request.');
                    }
                });
            }

            $('#request-link').on('click', handleRequest);
        })
    </script>
</body>

</html>
