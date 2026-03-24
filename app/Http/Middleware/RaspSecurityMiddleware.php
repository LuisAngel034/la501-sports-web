<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RaspSecurityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        $patterns = ['/select/i', '/union/i', '/<script>/i', '/\.\.\//', '/--/'];

        foreach ($input as $value) {
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, (string)$value)) {
                    ob_clean();
                    $html = view('errors.403')->render();
                    die($html);
                }
            }
        }

        return $next($request);
    }
}
