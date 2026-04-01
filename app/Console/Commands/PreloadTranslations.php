<?php

namespace App\Console\Commands;

use App\Models\News;
use App\Models\Property;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class PreloadTranslations extends Command
{
    protected $signature = 'translation:preload {--clear : Clear existing cache first}';
    protected $description = 'Preload translations into cache (useful when API quota is exceeded)';

    public function handle(): int
    {
        if ($this->option('clear')) {
            $this->info('Clearing translation cache...');
            $this->clearTranslationCache();
        }

        $this->info('Preloading property translations...');
        $this->preloadProperties();

        $this->info('Preloading news translations...');
        $this->preloadNews();

        $this->info('✅ Translation preload completed!');
        return 0;
    }

    private function clearTranslationCache(): void
    {
        $keys = Cache::getRedis()->keys('*translation_*');
        foreach ($keys as $key) {
            Cache::forget(str_replace(config('cache.prefix') . ':', '', $key));
        }
    }

    private function preloadProperties(): void
    {
        $properties = Property::where('is_published', true)->get();
        
        foreach ($properties as $property) {
            if ($property->title) {
                $this->cacheIfNotExists($property->title, 'en', $property->title_en);
                $this->cacheIfNotExists($property->title, 'zh', $property->title_zh);
            }
            
            if ($property->description) {
                $this->cacheIfNotExists($property->description, 'en', $property->description_en);
                $this->cacheIfNotExists($property->description, 'zh', $property->description_zh);
            }
        }
        
        $this->info("  Processed {$properties->count()} properties");
    }

    private function preloadNews(): void
    {
        $news = News::all();
        
        foreach ($news as $item) {
            if ($item->title) {
                $this->cacheIfNotExists($item->title, 'en', $item->title_en);
                $this->cacheIfNotExists($item->title, 'zh', $item->title_zh);
            }
            
            if ($item->content) {
                $this->cacheIfNotExists($item->content, 'en', $item->content_en);
                $this->cacheIfNotExists($item->content, 'zh', $item->content_zh);
            }
        }
        
        $this->info("  Processed {$news->count()} news items");
    }

    private function cacheIfNotExists(string $text, string $lang, ?string $translation): void
    {
        if (empty($text) || empty($translation)) {
            return;
        }

        $cacheKey = 'translation_' . md5($text . '_' . $lang);
        
        if (!Cache::has($cacheKey)) {
            Cache::put($cacheKey, $translation, now()->addDays(30));
        }
    }
}
