@extends('frontend.layouts.app')

@section('title', __('menu.news'))

@section('content')
<div id="content" class="content">
    <div class="listbox">
        <div class="left">
            <div id="navi">
                <div class="navibox">
                    <a href="{{ url('/') }}">{{ __('menu.home') }}</a> &nbsp;/&nbsp; 
                    <span>{{ __('menu.news') }}</span>
                </div>
            </div>
            
            <div class="lasted">
                <span>{{ __('menu.news') }}</span>
            </div>
            
            <div class="news-list" style="margin-top:20px;">
                @forelse($news as $article)
                <div class="news-item" style="margin-bottom:25px;padding-bottom:25px;border-bottom:1px solid #e0e0e0;">
                    <div style="display:flex;gap:20px;align-items:flex-start;">
                        @if($article->featured_image)
                        <div style="flex:0 0 200px;">
                            <a href="{{ url('/tin-tuc/' . $article->slug) }}">
                                <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                     alt="{{ $article->title_translated }}" 
                                     style="width:100%;height:140px;object-fit:cover;border-radius:8px;">
                            </a>
                        </div>
                        @endif
                        
                        <div style="flex:1;">
                            <h3 style="margin:0 0 10px;font-size:18px;line-height:1.4;">
                                <a href="{{ url('/tin-tuc/' . $article->slug) }}" 
                                   style="color:#263548;font-weight:bold;">
                                    {{ $article->title_translated }}
                                </a>
                            </h3>
                            
                            <p style="color:#666;font-size:12px;margin-bottom:10px;">
                                <i class="far fa-clock"></i> 
                                {{ $article->updated_at?->format('d/m/Y H:i') ?? $article->created_at?->format('d/m/Y H:i') }}
                            </p>
                            
                            @php
                                $content = $article->content_translated ?? $article->content;
                                $plainText = strip_tags($content);
                                $excerpt = Str::limit($plainText, 200);
                            @endphp
                            
                            <p style="color:#666;line-height:1.7;margin-bottom:10px;">
                                {{ $excerpt }}
                            </p>
                            
                            <a href="{{ url('/tin-tuc/' . $article->slug) }}" 
                               style="color:#D4AF37;font-weight:500;">
                                {{ __('common.view_detail') ?? 'Xem chi tiết' }} →
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <p style="color:#666;padding:40px 0;text-align:center;">
                    {{ __('common.no_items') ?? 'Chưa có tin tức nào' }}
                </p>
                @endforelse
            </div>
            
            @if($news->hasPages())
            <div class="pagination" style="margin-top:30px;text-align:center;">
                <div style="display:inline-flex;gap:5px;align-items:center;">
                    @if ($news->onFirstPage())
                        <span style="padding:8px 12px;border:1px solid #ddd;border-radius:4px;color:#999;">‹</span>
                    @else
                        <a href="{{ $news->previousPageUrl() }}" 
                           style="padding:8px 12px;border:1px solid #ddd;border-radius:4px;color:#333;">‹</a>
                    @endif

                    @foreach(range(1, $news->lastPage()) as $page)
                        @if($page == $news->currentPage())
                            <span style="padding:8px 12px;background:#D4AF37;color:#fff;border:1px solid #D4AF37;border-radius:4px;font-weight:bold;">{{ $page }}</span>
                        @else
                            <a href="{{ $news->url($page) }}" 
                               style="padding:8px 12px;border:1px solid #ddd;border-radius:4px;color:#333;">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($news->hasMorePages())
                        <a href="{{ $news->nextPageUrl() }}" 
                           style="padding:8px 12px;border:1px solid #ddd;border-radius:4px;color:#333;">›</a>
                    @else
                        <span style="padding:8px 12px;border:1px solid #ddd;border-radius:4px;color:#999;">›</span>
                    @endif
                </div>
            </div>
            @endif
        </div>
        
        @include('frontend.partials.sidebar-inner')
        <div class="clearfix"></div>
    </div>
</div>
@endsection
