<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<!-- Mirrored from themeon.net/nifty/v3.0.1/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 Apr 2022 04:26:59 GMT -->
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <title>Error @yield('errcode') - @yield('errtitle')</title>

    <!-- STYLESHEETS -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--- -->

    <!-- Fonts [ OPTIONAL ] -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&amp;family=Ubuntu:wght@400;500;700&amp;display=swap" rel="stylesheet">

    @vite(['resources/assets/css/bootstrap.min.css','resources/assets/css/nifty.min.css'])

</head>

<body class="jumping">

    <!-- PAGE CONTAINER -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div id="root" class="root mn--max hd--expanded">

        <!-- CONTENTS -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <section id="content" class="content">
            <div class="content__header content__boxed rounded-0">
                <div class="content__wrap">

                    <div class="pt-5 mb-4 text-center">
                        <div class="error-code page-title mb-3">@yield('errcode')</div>
                        <h3 class="mb-4">
                            <div class="badge bg-info">@yield('errtitle')</div>
                        </h3>
                        <p class="lead">@yield('errmsg')</p>
                    </div>
                </div>

            </div>

            @yield('content')

        </section>

        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!-- END - CONTENTS -->

    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!-- END - PAGE CONTAINER -->

</body>

<!-- Mirrored from themeon.net/nifty/v3.0.1/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 Apr 2022 04:26:59 GMT -->
</html>