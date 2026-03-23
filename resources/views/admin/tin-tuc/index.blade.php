@extends('admin.layouts.app')

@section('title', 'Tin tức')
@section('admin-title', 'Tin tức')

@section('content')
<div class="admin-breadcrumb">
    <a href="{{ url('/admin') }}">Admin</a> <span>/</span> <span>Tin tức</span>
</div>

<div class="admin-filter">
    <div class="admin-filter-header" onclick="toggleFilter('news-filter')">
        <div class="admin-filter-title">
            <i class="fas fa-filter"></i>
            <span>Bộ lọc</span>
            @if(request()->hasAny(['search', 'date_from', 'date_to']))
                <span class="admin-filter-active-count">{{ collect(request()->only(['search', 'date_from', 'date_to']))->filter()->count() }}</span>
            @endif
        </div>
        <i class="fas fa-chevron-down admin-filter-toggle {{ request()->hasAny(['search', 'date_from', 'date_to']) ? 'active' : '' }}" id="news-filter-icon"></i>
    </div>
    <div class="admin-filter-body {{ request()->hasAny(['search', 'date_from', 'date_to']) ? 'show' : '' }}" id="news-filter">
        <form method="GET" action="{{ route('admin.tin-tuc.index') }}">
            <div class="admin-filter-row">
                <div class="admin-filter-group">
                    <label class="admin-filter-label">Tìm kiếm</label>
                    <input type="text" name="search" class="admin-filter-input" placeholder="Nhập tiêu đề..." value="{{ request('search') }}">
                </div>
                <div class="admin-filter-group">
                    <label class="admin-filter-label">Từ ngày</label>
                    <input type="date" name="date_from" class="admin-filter-input" value="{{ request('date_from') }}">
                </div>
                <div class="admin-filter-group">
                    <label class="admin-filter-label">Đến ngày</label>
                    <input type="date" name="date_to" class="admin-filter-input" value="{{ request('date_to') }}">
                </div>
            </div>
            <div class="admin-filter-actions">
                <button type="submit" class="admin-filter-btn admin-filter-btn-primary">
                    <i class="fas fa-search"></i> Lọc
                </button>
                <a href="{{ route('admin.tin-tuc.index') }}" class="admin-filter-btn admin-filter-btn-secondary">
                    <i class="fas fa-times"></i> Xóa lọc
                </a>
            </div>
        </form>
    </div>
</div>

<div class="admin-box">
    <div class="box-header">
        <span>Danh sách tin tức ({{ $news->total() }} kết quả)</span>
        <a href="{{ route('admin.tin-tuc.create') }}" class="admin-btn admin-btn-primary">Thêm tin</a>
    </div>
    <div class="box-body">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th>Slug</th>
                    <th>Ngày cập nhật</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $item)
                <tr>
                    <td>{{ Str::limit($item->title, 50) }}</td>
                    <td>{{ $item->slug }}</td>
                    <td>{{ $item->updated_at?->format('d/m/Y H:i') }}</td>
                    <td class="actions">
                        <a href="{{ route('admin.tin-tuc.edit', $item) }}" class="btn-sm">Sửa</a>
                        <form action="{{ route('admin.tin-tuc.destroy', $item) }}" method="post" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa tin này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-sm btn-secondary">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="admin-empty">
                        <p>Chưa có tin tức nào.</p>
                        <a href="{{ route('admin.tin-tuc.create') }}" class="admin-btn admin-btn-primary">Thêm tin đầu tiên</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($news->hasPages())
            <div style="margin-top:16px;">{{ $news->links() }}</div>
        @endif
    </div>
</div>
@endsection
