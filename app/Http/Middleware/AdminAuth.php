<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard("admin")->check()) {
            return redirect()->route("admin.login")
                ->with("error", "Vui lòng đăng nhập để tiếp tục.");
        }

        return $next($request);
    }
}
