@extends('frontend.layouts.app')

@section('title', 'Nội dung yêu cầu')

@section('content')
<div id="content" class="content">
    <div class="listbox">
        <div class="left">
            <div id="navi">
                <div class="navibox"><a href="{{ url('/') }}">Trang chủ</a> &nbsp;/&nbsp; <a href="{{ url('/noi-dung-yeu-cau') }}" title="Nội dung yêu cầu">Nội dung yêu cầu</a></div>
            </div>
            <div class="pageintro">
                @if(session('message'))<p style="color:#4b8606;margin-bottom:15px;">{{ session('message') }}</p>@endif
                <p>Quý khách vui lòng điền form bên dưới để gửi yêu cầu tư vấn cho thuê / bán nhà xưởng, kho, mặt bằng. Chúng tôi sẽ liên hệ trong thời gian sớm nhất.</p>
            </div>
            <div id="form" style="padding-top:10px;">
                <form action="{{ url('/noi-dung-yeu-cau') }}" method="post" name="corder" id="corder">
                    @csrf
                    <div class="formbox">
                        <div class="formleft">Họ và tên</div>
                        <div class="formright"><input name="txtcValue01" type="text" value="{{ old('txtcValue01') }}" class="txtbox100" required></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">Công ty</div>
                        <div class="formright"><input name="txtcValue02" type="text" value="{{ old('txtcValue02') }}" class="txtbox100"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">Điện thoại</div>
                        <div class="formright"><input name="txtcValue05" type="text" value="{{ old('txtcValue05') }}" class="txtbox100" required></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">Email</div>
                        <div class="formright"><input name="txtcValue06" type="email" value="{{ old('txtcValue06') }}" class="txtbox100" required></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">Nội dung yêu cầu</div>
                        <div class="formright"><textarea name="txtcValue08" rows="8" class="txtarea100" required>{{ old('txtcValue08') }}</textarea></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">&nbsp;</div>
                        <div class="formright"><input type="submit" name="button" class="cbtnform" value="Gửi yêu cầu"></div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
        @include('frontend.partials.sidebar-inner')
        <div class="clearfix"></div>
    </div>
</div>
@endsection
