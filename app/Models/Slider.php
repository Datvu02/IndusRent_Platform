<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Slider extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        "title",
        "title_en",
        "title_zh",
        "description",
        "description_en",
        "description_zh",
        "image",
        "link",
        "order",
        "is_active",
    ];

    protected $casts = [
        "is_active" => "boolean",
        "order" => "integer",
    ];

    public $translatable = ["title", "description"];

    public function scopeActive($query)
    {
        return $query->where("is_active", true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy("order", "asc");
    }
}
