@extends('admin.layouts.app')

@section('title', 'Cài đặt')
@section('admin-title', 'Cài đặt')

@section('content')
<div class="admin-breadcrumb">
    <a href="{{ url('/admin') }}">Admin</a> <span>/</span> <span>Cài đặt</span>
</div>

<div class="admin-box">
    <div class="box-header">Cài đặt hệ thống</div>
    <div class="box-body">
        <p style="color:#666;">Phần cấu hình (hotline, email, thông tin công ty, v.v.) sẽ được thêm sau khi có bảng cài đặt trong database.</p>
    </div>
</div>
@endsection
