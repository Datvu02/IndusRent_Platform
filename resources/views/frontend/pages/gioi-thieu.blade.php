@extends('frontend.layouts.app')

@section('title', __('menu.about'))

@section('content')
<div id="content" class="content">
    <div class="listbox">
        <div class="left">
            <div id="navi">
                <div class="navibox"><a href="{{ url('/') }}">{{ __('menu.home') }}</a> &nbsp;/&nbsp; <a href="{{ url('/gioi-thieu') }}" title="{{ __('menu.about') }}">{{ __('menu.about') }}</a></div>
            </div>
            <div class="pageintro">
                <p><span style="font-size:14px;">{{ __('pages.about_p1') }}</span></p>
                <p><span style="font-size:14px;">{{ __('pages.about_p2') }}</span></p>
                <p><span style="font-size:14px;">{{ __('pages.about_p3') }}</span></p>
                <p><span style="font-size:14px;">{{ __('pages.about_p4') }}</span></p>
                <p><a href="{{ url('/') }}"><span style="font-size:14px;"><strong>CHOTHUEXUONG.COM.VN</strong></span></a> <span style="font-size:14px;">{{ __('pages.about_p5_before') }}</span></p>
            </div>
        </div>
        @include('frontend.partials.sidebar-inner')
        <div class="clearfix"></div>
    </div>
</div>
@endsection
