{{-- Sidebar menu admin - phong cách chothuexuong/IndusRent --}}
<aside class="admin-sidebar">
    <div class="brand">
        <a href="{{ url('/admin') }}">IndusRent Admin</a>
    </div>
    <div class="nav-title">Tổng quan</div>
    <nav class="nav">
        <a href="{{ url('/admin') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
    </nav>
    <div class="nav-title">Quản lý nội dung</div>
    <nav class="nav">
        <a href="{{ url('/admin/sliders') }}" class="{{ request()->segment(2) == 'sliders' ? 'active' : '' }}">Slider quảng cáo</a>
        <a href="{{ url('/admin/tin-dang') }}" class="{{ request()->segment(2) == 'tin-dang' ? 'active' : '' }}">Tin đăng BĐS</a>
        <a href="{{ url('/admin/tin-tuc') }}" class="{{ request()->segment(2) == 'tin-tuc' ? 'active' : '' }}">Tin tức</a>
    </nav>
    <div class="nav-title">Liên hệ & Yêu cầu</div>
    <nav class="nav">
        <a href="{{ url('/admin/lien-he') }}" class="{{ request()->segment(2) == 'lien-he' ? 'active' : '' }}">Liên hệ</a>
        <a href="{{ url('/admin/noi-dung-yeu-cau') }}" class="{{ request()->segment(2) == 'noi-dung-yeu-cau' ? 'active' : '' }}">Nội dung yêu cầu</a>
    </nav>
    <div class="nav-title">Hệ thống</div>
    <nav class="nav">
        <a href="{{ url('/admin/cai-dat') }}" class="{{ request()->segment(2) == 'cai-dat' ? 'active' : '' }}">Cài đặt</a>
    </nav>
</aside>
