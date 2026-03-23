@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('admin-title', 'Dashboard')

@section('content')
<div class="admin-breadcrumb">
    <a href="{{ url('/admin') }}">Admin</a> <span>/</span> <span>Dashboard</span>
</div>

<div class="admin-cards">
    <a href="{{ route('admin.tin-dang.index') }}">
        <div class="admin-card">
            <div class="card-value">{{ $propertyCount ?? 0 }}</div>
            <div class="card-label">Tin đăng BĐS</div>
        </div>
    </a>
    <a href="{{ route('admin.tin-tuc.index') }}">
        <div class="admin-card">
            <div class="card-value">{{ $newsCount ?? 0 }}</div>
            <div class="card-label">Tin tức</div>
        </div>
    </a>
    <a href="{{ route('admin.lien-he.index') }}">
        <div class="admin-card">
            <div class="card-value">{{ $contactCount ?? 0 }}</div>
            <div class="card-label">Liên hệ</div>
        </div>
    </a>
    <a href="{{ route('admin.noi-dung-yeu-cau.index') }}">
        <div class="admin-card">
            <div class="card-value">{{ $requestCount ?? 0 }}</div>
            <div class="card-label">Nội dung yêu cầu</div>
        </div>
    </a>
</div>

<div class="admin-box">
    <div class="box-header">Hoạt động gần đây</div>
    <div class="box-body">
        <p style="color:#666;">Thống kê từ database. Liên hệ và Nội dung yêu cầu từ form frontend; Tin đăng và Tin tức quản lý tại menu bên trái.</p>
    </div>
</div>
@endsection
