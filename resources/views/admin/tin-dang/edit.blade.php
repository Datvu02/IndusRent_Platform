@extends('admin.layouts.app')

@section('title', 'Sửa tin đăng')
@section('admin-title', 'Sửa tin đăng')

@section('content')
<div class="admin-breadcrumb">
    <a href="{{ url('/admin') }}">Admin</a> <span>/</span> <a href="{{ route('admin.tin-dang.index') }}">Tin đăng</a> <span>/</span> <span>Sửa</span>
</div>

<div class="admin-box">
    <div class="box-header">Sửa tin đăng</div>
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

        <form action="{{ route('admin.tin-dang.update', $property) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Tiêu đề <span style="color:red;">*</span></label>
                <input type="text" name="title" value="{{ old('title', $property->title) }}" style="width:100%;max-width:600px;padding:8px;" required>
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $property->slug) }}" style="width:100%;max-width:600px;padding:8px;">
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Loại BĐS <span style="color:red;">*</span></label>
                <select name="type_id" required style="padding:8px;min-width:250px;">
                    @foreach($types as $t)
                        <option value="{{ $t->id }}" {{ old('type_id', $property->type_id) == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div style="margin-bottom:16px;padding:16px;background:#f0f8ff;border-radius:8px;border:1px solid #D4AF37;">
                <h4 style="color:#1a3a52;margin-bottom:12px;">📍 Chọn Khu vực</h4>
                
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
                    <div>
                        <label style="display:block;font-weight:bold;margin-bottom:6px;">Tỉnh/Thành phố</label>
                        <select id="province-select" 
                                data-selected="{{ old('_province', $property->location?->province) }}"
                                style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;">
                            <option value="">-- Chọn tỉnh --</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display:block;font-weight:bold;margin-bottom:6px;">Quận/Huyện</label>
                        <select id="district-select" 
                                data-selected="{{ old('_district', $property->location?->district) }}"
                                disabled
                                style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;">
                            <option value="">-- Chọn quận --</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display:block;font-weight:bold;margin-bottom:6px;">Phường/Xã</label>
                        <select id="ward-select" 
                                name="location_id"
                                data-selected="{{ old('location_id', $property->location_id) }}"
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

            @include('admin.partials.property-map-picker', ['lat' => old('latitude', $property->latitude), 'lng' => old('longitude', $property->longitude)])
            
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Giá (VNĐ)</label>
                <input type="number" name="price" value="{{ old('price', $property->price) }}" step="1000" min="0" style="width:100%;max-width:300px;padding:8px;">
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Diện tích (m²)</label>
                <input type="number" name="area" value="{{ old('area', $property->area) }}" min="0" style="width:100%;max-width:200px;padding:8px;">
            </div>
            
            <div style="margin-bottom:16px;padding:16px;background:#f8f9fa;border-radius:8px;">
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-weight:bold;margin-bottom:6px;">
                        <i class="fas fa-image"></i> Ảnh đại diện
                    </label>
                    @if($property->main_image)
                        <div style="margin-bottom:10px;">
                            <img src="{{ asset('storage/' . $property->main_image) }}" alt="Ảnh chính" style="max-width:300px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                            <p style="margin-top:8px;color:#666;font-size:14px;">Ảnh hiện tại</p>
                        </div>
                    @endif
                    <input type="file" name="main_image" accept="image/*" class="form-control" style="max-width:600px;">
                    <small style="color:#666;">JPG, PNG, WebP. Tối đa 2MB. Để trống nếu không đổi.</small>
                </div>
                
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-weight:bold;margin-bottom:6px;">
                        <i class="fas fa-images"></i> Ảnh thư viện
                    </label>
                    @if($property->gallery && count($property->gallery) > 0)
                        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:10px;">
                            @foreach($property->gallery as $img)
                                <img src="{{ asset('storage/' . $img) }}" alt="Gallery" style="max-width:150px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                            @endforeach
                        </div>
                        <p style="color:#666;font-size:14px;margin-bottom:10px;">{{ count($property->gallery) }} ảnh hiện tại</p>
                    @endif
                    <input type="file" name="gallery[]" accept="image/*" multiple class="form-control" style="max-width:600px;">
                    <small style="color:#666;">Chọn thêm ảnh mới (ảnh cũ sẽ được giữ lại)</small>
                </div>
            </div>
            
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:bold;margin-bottom:6px;">Mô tả</label>
                <textarea name="description" class="tinymce-editor">{{ old('description', $property->description) }}</textarea>
                <small style="color:#28a745;display:block;margin-top:6px;">
                    <i class="fas fa-language"></i> Hệ thống sẽ tự động dịch sang English và 中文 khi lưu.
                </small>
            </div>
            <div style="margin-bottom:16px;">
                <label style="margin-right:20px;"><input type="checkbox" name="is_published" value="1" {{ old('is_published', $property->is_published) ? 'checked' : '' }}> Đăng lên trang chủ</label>
                <label><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $property->is_featured) ? 'checked' : '' }}> Tin nổi bật</label>
            </div>
            <div>
                <button type="submit" class="admin-btn admin-btn-primary">Cập nhật</button>
                <a href="{{ route('admin.tin-dang.index') }}" class="admin-btn admin-btn-secondary" style="margin-left:10px;">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection
