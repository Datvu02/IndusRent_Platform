@extends('frontend.layouts.app')

@section('title', __('menu.services'))

@section('content')
<div id="content" class="content">
    <div class="listbox">
        <div class="left">
            <div id="navi">
                <div class="navibox"><a href="{{ url('/') }}">{{ __('menu.home') }}</a> &nbsp;/&nbsp; <a href="{{ url('/dich-vu') }}" title="{{ __('menu.services') }}">{{ __('menu.services') }}</a></div>
            </div>
            <div class="pageintro">
                <p><strong>{{ __('pages.services_title') }}</strong></p>
                <p>– {{ __('pages.services_s1') }}</p>
                <p>– {{ __('pages.services_s2') }}</p>
                <p>– {{ __('pages.services_s3') }}</p>
                <p>– {{ __('pages.services_s4') }}</p>
            </div>
        </div>
        @include('frontend.partials.sidebar-inner')
        <div class="clearfix"></div>
    </div>
</div>
@endsection
