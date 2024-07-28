<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Management Information System</title>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poetsen+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet"
        integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/template.css') }}" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="bi bi-list"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">MDRRMO</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/">
                        <i class="bi bi-person-fill"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/inventory">
                        <i class="bi bi-duffle-fill"></i>
                        <span>Inventory</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse"
                        data-bs-target="#collapsetest" href="#" aria-expanded="true" aria-controls="collapsetest">
                        <i class="bi bi-person-fill"></i>
                        <span>Collapse Test</span>
                    </a>
                    <ul class="sidebar-dropdown list-unstyled collapse" id="collapsetest" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="#">Test</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="#">Test</a>
                        </li>
                    </ul>
                </li>
                {{-- <li class="sidebar-item">
                    <a class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse"
                        data-bs-target="#collapsemulti" href="#" aria-expanded="false"
                        aria-controls="collapsemulti">
                        <i class="bi bi-person-fill"></i>
                        <span>Collapse Multi Test</span>
                    </a>
                    <ul class="sidebar-dropdown list-unstyled collapse" id="collapsemulti" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse"
                                data-bs-target="#multilink" href="#" aria-expanded="false"
                                aria-controls="multilink">
                                Two Links
                            </a>
                            <ul class="sidebar-dropdown list-unstyled collapsed" id="multilink">
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="#">Test</a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="#">Test</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li> --}}
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <i class="bi bi-person-fill"></i>
                        <span>Test</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <i class="bi bi-person-fill"></i>
                        <span>Test</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a class="sidebar-link" href="#" href="#" style="color: black">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Log Out</span>
                </a>
            </div>
        </aside>
        <div class="main p-3 justify-content-center">
            @yield('content')
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script>
        let hamBurger = document.querySelector(".toggle-btn");

        hamBurger.addEventListener("click", function() {
            document.querySelector("#sidebar").classList.toggle("expand");
        });
    </script>
    @stack('scripts')
</body>

</html>
