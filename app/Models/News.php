<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasTranslations;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'title_en',
        'title_zh',
        'slug',
        'content',
        'content_en',
        'content_zh',
        'featured_image',
        'gallery',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'gallery' => 'array',
    ];

    public function getTitleTranslatedAttribute(): string
    {
        return (string) $this->getTranslated('title') ?: $this->title;
    }

    public function getContentTranslatedAttribute(): ?string
    {
        return $this->getTranslated('content') ?: $this->content;
    }
}
