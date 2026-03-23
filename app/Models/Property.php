<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasTranslations;

    protected $table = 'properties';

    protected $fillable = [
        'title',
        'title_en',
        'title_zh',
        'slug',
        'description',
        'description_en',
        'description_zh',
        'type_id',
        'location_id',
        'price',
        'area',
        'main_image',
        'gallery',
        'is_featured',
        'is_published',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'area' => 'integer',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'gallery' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class, 'type_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function getTitleTranslatedAttribute(): string
    {
        return (string) $this->getTranslated('title') ?: $this->title;
    }

    public function getDescriptionTranslatedAttribute(): ?string
    {
        return $this->getTranslated('description') ?: $this->description;
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->price === null) {
            return __('common.contact_price');
        }
        if ($this->price >= 1000000) {
            return number_format($this->price / 1000000, 1, ',', '.') . ' triệu';
        }
        return number_format($this->price, 0, ',', '.') . ' VNĐ';
    }
}
