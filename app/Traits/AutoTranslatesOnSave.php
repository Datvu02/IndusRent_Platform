<?php

namespace App\Traits;

use App\Services\TranslationService;

trait AutoTranslatesOnSave
{
    /**
     * Từ các trường tiếng Việt, sinh bản _en và _zh trước khi lưu DB.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string, string>  $fields  VD: ['title' => 'line', 'description' => 'html', 'content' => 'html']
     */
    protected function applyAutoTranslations(array $data, array $fields): array
    {
        foreach ($fields as $source => $type) {
            $value = isset($data[$source]) ? trim((string) $data[$source]) : '';

            if ($value === '') {
                $data[$source.'_en'] = null;
                $data[$source.'_zh'] = null;

                continue;
            }

            $data[$source] = $value;

            if ($type === 'html') {
                $data[$source.'_en'] = TranslationService::translateHtml($value, 'en');
                usleep((int) config('translation.lang_switch_delay_us', 500000));
                $data[$source.'_zh'] = TranslationService::translateHtml($value, 'zh');
            } else {
                $data[$source.'_en'] = TranslationService::translate($value, 'en');
                usleep((int) config('translation.lang_switch_delay_us', 500000));
                $data[$source.'_zh'] = TranslationService::translate($value, 'zh');
            }
        }

        return $data;
    }
}
