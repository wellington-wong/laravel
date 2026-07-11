<?php

namespace App\Http\Middleware;

use Closure;
use App\Company;

class CheckStripe
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

        // Get subdomain
        $hosts = explode('.', $request->getHost());
        $subdomain = $hosts[0];
        $routeUrls = [ 'logout', 'stripe_pk', 'company-update-card' ];
        
        // Redirect super admin to update credit card view if none is attached to the company

        return $next($request);
    }
}
