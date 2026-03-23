<div id="content" class="content">
    <div class="listbox">
        <div class="left">
            <div id="navi">
                <div class="navibox"><a href="{{ url('/') }}">{{ __('menu.home') }}</a> &nbsp;/&nbsp; <a href="{{ $listingUrl }}" title="{{ $listingTitle }}">{{ $listingTitle }}</a></div>
            </div>
            <div class="lasted">
                <span>{{ $listingTitle }}</span>
                @if(isset($pagination))
                    <span style="font-size:13px;color:#666;font-weight:normal;margin-left:10px;">({{ $pagination->total() }} kết quả)</span>
                @endif
            </div>
            <div class="featured" style="margin-top:15px;">
                @forelse($items ?? [] as $item)
                <div class="probox1">
                    <div class="image">
                        <div class="thumb" style="min-height:140px;background:#e0e0e0;background-size:cover;background-position:center;@if(!empty($item['image'])) background-image:url('{{ $item['image'] }}'); @endif"></div>
                        <div class="price"><span>{{ $item['price'] ?? __('common.contact_price') }}</span> {{ $item['unit'] ?? '' }}</div>
                    </div>
                    <div class="pbright">
                        <div class="pbinfo"><p><strong><a href="{{ $item['url'] ?? '#' }}">{{ $item['title'] }}</a></strong></p><p>{{ __('common.area_label') }}: {{ $item['area'] ?? '—' }} | {{ __('common.location_label') }}: {{ $item['location'] ?? '—' }}</p></div>
                        <div class="pbdesc">{{ $item['desc'] ?? '' }}</div>
                        <p><a href="{{ $item['url'] ?? '#' }}">{{ __('common.view_detail') }} →</a></p>
                    </div>
                </div>
                @empty
                <p style="color:#666;padding:20px 0;">{{ __('common.no_items') }}</p>
                @endforelse
            </div>
            @if(isset($pagination) && $pagination->hasPages())
            <div class="pagination" style="margin-top:20px;">
                {{ $pagination->links() }}
            </div>
            @endif
        </div>
        @include('frontend.partials.sidebar-inner')
        <div class="clearfix"></div>
    </div>
</div>
