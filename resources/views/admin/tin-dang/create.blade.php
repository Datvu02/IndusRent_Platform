@extends('admin.layouts.app')

@section('title', 'Thêm tin đăng')
@section('admin-title', 'Thêm tin đăng')

@section('content')
<div class="admin-breadcrumb">
    <a href="{{ url('/admin') }}">Admin</a> <span>/</span> <a href="{{ route('admin.tin-dang.index') }}">Tin đăng</a> <span>/</span> <span>Thêm tin</span>
</div>

<div class="admin-box">
    <div class="box-header">Thêm tin đăng BĐS</div>
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

        <form action="{{ route('admin.tin-dang.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Tiêu đề <span style="color:red;">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" style="width:100%;max-width:600px;padding:8px;" required>
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Slug (để trống tự tạo từ tiêu đề)</label>
                <input type="text" name="slug" value="{{ old('slug') }}" style="width:100%;max-width:600px;padding:8px;">
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Loại BĐS <span style="color:red;">*</span></label>
                <select name="type_id" required style="padding:8px;min-width:250px;">
                    @foreach($types as $t)
                        <option value="{{ $t->id }}" {{ old('type_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div style="margin-bottom:16px;padding:16px;background:#f0f8ff;border-radius:8px;border:1px solid #D4AF37;">
                <h4 style="color:#1a3a52;margin-bottom:12px;">📍 Chọn Khu vực</h4>
                
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
                    <div>
                        <label style="display:block;font-weight:bold;margin-bottom:6px;">Tỉnh/Thành phố</label>
                        <select id="province-select" 
                                data-selected="{{ old('_province') }}"
                                style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;">
                            <option value="">-- Chọn tỉnh --</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display:block;font-weight:bold;margin-bottom:6px;">Quận/Huyện</label>
                        <select id="district-select" 
                                data-selected="{{ old('_district') }}"
                                disabled
                                style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;">
                            <option value="">-- Chọn quận --</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display:block;font-weight:bold;margin-bottom:6px;">Phường/Xã</label>
                        <select id="ward-select" 
                                name="location_id"
                                data-selected="{{ old('location_id') }}"
                                disabled
                                required
                                style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;">
                            <option value="">-- Chọn phường/xã --</option>
                        </select>
                    </div>
                </div>
                
                <input type="hidden" id="location_id">
                <small style="color:#666;display:block;margin-top:8px;">
                    💡 Chọn lần lượt: Tỉnh → Quận → Phường/Xã
                </small>
            </div>
            
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Giá (VNĐ, để trống = Liên hệ)</label>
                <input type="number" name="price" value="{{ old('price') }}" step="1000" min="0" style="width:100%;max-width:300px;padding:8px;">
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Diện tích (m²)</label>
                <input type="number" name="area" value="{{ old('area') }}" min="0" style="width:100%;max-width:200px;padding:8px;">
            </div>
            
            <div style="margin-bottom:16px;padding:16px;background:#f8f9fa;border-radius:8px;">
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-weight:bold;margin-bottom:6px;">
                        <i class="fas fa-image"></i> Ảnh đại diện
                    </label>
                    <input type="file" name="main_image" accept="image/*" class="form-control" style="max-width:600px;">
                    <small style="color:#666;">JPG, PNG, WebP. Tối đa 2MB</small>
                </div>
                
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-weight:bold;margin-bottom:6px;">
                        <i class="fas fa-images"></i> Ảnh thư viện (nhiều ảnh)
                    </label>
                    <input type="file" name="gallery[]" accept="image/*" multiple class="form-control" style="max-width:600px;">
                    <small style="color:#666;">Chọn nhiều ảnh cùng lúc. JPG, PNG, WebP. Mỗi ảnh tối đa 2MB</small>
                </div>
            </div>
            
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Mô tả (Tiếng Việt)</label>
                <textarea name="description" class="tinymce-editor">{{ old('description') }}</textarea>
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Tiêu đề (Tiếng Anh) – tùy chọn</label>
                <input type="text" name="title_en" value="{{ old('title_en') }}" style="width:100%;max-width:600px;padding:8px;">
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Mô tả (Tiếng Anh) – tùy chọn</label>
                <textarea name="description_en" class="tinymce-editor">{{ old('description_en') }}</textarea>
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Tiêu đề (中文) – tùy chọn</label>
                <input type="text" name="title_zh" value="{{ old('title_zh') }}" style="width:100%;max-width:600px;padding:8px;">
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Mô tả (中文) – tùy chọn</label>
                <textarea name="description_zh" class="tinymce-editor">{{ old('description_zh') }}</textarea>
            </div>
            <div style="margin-bottom:16px;">
                <label style="margin-right:20px;"><input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}> Đăng lên trang chủ</label>
                <label><input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}> Tin nổi bật</label>
            </div>
            <div>
                <button type="submit" class="admin-btn admin-btn-primary">Lưu tin</button>
                <a href="{{ route('admin.tin-dang.index') }}" class="admin-btn admin-btn-secondary" style="margin-left:10px;">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection
