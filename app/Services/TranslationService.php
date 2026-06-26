<?php

namespace App\Services;

use DOMDocument;
use DOMNode;
use DOMXPath;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    private const SKIP_TEXT_PARENT_TAGS = ['script', 'style', 'noscript'];

    /**
     * Dịch text từ tiếng Việt sang ngôn ngữ đích (tự chia nhỏ nếu vượt giới hạn API).
     */
    public static function translate(string $text, string $targetLang): string
    {
        $text = trim($text);
        if ($text === '' || $targetLang === 'vi') {
            return $text;
        }

        $cacheKey = 'translation_'.md5($text.'_'.$targetLang);
        $cached = Cache::get($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        if (self::isQuotaExceeded()) {
            Log::info('Translation quota exceeded, returning original text', [
                'text' => mb_substr($text, 0, 50),
                'target' => $targetLang,
            ]);

            return $text;
        }

        $result = self::translateLongText($text, $targetLang);

        if (self::shouldCacheTranslation($text, $result)) {
            Cache::put($cacheKey, $result, now()->addDays(30));
        }

        return $result;
    }

    /**
     * Dịch HTML: giữ thẻ, class, style; chỉ dịch nội dung text trong từng node.
     */
    public static function translateHtml(string $html, string $targetLang): string
    {
        $html = trim($html);
        if ($html === '' || $targetLang === 'vi') {
            return $html;
        }

        if (self::isQuotaExceeded()) {
            return $html;
        }

        try {
            $result = self::translateHtmlPreservingStructure($html, $targetLang);

            if (self::shouldCacheTranslation(strip_tags($html), strip_tags($result))) {
                $cacheKey = 'translation_html_'.md5($html.'_'.$targetLang);
                Cache::put($cacheKey, $result, now()->addDays(30));
            }

            return $result;
        } catch (\Throwable $e) {
            Log::error('HTML translation failed, falling back to chunked plain text', [
                'target' => $targetLang,
                'error' => $e->getMessage(),
            ]);

            return self::translateLongText(strip_tags($html), $targetLang);
        }
    }

    private static function shouldCacheTranslation(string $source, string $result): bool
    {
        $source = trim($source);
        $result = trim($result);

        if ($result === '') {
            return false;
        }

        if ($source === $result) {
            return false;
        }

        if (self::isApiErrorResponse($result)) {
            return false;
        }

        return true;
    }

    private static function translateLongText(string $text, string $targetLang): string
    {
        $chunks = self::splitIntoChunks($text);
        if (count($chunks) <= 1) {
            return self::translateChunkWithRetry($chunks[0] ?? $text, $targetLang);
        }

        $translated = [];
        $delay = self::requestDelayUs();

        foreach ($chunks as $index => $chunk) {
            if ($index > 0 && $delay > 0) {
                usleep($delay);
            }
            $translated[] = self::translateChunkWithRetry($chunk, $targetLang);
        }

        return implode('', $translated);
    }

    /**
     * @return list<string>
     */
    private static function splitIntoChunks(string $text): array
    {
        $max = (int) config('translation.max_chunk_length', 450);
        $text = trim($text);

        if (mb_strlen($text) <= $max) {
            return [$text];
        }

        $chunks = [];
        $remaining = $text;

        while (mb_strlen($remaining) > $max) {
            $slice = mb_substr($remaining, 0, $max);
            $breakAt = max(
                mb_strrpos($slice, "\n\n") ?: 0,
                mb_strrpos($slice, "\n") ?: 0,
                mb_strrpos($slice, '. ') ?: 0,
                mb_strrpos($slice, '。') ?: 0,
                mb_strrpos($slice, ' ') ?: 0
            );

            if ($breakAt < (int) ($max * 0.4)) {
                $breakAt = $max;
            } else {
                if (mb_substr($remaining, $breakAt, 2) === '. ') {
                    $breakAt += 2;
                } elseif (mb_substr($remaining, $breakAt, 2) === "\n\n") {
                    $breakAt += 2;
                } else {
                    $breakAt += 1;
                }
            }

            $part = mb_substr($remaining, 0, $breakAt);
            if (trim($part) !== '') {
                $chunks[] = $part;
            }
            $remaining = mb_substr($remaining, $breakAt);
        }

        if ($remaining !== '') {
            $chunks[] = $remaining;
        }

        return $chunks !== [] ? $chunks : [$text];
    }

    private static function translateChunkWithRetry(string $text, string $targetLang, int $attempt = 1): string
    {
        $text = trim($text);
        if ($text === '') {
            return '';
        }

        if (mb_strlen($text) > (int) config('translation.max_chunk_length', 450)) {
            return self::translateLongText($text, $targetLang);
        }

        $result = self::translateChunkOnce($text, $targetLang);
        $maxAttempts = (int) config('translation.max_retries', 3);

        if ($result === $text && $attempt < $maxAttempts && ! self::isQuotaExceeded()) {
            usleep(self::retryDelayUs($attempt));
            Log::info('Retrying translation', [
                'target' => $targetLang,
                'attempt' => $attempt + 1,
                'length' => mb_strlen($text),
            ]);

            return self::translateChunkWithRetry($text, $targetLang, $attempt + 1);
        }

        return $result;
    }

    private static function translateChunkOnce(string $text, string $targetLang): string
    {
        $googleKey = config('services.google_translate.key');
        if (! empty($googleKey)) {
            return self::translateWithGoogle($text, $targetLang, $googleKey);
        }

        return self::translateWithMyMemory($text, $targetLang);
    }

    private static function requestDelayUs(): int
    {
        return (int) config('translation.chunk_delay_us', 350000);
    }

    private static function retryDelayUs(int $attempt): int
    {
        return (int) config('translation.retry_delay_us', 500000) * $attempt;
    }

    private static function translateHtmlPreservingStructure(string $html, string $targetLang): string
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);

        $wrapper = '<?xml version="1.0" encoding="UTF-8"?>'
            .'<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>'
            .'<body><div id="translation-root">'.$html.'</div></body></html>';

        $dom->loadHTML($wrapper, LIBXML_HTML_NODEFDTD | LIBXML_NOERROR);
        libxml_clear_errors();

        $root = $dom->getElementById('translation-root');
        if (! $root) {
            return self::translateLongText(strip_tags($html), $targetLang);
        }

        $xpath = new DOMXPath($dom);
        $textNodes = $xpath->query('.//text()[normalize-space()]', $root);

        if ($textNodes === false) {
            return self::translateLongText(strip_tags($html), $targetLang);
        }

        $delay = self::requestDelayUs();
        $requestIndex = 0;

        foreach ($textNodes as $textNode) {
            if (! $textNode instanceof \DOMText) {
                continue;
            }

            $parent = $textNode->parentNode;
            if ($parent instanceof DOMNode && in_array(strtolower($parent->nodeName), self::SKIP_TEXT_PARENT_TAGS, true)) {
                continue;
            }

            $original = $textNode->nodeValue;
            if (trim($original) === '') {
                continue;
            }

            if ($requestIndex > 0 && $delay > 0) {
                usleep($delay);
            }
            $requestIndex++;

            $translated = self::translateTextNodeValue($original, $targetLang);
            $textNode->nodeValue = $translated;
        }

        $output = '';
        foreach ($root->childNodes as $child) {
            $output .= $dom->saveHTML($child);
        }

        return $output !== '' ? $output : $html;
    }

    private static function translateTextNodeValue(string $value, string $targetLang): string
    {
        if (! preg_match('/^(\s*)([\s\S]*?)(\s*)$/u', $value, $matches)) {
            return self::translateLongText($value, $targetLang);
        }

        [, $leading, $core, $trailing] = $matches;

        if (trim($core) === '') {
            return $value;
        }

        return $leading.self::translateLongText($core, $targetLang).$trailing;
    }

    private static function isQuotaExceeded(): bool
    {
        return Cache::has('translation_quota_exceeded');
    }

    private static function markQuotaExceeded(): void
    {
        $tomorrow = now('UTC')->addDay()->startOfDay();
        Cache::put('translation_quota_exceeded', true, $tomorrow);

        Log::warning('Translation quota exceeded, will retry at '.$tomorrow->toDateTimeString().' UTC');
    }

    private static function isApiErrorResponse(string $translatedText): bool
    {
        $needles = [
            'MYMEMORY WARNING',
            'QUOTA',
            'QUERY LENGTH LIMIT',
            'MAX ALLOWED QUERY',
        ];

        foreach ($needles as $needle) {
            if (stripos($translatedText, $needle) !== false) {
                return true;
            }
        }

        return false;
    }

    private static function translateWithMyMemory(string $text, string $targetLang): string
    {
        try {
            $response = Http::timeout(15)->get('https://api.mymemory.translated.net/get', [
                'q' => $text,
                'langpair' => 'vi|'.$targetLang,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $translatedText = $data['responseData']['translatedText'] ?? '';

                if (self::isApiErrorResponse($translatedText)) {
                    if (stripos($translatedText, 'LENGTH LIMIT') !== false && mb_strlen($text) > 100) {
                        return self::translateLongText($text, $targetLang);
                    }

                    if (stripos($translatedText, 'QUOTA') !== false) {
                        self::markQuotaExceeded();
                    }

                    return $text;
                }

                if (isset($data['matches']) && is_array($data['matches'])) {
                    foreach ($data['matches'] as $match) {
                        if (! empty($match['translation']) && $match['translation'] !== $text) {
                            $candidate = $match['translation'];
                            if (! self::isApiErrorResponse($candidate)) {
                                return $candidate;
                            }
                        }
                    }
                }

                if ($translatedText !== '' && $translatedText !== $text) {
                    return $translatedText;
                }
            }

            if ($response->status() === 429) {
                self::markQuotaExceeded();
            } else {
                Log::warning('Translation API failed', [
                    'target' => $targetLang,
                    'status' => $response->status(),
                    'length' => mb_strlen($text),
                ]);
            }

            return $text;
        } catch (\Throwable $e) {
            Log::error('MyMemory translation exception', [
                'target' => $targetLang,
                'error' => $e->getMessage(),
            ]);

            return $text;
        }
    }

    private static function translateWithGoogle(string $text, string $targetLang, string $apiKey): string
    {
        try {
            $response = Http::timeout(20)->post('https://translation.googleapis.com/language/translate/v2', [
                'q' => $text,
                'source' => 'vi',
                'target' => $targetLang,
                'key' => $apiKey,
                'format' => 'html',
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['data']['translations'][0]['translatedText'])) {
                    return $data['data']['translations'][0]['translatedText'];
                }
            }

            Log::warning('Google Translate API failed', [
                'target' => $targetLang,
                'status' => $response->status(),
            ]);

            return self::translateWithMyMemory($text, $targetLang);
        } catch (\Throwable $e) {
            Log::error('Google Translate exception', [
                'target' => $targetLang,
                'error' => $e->getMessage(),
            ]);

            return self::translateWithMyMemory($text, $targetLang);
        }
    }
}
