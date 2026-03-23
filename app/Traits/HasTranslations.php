<?php

namespace App\Traits;

trait HasTranslations
{
    /**
     * Trả về giá trị đã dịch theo locale hiện tại (vi -> gốc, en -> _en, zh -> _zh).
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
