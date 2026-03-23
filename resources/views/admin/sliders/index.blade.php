@extends('admin.layouts.app')

@section('title', 'Quản lý Slider')

@section('content')
<div class="admin-filter">
    <div class="admin-filter-header" onclick="toggleFilter('slider-filter')">
        <div class="admin-filter-title">
            <i class="fas fa-filter"></i>
            <span>Bộ lọc</span>
            @if(request()->hasAny(['search', 'status']))
                <span class="admin-filter-active-count">{{ collect(request()->only(['search', 'status']))->filter()->count() }}</span>
            @endif
        </div>
        <i class="fas fa-chevron-down admin-filter-toggle {{ request()->hasAny(['search', 'status']) ? 'active' : '' }}" id="slider-filter-icon"></i>
    </div>
    <div class="admin-filter-body {{ request()->hasAny(['search', 'status']) ? 'show' : '' }}" id="slider-filter">
        <form method="GET" action="{{ route('admin.sliders.index') }}">
            <div class="admin-filter-row">
                <div class="admin-filter-group">
                    <label class="admin-filter-label">Tìm kiếm</label>
                    <input type="text" name="search" class="admin-filter-input" placeholder="Nhập tiêu đề..." value="{{ request('search') }}">
                </div>
                <div class="admin-filter-group">
                    <label class="admin-filter-label">Trạng thái</label>
                    <select name="status" class="admin-filter-select">
                        <option value="">Tất cả</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Hiển thị</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Ẩn</option>
                    </select>
                </div>
            </div>
            <div class="admin-filter-actions">
                <button type="submit" class="admin-filter-btn admin-filter-btn-primary">
                    <i class="fas fa-search"></i> Lọc
                </button>
                <a href="{{ route('admin.sliders.index') }}" class="admin-filter-btn admin-filter-btn-secondary">
                    <i class="fas fa-times"></i> Xóa lọc
                </a>
            </div>
        </form>
    </div>
</div>

<div class="admin-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <h3 class="admin-card-title">Quản lý Slider quảng cáo ({{ $sliders->count() }} kết quả)</h3>
        <a href="{{ route('admin.sliders.create') }}" class="admin-btn admin-btn-primary">
            <i class="fas fa-plus"></i> Thêm Slider mới
        </a>
    </div>

    @if($sliders->isEmpty())
        <p style="color:#666;padding:40px;text-align:center;">
            Chưa có slider nào. <a href="{{ route('admin.sliders.create') }}">Thêm slider đầu tiên</a>
        </p>
    @else
        <div style="overflow-x:auto;">
            <table class="admin-table admin-table-sliders">
                <colgroup>
                    <col style="width:100px;">
                    <col>
                    <col style="width:70px;">
                    <col style="width:100px;">
                    <col style="width:130px;">
                </colgroup>
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tiêu đề</th>
                        <th style="text-align:center;">Thứ tự</th>
                        <th style="text-align:center;">Trạng thái</th>
                        <th style="text-align:center;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sliders as $slider)
                    <tr>
                        <td style="width:100px;padding:8px;vertical-align:middle;">
                            @if($slider->image)
                                <img src="{{ asset('storage/' . $slider->image) }}" 
                                     alt="{{ $slider->title }}" 
                                     style="width:90px;height:50px;object-fit:cover;border-radius:4px;display:block;">
                            @else
                                <div style="width:90px;height:50px;background:#e0e0e0;border-radius:4px;"></div>
                            @endif
                        </td>
                        <td style="vertical-align:middle;">
                            <strong>{{ $slider->title }}</strong>
                            @if($slider->link)
                                <br><small style="color:#666;">
                                    <i class="fas fa-link"></i> {{ Str::limit($slider->link, 50) }}
                                </small>
                            @endif
                        </td>
                        <td style="text-align:center;width:70px;vertical-align:middle;">
                            <span style="background:#f0f0f0;padding:4px 8px;border-radius:12px;font-weight:bold;font-size:13px;">
                                {{ $slider->order }}
                            </span>
                        </td>
                        <td style="text-align:center;width:100px;vertical-align:middle;">
                            @if($slider->is_active)
                                <span style="background:#d4edda;color:#155724;padding:4px 8px;border-radius:12px;font-size:12px;">
                                    ✓ Hiển thị
                                </span>
                            @else
                                <span style="background:#f8d7da;color:#721c24;padding:4px 8px;border-radius:12px;font-size:12px;">
                                    ✕ Ẩn
                                </span>
                            @endif
                        </td>
                        <td style="text-align:center;width:130px;vertical-align:middle;white-space:nowrap;">
                            <a href="{{ route('admin.sliders.edit', $slider) }}" 
                               class="admin-btn admin-btn-secondary" 
                               style="font-size:12px;padding:6px 10px;">
                                Sửa
                            </a>
                            <form action="{{ route('admin.sliders.destroy', $slider) }}" 
                                  method="POST" 
                                  style="display:inline;" 
                                  onsubmit="return confirm('Xóa slider này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="admin-btn admin-btn-danger" 
                                        style="font-size:12px;padding:6px 10px;">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<div class="admin-card" style="margin-top:20px;background:#f8f9fa;">
    <h4 style="color:#1a3a52;margin-bottom:10px;">💡 Hướng dẫn</h4>
    <ul style="color:#666;line-height:1.8;padding-left:20px;">
        <li><strong>Thứ tự</strong>: Slider có số thứ tự nhỏ hơn sẽ hiển thị trước</li>
        <li><strong>Trạng thái</strong>: Chỉ các slider "Hiển thị" mới xuất hiện trên trang chủ</li>
        <li><strong>Link</strong>: URL để chuyển trang khi click vào slider (tùy chọn)</li>
        <li><strong>Kích thước ảnh đề xuất</strong>: 1200x400px hoặc 1920x600px</li>
    </ul>
</div>
@endsection
