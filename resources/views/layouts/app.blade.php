<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="icon" href="{{ asset('/favicon.ico') }}">
    @include('layouts.head')
</head>
<body>
    <div id="app">
        @include('layouts.header')
         <main class="main">
            @if (session('message'))
            <div class="flash_message bg-success text-center py-3 my-0 mb30">
                {{ session('message') }}
            </div>
            @endif
            @yield('content')
        </main>
        @include('layouts.footer')
    </div>
</body>
</html>
