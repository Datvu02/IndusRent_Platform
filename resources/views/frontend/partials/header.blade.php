@php
    $currentLocale = app()->getLocale();
@endphp
{{-- Top menu (thanh trên) --}}
<div id="topmn">
    <div class="tbox">
        <div class="tmenus">
            <ul>
                <li><a class="kygui" href="{{ url('/') }}">{{ __('menu.feng_shui_news') }}</a></li>
                <li>|</li>
                <li><a href="{{ url('/noi-dung-yeu-cau') }}">{{ __('menu.request_content') }}</a></li>
                <li>|</li>
                <li><a href="{{ url('/gioi-thieu') }}">{{ __('menu.about') }}</a></li>
                <li>|</li>
                <li><a href="{{ url('/dich-vu') }}">{{ __('menu.services') }}</a></li>
                <li>|</li>
                <li><a href="{{ url('/tin-tuc') }}">{{ __('menu.news') }}</a></li>
                <li>|</li>
                <li><a href="{{ url('/lien-he') }}">{{ __('menu.contact') }}</a></li>
            </ul>
            <div class="lang">
                <a href="{{ route('locale.switch', 'vi') }}" class="{{ $currentLocale === 'vi' ? 'active' : '' }}" title="Tiếng Việt">VN</a>
                <a href="{{ route('locale.switch', 'en') }}" class="{{ $currentLocale === 'en' ? 'active' : '' }}" title="English">EN</a>
                <a href="{{ route('locale.switch', 'zh') }}" class="{{ $currentLocale === 'zh' ? 'active' : '' }}" title="中文">CN</a>
            </div>
        </div>
    </div>
</div>

{{-- Header logo + hotline + icons --}}
<div id="header">
    <div class="header-2">
        <div class="left">
            <h1>
                <a href="{{ url('/') }}" title="{{ setting('site_name') ?? __('common.tagline') }}">
                    @php
                        $logoPath = setting('site_logo', 'images/default-logo.png');
                        $logoUrl = Str::startsWith($logoPath, ['http://', 'https://']) 
                            ? $logoPath 
                            : asset($logoPath);
                    @endphp
                    <img src="{{ $logoUrl }}" alt="{{ setting('site_name') ?? 'Logo' }}" class="logo-img" onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='inline';">
                    <span class="logo-text" style="display:none; color:#fff; font-size:18px; font-weight:bold;">{{ setting('site_name') ?? 'IndusRent' }}</span>
                </a>
                <span>{{ setting('site_slogan') ?? __('common.tagline') }}</span>
            </h1>
        </div>
        <div class="mid"></div>
        <div class="right">
            <div class="contact">
                <div class="tel">{{ __('common.contact_label') }}: <a href="tel:{{ str_replace([' ', '.', '-'], '', setting('company_hotline', '0909866966')) }}">{{ setting('company_hotline', '0909.866.966') }}</a> <h2>{{ setting('site_slogan') ?? __('common.tagline') }}</h2></div>
                <div class="icons">
                    @if(setting('facebook_url'))
                        <a href="{{ setting('facebook_url') }}" target="_blank" rel="noopener" title="Facebook">📘</a>
                    @endif
                    @if(setting('linkedin_url'))
                        <a href="{{ setting('linkedin_url') }}" target="_blank" rel="noopener" title="LinkedIn">💼</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
