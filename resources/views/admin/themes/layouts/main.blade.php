@include('admin.themes.partials.auth')
<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title') | Small Business </title>
    @include('admin.themes.partials.head')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('admin.themes.partials.navbar')
        @include('admin.themes.partials.sidebar')
        <div class="content-wrapper">
            @yield('content')
        </div>
        @include('admin.themes.partials.footer')
        @include('admin.themes.partials.controlsidebar')
        @include('admin.themes.partials.modals')
    </div>
    @include('admin.themes.partials.scripts')
</body>

</html>