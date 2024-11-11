<?php

namespace App\Http\Middleware;

use Closure;

class SetHeaders
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin'); // Or 'unsafe-none'
        return $response;
    }
}
