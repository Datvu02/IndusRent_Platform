@extends('frontend.layouts.app')

@section('title', __('common.tagline'))

@push('styles')
<style>
.slider-container {
    position: relative;
    overflow: hidden;
}
.slider-item {
    display: none;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    position: relative;
}
.slider-item.active {
    display: block;
}
.slider-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(26,58,82,0.8) 0%, rgba(26,58,82,0.5) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}
.slider-content {
    text-align: center;
    color: #fff;
    padding: 20px;
    max-width: 600px;
}
.slider-title {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 15px;
    text-shadow: 0 2px 8px rgba(0,0,0,0.3);
}
.slider-desc {
    font-size: 16px;
    margin-bottom: 20px;
    line-height: 1.6;
}
.slider-btn {
    display: inline-block;
    padding: 12px 30px;
    background: #D4AF37;
    color: #fff;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.slider-btn:hover {
    background: #B8860B;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(212,175,55,0.4);
}
.slider-controls {
    position: absolute;
    bottom: 20px;
    left: 0;
    right: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
}
.slider-prev, .slider-next {
    background: rgba(255,255,255,0.9);
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    font-size: 24px;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #1a3a52;
}
.slider-prev:hover, .slider-next:hover {
    background: #D4AF37;
    color: #fff;
}
.slider-dots {
    display: flex;
    gap: 8px;
}
.slider-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255,255,255,0.5);
    cursor: pointer;
    transition: all 0.3s ease;
}
.slider-dot.active, .slider-dot:hover {
    background: #D4AF37;
    width: 30px;
    border-radius: 6px;
}
/* Slider full width; tin nổi bật; form tìm kiếm */
#homeads .homeads-slider-row .slider-container {
    display: block;
    width: 100%;
    flex: none;
    min-height: 320px;
    align-self: stretch;
}
.slider-container .slider-item {
    min-height: 320px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.slider-container');
    if (!container) return;
    
    const items = container.querySelectorAll('.slider-item');
    const dots = container.querySelectorAll('.slider-dot');
    const prevBtn = container.querySelector('.slider-prev');
    const nextBtn = container.querySelector('.slider-next');
    
    if (items.length <= 1) return;
    
    let currentIndex = 0;
    let autoplayInterval;
    
    function showSlide(index) {
        items.forEach(item => item.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        items[index].classList.add('active');
        if (dots[index]) dots[index].classList.add('active');
        currentIndex = index;
    }
    
    function nextSlide() {
        const next = (currentIndex + 1) % items.length;
        showSlide(next);
    }
    
    function prevSlide() {
        const prev = (currentIndex - 1 + items.length) % items.length;
        showSlide(prev);
    }
    
    function startAutoplay() {
        autoplayInterval = setInterval(nextSlide, 5000);
    }
    
    function stopAutoplay() {
        clearInterval(autoplayInterval);
    }
    
    if (prevBtn) prevBtn.addEventListener('click', () => {
        prevSlide();
        stopAutoplay();
        startAutoplay();
    });
    
    if (nextBtn) nextBtn.addEventListener('click', () => {
        nextSlide();
        stopAutoplay();
        startAutoplay();
    });
    
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);
            stopAutoplay();
            startAutoplay();
        });
    });
    
    container.addEventListener('mouseenter', stopAutoplay);
    container.addEventListener('mouseleave', startAutoplay);
    
    startAutoplay();
});
</script>
@endpush

