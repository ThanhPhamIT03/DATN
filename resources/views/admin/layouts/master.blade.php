<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Default Page')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<style>
    #slidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 250px;
        transition: all 0.3s ease;
        overflow-y: auto;
        background: #fff;
        border-right: 1px solid #ddd;
        z-index: 1000;
    }

    #content {
        margin-left: 250px;
        transition: all 0.3s ease;
    }

    #slidebar.closed {
        width: 0;
        opacity: 0;
        overflow: hidden;
    }

    #content.full {
        margin-left: 0;
        width: 100%;
    }
</style>

<body>
    <div class="wrapper d-flex min-vh-100" style="background-color: var(--bgr-gray)">
        <div class="container-fluid my-auto">
            <div class="row">
                <!-- Sidebar -->
                <aside id="slidebar" class="col-md-2 p-0">
                    @include('admin.layouts.slidebar')
                </aside>

                <!-- Content -->
                <div id="content" class="col-md-10 d-flex flex-column min-vh-100">
                    <!-- Header -->
                    @include('admin.layouts.header')

                    <!-- Main Content -->
                    <main class="flex-fill ps-3">
                        @hasSection('breadcrumb')
                            <nav aria-label="breadcrumb" class="mt-2">
                                <ol class="breadcrumb" style="padding: 0.75rem 0;">
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

    <!-- Toggle Sidebar Script -->
    <script type="module">
        $(function() {
            $("#btn-toggle-sidebar").on("click", function() {
                var $sidebar = $("#slidebar");
                var $content = $("#content");
                var $icon = $(this).find("i");

                $sidebar.toggleClass("closed");
                $content.toggleClass("full");

                // Đổi icon
                if ($sidebar.hasClass("closed")) {
                    $icon.removeClass("bi-arrows-fullscreen").addClass("bi-fullscreen-exit");
                } else {
                    $icon.removeClass("bi-fullscreen-exit").addClass("bi-arrows-fullscreen");
                }
            });
        });
    </script>
</body>

</html>
