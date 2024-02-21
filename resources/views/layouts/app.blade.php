<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Repository MI</title>

    <link rel="shortcut icon" href="{{ asset('./assets/compiled/svg/favicon.svg') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    {{-- <link rel="dns-prefetch" href="//fonts.bunny.net"> --}}
    {{-- <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"
        integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

    @include('layouts.partials.styles')
    <style>
        @font-face {
            font-family: 'Pt Serif';
            src: url({{ asset('assets/static/fonts/PTSerif-Regular.ttf') }});
        }

        .pt-serif {
            font-family: 'Pt Serif', serif;
        }
    </style>
</head>

<body class="light">
    {{-- <script src="assets/static/js/initTheme.js"></script> --}}
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        <div id="main" class="layout-horizontal position-relative">
            <header class="mb-4">
                <div class="header-top py-2">
                    <div class="container flex-wrap">
                        <div class="d-flex gap-3 ">
                            <a href="https://ruangbaca.me" class="menu-link" target="_blank">
                                <span>Perpustakaan </span>
                            </a>
                            <a href="https://ulbi.siakadcloud.com" class="menu-link" target="_blank">
                                <span>SIAKAD </span>
                            </a>
                            <a href="https://d3mi.ulbi.ac.id" class="menu-link" target="_blank">
                                <span>D3 MI </span>
                            </a>
                        </div>
                        <div class="d-flex">

                            <div class="theme-toggle d-flex gap-2  align-items-center " style="margin-right:14px">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true" role="img" class="iconify iconify--system-uicons"
                                    width="20" height="20" preserveAspectRatio="xMidYMid meet"
                                    viewBox="0 0 21 21">
                                    <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                            opacity=".3"></path>
                                        <g transform="translate(-210 -1)">
                                            <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                            <circle cx="220.5" cy="11.5" r="4"></circle>
                                            <path
                                                d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                                <div class="form-check form-switch fs-6">
                                    <input class="form-check-input  me-0" type="checkbox" id="toggle-dark"
                                        style="cursor: pointer">
                                    <label class="form-check-label"></label>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true" role="img" class="iconify iconify--mdi" width="20"
                                    height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                    </path>
                                </svg>
                            </div>
                            <div class="header-top-right">
                                @guest
                                    @if (str_contains(Route::current()->getName(), 'login') || str_contains(Route::current()->getName(), 'register'))
                                    @else
                                        <div class="nav-item">
                                            <a class="nav-link" href="{{ route('login') }}"><i
                                                    class="fa fa-user mr-1"></i><span
                                                    style="font-size: 14px; margin-left:4px">MASUK
                                                    DAN
                                                    DAFTAR</span></a>
                                        </div>
                                    @endif
                                @else
                                    <div class="dropdown">
                                        <a href="#" id="topbarUserDropdown"
                                            class="user-dropdown d-flex align-items-center dropend dropdown-toggle "
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <div class="avatar">
                                                <img src="{{ asset('./assets/compiled/jpg/1.jpg') }}" alt="Avatar">
                                            </div>
                                            <div class="text">
                                                <h6 class="user-dropdown-name">{{ Auth::user()->nama }}</h6>
                                            </div>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg"
                                            aria-labelledby="topbarUserDropdown">
                                            <li>
                                                <h6 class="dropdown-header">Halo, {{ Auth::user()->nama }}!</h6>
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('landing.profile') }}"><i
                                                        class="icon-mid bi bi-person me-2"></i>
                                                    Profile</a></li>
                                            <li><a class="dropdown-item" href="{{ route('landing.setting') }}"><i
                                                        class="icon-mid bi bi-gear me-2"></i>
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

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
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
                </div>
                <nav class="main-navbar">
                    <div class="container">
                        <div class="d-flex justify-content-between ">
                            <div class="">
                                <h4 class="m-0"><a href="{{ route('landing') }}" class="text-white">Repository
                                        MI</a>
                                </h4>
                            </div>
                            <ul>
                                <li
                                    class="menu-item {{ str_contains(Route::current()->getName(), '') ? 'active' : '' }}">
                                    <a href="{{ route('landing') }}" class="menu-link">
                                        <span>Home</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

            </header>
            <div class="content-wrapper container">
                <main>
                    @yield('content')
                </main>
            </div>
            <footer>
                <div class="col-12 position-absolute bottom-0 py-2 " style="background-color:#1D1D1D">
                    <div class="container">
                        <p class="m-0 text-white " style="font-size:12px"> © 2024 MANAJEMEN INFORMATIKA | UNIVERSITAS
                            LOGISTIK DAN BISNIS INTERNASIONAL. All right reserved.</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    @include('layouts.partials.scripts')
    @include('layouts.partials.scripts')
</body>

</html>
