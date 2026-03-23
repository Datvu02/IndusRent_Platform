<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        "key", "value", "type", "group", "label",
        "label_en", "label_zh", "description", "order",
    ];

    protected $casts = ["order" => "integer"];

    public static function get(string $key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = self::where("key", $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set(string $key, $value): bool
    {
        $setting = self::where("key", $key)->first();
        if ($setting) {
            $setting->value = $value;
            $setting->save();
        } else {
            self::create(["key" => $key, "value" => $value, "label" => $key]);
        }
        Cache::forget("setting_{$key}");
        return true;
    }

    public static function allSettings(): array
    {
        return Cache::remember("all_settings", 3600, function () {
            return self::query()->pluck("value", "key")->toArray();
        });
    }

    public static function getByGroup(string $group): array
    {
        return Cache::remember("settings_group_{$group}", 3600, function () use ($group) {
            return self::where("group", $group)->orderBy("order")->get()->toArray();
        });
    }

    public static function clearCache(): void
    {
        Cache::flush();
    }

    protected static function boot()
    {
        parent::boot();
        static::saved(function () { self::clearCache(); });
        static::deleted(function () { self::clearCache(); });
    }
}
