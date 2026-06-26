<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Traits\AutoTranslatesOnSave;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    use AutoTranslatesOnSave;
    use ImageUploadTrait;

    public function index(Request $request)
    {
        $query = News::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%")
                  ->orWhere('title_zh', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $news = $query->orderByDesc("updated_at")->paginate(15)->withQueryString();
        return view("admin.tin-tuc.index", compact("news"));
    }

    public function create()
    {
        return view("admin.tin-tuc.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => "required|string|max:255",
            "slug" => "nullable|string|max:255|unique:news,slug",
            "content" => "nullable|string",
            "featured_image" => "nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048",
        ], [
            "title.required" => "Vui lòng nhập tiêu đề.",
            "slug.unique" => "Slug này đã tồn tại.",
            "featured_image.image" => "File phải là ảnh.",
            "featured_image.max" => "Ảnh không được vượt quá 2MB.",
        ]);

        if (empty($validated["slug"])) {
            $validated["slug"] = Str::slug($validated["title"]);
        }

        $validated = $this->applyAutoTranslations($validated, [
            'title' => 'line',
            'content' => 'html',
        ]);

        if ($request->hasFile("featured_image")) {
            $validated["featured_image"] = $this->uploadImage($request->file("featured_image"), "news");
        }

        News::create($validated);
        return redirect()->route("admin.tin-tuc.index")->with("message", "Đã thêm tin tức.");
    }

    public function edit(News $article)
    {
        return view("admin.tin-tuc.edit", compact("article"));
    }

    public function update(Request $request, News $article)
    {
        $validated = $request->validate([
            "title" => "required|string|max:255",
            "slug" => "nullable|string|max:255|unique:news,slug," . $article->id,
            "content" => "nullable|string",
            "featured_image" => "nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048",
        ], [
            "title.required" => "Vui lòng nhập tiêu đề.",
            "slug.unique" => "Slug này đã tồn tại.",
            "featured_image.image" => "File phải là ảnh.",
            "featured_image.max" => "Ảnh không được vượt quá 2MB.",
        ]);

        if (empty($validated["slug"])) {
            $validated["slug"] = Str::slug($validated["title"]);
        }

        $validated = $this->applyAutoTranslations($validated, [
            'title' => 'line',
            'content' => 'html',
        ]);

        if ($request->hasFile("featured_image")) {
            $validated["featured_image"] = $this->uploadImage(
                $request->file("featured_image"),
                "news",
                $article->featured_image
            );
        }

        $article->update($validated);
        return redirect()->route("admin.tin-tuc.index")->with("message", "Đã cập nhật tin tức.");
    }

    public function destroy(News $article)
    {
        if ($article->featured_image) {
            $this->deleteImage($article->featured_image);
        }
        $article->delete();
        return redirect()->route("admin.tin-tuc.index")->with("message", "Đã xóa tin tức.");
    }
}
