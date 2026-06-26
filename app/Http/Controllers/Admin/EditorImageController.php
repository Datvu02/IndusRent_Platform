<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EditorImageController extends Controller
{
    use ImageUploadTrait;

    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'upload.required' => 'Vui lòng chọn ảnh.',
            'upload.image' => 'File phải là ảnh.',
            'upload.max' => 'Ảnh không được vượt quá 2MB.',
        ]);

        $path = $this->uploadImage($request->file('upload'), 'editor');

        return response()->json([
            'url' => asset('storage/'.$path),
        ]);
    }
}
