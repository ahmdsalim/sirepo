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

    @include('layouts.partials.styles')
</head>

<body class="light">
    {{-- <script src="assets/static/js/initTheme.js"></script> --}}
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <header class="mb-5">
                <div class="header-top py-2">
                    <div class="container">
                        <div class="d-flex gap-3 ">
                            <a href="#" class="menu-link">
                                <span><i class="fa fa-circle-question"></i> FAQ</span>
                            </a>
                            <a href="https://ruangbaca.me" class="menu-link" target="_blank">
                                <span>Perpustakaan </span>
                            </a>
                            <a href="https://siapmhs.ulbi.ac.id" class="menu-link" target="_blank">
                                <span>SIAP Mahasiswa </span>
                            </a>
                            <a href="https://d3mi.ulbi.ac.id" class="menu-link" target="_blank">
                                <span>D3 MI </span>
                            </a>
                        </div>
                        <div class="header-top-right">
                            @guest
                                @if (str_contains(Route::current()->getName(), 'login') || str_contains(Route::current()->getName(), 'register'))
                                @else
                                    <div class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-user mr-1"></i><span
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
                                            <img src="./assets/compiled/jpg/1.jpg" alt="Avatar">
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
                                        <li><a class="dropdown-item" href="{{ route('user.profileLanding') }}"><i
                                                    class="icon-mid bi bi-person me-2"></i>
                                                Profile</a></li>
                                        <li><a class="dropdown-item" href="{{ route('user.settingLanding') }}"><i
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
                <nav class="main-navbar">
                    <div class="container">
                        <div class="d-flex justify-content-between ">
                            <div class="">
                                <h4 class="m-0"><a href="{{ url('/') }}" class="text-white">Repository MI</a>
                                </h4>
                            </div>
                            <ul>
                                <li
                                    class="menu-item {{ str_contains(Route::current()->getName(), '') ? 'active' : '' }}">
                                    <a href="{{ url('/') }}" class="menu-link">
                                        <span>Home</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

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
