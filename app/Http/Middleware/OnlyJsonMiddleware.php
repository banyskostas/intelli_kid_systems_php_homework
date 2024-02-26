<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
//use Illuminate\Http\Client\Request;
use Symfony\Component\HttpFoundation\Response;


class OnlyJsonMiddleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $header = $request->header('Accept');

        if (!in_array($header, ['application/json', '*/*'])) {
            abort(400, 'Only JSON requests are allowed');
        }

        if (!$request->hasHeader('Content-Type') ||
            !str_contains($request->header('Content-Type'), 'json')
        ) {
            abort(400, 'Only JSON requests are allowed');
        }

        return $next($request);
    }
}
