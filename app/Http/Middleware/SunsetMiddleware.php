<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SunsetMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $date): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $deprecated = now()->gte(Carbon::parse($date));

        $response->headers->set('Sunset', $date, true);
        $response->headers->set('Deprecated', $deprecated ? 'true' : 'false', true);

        return $response;
    }
}
