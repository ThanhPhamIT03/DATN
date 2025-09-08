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
        <div class="container-fluid my-auto">
            <div class="row">
                <!-- Sidebar -->
                <aside class="col-md-2 p-0">
                    @include('admin.layouts.slidebar')
                </aside>

                <!-- Content -->
                <div class="col-md-10 d-flex flex-column min-vh-100">
                    <!-- Header -->
                    @include('admin.layouts.header')

                    <main class="flex-fill">
                        @hasSection('breadcrumb')
                            <nav aria-label="breadcrumb" class="mt-2">
                                <ol class="breadcrumb">
                                    @yield('breadcrumb')
                                </ol>
                            </nav>
                        @endif

                        @yield('content')
                    </main>

                    <!-- Footer -->
                    @include('admin.layouts.footer')
                </div>
            </div>
        </div>
    </div>
    @yield('script')
</body>
</html>
