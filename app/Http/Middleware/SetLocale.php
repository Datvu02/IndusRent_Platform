<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Các locale được hỗ trợ: Việt, Anh, Trung.
     */
    protected array $locales = ['vi', 'en', 'zh'];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('app.locale', 'vi'));

        if (in_array($locale, $this->locales, true)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
