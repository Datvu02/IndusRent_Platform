<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    /**
     * Dịch text từ tiếng Việt sang ngôn ngữ đích.
     * Hỗ trợ: MyMemory (miễn phí), Google Translate (trả phí)
     * Cache kết quả 30 ngày để tránh gọi API lặp lại và tiết kiệm quota.
     */
    public static function translate(string $text, string $targetLang): string
    {
        if (empty($text) || $targetLang === 'vi') {
            return $text;
        }

        $cacheKey = 'translation_' . md5($text . '_' . $targetLang);

        return Cache::remember($cacheKey, now()->addDays(30), function () use ($text, $targetLang) {
            if (self::isQuotaExceeded()) {
                Log::info('Translation quota exceeded, returning original text', [
                    'text' => substr($text, 0, 50),
                    'target' => $targetLang,
                ]);
                return $text;
            }
            
            return self::translateWithMyMemory($text, $targetLang);
        });
    }

    /**
     * Kiểm tra xem đã hết quota chưa (dựa vào cache flag)
     */
    private static function isQuotaExceeded(): bool
    {
        return Cache::has('translation_quota_exceeded');
    }

    /**
     * Đánh dấu đã hết quota (cache đến 00:00 UTC ngày mai = 7:00 sáng VN)
     */
    private static function markQuotaExceeded(): void
    {
        $tomorrow = now('UTC')->addDay()->startOfDay();
        Cache::put('translation_quota_exceeded', true, $tomorrow);
        
        Log::warning('Translation quota exceeded, will retry at ' . $tomorrow->toDateTimeString() . ' UTC (7:00 AM Vietnam time)');
    }

    /**
     * Dịch bằng MyMemory API (miễn phí, 1000 requests/ngày)
     */
    private static function translateWithMyMemory(string $text, string $targetLang): string
    {
        try {
            $response = Http::timeout(5)->get('https://api.mymemory.translated.net/get', [
                'q' => $text,
                'langpair' => 'vi|' . $targetLang,
            ]);

                if ($response->successful()) {
                    $data = $response->json();
                    
                    $translatedText = $data['responseData']['translatedText'] ?? '';
                    if (stripos($translatedText, 'MYMEMORY WARNING') !== false || 
                        stripos($translatedText, 'QUOTA') !== false) {
                        self::markQuotaExceeded();
                        Log::warning('Translation API quota exceeded, marked for 1 hour', [
                            'text' => substr($text, 0, 50),
                            'target' => $targetLang,
                        ]);
                        return $text;
                    }
                    
                    if (isset($data['matches']) && is_array($data['matches']) && count($data['matches']) > 0) {
                        foreach ($data['matches'] as $match) {
                            if (isset($match['translation']) && 
                                $match['translation'] !== $text && 
                                !empty($match['translation'])) {
                                return $match['translation'];
                            }
                        }
                    }
                    
                    if (!empty($translatedText) && $translatedText !== $text) {
                        return $translatedText;
                    }
                }

                if ($response->status() === 429) {
                    self::markQuotaExceeded();
                    Log::warning('Translation API rate limited (429), marked for 1 hour', [
                        'text' => substr($text, 0, 50),
                        'target' => $targetLang,
                    ]);
                } else {
                    Log::warning('Translation API failed', [
                        'text' => substr($text, 0, 100),
                        'target' => $targetLang,
                        'status' => $response->status(),
                    ]);
                }

                return $text;
        } catch (\Exception $e) {
            Log::error('MyMemory translation exception', [
                'text' => substr($text, 0, 100),
                'target' => $targetLang,
                'error' => $e->getMessage(),
            ]);

            return $text;
        }
    }

    /**
     * Dịch bằng Google Translate API (trả phí, ổn định)
     */
    private static function translateWithGoogle(string $text, string $targetLang, string $apiKey): string
    {
        try {
            $response = Http::timeout(10)->post('https://translation.googleapis.com/language/translate/v2', [
                'q' => $text,
                'source' => 'vi',
                'target' => $targetLang,
                'key' => $apiKey,
                'format' => 'text',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['data']['translations'][0]['translatedText'])) {
                    return $data['data']['translations'][0]['translatedText'];
                }
            }

            Log::warning('Google Translate API failed', [
                'text' => substr($text, 0, 100),
                'target' => $targetLang,
                'status' => $response->status(),
            ]);

            return $text;
        } catch (\Exception $e) {
            Log::error('Google Translate exception', [
                'text' => substr($text, 0, 100),
                'target' => $targetLang,
                'error' => $e->getMessage(),
            ]);

            return $text;
        }
    }

    /**
     * Dịch HTML content (loại bỏ tag trước khi dịch, sau đó ghép lại).
     */
    public static function translateHtml(string $html, string $targetLang): string
    {
        if (empty($html) || $targetLang === 'vi') {
            return $html;
        }

        $plainText = strip_tags($html);
        
        if (strlen($plainText) > 5000) {
            $plainText = substr($plainText, 0, 5000);
        }

        return self::translate($plainText, $targetLang);
    }
}
