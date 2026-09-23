<?php

namespace App\Observers;

use App\Models\Slider;
use App\Services\TranslationService;

class SliderObserver
{
    private const TRANSLATABLE_FIELDS = [
        'title' => 'line',
        'description' => 'line',
    ];

    public function saving(Slider $slider): void
    {
        foreach (self::TRANSLATABLE_FIELDS as $source => $type) {
            $value = trim((string) ($slider->{$source} ?? ''));

            if ($value === '') {
                $slider->{$source} = null;
                $slider->{$source.'_en'} = null;
                $slider->{$source.'_zh'} = null;

                continue;
            }

            $slider->{$source} = $value;

            if ($type === 'html') {
                $slider->{$source.'_en'} = TranslationService::translateHtml($value, 'en');
                usleep((int) config('translation.lang_switch_delay_us', 500000));
                $slider->{$source.'_zh'} = TranslationService::translateHtml($value, 'zh');
            } else {
                $slider->{$source.'_en'} = TranslationService::translate($value, 'en');
                usleep((int) config('translation.lang_switch_delay_us', 500000));
                $slider->{$source.'_zh'} = TranslationService::translate($value, 'zh');
            }
        }
    }
}
