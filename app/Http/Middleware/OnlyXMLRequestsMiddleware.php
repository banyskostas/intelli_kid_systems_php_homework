<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
//use Illuminate\Http\Client\Request;
use Symfony\Component\HttpFoundation\Response;


class OnlyXMLRequestsMiddleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isXmlHttpRequest()) {
            abort(400, 'Only "X-Requested-With: XMLHttpRequest" requests are allowed');
        }

        return $next($request);
    }
}
