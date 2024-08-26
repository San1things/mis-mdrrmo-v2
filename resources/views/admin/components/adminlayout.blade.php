<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Management Information System</title>

    <script>
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark-mode');
        }
    </script>

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
                <li class="sidebar-item"
                    style="{{ $path == 'inventory' || $path == 'categories' ? 'background-color: #3b7ddd' : '' }}">
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
                @php
                    $adminmessageCount = DB::table('tbl_messages')->where('seen', 0)->count();
                @endphp
                <li class="sidebar-item" style="{{ $path == 'adminmessages' ? 'background-color: #3b7ddd' : '' }}">
                    <a class="sidebar-link" href="/adminmessages">
                        <i class="bi bi-chat-left-text-fill position-relative">
                            @if ($adminmessageCount >= 1)
                                <span
                                    class="position-absolute fs-4 top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $adminmessageCount }}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            @endif
                        </i>
                        <span>Messages</span>
                    </a>
                </li>
                @php
                    $userinfo = request()->attributes->get('userinfo');
                    $adminnotifCount = DB::table('tbl_notif')
                        ->where('user_id', $userinfo[0])
                        ->where('user_type', 'org')
                        ->where('seen', 0)
                        ->count();
                @endphp
                <li class="sidebar-item" style="{{ $path == 'adminnotif' ? 'background-color: #3b7ddd' : '' }}">
                    <a class="sidebar-link" href="/adminnotif">
                        <i class="bi bi-bell-fill position-relative">
                            @if ($adminnotifCount >= 1)
                                <span
                                    class="position-absolute fs-4 top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $adminnotifCount }}
                                </span>
                            @endif
                        </i>
                        <span>Notifications</span>
                    </a>
                </li>
                <li class="sidebar-item"
                    style="{{ $path == 'logs' || $path == 'adminprofile' ? 'background-color: #3b7ddd' : '' }}">
                    <a class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse"
                        data-bs-target="#collapsetest" href="#" aria-expanded="true" aria-controls="collapsetest">
                        <i class="bi bi-gear-fill"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sidebar-dropdown list-unstyled collapse" id="collapsetest" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/logs">Logs</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/adminprofile">User Profile</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link san1-apperance-button" href="#"
                                style="color:black;">Appearance
                                <label class="san1-appearance-content">
                                    <input class="toggle-checkbox" id="darkModeToggle" type="checkbox">
                                    <div class="toggle-slot">
                                        <div class="sun-icon-wrapper">
                                            <div class="iconify sun-icon" data-icon="feather-sun"
                                                data-inline="false"></div>
                                        </div>
                                        <div class="toggle-button"></div>
                                        <div class="moon-icon-wrapper">
                                            <div class="iconify moon-icon" data-icon="feather-moon"
                                                data-inline="false">
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </a>
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

        // DARKMODE
        $(document).ready(function() {
            if (localStorage.getItem('darkMode') === 'enabled') {
                $('.main').addClass('dark-mode')
                $('.btn-primary').addClass('dark-mode')
                $('#sidebar').addClass('dark-mode')
                $('.sidebar-dropdown').addClass('dark-mode')
                $('.page-link').addClass('dark-mode')
                $('.users-card-body').addClass('dark-mode')
                $('.modal-content').addClass('dark-mode')
                $('.admin-header').removeClass('border-dark').addClass('border-light');
                $('.navbar').removeClass('bg-body-tertiary').addClass('bg-body-dark');
                $('.nav-link').removeClass('text-dark').addClass('text-light');
                $('.table').removeClass('table-light').addClass('table-dark');
                $('#darkModeToggle').prop('checked', true);
            } else {
                $('.admin-header').removeClass('border-light').addClass('border-dark');
                $('.navbar').removeClass('bg-body-dark').addClass('bg-body-tertiary');
                $('.nav-link').removeClass('text-light').addClass('text-dark');
                $('.table').removeClass('table-dark').addClass('table-light');
                $('#darkModeToggle').prop('checked', false);
            }

            $('#darkModeToggle').on('change', function() {
                $('.main').toggleClass('dark-mode')
                $('.btn-primary').toggleClass('dark-mode')
                $('.users-card-body').toggleClass('dark-mode')
                $('.page-link').toggleClass('dark-mode')
                $('.modal-content').toggleClass('dark-mode')
                $('#sidebar').toggleClass('dark-mode')

                if ($(this).is(':checked')) {
                    $('.admin-header').removeClass('border-dark').addClass('border-light');
                    $('.navbar').removeClass('bg-body-tertiary').addClass('bg-body-dark');
                    $('.nav-link').removeClass('text-dark').addClass('text-light');
                    $('.table').removeClass('table-light').addClass('table-dark');
                    localStorage.setItem('darkMode', 'enabled');
                } else {
                    $('.admin-header').removeClass('border-light').addClass('border-dark');
                    $('.navbar').removeClass('bg-body-dark').addClass('bg-body-tertiary');
                    $('.nav-link').removeClass('text-light').addClass('text-dark');
                    $('.table').removeClass('table-dark').addClass('table-light');
                    localStorage.setItem('darkMode', 'disabled');
                }
            })



        })
    </script>


</body>

</html>
