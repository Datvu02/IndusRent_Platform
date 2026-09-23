{{-- Sidebar: form tìm kiếm + tin nổi bật từ DB --}}
<div class="right">
    <form action="{{ url('/tim-kiem') }}" method="get" class="sbox" style="padding: 15px 5% 25px 5%;">
        <input name="se" type="hidden" value="true">
        <input type="hidden" name="_province" id="sidebar_province" value="{{ request('_province') }}">
        <input type="hidden" name="_district" id="sidebar_district" value="{{ request('_district') }}">
        <div class="contitle">{{ __('common.search') }}:</div>
        <div>
            <select name="trans">
                <option value="1" {{ request('trans', '1') == '1' ? 'selected' : '' }}>{{ __('common.rent') }}</option>
                <option value="2" {{ request('trans') == '2' ? 'selected' : '' }}>{{ __('common.sale') }}</option>
            </select>
        </div>
        <div>
            <select name="mnu">
                <option value="" {{ request('mnu') ? '' : 'selected' }}>{{ __('common.select_category') }}</option>
                @foreach($propertyTypes ?? [] as $t)
                    <option value="{{ $t->id }}" {{ (string)request('mnu') === (string)$t->id ? 'selected' : '' }}>{{ $t->name_translated }}</option>
                @endforeach
            </select>
        </div>
        <div><select id="province-select" data-selected="{{ request('_province') }}"><option value="">{{ __('common.select_city') }}</option></select></div>
        <div><select id="district-select" disabled data-selected="{{ request('_district') }}"><option value="">{{ __('common.select_district') }}</option></select></div>
        <div><select id="ward-select" name="location_id" disabled data-selected="{{ request('location_id') }}"><option value="">{{ __('common.select_ward') }}</option></select></div>
        <div>
            <select name="area">
                <option value="0^0" {{ request('area') ? '' : 'selected' }}>{{ __('common.select_area') }}</option>
                <option value="100^500" {{ request('area') == '100^500' ? 'selected' : '' }}>{{ __('common.area_range_100_500') }}</option>
                <option value="500^1000" {{ request('area') == '500^1000' ? 'selected' : '' }}>{{ __('common.area_range_500_1000') }}</option>
                <option value="1000^2000" {{ request('area') == '1000^2000' ? 'selected' : '' }}>{{ __('common.area_range_1000_2000') }}</option>
                <option value="2000^5000" {{ request('area') == '2000^5000' ? 'selected' : '' }}>{{ __('common.area_range_2000_5000') }}</option>
            </select>
        </div>
        <div>
            <select name="price">
                <option value="0^0" {{ request('price') ? '' : 'selected' }}>{{ __('common.select_price_range') }}</option>
                <option value="1000^3000" {{ request('price') == '1000^3000' ? 'selected' : '' }}>{{ __('common.price_range_1') }}</option>
                <option value="3000^5000" {{ request('price') == '3000^5000' ? 'selected' : '' }}>{{ __('common.price_range_2') }}</option>
                <option value="5000^7000" {{ request('price') == '5000^7000' ? 'selected' : '' }}>{{ __('common.price_range_3') }}</option>
            </select>
        </div>
        <div><input type="text" name="skey" placeholder="{{ __('common.search_placeholder') }}" value="{{ request('skey') }}"></div>
        <div class="sbtn"><input type="submit" name="btnSearch" value="{{ __('common.search') }}" class="cbtn"></div>
    </form>
    <div class="lbrfeatured"><span>{{ __('common.section_latest_warehouse') }}</span></div>
    @forelse($sidebarFeatured ?? [] as $item)
    <div class="rprobox1">
        <div class="image">
            <div class="thumb" style="height:120px;background:#e0e0e0;background-size:cover;background-position:center;@if(!empty($item['image'])) background-image:url('{{ $item['image'] }}'); @endif"></div>
            <div class="price"><span>{{ $item['price'] ?? __('common.contact_price') }}</span></div>
        </div>
        <div class="title"><a href="{{ $item['url'] ?? '#' }}">{{ $item['title'] ?? '' }}</a></div>
    </div>
    @empty
    <p style="color:#666;font-size:13px;padding:10px 0;">{{ __('common.no_items_short') }}</p>
    @endforelse
    <div class="cfeatured"><span>{{ __('common.section_transfer_land') }}</span></div>
    @forelse($sidebarTransfer ?? [] as $item)
    <div class="probox6" style="{{ $loop->first ? 'margin-left:0;' : '' }}">
        <div class="image">
            <div class="thumb" style="height:90px;background:#e0e0e0;background-size:cover;background-position:center;@if(!empty($item['image'])) background-image:url('{{ $item['image'] }}'); @endif"></div>
        </div>
        <div class="title"><a href="{{ $item['url'] ?? '#' }}">{{ $item['title'] ?? '' }}</a></div>
    </div>
    @empty
    <p style="color:#666;font-size:13px;padding:10px 0;">{{ __('common.no_items_short') }}</p>
    @endforelse
</div>
