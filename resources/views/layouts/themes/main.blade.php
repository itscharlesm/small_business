<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('layouts.partials.head')
    </head>
    <body>
        <div class="body-inner">
            @include('sweetalert::alert')
            @include('layouts.partials.header')
            @yield('content')
            @include('layouts.partials.footer') 
            @include('layouts.partials.scripts')
        </div>
        @include('layouts.partials.modals')
    </body>
</html>