@section('content')
    {{-- Slider → Tin tức nổi bật → Form tìm kiếm --}}
    <div id="homeads">
        <div class="homeads-slider-row">
            <div class="slider-container">
                @if($sliders->isNotEmpty())
                    @foreach($sliders as $index => $slide)
                    <div class="slider-item {{ $index === 0 ? 'active' : '' }}" 
                         style="background-image:url('{{ asset('storage/' . $slide->image) }}');"
                         data-link="{{ $slide->link }}">
                        <div class="slider-overlay">
                            <div class="slider-content">
                                <h2 class="slider-title">{{ $slide->getTranslated('title') ?: $slide->title }}</h2>
                                @if($slide->getTranslated('description') ?: $slide->description)
                                    <p class="slider-desc">{{ $slide->getTranslated('description') ?: $slide->description }}</p>
                                @endif
                                @if($slide->link)
                                    <a href="{{ $slide->link }}" class="slider-btn">{{ __('common.learn_more') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    @if($sliders->count() > 1)
                    <div class="slider-controls">
                        <button class="slider-prev">‹</button>
                        <div class="slider-dots">
                            @foreach($sliders as $index => $slide)
                                <span class="slider-dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></span>
                            @endforeach
                        </div>
                        <button class="slider-next">›</button>
                    </div>
                    @endif
                @else
                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:16px;background:#e8e8e8;color:#666;">
                        {{ __('common.slider_placeholder') }}
                    </div>
                @endif
            </div>
        </div>

        @if($latestNews->isNotEmpty())
        <section class="home-featured-news" aria-label="{{ __('common.section_real_estate_news') }}">
            <div class="home-featured-news-inner">
                <h2 class="home-featured-news-title">{{ __('common.section_real_estate_news') }}</h2>
                <div class="home-featured-news-grid">
                    @foreach($latestNews as $news)
                    <article class="home-featured-news-card">
                        <a href="{{ url('/tin-tuc/'.$news->slug) }}" class="home-featured-news-card-link">
                            <div class="home-featured-news-card-img">
                                @if($news->featured_image)
                                    <img src="{{ asset('storage/'.$news->featured_image) }}" alt="{{ $news->title_translated }}">
                                @else
                                    <span class="home-featured-news-card-placeholder" aria-hidden="true"></span>
                                @endif
                            </div>
                            <h3 class="home-featured-news-card-title">{{ $news->title_translated }}</h3>
                        </a>
                    </article>
                    @endforeach
                </div>
                <p class="home-featured-news-more"><a href="{{ url('/tin-tuc') }}">{{ __('common.view_all') }} →</a></p>
            </div>
        </section>
        @endif

        <div class="homeads-search-row">
            <form action="{{ url('/tim-kiem') }}" method="get" class="sbox">
                <input type="hidden" name="se" value="true">
                <div class="title">{{ __('common.search') }}:</div>
                <div>
                    <select name="trans" class="cbbox100">
                        <option value="1" selected>{{ __('common.rent') }}</option>
                        <option value="2">{{ __('common.sale') }}</option>
                    </select>
                </div>
                <div>
                    <select name="mnu">
                        <option value="">{{ __('common.select_category') }}</option>
                        @foreach($propertyTypes ?? [] as $t)
                            <option value="{{ $t->id }}">
                                {{ $t->name_translated }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select id="province-select" data-selected="{{ request('_province') }}">
                        <option value="">{{ __('common.select_city') }}</option>
                    </select>
                </div>
                <div><select id="district-select" disabled data-selected="{{ request('_district') }}"><option value="">{{ __('common.select_district') }}</option></select></div>
                <div><select id="ward-select" name="location_id" disabled data-selected="{{ request('location_id') }}"><option value="">{{ __('common.select_ward') }}</option></select></div>
                <div>
                    <select name="area">
                        <option value="0" selected>{{ __('common.select_area') }}</option>
                        <option value="100^500">{{ __('common.area_range_100_500') }}</option>
                        <option value="500^1000">{{ __('common.area_range_500_1000') }}</option>
                        <option value="1000^2000">{{ __('common.area_range_1000_2000') }}</option>
                        <option value="2000^5000">{{ __('common.area_range_2000_5000') }}</option>
                    </select>
                </div>
                <div>
                    <input type="text" name="skey" placeholder="{{ __('common.search_placeholder') }}..." value="{{ request('skey') }}">
                </div>
                <div class="sbtn">
                    <input type="submit" name="btnSearch" value="{{ __('common.search') }}">
                </div>
            </form>
        </div>
    </div>

    {{-- Nội dung chính --}}
    <div id="content">
        {{-- CHO THUÊ NHÀ XƯỞNG MỚI NHẤT --}}
        <div class="hpro">
            <ul>
                <li class="title4"><span>{{ __('common.section_latest_warehouse') }}</span></li>
                <li class="li4">
                    <ul>
                        @forelse($latestWarehouseRent ?? [] as $item)
                        <li>
                            <div class="thumb" style="background:#ddd;@if(!empty($item['image'])) background-image:url('{{ $item['image'] }}'); background-size:cover; background-position:center; @endif">
                                <div class="price"><span>{{ $item['price'] ?? __('common.contact_price') }}</span>{{ $item['unit'] ?? '' }}</div>
                            </div>
                            <div class="info">
                                <h2><a href="{{ $item['url'] ?? '#' }}">{{ $item['title'] ?? '' }}</a></h2>
                            </div>
                        </li>
                        @empty
                        <li style="padding:15px;color:#666;">{{ __('common.no_items_short') }}</li>
                        @endforelse
                    </ul>
                </li>
                <li class="more"><a href="{{ url('/cho-thue-nha-xuong') }}">{{ __('common.view_all') }} →</a></li>

                <li class="title5"><span>{{ __('common.section_transfer_land') }}</span></li>
                <li class="li5">
                    <ul>
                        @forelse($latestLandSale ?? [] as $item)
                        <li>
                            <div class="thumb" style="background:#ddd;@if(!empty($item['image'])) background-image:url('{{ $item['image'] }}'); background-size:cover; background-position:center; @endif">
                                <div class="price"><span>{{ $item['price'] ?? __('common.contact_price') }}</span>{{ $item['unit'] ?? '' }}</div>
                            </div>
                            <div class="info">
                                <h2><a href="{{ $item['url'] ?? '#' }}">{{ $item['title'] ?? '' }}</a></h2>
                            </div>
                        </li>
                        @empty
                        <li style="padding:15px;color:#666;">{{ __('common.no_items_short') }}</li>
                        @endforelse
                    </ul>
                </li>
                <li class="more"><a href="{{ url('/dat-ban') }}">{{ __('common.view_all') }} →</a></li>
            </ul>
        </div>

        <div class="line-2"></div>

        {{-- Mặt bằng cho thuê mới nhất (full width) --}}
        <div class="homebox homebox-full">
            <div class="lepro">
                <ul>
                    <li class="title"><span>{{ __('common.section_latest_premises') }}</span></li>
                    <li>
                        <ul>
                            @forelse($latestPremises ?? [] as $item)
                            <li>
                                <h2><a href="{{ $item['url'] ?? '#' }}">{{ $item['title'] ?? '' }}</a></h2>
                                <div class="lecon">
                                    <div class="thumb" style="background:#e0e0e0; min-height:120px; width:30%; float:left; margin-right:15px; @if(!empty($item['image'])) background-image:url('{{ $item['image'] }}'); background-size:cover; @endif"></div>
                                    <div class="info">
                                        <p>{{ __('common.area_label') }}: {{ $item['area'] ?? '—' }} | {{ __('common.location_label') }}: {{ $item['location'] ?? '—' }}</p>
                                        <p><strong>{{ $item['price'] ?? __('common.contact_price') }}</strong></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                            @empty
                            <li style="padding:15px;color:#666;">{{ __('common.no_items_short') }}</li>
                            @endforelse
                        </ul>
                    </li>
                    <li class="more"><a href="{{ url('/cho-thue-mat-bang') }}">{{ __('common.view_all') }} →</a></li>
                </ul>
            </div>
        </div>

        {{-- Cho thuê xem nhiều | Chuyển nhượng xem nhiều --}}
        <div class="readbox">
            <div class="releft">
                <div class="refeatured"><span>{{ __('common.section_top_rent') }}</span></div>
                <div class="rebox">
                    @forelse($topRent ?? [] as $item)
                    <div class="retitle"><a href="{{ $item['url'] ?? '#' }}">{{ $item['title'] ?? '' }}</a></div>
                    @empty
                    <p style="color:#666;font-size:13px;">{{ __('common.no_items_short') }}</p>
                    @endforelse
                </div>
            </div>
            <div class="reright">
                <div class="refeatured"><span>{{ __('common.section_top_transfer') }}</span></div>
                <div class="rebox">
                    @forelse($topTransfer ?? [] as $item)
                    <div class="retitle"><a href="{{ $item['url'] ?? '#' }}">{{ $item['title'] ?? '' }}</a></div>
                    @empty
                    <p style="color:#666;font-size:13px;">{{ __('common.no_items_short') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
