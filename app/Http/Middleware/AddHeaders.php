<?php

namespace App\Http\Middleware;

use Closure;

class AddHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $response = $next($request);

        $response->headers->set('Cache-Control', 'max-age=604800, public');
        $response->headers->set('Expires', gmdate("D, d M Y H:i:s", time() + 604800) . " GMT");

        return $response;
    }
}
