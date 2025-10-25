<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeviceToken
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->hasCookie('device_token')) {
            $token = (string) Str::uuid();
            $response = $next($request);
            $response->withCookie(cookie(
                'device_token',
                $token,
                60 * 24 * 365 * 2, // 2 ans
                null, null, true, true, false, 'Lax'
            ));
            return $response;
        }

        return $next($request);
    }
}
