<?php

namespace App\Http\Middleware;
use Cmgmyr\Messenger\Models\Thread;

use Closure;

class Messages
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
        
        if (auth()->check() && $request->_company->subdomain != 'app') {
            \Session::put('messages', $request->_company->threads()->get());
        }    


        return $next($request);
    }
}
