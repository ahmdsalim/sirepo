<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Repository MI</title>

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.bunny.net"> --}}
    {{-- <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"
        integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    {{-- <style>
        body {
            background-color: #E6E6E6 !important;
        }

        #header {
            background-color: #073C64;
            position: relative;
        }

        #header.header-fancy {
            margin-bottom: 40px;
        }

        #header .navbar-nav .nav-link {
            color: white;
        }

        #header .topbar {
            display: block;
            min-height: 40px;
            border: none;
            background-color: #1A2C43;
            position: relative;
        }

        #header .topbar .container {
            position: relative;
            display: block;
        }

        #header .topbar .nav-more {
            width: 50px;
            height: 50px;
            position: absolute;
            top: 0;
            right: 0;
            border: none;
            outline: none;
            font-size: 18px;
            text-align: center;
            color: #fff;
            background-color: transparent;
            display: none;
        }

        #header .topbar .nav-more .svg-inline--fa {
            /* vertical-align: baseline; */
        }

        #header .topbar .nav>li {
            display: inline-block;
            vertical-align: middle;
            color: white;
            float: none;
        }

        #header .topbar .nav>li>a {
            font-family: "Open Sans", Helvetica, Arial, sans-serif;
            font-size: 12px;
            font-weight: normal;
            text-transform: capitalize;
            color: white;
            text-decoration: none;
            padding: 8px 0;
        }

        #header .topbar .nav {
            float: right;
            margin: 0;
        }

        #header .navbar-collapse li a {
            font-family: "Montserrat", Helvetica, Arial, sans-serif;
            font-size: 12px;
            font-weight: normal;
        }

        .navbar-toggler {
            border: none !important;
        }

        .navbar-toggler:focus {
            box-shadow: none !important;
        }

        .navbar-toggler-icon {
            background-image: none !important;
            width: 1em !important;
            height: 1em !important;
        }

        .navbar-toggler-icon::before {
            font-family: FontAwesome;
            content: "\f0c9";
        }

        #header .navbar-collapse .navbar-nav>li>a {
            padding-top: 10px;
            padding-bottom: 10px;
            line-height: 23px;
        }

        @media (max-width: 1199px) {
            #header .topbar .header-nav {
                position: absolute;
                top: 20px;
                right: 60;
                z-index: 99;
            }

            #header .topbar {
                background-color: transparent;
                min-height: 0;
            }

            #header .topbar .header-nav .nav>li>a {
                height: 50px;
                line-height: 30px;
                padding: 10px 0;
                font-size: 14px;
            }

            #header .navbar-collapse .navbar-nav {
                margin-bottom: 20px;
            }
        }

        @media (max-width: 1024px) {
            #header .topbar .header-nav .nav {
                position: absolute;
                right: 0;
                top: 50px;
                background-color: #fff;
                padding: 0;
                z-index: 9999;
                width: 50%;
                max-width: 250px;
                box-shadow: 0 2px 30px rgba(0, 0, 0, 0.3);
                -webkit-box-shadow: 0 2px 30px rgba(0, 0, 0, 0.3);
                -moz-box-shadow: 0 2px 30px rgba(0, 0, 0, 0.3);
                visibility: hidden;
                opacity: 0;
                height: 0;
                transition: all ease-in-out .2s;
                -webkit-transition: all ease-in-out .2s;
                -moz-transition: all ease-in-out .2s;
            }

            #header .topbar .header-nav .nav {
                width: 200px;
            }

            #header .topbar .header-nav .nav>li>a {
                color: rgb(85, 85, 85);
                padding: 10px;
            }

            #header .topbar .header-nav {
                top: 7.5px;
                right: 0;
                z-index: 999;
            }

            #header .topbar {
                height: auto;
                padding: 0;
            }

            #header .navbar-header {
                padding-right: 40px;
                padding-top: 0;
                padding-bottom: 0;
            }

            #header .navbar-toggler {
                margin: 18px 0;
            }

            #header .header-nav .nav-more {
                display: block;
                border-left: 1px solid rgba(255, 255, 255, 0.1);
            }

            #header .header-nav .nav-more:hover {
                background-color: #121F33;
            }

            #header .topbar .header-nav:hover .nav {
                height: auto;
                visibility: visible;
                opacity: 1;
            }

            #header .topbar .header-nav .nav>li>a {
                line-height: 48px;
            }

            #header .topbar .header-nav .nav li a:hover {
                color: #149fc0;
            }
        }
    </style> --}}
    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/landing.js']) --}}
    @include('layouts.partials.styles')
</head>

<body class="light">
    {{-- <script src="assets/static/js/initTheme.js"></script> --}}
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <header class="mb-5">
                <nav class="main-navbar p-1">
                    <div class="container">
                        <ul>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span><i class="fa fa-circle-question"></i> FAQ</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="https://ruangbaca.me" class="menu-link" target="_blank">
                                    <span>Perpustakaan </span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="https://siapmhs.ulbi.ac.id" class="menu-link" target="_blank">
                                    <span>SIAP Mahasiswa </span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="https://d3mi.ulbi.ac.id" class="menu-link" target="_blank">
                                    <span>D3 MI</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="header-top">
                    <div class="container">
                        <div class="logo">
                            <h5 class="m-0"><a href="{{ url('/') }}">Repository MI</a></h5>
                        </div>
                        <div class="header-top-right">
                            @guest
                                @if (str_contains(Route::current()->getName(), 'login') || str_contains(Route::current()->getName(), 'register'))
                                @else
                                    <div class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-user"></i> MASUK DAN
                                            DAFTAR</a>
                                    </div>
                                @endif
                            @else
                                <div class="dropdown">
                                    <a href="#" data-bs-toggle="dropdown" class="text-decoration-none "
                                        aria-expanded="false" class="">
                                        <div class="user-menu d-flex">
                                            <div class="user-img d-flex align-items-center">
                                                <div
                                                    class="avatar avatar-md d-flex align-items-center gap-2 text-white font-bold">
                                                    <img src="./assets/compiled/jpg/1.jpg" class="rounded-circle"
                                                        height="32px">
                                                    <h6 class="mb-0 text-gray-600">{{ Auth::user()->nama }}</h6>

                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                                        style="min-width: 11rem;">
                                        <li>
                                            <h6 class="dropdown-header">Halo, {{ Auth::user()->nama }}!</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="#"><i
                                                    class="icon-mid bi bi-person me-2"></i>
                                                Profile</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-gear me-2"></i>
                                                Settings</a></li>
                                        <li><a class="dropdown-item" href="#"><i
                                                    class="icon-mid bi bi-wallet me-2"></i>
                                                Koleksi</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        {{-- <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li> --}}
                                        <li><a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();"><i
                                                    class="icon-mid bi bi-box-arrow-left me-2"></i>Logout
                                            </a></li>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </ul>
                                </div>
                            @endguest
                            <!-- Burger button responsive -->
                            <a href="#" class="burger-btn d-block d-xl-none">
                                <i class="bi bi-justify fs-3"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </header>
            <div class="content-wrapper container">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    @include('layouts.partials.scripts')
    @include('layouts.partials.scripts')
</body>

</html>
