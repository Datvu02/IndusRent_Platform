@extends('admin.layouts.app')

@section('title', 'Liên hệ')
@section('admin-title', 'Liên hệ')

@section('content')
<div class="admin-breadcrumb">
    <a href="{{ url('/admin') }}">Admin</a> <span>/</span> <span>Liên hệ</span>
</div>

<div class="admin-filter">
    <div class="admin-filter-header" onclick="toggleFilter('inquiry-filter')">
        <div class="admin-filter-title">
            <i class="fas fa-filter"></i>
            <span>Bộ lọc</span>
            @if(request()->hasAny(['search', 'date_from', 'date_to']))
                <span class="admin-filter-active-count">{{ collect(request()->only(['search', 'date_from', 'date_to']))->filter()->count() }}</span>
            @endif
        </div>
        <i class="fas fa-chevron-down admin-filter-toggle {{ request()->hasAny(['search', 'date_from', 'date_to']) ? 'active' : '' }}" id="inquiry-filter-icon"></i>
    </div>
    <div class="admin-filter-body {{ request()->hasAny(['search', 'date_from', 'date_to']) ? 'show' : '' }}" id="inquiry-filter">
        <form method="GET" action="{{ route('admin.lien-he.index') }}">
            <div class="admin-filter-row">
                <div class="admin-filter-group">
                    <label class="admin-filter-label">Tìm kiếm</label>
                    <input type="text" name="search" class="admin-filter-input" placeholder="Tên, email, SĐT..." value="{{ request('search') }}">
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
                <a href="{{ route('admin.lien-he.index') }}" class="admin-filter-btn admin-filter-btn-secondary">
                    <i class="fas fa-times"></i> Xóa lọc
                </a>
            </div>
        </form>
    </div>
</div>

<div class="admin-box">
    <div class="box-header">Danh sách liên hệ từ trang Liên hệ ({{ $inquiries->total() }} kết quả)</div>
    <div class="box-body">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Họ tên</th>
                    <th>Công ty</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Ngày gửi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inquiries as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->company ?? '—' }}</td>
                    <td>{{ $item->phone ?? '—' }}</td>
                    <td>{{ $item->email ?? '—' }}</td>
                    <td>{{ $item->created_at?->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="admin-empty">
                        <p>Chưa có liên hệ nào.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($inquiries->hasPages())
            <div style="margin-top:16px;">{{ $inquiries->links() }}</div>
        @endif
    </div>
</div>
@endsection
