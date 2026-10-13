<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', __('common.tagline'))</title>
    <meta name="description" content="@yield('meta_description', __('common.tagline'))">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">
    <link rel="stylesheet" href="{{ asset('css/clone-chothuexuong.css') }}?v={{ @filemtime(public_path('css/clone-chothuexuong.css')) ?: time() }}">
    <link rel="stylesheet" href="{{ asset('css/theme-golden.css') }}?v={{ @filemtime(public_path('css/theme-golden.css')) ?: time() }}">
    <link rel="stylesheet" href="{{ asset('css/logo-fix.css') }}?v={{ @filemtime(public_path('css/logo-fix.css')) ?: time() }}">
    <link rel="stylesheet" href="{{ asset('css/frontend-filter.css') }}?v={{ @filemtime(public_path('css/frontend-filter.css')) ?: time() }}">
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
        window.locationI18n = {
            province: @json(__('forms.select_province_placeholder')),
            district: @json(__('forms.select_district_placeholder')),
            ward: @json(__('forms.select_ward_placeholder')),
        };
    </script>
    <script src="{{ asset('js/cascading-location.js') }}"></script>
    <script src="{{ asset('js/search-ajax.js') }}"></script>
    @stack('scripts')
</body>
</html>
