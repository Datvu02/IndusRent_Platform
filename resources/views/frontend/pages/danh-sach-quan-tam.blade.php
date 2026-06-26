@extends('frontend.layouts.app')

@section('title', __('menu.interest_list'))

@section('content')
<div id="content" class="content">
    <div class="listbox">
        <div class="left">
            <div id="navi">
                <div class="navibox"><a href="{{ url('/') }}">{{ __('menu.home') }}</a> &nbsp;/&nbsp; <a href="{{ url('/danh-sach-quan-tam') }}">{{ __('menu.interest_list') }}</a></div>
            </div>
            <div class="pageintro">
                <h1 style="font-size:18px;margin:0 0 15px;">{{ __('pages.interest_title', ['count' => 0]) }}</h1>
                <p>{{ __('pages.interest_empty') }}</p>
                <p><a href="{{ url('/cho-thue-nha-xuong') }}">{{ __('pages.interest_view_warehouse') }}</a> | <a href="{{ url('/dat-ban') }}">{{ __('pages.interest_view_land') }}</a></p>
            </div>
        </div>
        @include('frontend.partials.sidebar-inner')
        <div class="clearfix"></div>
    </div>
</div>
@endsection
