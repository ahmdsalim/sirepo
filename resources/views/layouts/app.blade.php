<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Repository MI</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"
        integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
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
    </style>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/landing.js'])
</head>

<body>
    <div id="app">
        <header id="header" class="header-fancy">
            <nav class="navbar topbar">
                <div class="container">
                    <div class="header-nav">
                        <button class="nav-more">
                            <i class="fa fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="nav">
                            <li class="me-3">
                                <a href="https://ruangbaca.me" target="_blank" rel="no-follow">Perpustakaan</a>
                            </li>
                            <li class="me-3">
                                <a href="https://siapmhs.ulbi.ac.id" target="_blank" rel="no-follow">SIAP Mahasiswa</a>
                            </li>
                            <li class="me-3">
                                <a href="https://d3mi.ulbi.ac.id" target="_blank" rel="no-follow">D3 MI</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container">
                <nav class="navbar navbar-header navbar-expand-md navbar-light shadow-sm">
                    <a class="navbar-brand text-white" href="{{ url('/') }}">
                        Repository MI
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon text-white"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-circle-question"></i>
                                    FAQ</a>
                            </li>
                            @guest
                            @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-user"></i> MASUK DAN
                                    DAFTAR</a>
                            </li>
                            @endif
                            @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </nav>
            </div>
        </header>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>