<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Default Page')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper d-flex min-vh-100" style="background-color: var(--bgr-gray)">
        <div class="container-xl pt-4">
            @include('web.pages.information.layouts.nav-top')
        </div>
        <div class="container-xl" style="background-color: var(--bgr-gray); height: auto;">
            <div class="row">
                <div id="content" class="col-md-12 d-flex min-vh-100">
                    <main class="flex-fill">
                        <div class="row pt-4">
                            @include('web.pages.information.layouts.nav-left')

                            <div class="col-md-8">
                                <div id="content-area">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
    <!-- Custom Page Loading -->
    @yield('script')
</body>

</html>
