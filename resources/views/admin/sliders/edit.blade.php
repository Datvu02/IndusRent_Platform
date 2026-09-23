@extends('admin.layouts.app')

@section('title', 'Sửa Slider')

@section('content')
<div class="admin-card">
    <h3 class="admin-card-title">Sửa Slider</h3>

    <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:bold;margin-bottom:6px;">
                <i class="fas fa-image"></i> Hình ảnh Slider
            </label>
            @if($slider->image)
                <div style="margin-bottom:10px;">
                    <img src="{{ asset('storage/' . $slider->image) }}" alt="Ảnh hiện tại" style="max-width:400px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                    <p style="margin-top:8px;color:#666;font-size:14px;">Ảnh hiện tại</p>
                </div>
            @endif
            <input type="file" name="image" accept="image/*" class="form-control" style="max-width:600px;">
            <small style="color:#666;">Định dạng: JPG, PNG, GIF, WebP. Tối đa 2MB. Để trống nếu không muốn đổi ảnh.</small>
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:bold;margin-bottom:6px;">Tiêu đề (Tiếng Việt) <span style="color:red;">*</span></label>
            <input type="text" name="title" value="{{ old('title', $slider->title) }}" required class="txtbox100" style="width:100%;max-width:600px;padding:8px;">
            @include('admin.partials.auto-translate-note')
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:bold;margin-bottom:6px;">Mô tả</label>
            <textarea name="description" rows="3" class="form-control" style="width:100%;max-width:600px;">{{ old('description', $slider->description) }}</textarea>
            @include('admin.partials.auto-translate-note')
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:bold;margin-bottom:6px;">
                <i class="fas fa-link"></i> Link (URL khi click vào slider)
            </label>
            <input type="url" name="link" value="{{ old('link', $slider->link) }}" placeholder="https://example.com" class="txtbox100" style="width:100%;max-width:600px;padding:8px;">
            <small style="color:#666;">Để trống nếu không cần link</small>
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:bold;margin-bottom:6px;">Thứ tự hiển thị</label>
            <input type="number" name="order" value="{{ old('order', $slider->order) }}" min="0" class="form-control" style="width:150px;padding:8px;">
            <small style="color:#666;">Số nhỏ hơn sẽ hiển thị trước</small>
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:inline-flex;align-items:center;cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $slider->is_active) ? 'checked' : '' }} style="margin-right:8px;">
                <strong>Hiển thị slider này</strong>
            </label>
        </div>

        <div>
            <button type="submit" class="admin-btn admin-btn-primary">Cập nhật Slider</button>
            <a href="{{ route('admin.sliders.index') }}" class="admin-btn admin-btn-secondary" style="margin-left:10px;">Quay lại</a>
        </div>
    </form>
</div>
@endsection
