<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImageUploadTrait
{
    public function uploadImage(UploadedFile $file, string $folder = "images", ?string $oldPath = null): string
    {
        if ($oldPath && Storage::disk("public")->exists($oldPath)) {
            Storage::disk("public")->delete($oldPath);
        }

        $filename = time() . "_" . Str::random(10) . "." . $file->getClientOriginalExtension();
        $path = $file->storeAs($folder, $filename, "public");
        
        return $path;
    }

    public function uploadMultipleImages(array $files, string $folder = "images"): array
    {
        $paths = [];
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $paths[] = $this->uploadImage($file, $folder);
            }
        }
        return $paths;
    }

    public function deleteImage(?string $path): bool
    {
        if ($path && Storage::disk("public")->exists($path)) {
            return Storage::disk("public")->delete($path);
        }
        return false;
    }
}
