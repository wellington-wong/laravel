<?php

namespace App\Http\Middleware;

use App\Company;
use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;

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

        config(['company_id' => 0]);

        $company = Company::where('subdomain', $subdomain)->first();

        //IF THE SUBDOMAIN IS NOT VALID
        if ( 'app' != $subdomain ) {
            if ( is_null($company) ) {
                return redirect('https://app.' . $_ENV['APP_URL'] );
            }
        }

        $request->current_subdomain = $subdomain;
        $request->_company = $company;
        config(['company_id' => $company->id]);
        View::share('_company', $company);

        return $next($request);
    }
}
