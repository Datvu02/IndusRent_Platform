@extends('frontend.layouts.app')

@section('title', __('menu.contact'))

@push('styles')
<style>
.contact-page-full { max-width: 800px; margin: 0 auto; }
.contact-captcha-wrap { display: flex; align-items: center; gap: 15px; flex-wrap: wrap; }
.contact-captcha-display { 
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    font-size: 20px;
    font-weight: bold;
    letter-spacing: 4px;
    border-radius: 6px;
    user-select: none;
    min-width: 120px;
    font-family: 'Courier New', monospace;
}
.contact-captcha-refresh {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    background: #4b8606;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 18px;
    transition: all 0.3s ease;
}
.contact-captcha-refresh:hover {
    background: #3d7005;
    transform: rotate(180deg);
}
</style>
@endpush

@section('content')
<div id="content" class="content">
    <div class="contact-page-full">
        <div id="navi">
            <div class="navibox"><a href="{{ url('/') }}">{{ __('menu.home') }}</a> &nbsp;/&nbsp; <span>{{ __('menu.contact') }}</span></div>
        </div>
        <div class="pageintro">
            <h1 style="font-size:22px;margin:15px 0;color:#263548;">{{ __('menu.contact') }}</h1>
        </div>
        @if(session('message'))
            <div style="padding:15px;background:#d4edda;border:1px solid #c3e6cb;border-radius:6px;color:#155724;margin-bottom:20px;">
                <strong>✓</strong> {{ session('message') }}
            </div>
        @endif
        @if($errors->any())
            <div style="padding:15px;background:#f8d7da;border:1px solid #f5c6cb;border-radius:6px;color:#721c24;margin-bottom:20px;">
                <strong>⚠</strong> 
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <div id="form" style="padding-top:10px;">
                <form action="{{ url('/lien-he') }}" method="post" name="corder" id="corder">
                    @csrf
                    <div class="formbox">
                        <div class="formleft">{{ __('forms.full_name') }}</div>
                        <div class="formright"><input name="txtcValue01" type="text" value="{{ old('txtcValue01') }}" class="txtbox100"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">{{ __('forms.company') }}</div>
                        <div class="formright"><input name="txtcValue02" type="text" value="{{ old('txtcValue02') }}" class="txtbox100"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">{{ __('forms.nationality') }}</div>
                        <div class="formright"><input name="txtcValue03" type="text" value="{{ old('txtcValue03') }}" class="txtbox100"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">{{ __('forms.address') }}</div>
                        <div class="formright"><input name="txtcValue04" type="text" value="{{ old('txtcValue04') }}" class="txtbox100"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">{{ __('forms.phone') }}</div>
                        <div class="formright"><input name="txtcValue05" type="text" value="{{ old('txtcValue05') }}" class="txtbox100"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">{{ __('forms.email') }}</div>
                        <div class="formright"><input name="txtcValue06" type="email" value="{{ old('txtcValue06') }}" class="txtbox100"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">{{ __('forms.request_content') }}</div>
                        <div class="formright"><textarea name="txtcValue08" rows="10" class="txtarea100">{{ old('txtcValue08') }}</textarea></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="formbox">
                        <div class="formleft">{{ __('forms.captcha') }}&nbsp;(<span>*</span>)</div>
                        <div class="formright">
                            <div class="contact-captcha-wrap">
                                <input name="captcha" type="text" value="{{ old('captcha') }}" placeholder="{{ __('forms.captcha_placeholder') }}" style="width:140px;padding:10px;border:2px solid #ccc;border-radius:6px;font-size:14px;" required>
                                <span class="contact-captcha-display" id="captcha-display">{{ session('captcha_code', 'ABCD') }}</span>
                                <button type="button" class="contact-captcha-refresh" onclick="refreshCaptcha()" title="{{ __('forms.captcha_refresh') }}">↻</button>
                            </div>
                            <small style="display:block;margin-top:6px;color:#666;">{{ __('forms.captcha_hint') }}</small>
                        </div>
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
</div>

@push('scripts')
<script>
function refreshCaptcha() {
    fetch('{{ url("/refresh-captcha") }}')
        .then(response => response.json())
        .then(data => {
            if (data.captcha) {
                document.getElementById('captcha-display').textContent = data.captcha;
            }
        })
        .catch(error => console.error('Error refreshing captcha:', error));
}
</script>
@endpush
@endsection
