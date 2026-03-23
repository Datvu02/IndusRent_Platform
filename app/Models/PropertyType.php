<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertyType extends Model
{
    use HasTranslations;

    protected $table = 'property_types';

    protected $fillable = ['name', 'name_en', 'name_zh', 'slug'];

    public function getNameTranslatedAttribute(): string
    {
        return (string) $this->getTranslated('name') ?: $this->name;
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'type_id');
    }
}
