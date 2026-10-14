<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        $response->headers->set('X-Content-Type-Options', 'nosniff');

        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');

        $csp = implode('; ', [
            "default-src 'self'",

            "script-src 'self' 'unsafe-inline' 'unsafe-eval' " .
                "https://cdn.tailwindcss.com " .
                "https://unpkg.com " .
                "https://cdn.jsdelivr.net " .
                "https://js.pusher.com",

            "style-src 'self' 'unsafe-inline' " .
                "https://fonts.googleapis.com",

            "font-src 'self' " .
                "https://fonts.gstatic.com",


            "img-src 'self' data: blob: " .
                "https://fonts.gstatic.com",

            "connect-src 'self' " .
                "https://sockjs-mt1.pusher.com " .
                "wss://ws-mt1.pusher.com",

            "frame-src 'self' " .
                "https://www.google.com",

            "form-action 'self'",

            "frame-ancestors 'self'",

            "base-uri 'self'",

            "object-src 'none'",

            "upgrade-insecure-requests",
        ]);

        $response->headers->set('Content-Security-Policy', $csp);

        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}
