{{-- Top bar admin: tiêu đề trang + link ra site + user --}}
<header class="admin-header">
    <h2>@yield('title', 'Dashboard')</h2>
    <div style="display:flex;align-items:center;gap:15px;">
        <a href="{{ url('/') }}" target="_blank" style="color:#666;text-decoration:none;font-size:14px;">
            🌐 Xem trang chủ
        </a>
        @auth('admin')
        <div style="display:flex;align-items:center;gap:10px;">
            <span style="color:#1a3a52;font-weight:600;font-size:14px;">
                👤 {{ Auth::guard('admin')->user()->name }}
            </span>
            <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="background:#dc3545;color:#fff;border:none;padding:6px 16px;border-radius:6px;cursor:pointer;font-size:13px;font-weight:500;">
                    Đăng xuất
                </button>
            </form>
        </div>
        @endauth
    </div>
</header>
