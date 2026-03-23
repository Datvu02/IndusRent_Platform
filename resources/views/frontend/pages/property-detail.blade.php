@extends('frontend.layouts.app')

@section('title', $property->title_translated)

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
                    <div style="margin:15px 0;">
                        <img src="{{ asset('storage/'.$property->main_image) }}" alt="{{ $property->title_translated }}" style="max-width:100%;height:auto;border-radius:8px;">
                    </div>
                @endif
                
                @if(!empty($property->gallery) && is_array($property->gallery))
                    <div style="margin:15px 0;">
                        <h3 style="font-size:16px;margin-bottom:10px;color:#263548;">{{ __('common.gallery') ?? 'Thư viện ảnh' }}</h3>
                        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:10px;">
                            @foreach($property->gallery as $image)
                                <img src="{{ asset('storage/'.$image) }}" alt="Gallery" style="width:100%;height:150px;object-fit:cover;border-radius:8px;">
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
