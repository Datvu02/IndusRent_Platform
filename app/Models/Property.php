<?php

namespace App\Models;

use App\Support\Currency;
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
        'latitude',
        'longitude',
        'price',
        'area',
        'main_image',
        'gallery',
        'is_featured',
        'is_published',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
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
        return Currency::format($this->price);
    }
}
