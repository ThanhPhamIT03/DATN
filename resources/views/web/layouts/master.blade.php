<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Default Page')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        @include('web.layouts.header')
        
        <main class="main-content">
            <div class="content" style="background-color: var(--bgr-gray)">
                @hasSection('breadcrumb')
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                @endif

                @yield('content')
            </div>
        </main>

        @include('web.layouts.footer')
    </div>
    @yield('script')
</body>
</html>
