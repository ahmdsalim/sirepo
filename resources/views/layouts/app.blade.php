<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Repository MI</title>

    <link href='{{ asset('./assets/compiled/ico/favicon.ico') }}' rel='apple-touch-icon' sizes='120x120' />
    <link href='{{ asset('./assets/compiled/ico/favicon.ico') }}' rel='apple-touch-icon' sizes='152x152' />
    <link href='{{ asset('./assets/compiled/ico/favicon.ico') }}' rel='icon' type='image/x-icon' />
    <link href='{{ asset('./assets/compiled/ico/favicon.ico') }}' rel='shortcut icon' type='image/x-icon' />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    @include('layouts.partials.styles')
    <style>
        @font-face {
            font-family: 'Pt Serif';
            src: url({{ asset('assets/static/fonts/PTSerif-Regular.ttf') }});
        }

        .pt-serif {
            font-family: 'Pt Serif', serif;
        }

        .main-navbar .title {
            color: #435ebe;
        }

        .layout-horizontal .main-navbar .submenu .submenu-group {
            max-height: auto !important;
            min-width: auto !important;
        }

        .layout-horizontal .bahasa,
        .layout-horizontal .bahasa a {
            color: #25396f;
        }

        html[data-bs-theme=dark] .layout-horizontal .bahasa,
        html[data-bs-theme=dark] .layout-horizontal .bahasa a {
            color: #ffffff;
        }

        @media only screen and (min-width: 1200px) {
            #menu-right {
                width: auto !important;
            }

            #menu-left {
                display: flex !important;
            }

            .main-navbar .title {
                color: #fff !important;
            }
        }

        @media only screen and (max-width: 1199px) {
            .layout-horizontal .main-navbar ul {
                flex-direction: row !important;
                gap: 1.5rem !important;
            }
        }
    </style>
</head>

