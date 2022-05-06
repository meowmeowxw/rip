<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ripperoni') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/public.js') }}" defer></script>
    @yield('scripts')

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/img-box.css') }}" rel="stylesheet">
    <link href="{{ asset('css/page.css') }}" rel="stylesheet">
    <style>
        #cookie-banner {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }
    </style>
    @yield('styles')

</head>
<body id="body" class="d-flex flex-column h-100">

<header>
    <x-nav-bar/>
</header>
<main id="app" class="p-2 flex-shrink-0">
    @yield('content')
</main>

<footer id="footer" class="footer mt-auto text-center">
    <div id="cookie-banner" class="d-flex col-md-auto justify-content-center">
        @include('cookie-consent::index')
    </div>

    <div class="container text-center p-3">
        © 2021 Copyright:
        <a class="text-dark" href="{{config('app.url', 'http://localhost')}}">{{ config('app.name', 'Ripperoni') }}</a>
    </div>
</footer>


</body>

</html>
