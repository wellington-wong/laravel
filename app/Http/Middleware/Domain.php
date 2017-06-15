<?php

namespace App\Http\Middleware;

use App\Company;
use Closure;
use Illuminate\Support\Facades\View;

class Domain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next )
    {
        //FOR IF THIS ROUTING PROBLEM EVER GETS SORTED
        //https://github.com/laravel/framework/issues/844
        //$subdomain = $request->route()->parameters()['subdomain'];
        $hosts = explode('.', $request->getHost());
        $subdomain = $hosts[0];
        $request->current_subdomain = $subdomain;
        
        $request->_company = Company::where('subdomain', $subdomain)->first();

        return $next($request);
    }
}
