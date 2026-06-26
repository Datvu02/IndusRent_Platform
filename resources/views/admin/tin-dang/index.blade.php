@extends('admin.layouts.app')

@section('title', 'Tin đăng BĐS')
@section('admin-title', 'Tin đăng BĐS')

@section('content')
<div class="admin-breadcrumb">
    <a href="{{ url('/admin') }}">Admin</a> <span>/</span> <span>Tin đăng BĐS</span>
</div>

<div class="admin-filter">
    <div class="admin-filter-header" onclick="toggleFilter('property-filter')">
        <div class="admin-filter-title">
            <i class="fas fa-filter"></i>
            <span>Bộ lọc</span>
            @if(request()->hasAny(['search', 'type_id', 'province', 'status', 'price_min', 'price_max', 'area_min', 'area_max']))
                <span class="admin-filter-active-count">{{ collect(request()->only(['search', 'type_id', 'province', 'status', 'price_min', 'price_max', 'area_min', 'area_max']))->filter()->count() }}</span>
            @endif
        </div>
        <i class="fas fa-chevron-down admin-filter-toggle {{ request()->hasAny(['search', 'type_id', 'province', 'status', 'price_min', 'price_max', 'area_min', 'area_max']) ? 'active' : '' }}" id="property-filter-icon"></i>
    </div>
    <div class="admin-filter-body {{ request()->hasAny(['search', 'type_id', 'province', 'status', 'price_min', 'price_max', 'area_min', 'area_max']) ? 'show' : '' }}" id="property-filter">
        <form method="GET" action="{{ route('admin.tin-dang.index') }}">
            <div class="admin-filter-row">
                <div class="admin-filter-group">
                    <label class="admin-filter-label">Tìm kiếm</label>
                    <input type="text" name="search" class="admin-filter-input" placeholder="Nhập tiêu đề..." value="{{ request('search') }}">
                </div>
                <div class="admin-filter-group">
                    <label class="admin-filter-label">Loại BĐS</label>
                    <select name="type_id" class="admin-filter-select">
                        <option value="">Tất cả</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ request('type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="admin-filter-group">
                    <label class="admin-filter-label">Khu vực</label>
                    <select name="province" class="admin-filter-select">
                        <option value="">Tất cả</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province }}" {{ request('province') == $province ? 'selected' : '' }}>
                                {{ $province }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="admin-filter-group">
                    <label class="admin-filter-label">Trạng thái</label>
                    <select name="status" class="admin-filter-select">
                        <option value="">Tất cả</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Đã đăng</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Nháp</option>
                    </select>
                </div>
            </div>
            <div class="admin-filter-row">
                <div class="admin-filter-group">
                    <label class="admin-filter-label">{{ __('common.price_usd') }}</label>
                    <div class="admin-filter-range">
                        <input type="number" name="price_min" class="admin-filter-input" placeholder="Từ" value="{{ request('price_min') }}" step="100" min="0">
                        <span class="admin-filter-range-separator">—</span>
                        <input type="number" name="price_max" class="admin-filter-input" placeholder="Đến" value="{{ request('price_max') }}" step="100" min="0">
                    </div>
                </div>
                <div class="admin-filter-group">
                    <label class="admin-filter-label">Diện tích (m²)</label>
                    <div class="admin-filter-range">
                        <input type="number" name="area_min" class="admin-filter-input" placeholder="Từ" value="{{ request('area_min') }}">
                        <span class="admin-filter-range-separator">—</span>
                        <input type="number" name="area_max" class="admin-filter-input" placeholder="Đến" value="{{ request('area_max') }}">
                    </div>
                </div>
            </div>
            <div class="admin-filter-actions">
                <button type="submit" class="admin-filter-btn admin-filter-btn-primary">
                    <i class="fas fa-search"></i> Lọc
                </button>
                <a href="{{ route('admin.tin-dang.index') }}" class="admin-filter-btn admin-filter-btn-secondary">
                    <i class="fas fa-times"></i> Xóa lọc
                </a>
            </div>
        </form>
    </div>
</div>

<div class="admin-box">
    <div class="box-header">
        <span>Danh sách tin đăng ({{ $properties->total() }} kết quả)</span>
        <a href="{{ route('admin.tin-dang.create') }}" class="admin-btn admin-btn-primary">Thêm tin</a>
    </div>
    <div class="box-body">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th>Nhóm</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($properties as $item)
                <tr>
                    <td>{{ Str::limit($item->title, 50) }}</td>
                    <td>{{ $item->type->name ?? '—' }}</td>
                    <td>{{ $item->formatted_price }}</td>
                    <td>{{ $item->is_published ? 'Đã đăng' : 'Nháp' }}</td>
                    <td class="actions">
                        <div class="admin-table-actions">
                            <a href="{{ route('admin.tin-dang.edit', $item) }}" class="admin-table-action admin-table-action--edit"><i class="fas fa-pen" aria-hidden="true"></i> Sửa</a>
                            <form action="{{ route('admin.tin-dang.destroy', $item) }}" method="post" onsubmit="return confirm('Bạn có chắc muốn xóa tin này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-table-action admin-table-action--delete"><i class="fas fa-trash-alt" aria-hidden="true"></i> Xóa</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="admin-empty">
                        <p>Chưa có tin đăng nào.</p>
                        <a href="{{ route('admin.tin-dang.create') }}" class="admin-btn admin-btn-primary">Thêm tin đầu tiên</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($properties->hasPages())
            <div style="margin-top:16px;">{{ $properties->links() }}</div>
        @endif
    </div>
</div>
@endsection
