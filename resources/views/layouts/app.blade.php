<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="RuangBaca">
    <meta name="description" content="RuangBaca merupakan situs yang menyediakan buku-buku digital yang dapat dibaca secara online dan gratis.">
    <meta name="keywords" content="baca buku, buku digital, baca gratis">
    <meta name="robots" content="index, follow">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    

    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @vite(['resources/assets/css/bootstrap.min.css','resources/assets/css/nifty.min.css','resources/assets/css/auth.css'])
    @stack('css')
    <!-- Scripts -->
    @vite('resources/js/app.js')

</head>
<body>
    <div id="app">
        <main class="pt-5">
            <div class="header-wrapper mb-4">
                <a href="{{route('landing')}}" style="height: 100%;">
                    <div class="header-logo-wrapper">
                        <img id="logo" src="{{asset('assets/img/app-logo-sample.png')}}">
                        <span id="text-logo">RuangBaca</span>
                    </div>
                </a>
            </div>
            @yield('content')
        </main>
    </div>
    
    @stack('js')
</body>
</html>
