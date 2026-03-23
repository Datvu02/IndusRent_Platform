@extends('frontend.layouts.app')

@section('title', 'Liên hệ')

@section('content')
<div id="content" class="content">
    <div class="listbox">
        <div class="left">
            <div id="navi">
                <div class="navibox"><a href="{{ url('/') }}">Trang chủ</a> &nbsp;/&nbsp; <a href="{{ url('/lien-he') }}" title="Liên hệ">Liên hệ</a></div>
            </div>
            <div class="pageintro"></div>
            @if(session('message'))<p style="color:#4b8606;margin-bottom:15px;">{{ session('message') }}</p>@endif
            <div id="form" style="padding-top:10px;">
                <form action="{{ url('/lien-he') }}" method="post" name="corder" id="corder">
                    @csrf
                    <div class="formbox">
                        <div class="formleft">Họ và tên</div>
                        <div class="formright"><input name="txtcValue01" type="text" value="{{ old('txtcValue01') }}" class="txtbox100"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">Công ty</div>
                        <div class="formright"><input name="txtcValue02" type="text" value="{{ old('txtcValue02') }}" class="txtbox100"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">Quốc tịch</div>
                        <div class="formright"><input name="txtcValue03" type="text" value="{{ old('txtcValue03') }}" class="txtbox100"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">Địa chỉ</div>
                        <div class="formright"><input name="txtcValue04" type="text" value="{{ old('txtcValue04') }}" class="txtbox100"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">Điện thoại</div>
                        <div class="formright"><input name="txtcValue05" type="text" value="{{ old('txtcValue05') }}" class="txtbox100"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">Email</div>
                        <div class="formright"><input name="txtcValue06" type="email" value="{{ old('txtcValue06') }}" class="txtbox100"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">Nội dung yêu cầu</div>
                        <div class="formright"><textarea name="txtcValue08" rows="10" class="txtarea100">{{ old('txtcValue08') }}</textarea></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">Mã bảo vệ&nbsp;(<span>*</span>)</div>
                        <div class="formright">
                            <input name="csecurity_code" type="text" value="" class="txtbox65px" placeholder="Nhập mã" style="width:120px;">
                            <span style="margin-left:8px;display:inline-block;padding:6px 12px;background:#e8e8e8;font-size:14px;letter-spacing:2px;">ABCD</span>
                        </div>
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
