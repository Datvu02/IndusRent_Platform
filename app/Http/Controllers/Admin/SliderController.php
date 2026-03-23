<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        $sliders = Slider::ordered()->get();
        return view("admin.sliders.index", compact("sliders"));
    }

    public function create()
    {
        return view("admin.sliders.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => "required|string|max:255",
            "title_en" => "nullable|string|max:255",
            "title_zh" => "nullable|string|max:255",
            "description" => "nullable|string",
            "description_en" => "nullable|string",
            "description_zh" => "nullable|string",
            "image" => "required|image|mimes:jpeg,png,jpg,gif,webp|max:2048",
            "link" => "nullable|url|max:500",
            "order" => "nullable|integer|min:0",
            "is_active" => "nullable|boolean",
        ]);

        if ($request->hasFile("image")) {
            $validated["image"] = $this->uploadImage($request->file("image"), "sliders");
        }

        $validated["is_active"] = $request->has("is_active");

        Slider::create($validated);

        return redirect()->route("admin.sliders.index")->with("message", "Đã thêm slider thành công!");
    }

    public function edit(Slider $slider)
    {
        return view("admin.sliders.edit", compact("slider"));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            "title" => "required|string|max:255",
            "title_en" => "nullable|string|max:255",
            "title_zh" => "nullable|string|max:255",
            "description" => "nullable|string",
            "description_en" => "nullable|string",
            "description_zh" => "nullable|string",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048",
            "link" => "nullable|url|max:500",
            "order" => "nullable|integer|min:0",
            "is_active" => "nullable|boolean",
        ]);

        if ($request->hasFile("image")) {
            $validated["image"] = $this->uploadImage(
                $request->file("image"),
                "sliders",
                $slider->image
            );
        }

        $validated["is_active"] = $request->has("is_active");

        $slider->update($validated);

        return redirect()->route("admin.sliders.index")->with("message", "Đã cập nhật slider thành công!");
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            $this->deleteImage($slider->image);
        }

        $slider->delete();

        return redirect()->route("admin.sliders.index")->with("message", "Đã xóa slider thành công!");
    }
}
