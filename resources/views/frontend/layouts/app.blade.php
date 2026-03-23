<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', __('common.tagline'))</title>
    <meta name="description" content="{{ __('common.tagline') }}">
    <link rel="stylesheet" href="{{ asset('css/clone-chothuexuong.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme-golden.css') }}">
    <link rel="stylesheet" href="{{ asset('css/logo-fix.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend-filter.css') }}">
    @stack('styles')
</head>
<body>
    @include('frontend.partials.header')

    <div id="main">
        @include('frontend.partials.nav')

        <div id="main-content-wrap">
            @yield('content')
        </div>
    </div>

    @include('frontend.partials.footer')

    <script>
        console.log('Frontend layout loaded');
        console.log('Cascading script path:', '{{ asset("js/cascading-location.js") }}');
    </script>
    <script src="{{ asset('js/cascading-location.js') }}"></script>
    <script src="{{ asset('js/search-ajax.js') }}"></script>
    @stack('scripts')
</body>
</html>
