<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | SIREPO</title>
    <link href='{{ asset('./assets/compiled/ico/favicon.ico') }}' rel='apple-touch-icon' sizes='120x120' />
    <link href='{{ asset('./assets/compiled/ico/favicon.ico') }}' rel='apple-touch-icon' sizes='152x152' />
    <link href='{{ asset('./assets/compiled/ico/favicon.ico') }}' rel='icon' type='image/x-icon' />
    <link href='{{ asset('./assets/compiled/ico/favicon.ico') }}' rel='shortcut icon' type='image/x-icon' />

    @include('layouts.partials.styles')
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        @include('layouts.partials.sidebar')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="page-title">
                    {{ $header }}
                </div>

                {{ $slot }}
            </div>

            @include('layouts.partials.footer')
        </div>
    </div>

    @include('layouts.partials.scripts')
</body>

</html>
