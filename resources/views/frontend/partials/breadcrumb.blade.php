{{-- Breadcrumb (đường dẫn Trang chủ / Trang hiện tại) --}}
@isset($breadcrumbs)
<div id="navi">
    <div class="navibox">
        @foreach($breadcrumbs as $i => $item)
            @if($i > 0)&nbsp;/&nbsp;@endif
            @if(!empty($item['url']))
                <a href="{{ $item['url'] }}" title="{{ $item['title'] }}">{{ $item['title'] }}</a>
            @else
                <span>{{ $item['title'] }}</span>
            @endif
        @endforeach
    </div>
</div>
@endisset
