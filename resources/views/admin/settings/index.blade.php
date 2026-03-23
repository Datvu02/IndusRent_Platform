@extends("admin.layouts.app")

@section("title", "Cài đặt hệ thống")

@push("styles")
<style>
.settings-page { background: #f8f9fa; min-height: 100vh; padding: 2rem 0; }
.settings-card { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); overflow: hidden; }
.settings-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; border: none; }
.settings-header h3 { font-size: 1.5rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 0.75rem; }
.settings-header i { font-size: 1.75rem; }
.settings-body { padding: 2rem; background: white; }
.settings-tabs { border-bottom: 2px solid #e9ecef; margin-bottom: 2rem; }
.settings-tabs .nav-link { color: #6c757d; border: none; padding: 1rem 1.5rem; font-weight: 500; transition: all 0.3s ease; border-radius: 8px 8px 0 0; }
.settings-tabs .nav-link:hover { color: #667eea; background: #f8f9fa; }
.settings-tabs .nav-link.active { color: #667eea; background: transparent; border-bottom: 3px solid #667eea; }
.settings-tabs .nav-link i { margin-right: 0.5rem; font-size: 1.1rem; }
.setting-group { background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem; border-left: 4px solid #667eea; transition: all 0.3s ease; }
.setting-group:hover { box-shadow: 0 3px 15px rgba(102,126,234,0.1); transform: translateX(5px); }
.setting-group label { color: #2d3748; font-weight: 600; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem; }
.setting-group label small { font-weight: 400; color: #718096; }
.setting-group .form-control { border: 2px solid #e2e8f0; border-radius: 8px; padding: 0.75rem 1rem; transition: all 0.3s ease; }
.setting-group .form-control:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.1); }
.setting-group textarea.form-control { resize: vertical; min-height: 100px; }
.btn-save { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; color: white; padding: 0.75rem 2rem; border-radius: 8px; font-weight: 600; box-shadow: 0 4px 15px rgba(102,126,234,0.3); transition: all 0.3s ease; }
.btn-save:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102,126,234,0.4); color: white; }
.btn-cancel { background: #e2e8f0; border: none; color: #4a5568; padding: 0.75rem 2rem; border-radius: 8px; font-weight: 600; }
.alert { border: none; border-radius: 10px; padding: 1rem 1.5rem; margin-bottom: 1.5rem; }
.alert-success { background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); color: #065f46; }
.alert-danger { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: #991b1b; }
.image-preview { max-width: 200px; border-radius: 8px; margin-top: 1rem; box-shadow: 0 3px 10px rgba(0,0,0,0.1); }
</style>
@endpush

@section("content")
<div class="settings-page">
<div class="container-fluid"><div class="row justify-content-center"><div class="col-12 col-xl-10">
<div class="card settings-card">
<div class="card-header settings-header"><h3><i class="fas fa-cog"></i> Cài đặt hệ thống</h3></div>
<div class="card-body settings-body">
@if(session("success"))
<div class="alert alert-success alert-dismissible fade show">
<i class="fas fa-check-circle me-2"></i><strong>Thành công!</strong> {{ session("success") }}
<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif
@if(session("error"))
<div class="alert alert-danger alert-dismissible fade show">
<i class="fas fa-exclamation-triangle me-2"></i><strong>Lỗi!</strong> {{ session("error") }}
<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif
<form action="{{ route("admin.settings.update") }}" method="POST" enctype="multipart/form-data">
@csrf
@method("PUT")
<ul class="nav nav-tabs settings-tabs" role="tablist">
<li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general" type="button"><i class="fas fa-home"></i> Thông tin chung</button></li>
<li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#contact" type="button"><i class="fas fa-address-book"></i> Liên hệ</button></li>
<li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#social" type="button"><i class="fas fa-share-alt"></i> Mạng xã hội</button></li>
<li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#seo" type="button"><i class="fas fa-search"></i> SEO</button></li>
</ul>
<div class="tab-content">
@foreach($settings as $group => $items)
<div class="tab-pane fade {{ $loop->first ? "show active" : "" }}" id="{{ $group }}">
<div class="row">
@foreach($items as $setting)
<div class="col-12 col-md-6">
<div class="setting-group">
<label class="form-label">{{ $setting->label }} @if($setting->label_en)<small>({{ $setting->label_en }})</small>@endif</label>
@if($setting->type === "textarea")
<textarea name="settings[{{ $setting->key }}]" class="form-control" rows="4" placeholder="Nhập {{ strtolower($setting->label) }}">{{ old("settings.{$setting->key}", $setting->value) }}</textarea>
@elseif($setting->type === "image")
<input type="file" name="settings[{{ $setting->key }}]" class="form-control" accept="image/*">
@if($setting->value)<img src="{{ asset($setting->value) }}" alt="{{ $setting->label }}" class="image-preview">@endif
@else
<input type="{{ $setting->type === "phone" ? "tel" : $setting->type }}" name="settings[{{ $setting->key }}]" class="form-control" value="{{ old("settings.{$setting->key}", $setting->value) }}" placeholder="Nhập {{ strtolower($setting->label) }}">
@endif
@if($setting->description)<small class="form-text text-muted"><i class="fas fa-info-circle"></i> {{ $setting->description }}</small>@endif
</div></div>
@endforeach
</div></div>
@endforeach
</div>
<div class="mt-4 d-flex gap-3">
<button type="submit" class="btn btn-save"><i class="fas fa-save me-2"></i>Lưu cài đặt</button>
<a href="{{ route("admin.dashboard") }}" class="btn btn-cancel"><i class="fas fa-times me-2"></i>Hủy</a>
</div>
</form>
</div></div></div></div></div>
</div>
@endsection