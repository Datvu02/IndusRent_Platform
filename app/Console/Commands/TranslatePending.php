<?php

namespace App\Console\Commands;

use App\Models\News;
use App\Models\Property;
use App\Models\Setting;
use App\Services\TranslationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class TranslatePending extends Command
{
    protected $signature = 'translate:pending 
                            {--limit=20 : Number of items to translate}
                            {--delay=500 : Delay between translations (ms)}';
    
    protected $description = 'Translate pending content (items without EN/ZH translations)';

    public function handle(): int
    {
        if (Cache::has('translation_quota_exceeded')) {
            $this->error('❌ Translation quota exceeded. Will retry at 7:00 AM tomorrow.');
            return 1;
        }

        $limit = (int) $this->option('limit');
        $delay = (int) $this->option('delay');

        $this->info('🔄 Starting translation of pending content...');
        $this->newLine();

        $totalTranslated = 0;

        $totalTranslated += $this->translateProperties($limit, $delay);
        
        if (!Cache::has('translation_quota_exceeded')) {
            $totalTranslated += $this->translateNews($limit, $delay);
        }
        
        if (!Cache::has('translation_quota_exceeded')) {
            $totalTranslated += $this->translateSettings($limit, $delay);
        }

        $this->newLine();
        
        if (Cache::has('translation_quota_exceeded')) {
            $this->warn('⚠️  Quota exceeded. Translated ' . $totalTranslated . ' items before stopping.');
            $this->info('💡 Will auto-retry tomorrow at 7:00 AM when quota resets.');
        } else {
            $this->info('✅ Successfully translated ' . $totalTranslated . ' items!');
        }

        return 0;
    }

    private function translateProperties(int $limit, int $delay): int
    {
        $properties = Property::where(function($query) {
            $query->whereNull('title_en')
                  ->orWhereNull('title_zh')
                  ->orWhereNull('description_en')
                  ->orWhereNull('description_zh');
        })->limit($limit)->get();

        if ($properties->isEmpty()) {
            $this->line('  ℹ️  No pending properties to translate');
            return 0;
        }

        $this->info('📦 Translating ' . $properties->count() . ' properties...');
        $bar = $this->output->createProgressBar($properties->count());
        $bar->start();

        $count = 0;
        foreach ($properties as $property) {
            if (Cache::has('translation_quota_exceeded')) {
                break;
            }

            $updated = false;

            if (empty($property->title_en) && !empty($property->title)) {
                $property->title_en = TranslationService::translate($property->title, 'en');
                $updated = true;
                usleep($delay * 1000);
            }

            if (empty($property->title_zh) && !empty($property->title)) {
                $property->title_zh = TranslationService::translate($property->title, 'zh');
                $updated = true;
                usleep($delay * 1000);
            }

            if (empty($property->description_en) && !empty($property->description)) {
                $plainText = strip_tags($property->description);
                if (strlen($plainText) > 5000) {
                    $plainText = substr($plainText, 0, 5000);
                }
                $property->description_en = TranslationService::translate($plainText, 'en');
                $updated = true;
                usleep($delay * 1000);
            }

            if (empty($property->description_zh) && !empty($property->description)) {
                $plainText = strip_tags($property->description);
                if (strlen($plainText) > 5000) {
                    $plainText = substr($plainText, 0, 5000);
                }
                $property->description_zh = TranslationService::translate($plainText, 'zh');
                $updated = true;
                usleep($delay * 1000);
            }

            if ($updated) {
                $property->save();
                $count++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->line('  ✓ Translated ' . $count . ' properties');

        return $count;
    }

    private function translateNews(int $limit, int $delay): int
    {
        $news = News::where(function($query) {
            $query->whereNull('title_en')
                  ->orWhereNull('title_zh')
                  ->orWhereNull('content_en')
                  ->orWhereNull('content_zh');
        })->limit($limit)->get();

        if ($news->isEmpty()) {
            $this->line('  ℹ️  No pending news to translate');
            return 0;
        }

        $this->info('📰 Translating ' . $news->count() . ' news...');
        $bar = $this->output->createProgressBar($news->count());
        $bar->start();

        $count = 0;
        foreach ($news as $item) {
            if (Cache::has('translation_quota_exceeded')) {
                break;
            }

            $updated = false;

            if (empty($item->title_en) && !empty($item->title)) {
                $item->title_en = TranslationService::translate($item->title, 'en');
                $updated = true;
                usleep($delay * 1000);
            }

            if (empty($item->title_zh) && !empty($item->title)) {
                $item->title_zh = TranslationService::translate($item->title, 'zh');
                $updated = true;
                usleep($delay * 1000);
            }

            if (empty($item->content_en) && !empty($item->content)) {
                $plainText = strip_tags($item->content);
                if (strlen($plainText) > 5000) {
                    $plainText = substr($plainText, 0, 5000);
                }
                $item->content_en = TranslationService::translate($plainText, 'en');
                $updated = true;
                usleep($delay * 1000);
            }

            if (empty($item->content_zh) && !empty($item->content)) {
                $plainText = strip_tags($item->content);
                if (strlen($plainText) > 5000) {
                    $plainText = substr($plainText, 0, 5000);
                }
                $item->content_zh = TranslationService::translate($plainText, 'zh');
                $updated = true;
                usleep($delay * 1000);
            }

            if ($updated) {
                $item->save();
                $count++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->line('  ✓ Translated ' . $count . ' news');

        return $count;
    }

    private function translateSettings(int $limit, int $delay): int
    {
        $settings = Setting::where('type', '!=', 'image')
            ->where(function($query) {
                $query->whereNull('value_en')
                      ->orWhereNull('value_zh');
            })
            ->limit($limit)
            ->get();

        if ($settings->isEmpty()) {
            $this->line('  ℹ️  No pending settings to translate');
            return 0;
        }

        $this->info('⚙️  Translating ' . $settings->count() . ' settings...');
        $bar = $this->output->createProgressBar($settings->count());
        $bar->start();

        $count = 0;
        foreach ($settings as $setting) {
            if (Cache::has('translation_quota_exceeded')) {
                break;
            }

            $updated = false;

            if (empty($setting->value_en) && !empty($setting->value)) {
                $setting->value_en = TranslationService::translate($setting->value, 'en');
                $updated = true;
                usleep($delay * 1000);
            }

            if (empty($setting->value_zh) && !empty($setting->value)) {
                $setting->value_zh = TranslationService::translate($setting->value, 'zh');
                $updated = true;
                usleep($delay * 1000);
            }

            if ($updated) {
                $setting->save();
                $count++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->line('  ✓ Translated ' . $count . ' settings');

        return $count;
    }
}
