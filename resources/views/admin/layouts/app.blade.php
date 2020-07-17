<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('admin.layouts.head')
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            @include('admin.layouts.header')
            
            @include('admin.layouts.sidebar')

            @yield('content')
        
            @include('admin.layouts.foot')
        </body>
</html>
