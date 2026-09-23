@extends('frontend.layouts.app')

@section('title', __('menu.request_content'))

@section('content')
<div id="content" class="content">
    <div class="listbox">
        <div class="left">
            <div id="navi">
                <div class="navibox"><a href="{{ url('/') }}">{{ __('menu.home') }}</a> &nbsp;/&nbsp; <a href="{{ url('/noi-dung-yeu-cau') }}" title="{{ __('menu.request_content') }}">{{ __('menu.request_content') }}</a></div>
            </div>
            <div class="pageintro">
                @if(session('message'))<p style="color:#4b8606;margin-bottom:15px;">{{ session('message') }}</p>@endif
                <p>{{ __('pages.request_intro') }}</p>
            </div>
            <div id="form" style="padding-top:10px;">
                <form action="{{ url('/noi-dung-yeu-cau') }}" method="post" name="corder" id="corder">
                    @csrf
                    <div class="formbox">
                        <div class="formleft">{{ __('forms.full_name') }}</div>
                        <div class="formright"><input name="txtcValue01" type="text" value="{{ old('txtcValue01') }}" class="txtbox100" required></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">{{ __('forms.company') }}</div>
                        <div class="formright"><input name="txtcValue02" type="text" value="{{ old('txtcValue02') }}" class="txtbox100"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">{{ __('forms.phone') }}</div>
                        <div class="formright"><input name="txtcValue05" type="text" value="{{ old('txtcValue05') }}" class="txtbox100" required></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">{{ __('forms.email') }}</div>
                        <div class="formright"><input name="txtcValue06" type="email" value="{{ old('txtcValue06') }}" class="txtbox100" required></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">{{ __('forms.request_content') }}</div>
                        <div class="formright"><textarea name="txtcValue08" rows="8" class="txtarea100" required>{{ old('txtcValue08') }}</textarea></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">&nbsp;</div>
                        <div class="formright"><input type="submit" name="button" class="cbtnform" value="{{ __('forms.submit_request') }}"></div>
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
