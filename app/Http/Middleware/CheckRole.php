<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use app\Role;

class CheckRole
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
        if(Auth::check()){
            
            //IF THE SUBDOMAIN EXISTS AS A VALID COMPANY
            if( 0 != $request->_company->id ) {
                // Assign member role when no role is found for this company
                if ( !$request->user()->hasAnyRole() ) {
                    if ($role = Role::where('name', 'member')->first()) {
                        $request->user()->attachRole( $role );
                    }
                }
            }

        }

        //dd( $request->user()->hasRole(['member'] ) );

        return $next($request);
    }
}
