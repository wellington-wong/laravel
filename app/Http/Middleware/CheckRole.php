<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use app\Role;
use App\RoleUser;
use App\Company;

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
            // Assign user as member when no role is found
            if (!count(auth()->user()->roles)) {
                if ($member = Role::where('name', 'member')->first()) {
                    auth()->user()->attachRole($member);
                }
            }
        }

        return $next($request);
    }
}
