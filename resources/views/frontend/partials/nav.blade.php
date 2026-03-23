{{-- Menu chính + danh sách quan tâm --}}
<div id="mmenu">
    <nav class="menu">
        <h3 class="dropdown">{{ __('menu.hotline') }} <span>0909.866.966</span></h3>
        <ul>
            <li><a href="{{ url('/') }}">{{ __('menu.home') }}</a></li>
            <li><a href="{{ url('/cho-thue-nha-xuong') }}">{{ __('menu.warehouse_for_rent') }}</a></li>
            <li><a href="{{ url('/cho-thue-kho') }}">{{ __('menu.warehouse_rent') }}</a></li>
            <li><a href="{{ url('/cho-thue-mat-bang') }}">{{ __('menu.premises_rent') }}</a></li>
            <li><a href="{{ url('/dat-ban') }}">{{ __('menu.land_sale') }}</a></li>
            <li><a href="{{ url('/nha-xuong-ban') }}">{{ __('menu.warehouse_sale') }}</a></li>
        </ul>
    </nav>
    <div class="cart"><span><a href="{{ url('/danh-sach-quan-tam') }}">{{ __('menu.interest_list') }} (<b id="cartnum">0</b>)</a></span></div>
    <div class="clearfix"></div>
</div>
