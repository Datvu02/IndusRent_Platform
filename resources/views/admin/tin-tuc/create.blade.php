@extends('admin.layouts.app')

@section('title', 'Thêm tin tức')
@section('admin-title', 'Thêm tin tức')

@section('content')
<div class="admin-breadcrumb">
    <a href="{{ url('/admin') }}">Admin</a> <span>/</span> <a href="{{ route('admin.tin-tuc.index') }}">Tin tức</a> <span>/</span> <span>Thêm tin</span>
</div>

<div class="admin-box">
    <div class="box-header">Thêm tin tức</div>
    <div class="box-body">
        @if ($errors->any())
            <div class="admin-alert admin-alert-info" style="margin-bottom:16px;">
                <ul style="margin:0;padding-left:20px;">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.tin-tuc.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Tiêu đề <span style="color:red;">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" class="txtbox100" style="width:100%;max-width:600px;padding:8px;" required>
                @include('admin.partials.auto-translate-note')
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Slug (để trống sẽ tự tạo từ tiêu đề)</label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="txtbox100" style="width:100%;max-width:600px;padding:8px;" placeholder="vd: bai-viet-tin-tuc">
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">
                    <i class="fas fa-image"></i> Ảnh đại diện
                </label>
                <input type="file" name="featured_image" accept="image/*" class="form-control" style="max-width:600px;">
                <small style="color:#666;">Định dạng: JPG, PNG, GIF, WebP. Tối đa 2MB</small>
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Nội dung</label>
                <textarea name="content" class="tinymce-editor">{{ old('content') }}</textarea>
                @include('admin.partials.auto-translate-note')
            </div>
            <div>
                <button type="submit" class="admin-btn admin-btn-primary">Lưu tin</button>
                <a href="{{ route('admin.tin-tuc.index') }}" class="admin-btn admin-btn-secondary" style="margin-left:10px;">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection
