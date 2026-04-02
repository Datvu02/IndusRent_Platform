@extends('frontend.layouts.app')

@section('title', $property->title_translated)

@push('styles')
<style>
/* Ảnh đại diện tin đăng: luôn full chiều ngang; khung cao tối đa (ảnh dọc crop giữa; ảnh ngang thấp phóng to vừa khung, có thể crop nhẹ mép) */
.property-listing-main-image-wrap {
    width: 100%;
    max-width: 100%;
    height: min(420px, 55vh);
    overflow: hidden;
    border-radius: 8px;
    background: #f0f0f0;
    line-height: 0;
}
.property-listing-main-image-wrap img {
    width: 100%;
    max-width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
}
/* Mô tả HTML (TinyMCE): ảnh/video có width inline vẫn co vừa cột */
.pageintro .news-content img,
.pageintro .news-content video {
    max-width: 100% !important;
    height: auto !important;
}
.pageintro .news-content iframe {
    max-width: 100% !important;
}
.pageintro .news-content {
    overflow-x: auto;
}
.pageintro .news-content table {
    max-width: 100%;
    border-collapse: collapse;
}
/* Thư viện ảnh: ít ảnh thì căn giữa hàng */
.property-listing-gallery {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    align-items: stretch;
}
.property-listing-gallery .property-listing-gallery-item {
    flex: 0 1 200px;
    max-width: min(100%, 280px);
    min-width: 0;
}
.property-listing-gallery .property-listing-gallery-item img {
    width: 100%;
    max-width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
    display: block;
}
</style>
@if($property->latitude !== null && $property->longitude !== null)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
<style>
.property-detail-map {
    height: 360px;
    width: 100%;
    border-radius: 8px;
    margin-top: 10px;
    border: 1px solid #e0e0e0;
    z-index: 1;
}
</style>
@endif
@endpush

@push('scripts')
@if($property->latitude !== null && $property->longitude !== null)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var el = document.getElementById('property-detail-map');
    if (!el || typeof L === 'undefined') return;
    var lat = {{ (float) $property->latitude }};
    var lng = {{ (float) $property->longitude }};
    var map = L.map('property-detail-map').setView([lat, lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    L.marker([lat, lng]).addTo(map);
    setTimeout(function() { map.invalidateSize(); }, 300);
});
</script>
@endif
@endpush

@section('content')
<div id="content" class="content">
    <div class="listbox">
        <div class="left">
            <div id="navi">
                <div class="navibox">
                    <a href="{{ url('/') }}">{{ __('menu.home') }}</a> &nbsp;/&nbsp;
                    <a href="{{ url('/cho-thue-nha-xuong') }}">{{ $property->type->name_translated ?? 'BĐS' }}</a> &nbsp;/&nbsp;
                    <span>{{ Str::limit($property->title_translated, 50) }}</span>
                </div>
            </div>
            <div class="pageintro">
                <h1 style="font-size:20px;margin:0 0 15px;color:#263548;">{{ $property->title_translated }}</h1>
                <p style="color:#666;font-size:13px;">
                    @if($property->location)
                        {{ __('common.location_label') }}: {{ $property->location->location_line }}
                        @if($property->area) &nbsp;|&nbsp; {{ __('common.area_label') }}: {{ number_format($property->area) }} m² @endif
                    @endif
                    &nbsp;|&nbsp; {{ __('common.price_label') }}: <strong>{{ $property->formatted_price }}</strong>
                </p>
                @if($property->main_image)
                    <div class="property-listing-main-image-wrap" style="margin:15px 0;">
                        <img src="{{ asset('storage/'.$property->main_image) }}" alt="{{ $property->title_translated }}" class="property-listing-main-image">
                    </div>
                @endif
                
                @if($property->latitude !== null && $property->longitude !== null)
                    <div style="margin:20px 0 0;">
                        <h3 style="font-size:16px;margin-bottom:8px;color:#263548;">{{ __('common.map_location') }}</h3>
                        <div id="property-detail-map" class="property-detail-map"></div>
                    </div>
                @endif

                @if(!empty($property->gallery) && is_array($property->gallery))
                    <div style="margin:15px 0;">
                        <h3 style="font-size:16px;margin-bottom:10px;color:#263548;">{{ __('common.gallery') ?? 'Thư viện ảnh' }}</h3>
                        <div class="property-listing-gallery">
                            @foreach($property->gallery as $image)
                                <div class="property-listing-gallery-item">
                                    <img src="{{ asset('storage/'.$image) }}" alt="Gallery">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                @if($property->description_translated ?? $property->description)
                    <div class="news-content" style="line-height:1.7;margin-top:15px;">
                        {!! $property->description_translated ?? $property->description !!}
                    </div>
                @else
                    <p>{{ __('common.content_updating') }}</p>
                @endif
            </div>
        </div>
        @include('frontend.partials.sidebar-inner')
        <div class="clearfix"></div>
    </div>
</div>
@endsection
