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

            // Assign member role when no role is found for this company
            if ( auth()->user()->roles()->where('company_id', $request->current_company_id)->get()->isEmpty()) {
                if ($member = Role::where('name', 'member')->first()) {
                    auth()->user()->roles()->save($member,
                        ['company_id'=>$request->current_company_id]);
                }
            }
        }

        return $next($request);
    }
}