<body class="light">
    {{-- <script src="assets/static/js/initTheme.js"></script> --}}
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        <div id="main" class="layout-horizontal position-relative">
            <header class="mb-4">
                @if (!str_contains(Route::current()->getName(), 'contributors'))
                    <div class="header-top py-2">
                        <div class="container flex-wrap">
                            <div class="gap-3 d-none" id="menu-left">
                                <a href="https://ruangbaca.me" class="menu-link" target="_blank">
                                    <span>Digital Library</span>
                                </a>
                                <a href="https://ejurnal.ulbi.ac.id/index.php/improve" class="menu-link"
                                    target="_blank">
                                    <span>E-Jurnal</span>
                                </a>
                            </div>
                            <div class="d-flex justify-content-between w-100" id="menu-right">

                                <div class="theme-toggle d-flex gap-2  align-items-center " style="margin-right:14px">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        aria-hidden="true" role="img" class="iconify iconify--system-uicons"
                                        width="20" height="20" preserveAspectRatio="xMidYMid meet"
                                        viewBox="0 0 21 21">
                                        <g fill="none" fill-rule="evenodd" stroke="currentColor"
                                            stroke-linecap="round" stroke-linejoin="round">
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
                                    <div class="bahasa d-lg-none">
                                        <a href="{{ route('setlocale', 'id') }}">ID</a> | <a
                                            href="{{ route('setlocale', 'en') }}">EN</a>
                                    </div>
                                </div>
                                <div class="header-top-right">
                                    @guest
                                        @if (str_contains(Route::current()->getName(), 'login') || str_contains(Route::current()->getName(), 'register'))
                                        @else
                                            <div class="nav-item">
                                                <a class="nav-link" href="{{ route('login') }}"><i
                                                        class="fa fa-user mr-1"></i><span
                                                        style="font-size: 14px; margin-left:4px">{{ __('landing.login-register') }}</span></a>
                                            </div>
                                        @endif
                                    @else
                                        <div class="dropdown">
                                            <a href="#" id="topbarUserDropdown"
                                                class="user-dropdown d-flex align-items-center dropend dropdown-toggle "
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <div class="text">
                                                    <h6 class="user-dropdown-name">{{ Auth::user()->nama }}</h6>
                                                </div>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-lg"
                                                aria-labelledby="topbarUserDropdown">
                                                <li>
                                                    <h6 class="dropdown-header">
                                                        {{ __('landing.account-dropdown.greeting') }},
                                                        {{ Auth::user()->nama }}!</h6>
                                                </li>
                                                @if (auth()->user()->role == 'user')
                                                    <li><a class="dropdown-item {{ str_contains(Route::current()->getName(), 'profile') ? 'active' : '' }}"
                                                            href="{{ route('landing.profile') }}"><i
                                                                class="icon-mid bi bi-person me-2"></i>
                                                            {{ __('landing.account-dropdown.profile') }}</a></li>
                                                    <li><a class="dropdown-item {{ Request::is('setting*') ? 'active' : '' }}"
                                                            href="{{ route('landing.setting') }}"><i
                                                                class="icon-mid bi bi-gear me-2"></i>
                                                            {{ __('landing.account-dropdown.settings') }}</a></li>
                                                    <li><a class="dropdown-item {{ str_contains(Route::current()->getName(), 'koleksi') ? 'active' : '' }}"
                                                            href="{{ route('landing.koleksi') }}"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="18"
                                                                height="18" fill="none" viewBox="0 0 24 24"
                                                                class="icon" style="color: none; margin-right:6px;">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="m19 21-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16Z">
                                                                </path>
                                                            </svg>
                                                            {{ __('landing.account-dropdown.collection') }}</a></li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                @endif

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
                                    <a href="#" class="burger-btn d-block d-xl-none mb-2">
                                        <i class="bi bi-justify fs-3"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <nav class="main-navbar">
                        <div class="container">
                            <div class="d-flex justify-content-between">
                                <div class="my-auto">
                                    <a href="{{ route('landing') }}" class="fs-5 fw-bold title">Repository MI</a>
                                </div>
                                <ul>
                                    <li class="menu-item">
                                        <a href="{{ route('landing') }}" class="menu-link">
                                            <span>{{ __('landing.home') }}</span>
                                        </a>
                                    </li>
                                    @if (str_contains(Route::current()->getName(), 'login'))
                                        <li class="menu-item">
                                            <a href="{{ route('register') }}" class="menu-link">
                                                <span>{{ __('landing.register-text') }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (str_contains(Route::current()->getName(), 'register'))
                                        <li class="menu-item">
                                            <a href="{{ route('login') }}" class="menu-link">
                                                <span>{{ __('landing.login-text') }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    <li class="menu-item has-sub d-lg-block d-none">
                                        <a class="menu-link" href="javascript:void(0)">
                                            @if (app()->getlocale() == 'id')
                                                <svg viewBox="0 0 36 36" width="20"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                                    role="img" class="iconify iconify--twemoji"
                                                    preserveAspectRatio="xMidYMid meet" fill="#000000">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path fill="#DC1F26"
                                                            d="M32 5H4a4 4 0 0 0-4 4v9h36V9a4 4 0 0 0-4-4z"></path>
                                                        <path fill="#EEE"
                                                            d="M36 27a4 4 0 0 1-4 4H4a4 4 0 0 1-4-4v-9h36v9z"></path>
                                                    </g>
                                                </svg>
                                            @else
                                                <svg width="20" version="1.1" id="Layer_1"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"
                                                    xml:space="preserve" fill="#000000">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path style="fill:#41479B;"
                                                            d="M473.655,88.276H38.345C17.167,88.276,0,105.443,0,126.621V385.38 c0,21.177,17.167,38.345,38.345,38.345h435.31c21.177,0,38.345-17.167,38.345-38.345V126.621 C512,105.443,494.833,88.276,473.655,88.276z">
                                                        </path>
                                                        <path style="fill:#F5F5F5;"
                                                            d="M511.469,120.282c-3.022-18.159-18.797-32.007-37.814-32.007h-9.977l-163.54,107.147V88.276h-88.276 v107.147L48.322,88.276h-9.977c-19.017,0-34.792,13.847-37.814,32.007l139.778,91.58H0v88.276h140.309L0.531,391.717 c3.022,18.159,18.797,32.007,37.814,32.007h9.977l163.54-107.147v107.147h88.276V316.577l163.54,107.147h9.977 c19.017,0,34.792-13.847,37.814-32.007l-139.778-91.58H512v-88.276H371.691L511.469,120.282z">
                                                        </path>
                                                        <g>
                                                            <polygon style="fill:#FF4B55;"
                                                                points="282.483,88.276 229.517,88.276 229.517,229.517 0,229.517 0,282.483 229.517,282.483 229.517,423.724 282.483,423.724 282.483,282.483 512,282.483 512,229.517 282.483,229.517 ">
                                                            </polygon>
                                                            <path style="fill:#FF4B55;"
                                                                d="M24.793,421.252l186.583-121.114h-32.428L9.224,410.31 C13.377,415.157,18.714,418.955,24.793,421.252z">
                                                            </path>
                                                            <path style="fill:#FF4B55;"
                                                                d="M346.388,300.138H313.96l180.716,117.305c5.057-3.321,9.277-7.807,12.287-13.075L346.388,300.138z">
                                                            </path>
                                                            <path style="fill:#FF4B55;"
                                                                d="M4.049,109.475l157.73,102.387h32.428L15.475,95.842C10.676,99.414,6.749,104.084,4.049,109.475z">
                                                            </path>
                                                            <path style="fill:#FF4B55;"
                                                                d="M332.566,211.862l170.035-110.375c-4.199-4.831-9.578-8.607-15.699-10.86L300.138,211.862H332.566z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </svg>
                                            @endif
                                        </a>
                                        <div class="submenu">
                                            <ul class="submenu-group">
                                                <li class="submenu-item">
                                                    <a href="{{ route('setlocale', 'id') }}"
                                                        class="submenu-link">{{ __('landing.indonesian') }}</a>
                                                </li>
                                                <li class="submenu-item  ">
                                                    <a href="{{ route('setlocale', 'en') }}"
                                                        class="submenu-link">{{ __('landing.english') }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                @endif
            </header>

            <div class="content-wrapper container">
                <main>
                    @yield('content')
                </main>
            </div>
            @if (!str_contains(Route::current()->getName(), 'profile'))
                <footer>
                    <div class="col-12 position-absolute bottom-0">
                        <div class="container">
                            <div class="footer clearfix mb-0 text-muted">
                                <div class="float-start">
                                    <p>{{ date('Y') }} © Repository MI</p>
                                </div>
                                <div class="float-end">
                                    <p>Crafted by <a href="{{ route('contributors') }}">Contributors</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            @else
                <footer>
                    <div class="container">
                        <div class="footer clearfix mb-0 text-muted">
                            <div class="float-start">
                                <p>{{ date('Y') }} © Repository MI</p>
                            </div>
                            <div class="float-end">
                                <p>Crafted by <a href="{{ route('contributors') }}">Contributors</a></p>
                            </div>
                        </div>
                    </div>
                </footer>
            @endif

        </div>
    </div>
    @vite('resources/js/landing.js')
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/horizontal-layout.js') }}"></script>
    <script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
    @stack('scripts')
</body>

</html>
