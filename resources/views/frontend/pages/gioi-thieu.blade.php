@extends('frontend.layouts.app')

@section('title', 'Giới thiệu Rich Hưng Thịnh | Nhà xưởng, kho xưởng và mặt bằng')

@section('meta_description', 'Giới thiệu Rich Hưng Thịnh – đơn vị cung cấp thông tin nhà xưởng, kho xưởng, mặt bằng và bất động sản phục vụ nhu cầu sản xuất, kinh doanh.')


@section('content')
<div id="content" class="content">
    <div class="listbox">
        <div class="left">
	    <h1 style="font-size:22px;margin:15px 0;color:#263548;">
		    Giới thiệu Rich Hưng Thịnh
 	    </h1>
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
