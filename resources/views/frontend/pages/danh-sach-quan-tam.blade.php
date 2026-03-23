@extends('frontend.layouts.app')

@section('title', 'Danh sách quan tâm')

@section('content')
<div id="content" class="content">
    <div class="listbox">
        <div class="left">
            <div id="navi">
                <div class="navibox"><a href="{{ url('/') }}">Trang chủ</a> &nbsp;/&nbsp; <a href="{{ url('/danh-sach-quan-tam') }}">Danh sách quan tâm</a></div>
            </div>
            <div class="pageintro">
                <h1 style="font-size:18px;margin:0 0 15px;">Danh sách quan tâm (0)</h1>
                <p>Bạn chưa lưu tin nào. Hãy duyệt các tin đăng và bấm lưu để xem lại sau.</p>
                <p><a href="{{ url('/cho-thue-nha-xuong') }}">Xem nhà xưởng cho thuê</a> | <a href="{{ url('/dat-ban') }}">Xem đất bán</a></p>
            </div>
        </div>
        @include('frontend.partials.sidebar-inner')
        <div class="clearfix"></div>
    </div>
</div>
@endsection
