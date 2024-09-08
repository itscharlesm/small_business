@include('admin.themes.partials.auth')
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>@yield('title') | MCM EyeCafe </title>
        @include('admin.themes.partials.head')
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            @include('sweetalert::alert')
            {{-- @include('admin.themes.partials.preloader') --}}
            @include('admin.themes.partials.navbar')
            @include('admin.themes.partials.sidebar')
            <div class="content-wrapper">
                @yield('content')
                {{-- <a class="btn btn-primary back-to-top no-print" id="back-to-top" role="button" aria-label="Scroll to top" href="#">
                    <i class="fas fa-chevron-up"></i> --}}
                </a>
            </div>
            {{-- @include('layouts.partials.footer') --}}
            @include('admin.themes.partials.footer')
            @include('admin.themes.partials.controlsidebar')
            @include('admin.themes.partials.modals')
        </div>
        @include('admin.themes.partials.scripts')
    </body>
</html>
