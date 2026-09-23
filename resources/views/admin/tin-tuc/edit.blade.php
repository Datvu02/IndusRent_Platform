@extends('admin.layouts.app')

@section('title', 'Sửa tin tức')
@section('admin-title', 'Sửa tin tức')

@section('content')
<div class="admin-breadcrumb">
    <a href="{{ url('/admin') }}">Admin</a> <span>/</span> <a href="{{ route('admin.tin-tuc.index') }}">Tin tức</a> <span>/</span> <span>Sửa</span>
</div>

<div class="admin-box">
    <div class="box-header">Sửa tin tức</div>
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

        <form action="{{ route('admin.tin-tuc.update', $article) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Tiêu đề <span style="color:red;">*</span></label>
                <input type="text" name="title" value="{{ old('title', $article->title) }}" class="txtbox100" style="width:100%;max-width:600px;padding:8px;" required>
                @include('admin.partials.auto-translate-note')
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Slug (để trống sẽ tự tạo từ tiêu đề)</label>
                <input type="text" name="slug" value="{{ old('slug', $article->slug) }}" class="txtbox100" style="width:100%;max-width:600px;padding:8px;">
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">
                    <i class="fas fa-image"></i> Ảnh đại diện
                </label>
                @if($article->featured_image)
                    <div style="margin-bottom:10px;">
                        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="Ảnh hiện tại" style="max-width:300px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                        <p style="margin-top:8px;color:#666;font-size:14px;">Ảnh hiện tại</p>
                    </div>
                @endif
                <input type="file" name="featured_image" accept="image/*" class="form-control" style="max-width:600px;">
                <small style="color:#666;">Định dạng: JPG, PNG, GIF, WebP. Tối đa 2MB. Để trống nếu không muốn đổi ảnh.</small>
            </div>
            
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Nội dung</label>
                <textarea name="content" class="tinymce-editor">{{ old('content', $article->content) }}</textarea>
                @include('admin.partials.auto-translate-note')
            </div>
            <div>
                <button type="submit" class="admin-btn admin-btn-primary">Cập nhật</button>
                <a href="{{ route('admin.tin-tuc.index') }}" class="admin-btn admin-btn-secondary" style="margin-left:10px;">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection
