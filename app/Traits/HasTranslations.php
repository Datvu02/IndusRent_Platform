<?php

namespace App\Traits;

trait HasTranslations
{
    /**
     * Trả về giá trị đã dịch theo locale hiện tại.
     * - vi: trả về giá trị gốc (field không có suffix)
     * - en: trả về field có suffix _en, nếu trống thì fallback về tiếng Việt
     * - zh: trả về field có suffix _zh, nếu trống thì fallback về tiếng Việt
     */
    public function getTranslated(string $attribute): ?string
    {
        $locale = app()->getLocale();

        if ($locale === 'en') {
            $key = $attribute . '_en';
            if (array_key_exists($key, $this->getAttributes())) {
                $value = $this->getAttribute($key);
                if ($value !== null && $value !== '') {
                    return $value;
                }
            }
        }

        if ($locale === 'zh') {
            $key = $attribute . '_zh';
            if (array_key_exists($key, $this->getAttributes())) {
                $value = $this->getAttribute($key);
                if ($value !== null && $value !== '') {
                    return $value;
                }
            }
        }

        return $this->getAttribute($attribute);
    }
}

