<?php

namespace App\Http\Middleware;

use App\Company;
use Closure;
use Exults\Logs\UserLog;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;

use MetaTag;

function stripos_array($haystack, $needles){
    foreach($needles as $needle) {
        if(($res = stripos($haystack, $needle)) !== false) {
            return $res;
        }
    }
    return false;
}

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
        if ( env('ROOT_SUBDOMAIN', '') != $subdomain ) {
            if ( is_null($company) ) {
                return redirect('https://demo.' . config('app.domain') );
            }
        } else {
            //CHECKS IF ANY OF THESE STRINGS ARE IN THE URL
            $ok_routes = ['companies', 'company/create', 'login', 'register', 'logout', 'manage-account',
                'global-settings/login-as-user', 'password/reset', 'password/email', 'auth/facebook',
                'auth/google', 'how-it-works', 'features', 'about-us', 'pricing', 'contact', 'ajax-validate', 'stripe_pk', 'company/delete'];
            if ( stripos_array( trim($request->getRequestUri(), '/') , $ok_routes ) === false ) {
                return redirect('https://demo.' . config('app.domain') );
                return redirect()->route('all-companies');
            }
            $company = new \stdClass();
            $company->subdomain = 'referrals';
            $company->id = 0;
        }
        $company_id = isset($company->id) ? $company->id : 0;

        $request->current_subdomain = $subdomain;
        $request->_company = $company;
        config(['company_id' => $company_id]);
        View::share('_company', $company);

        /* user logs */
        UserLog::log();

        // Set metatags
        if (isset($company->company_name)) {
            MetaTag::set('title', $company->company_name);
            MetaTag::set('description', 'Referrals program for ' . $company->company_name);
        }

        return $next($request);
    }

    public function terminate()
    {
        UserLog::logEnd();
    }

}
