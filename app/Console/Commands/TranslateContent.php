<?php

namespace App\Console\Commands;

use App\Models\News;
use App\Models\Property;
use App\Services\TranslationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class TranslateContent extends Command
{
    protected $signature = 'content:translate 
                            {--model=all : Model to translate (property, news, all)}
                            {--limit=10 : Number of items to translate per run}
                            {--force : Force translate even if quota exceeded}';
    
    protected $description = 'Translate content and save to database (batch mode to avoid quota issues)';

    public function handle(): int
    {
        if (!$this->option('force') && Cache::has('translation_quota_exceeded')) {
            $this->error('❌ Translation quota exceeded. Wait 1 hour or use --force flag.');
            $this->info('Or add GOOGLE_TRANSLATE_API_KEY to .env');
            return 1;
        }

        $model = $this->option('model');
        $limit = (int) $this->option('limit');

        if ($model === 'all' || $model === 'property') {
            $this->info('Translating properties...');
            $this->translateProperties($limit);
        }

        if ($model === 'all' || $model === 'news') {
            $this->info('Translating news...');
            $this->translateNews($limit);
        }

        $this->info('✅ Translation completed!');
        return 0;
    }

    private function translateProperties(int $limit): void
    {
        $properties = Property::where('is_published', true)
            ->where(function($query) {
                $query->whereNull('title_en')
                      ->orWhereNull('description_en')
                      ->orWhereNull('title_zh')
                      ->orWhereNull('description_zh');
            })
            ->limit($limit)
            ->get();

        $bar = $this->output->createProgressBar($properties->count());
        $bar->start();

        foreach ($properties as $property) {
            $updated = false;

            if (empty($property->title_en) && !empty($property->title)) {
                $property->title_en = TranslationService::translate($property->title, 'en');
                $updated = true;
                usleep(200000); // 200ms delay
            }

            if (empty($property->title_zh) && !empty($property->title)) {
                $property->title_zh = TranslationService::translate($property->title, 'zh');
                $updated = true;
                usleep(200000);
            }

            if (empty($property->description_en) && !empty($property->description)) {
                $property->description_en = TranslationService::translateHtml($property->description, 'en');
                $updated = true;
                usleep((int) config('translation.lang_switch_delay_us', 500000));
            }

            if (empty($property->description_zh) && !empty($property->description)) {
                $property->description_zh = TranslationService::translateHtml($property->description, 'zh');
                $updated = true;
                usleep(200000);
            }

            if ($updated) {
                $property->save();
            }

            $bar->advance();

            if (Cache::has('translation_quota_exceeded')) {
                $bar->finish();
                $this->newLine();
                $this->warn('⚠️  Quota exceeded. Stopping translation.');
                return;
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info("  Translated {$properties->count()} properties");
    }

    private function translateNews(int $limit): void
    {
        $news = News::where(function($query) {
                $query->whereNull('title_en')
                      ->orWhereNull('content_en')
                      ->orWhereNull('title_zh')
                      ->orWhereNull('content_zh');
            })
            ->limit($limit)
            ->get();

        $bar = $this->output->createProgressBar($news->count());
        $bar->start();

        foreach ($news as $item) {
            $updated = false;

            if (empty($item->title_en) && !empty($item->title)) {
                $item->title_en = TranslationService::translate($item->title, 'en');
                $updated = true;
                usleep(200000);
            }

            if (empty($item->title_zh) && !empty($item->title)) {
                $item->title_zh = TranslationService::translate($item->title, 'zh');
                $updated = true;
                usleep(200000);
            }

            if (empty($item->content_en) && !empty($item->content)) {
                $item->content_en = TranslationService::translateHtml($item->content, 'en');
                $updated = true;
                usleep((int) config('translation.lang_switch_delay_us', 500000));
            }

            if (empty($item->content_zh) && !empty($item->content)) {
                $item->content_zh = TranslationService::translateHtml($item->content, 'zh');
                $updated = true;
                usleep(200000);
            }

            if ($updated) {
                $item->save();
            }

            $bar->advance();

            if (Cache::has('translation_quota_exceeded')) {
                $bar->finish();
                $this->newLine();
                $this->warn('⚠️  Quota exceeded. Stopping translation.');
                return;
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info("  Translated {$news->count()} news items");
    }
}
