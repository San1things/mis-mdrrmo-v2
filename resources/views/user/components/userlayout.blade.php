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
    <link href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" rel="stylesheet" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/userstyle.css') }}" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg ps-2">
        <div class="container-xl d-flex">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/publicpics/logo.png') }}" alt="logo" style="border-radius:100%;"
                    height="80">
            </a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav" type="button"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @php
                    $path = request()->path();
                @endphp
                <ul class="navbar-nav p-2 flex-grow-1 align-items-center">
                    <li class="nav-item p-3 {{ $path == 'userhome' ? 'border-end border-start' : '' }}">
                        <a class="nav-link" href="/userhome" aria-current="page"
                            style="{{ $path == 'userhome' ? 'font-weight: bolder;' : '' }}">Home</a>
                    </li>
                    <li class="nav-item p-3 {{ $path == 'userabout' ? 'border-end border-start' : '' }}">
                        <a class="nav-link" href="/userabout"
                            style="{{ $path == 'userabout' ? 'font-weight: bolder;' : '' }}">About</a>
                    </li>

                    <li class="nav-item p-3 {{ $path == 'userservices' ? 'border-end border-start' : '' }}">
                        <a class="nav-link" href="/userservices"
                            style="{{ $path == 'userservices' ? 'font-weight: bolder;' : '' }}">Services</a>
                    </li>
                    <li class="nav-item p-3 {{ $path == 'userfaqs' ? 'border-end border-start' : '' }}">
                        <a class="nav-link" href="/userfaqs"
                            style="{{ $path == 'userfaqs' ? 'font-weight: bolder;' : '' }}">FAQs</a>
                    </li>
                    <li class="nav-item p-3 {{ $path == 'userannouncements' ? 'border-end border-start' : '' }}">
                        <a class="nav-link" href="/userannouncements"
                            style="{{ $path == 'userannouncements' ? 'font-weight: bolder;' : '' }}">Announcements</a>
                    </li>
                    <li class="nav-item p-3 {{ $path == 'userreport' ? 'border-end border-start' : '' }}">
                        <a class="nav-link" href="/userreport"
                            style="{{ $path == 'userreport' ? 'font-weight: bolder;' : '' }}">Report</a>
                    </li>
                    <li class="nav-item p-3 {{ $path == 'userseminars' ? 'border-end border-start' : '' }}">
                        <a class="nav-link" href="/userseminars"
                            style="{{ $path == 'userseminars' ? 'font-weight: bolder;' : '' }}">Seminars</a>
                    </li>
                </ul>

                <div class="p-2">
                    <div class="dropdown">
                        @php
                            $userinfo = request()->attributes->get('userinfo');
                            $user = DB::table('tbl_users')
                                ->where('id', $userinfo[0])
                                ->first();

                            $usernotifCount = DB::table('tbl_notif')
                                ->where('user_id', $userinfo[0])
                                ->where('seen', 0)
                                ->count();
                        @endphp
                        <button class="btn btn-lite dropdown-toggle fs-2 san1-dropdown position-relative"
                            data-bs-toggle="dropdown" type="button" aria-expanded="false">
                            {{ $user->username }}
                            @if ($usernotifCount >= 1)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger fs-4">
                                    {{ $usernotifCount }}
                                </span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-lite">
                            <li><a class="dropdown-item py-3 px-5" href="/userprofile">User Profile</a></li>
                            <li>
                                <a class="dropdown-item py-3 px-5" href="/usernotif">
                                    Notifications
                                    @if ($usernotifCount >= 1)
                                        <span class="badge text-bg-danger">{{ $usernotifCount }}</span>
                                    @endif
                                </a>
                            </li>
                            <li><a class="dropdown-item py-3 px-5" href="/logout">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('resident_content')
    </main>

    <footer>
        <div class="container-xl">
            <center>
                <p class="footer-text">Copyright © MDRRMO Morong, Rizal All rights reserved</p>
            </center>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    @stack('userscripts')
</body>

</html>
