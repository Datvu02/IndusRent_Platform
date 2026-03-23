<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class TrustNgrokProxy
{
    /**
     * When accessed via ngrok, force HTTPS so asset() and url() generate correct URLs.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        if (str_ends_with($host, '.ngrok-free.app') || str_ends_with($host, '.ngrok-free.dev')) {
            URL::forceScheme('https');
        }

        return $next($request);
    }
}
