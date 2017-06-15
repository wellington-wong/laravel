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

        \Session::put('messages', Thread::forUserWithNewMessages(auth()->user()->id)->latest('updated_at')->get());

        return $next($request);
    }
}
