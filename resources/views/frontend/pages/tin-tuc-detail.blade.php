@extends('frontend.layouts.app')

@section('title', $article->title_translated)

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">
<style>
.news-gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin: 20px 0;
}
.news-gallery-grid img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.3s ease;
}
.news-gallery-grid img:hover {
    transform: scale(1.05);
}
.news-gallery-slider {
    margin: 20px 0;
    position: relative;
}
.news-swiper {
    border-radius: 8px;
    overflow: hidden;
}
.news-swiper .swiper-slide img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    cursor: pointer;
}
.news-swiper .swiper-button-prev,
.news-swiper .swiper-button-next {
    background: rgba(255,255,255,0.9);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    color: #1a3a52;
}
.news-swiper .swiper-button-prev:after,
.news-swiper .swiper-button-next:after {
    font-size: 18px;
}
.news-swiper .swiper-pagination-bullet-active {
    background: #D4AF37;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const newsSwiper = document.querySelector('.news-swiper');
    if (newsSwiper) {
        new Swiper('.news-swiper', {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 0,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            speed: 600,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            keyboard: {
                enabled: true,
            },
        });
    }
    
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'albumLabel': 'Ảnh %1 / %2'
    });
});
</script>
@endpush

@section('content')
<div id="content" class="content">
    <div class="listbox">
        <div class="left">
            <div id="navi">
                <div class="navibox"><a href="{{ url('/') }}">{{ __('menu.home') }}</a> &nbsp;/&nbsp; <a href="{{ url('/tin-tuc') }}">{{ __('menu.news') }}</a> &nbsp;/&nbsp; <span>{{ Str::limit($article->title_translated, 40) }}</span></div>
            </div>
            <div class="pageintro">
                <h1 style="font-size:20px;margin:0 0 15px;color:#263548;">{{ $article->title_translated }}</h1>
                <p style="color:#666;font-size:13px;">{{ __('common.updated') }}: {{ $article->updated_at?->format('d/m/Y') }}</p>
                
                @if($article->featured_image)
                    <div style="margin:15px 0;">
                        <a href="{{ asset('storage/'.$article->featured_image) }}" data-lightbox="article-gallery" data-title="{{ $article->title_translated }}">
                            <img src="{{ asset('storage/'.$article->featured_image) }}" alt="{{ $article->title_translated }}" style="max-width:100%;height:auto;border-radius:8px;cursor:pointer;">
                        </a>
                    </div>
                @endif
                
                @if(!empty($article->gallery) && is_array($article->gallery))
                    @php
                        $galleryCount = count($article->gallery);
                    @endphp
                    
                    @if($galleryCount <= 3)
                        <div class="news-gallery-grid">
                            @foreach($article->gallery as $index => $image)
                                <a href="{{ asset('storage/' . $image) }}" data-lightbox="article-gallery" data-title="Ảnh {{ $index + 1 }}">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gallery {{ $index + 1 }}">
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="news-gallery-slider">
                            <div class="news-swiper swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach($article->gallery as $index => $image)
                                        <div class="swiper-slide">
                                            <a href="{{ asset('storage/' . $image) }}" data-lightbox="article-gallery" data-title="Ảnh {{ $index + 1 }}">
                                                <img src="{{ asset('storage/' . $image) }}" alt="Gallery {{ $index + 1 }}">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    @endif
                @endif
                
                @if($article->content_translated ?? $article->content)
                    <div class="news-content" style="line-height:1.7;margin-top:15px;">
                        {!! $article->content_translated ?? $article->content !!}
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
