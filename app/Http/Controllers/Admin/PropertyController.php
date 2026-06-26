<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyType;
use App\Traits\AutoTranslatesOnSave;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PropertyController extends Controller
{
    use AutoTranslatesOnSave;
    use ImageUploadTrait;

    public function index(Request $request): View
    {
        $query = Property::with("type", "location");
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%")
                  ->orWhere('title_zh', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        }
        
        if ($request->filled('province')) {
            $query->whereHas('location', function($q) use ($request) {
                $q->where('province', $request->province);
            });
        }
        
        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }
        
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }
        
        if ($request->filled('area_min')) {
            $query->where('area', '>=', $request->area_min);
        }
        
        if ($request->filled('area_max')) {
            $query->where('area', '<=', $request->area_max);
        }
        
        $properties = $query->orderByDesc("updated_at")->paginate(15)->withQueryString();
        
        $types = PropertyType::orderBy('name')->get();
        $provinces = Location::select('province')->distinct()->orderBy('province')->pluck('province');
        
        return view("admin.tin-dang.index", compact("properties", "types", "provinces"));
    }

    public function create(): View
    {
        $types = PropertyType::orderBy("name")->get();
        $locations = Location::orderBy("province")->get();
        return view("admin.tin-dang.create", compact("types", "locations"));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'latitude' => $request->filled('latitude') ? $request->input('latitude') : null,
            'longitude' => $request->filled('longitude') ? $request->input('longitude') : null,
        ]);

        $validated = $request->validate([
            "title" => "required|string|max:255",
            "slug" => "nullable|string|max:255|unique:properties,slug",
            "description" => "nullable|string",
            "type_id" => "required|exists:property_types,id",
            "location_id" => "required|exists:locations,id",
            "price" => "nullable|numeric|min:0",
            "area" => "nullable|integer|min:0",
            "latitude" => "nullable|numeric",
            "longitude" => "nullable|numeric",
            "main_image" => "nullable|image|mimes:jpeg,png,jpg,webp|max:2048",
        ], [
            "title.required" => "Vui lòng nhập tiêu đề.",
            "type_id.required" => "Vui lòng chọn loại BĐS.",
            "location_id.required" => "Vui lòng chọn khu vực.",
            "main_image.image" => "File phải là ảnh.",
            "main_image.max" => "Ảnh không được vượt quá 2MB.",
        ]);

        if (empty($validated["slug"])) {
            $validated["slug"] = Str::slug($validated["title"]);
        }
        $validated["is_published"] = $request->boolean("is_published");
        $validated["is_featured"] = $request->boolean("is_featured");

        $validated = $this->applyAutoTranslations($validated, [
            'title' => 'line',
            'description' => 'html',
        ]);

        if ($request->hasFile("main_image")) {
            $validated["main_image"] = $this->uploadImage($request->file("main_image"), "properties");
        }

        Property::create($validated);
        return redirect()->route("admin.tin-dang.index")->with("message", "Đã thêm tin đăng.");
    }

    public function edit(Property $tin_dang): View
    {
        $property = $tin_dang;
        $types = PropertyType::orderBy("name")->get();
        $locations = Location::orderBy("province")->get();
        return view("admin.tin-dang.edit", compact("property", "types", "locations"));
    }

    public function update(Request $request, Property $tin_dang): RedirectResponse
    {
        $request->merge([
            'latitude' => $request->filled('latitude') ? $request->input('latitude') : null,
            'longitude' => $request->filled('longitude') ? $request->input('longitude') : null,
        ]);

        $validated = $request->validate([
            "title" => "required|string|max:255",
            "slug" => "nullable|string|max:255|unique:properties,slug," . $tin_dang->id,
            "description" => "nullable|string",
            "type_id" => "required|exists:property_types,id",
            "location_id" => "required|exists:locations,id",
            "price" => "nullable|numeric|min:0",
            "area" => "nullable|integer|min:0",
            "latitude" => "nullable|numeric",
            "longitude" => "nullable|numeric",
            "main_image" => "nullable|image|mimes:jpeg,png,jpg,webp|max:2048",
        ], [
            "title.required" => "Vui lòng nhập tiêu đề.",
            "main_image.image" => "File phải là ảnh.",
        ]);

        if (empty($validated["slug"])) {
            $validated["slug"] = Str::slug($validated["title"]);
        }
        $validated["is_published"] = $request->boolean("is_published");
        $validated["is_featured"] = $request->boolean("is_featured");

        $validated = $this->applyAutoTranslations($validated, [
            'title' => 'line',
            'description' => 'html',
        ]);

        if ($request->hasFile("main_image")) {
            $validated["main_image"] = $this->uploadImage(
                $request->file("main_image"),
                "properties",
                $tin_dang->main_image
            );
        }

        $tin_dang->update($validated);
        return redirect()->route("admin.tin-dang.index")->with("message", "Đã cập nhật tin đăng.");
    }

    public function destroy(Property $tin_dang): RedirectResponse
    {
        if ($tin_dang->main_image) {
            $this->deleteImage($tin_dang->main_image);
        }
        if ($tin_dang->gallery) {
            foreach ($tin_dang->gallery as $image) {
                $this->deleteImage($image);
            }
        }
        $tin_dang->delete();
        return redirect()->route("admin.tin-dang.index")->with("message", "Đã xóa tin đăng.");
    }
}
