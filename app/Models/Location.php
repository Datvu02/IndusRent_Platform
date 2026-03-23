<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasTranslations;

    protected $fillable = [
        'province', 'province_en', 'province_zh',
        'district', 'district_en', 'district_zh',
        'ward', 'ward_en', 'ward_zh',
        'slug',
    ];

    public function getProvinceTranslatedAttribute(): string
    {
        return (string) $this->getTranslated('province') ?: $this->province;
    }

    public function getDistrictTranslatedAttribute(): string
    {
        return (string) $this->getTranslated('district') ?: $this->district;
    }

    public function getWardTranslatedAttribute(): ?string
    {
        return $this->getTranslated('ward') ?: $this->ward;
    }

    public function getLocationLineAttribute(): string
    {
        $parts = array_filter([
            $this->ward_translated,
            $this->district_translated,
            $this->province_translated
        ]);
        return implode(', ', $parts);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
