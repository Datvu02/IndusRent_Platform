@extends('admin.layouts.app')

@section('title', 'Thêm Slider')

@section('content')
<div class="admin-card">
    <h3 class="admin-card-title">Thêm Slider mới</h3>

    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:bold;margin-bottom:6px;">
                <i class="fas fa-image"></i> Hình ảnh Slider <span style="color:red;">*</span>
            </label>
            <input type="file" name="image" accept="image/*" required class="form-control" style="max-width:600px;">
            <small style="color:#666;">Định dạng: JPG, PNG, GIF, WebP. Tối đa 2MB. Kích thước đề xuất: 1200x400px</small>
            @error('image')
                <div style="color:red;font-size:12px;margin-top:4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:bold;margin-bottom:6px;">Tiêu đề (Tiếng Việt) <span style="color:red;">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" required class="txtbox100" style="width:100%;max-width:600px;padding:8px;">
            @error('title')
                <div style="color:red;font-size:12px;margin-top:4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:bold;margin-bottom:6px;">Mô tả (Tiếng Việt)</label>
            <textarea name="description" rows="3" class="form-control" style="width:100%;max-width:600px;">{{ old('description') }}</textarea>
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:bold;margin-bottom:6px;">Tiêu đề (English)</label>
            <input type="text" name="title_en" value="{{ old('title_en') }}" class="txtbox100" style="width:100%;max-width:600px;padding:8px;">
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:bold;margin-bottom:6px;">Mô tả (English)</label>
            <textarea name="description_en" rows="3" class="form-control" style="width:100%;max-width:600px;">{{ old('description_en') }}</textarea>
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:bold;margin-bottom:6px;">Tiêu đề (中文)</label>
            <input type="text" name="title_zh" value="{{ old('title_zh') }}" class="txtbox100" style="width:100%;max-width:600px;padding:8px;">
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:bold;margin-bottom:6px;">Mô tả (中文)</label>
            <textarea name="description_zh" rows="3" class="form-control" style="width:100%;max-width:600px;">{{ old('description_zh') }}</textarea>
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:bold;margin-bottom:6px;">
                <i class="fas fa-link"></i> Link (URL khi click vào slider)
            </label>
            <input type="url" name="link" value="{{ old('link') }}" placeholder="https://example.com" class="txtbox100" style="width:100%;max-width:600px;padding:8px;">
            <small style="color:#666;">Để trống nếu không cần link</small>
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:bold;margin-bottom:6px;">Thứ tự hiển thị</label>
            <input type="number" name="order" value="{{ old('order', 0) }}" min="0" class="form-control" style="width:150px;padding:8px;">
            <small style="color:#666;">Số nhỏ hơn sẽ hiển thị trước</small>
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:inline-flex;align-items:center;cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="margin-right:8px;">
                <strong>Hiển thị slider này</strong>
            </label>
        </div>

        <div>
            <button type="submit" class="admin-btn admin-btn-primary">Lưu Slider</button>
            <a href="{{ route('admin.sliders.index') }}" class="admin-btn admin-btn-secondary" style="margin-left:10px;">Quay lại</a>
        </div>
    </form>
</div>
@endsection
