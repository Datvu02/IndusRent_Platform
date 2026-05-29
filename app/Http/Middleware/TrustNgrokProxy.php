<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class TrustNgrokProxy
{
    /**
     * Force HTTPS URL generation for ngrok or when enabled by env.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        $isNgrokHost = str_ends_with($host, '.ngrok-free.app') || str_ends_with($host, '.ngrok-free.dev');
        $forceHttps = (bool) config('app.force_https', false);

        if ($isNgrokHost || $forceHttps) {
            URL::forceScheme('https');
        }

        return $next($request);
    }
}
