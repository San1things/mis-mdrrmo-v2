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
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/template.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modalloader.css') }}" rel="stylesheet">

</head>

<body class="bg-light">
    <div class="wrapper">
        <aside class="expand" id="sidebar">
            <div class="d-flex">
                <a class="toggle-btn" type="button">
                    <img src="{{ asset('images/publicpics/logo.png') }}" alt="">
                </a>
                <div class="sidebar-logo">
                    @php
                        $userinfo = request()->attributes->get('userinfo');
                        $user = DB::table('tbl_users')
                            ->where('id', $userinfo[0])
                            ->first();
                    @endphp
                    <a href="/users">{{ $user->username }}</a>
                </div>
            </div>
            @php
                $path = request()->path();
            @endphp
            <ul class="sidebar-nav">
                <li class="sidebar-item" style="{{ $path == 'users' ? 'background-color: #3b7ddd' : '' }}">
                    <a class="sidebar-link" href="/users">
                        <i class="bi bi-person-fill"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="sidebar-item" style="{{ $path == 'inventory' ? 'background-color: #3b7ddd' : '' }}">
                    <a class="sidebar-link" href="/inventory">
                        <i class="bi bi-duffle-fill"></i>
                        <span>Inventory</span>
                    </a>
                </li>
                <li class="sidebar-item" style="{{ $path == 'adminannouncements' ? 'background-color: #3b7ddd' : '' }}">
                    <a class="sidebar-link" href="/adminannouncements">
                        <i class="bi bi-megaphone-fill"></i>
                        <span>Announcements</span>
                    </a>
                </li>
                <li class="sidebar-item" style="{{ $path == 'adminseminars' ? 'background-color: #3b7ddd' : '' }}">
                    <a class="sidebar-link" href="/adminseminars">
                        <i class="bi bi-person-video3"></i>
                        <span>Seminars</span>
                    </a>
                </li>
                <li class="sidebar-item" style="{{ $path == 'subscriptions' ? 'background-color: #3b7ddd' : '' }}">
                    <a class="sidebar-link" href="/subscriptions">
                        <i class="bi bi-bell-fill"></i>
                        <span>Subscriptions</span>
                    </a>
                </li>
                <li class="sidebar-item" style="{{ $path == 'adminmessages' ? 'background-color: #3b7ddd' : '' }}">
                    <a class="sidebar-link" href="/adminmessages">
                        <i class="bi bi-chat-left-text-fill position-relative">
                            <span
                                class="position-absolute fs-6 top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                99+
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </i>
                        <span>Messages</span>
                    </a>
                </li>
                <li class="sidebar-item" style="{{ $path == 'adminnotif' ? 'background-color: #3b7ddd' : '' }}">
                    <a class="sidebar-link" href="/adminnotif">
                        <i class="bi bi-bell-fill position-relative">
                            <span
                                class="position-absolute fs-6 top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                99+
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </i>
                        <span>Notifications</span>
                    </a>
                </li>
                <li class="sidebar-item"
                    style="{{ $path == 'categories' || $path == 'logs' || $path == 'adminprofile' ? 'background-color: #3b7ddd' : '' }}">
                    <a class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse"
                        data-bs-target="#collapsetest" href="#" aria-expanded="true" aria-controls="collapsetest">
                        <i class="bi bi-gear-fill"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sidebar-dropdown list-unstyled collapse" id="collapsetest" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/categories">Categories</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/logs">Logs</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/adminprofile">User Profile</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a class="sidebar-link" href="/logout" href="#" style="color: black">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Log Out</span>
                </a>
            </div>
        </aside>
        <div class="main p-3 justify-content-center">
            @yield('content')
        </div>
    </div>

    <script>
        let hamBurger = document.querySelector(".toggle-btn");
        hamBurger.addEventListener("click", function() {
            document.querySelector("#sidebar").classList.toggle("expand");
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    @stack('scripts')
    <script>
        $(window).resize(function() {
            let width = $(window).width();
            if (width < 992) {
                $('#sidebar').attr('class', '');
            } else {
                $('#sidebar').attr('class', 'expand');
            }
        });
        $(window).resize();
    </script>


</body>

</html>
