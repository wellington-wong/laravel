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
        // Count all unread message/s for user in current company
        if ($request->_company->id) {
            $userThreadsByCompany = $request->_company->threads()->get();
            $messageCount = 0;
            if (auth()->user()) {
                foreach ($userThreadsByCompany as $key => $thread) {
                    $messageCount = $messageCount + $thread->userUnreadMessagesCount(auth()->user()->id);
                }
                if (auth()->check() && $request->_company->subdomain != 'app') {
                    \Session::put('messageCount', $messageCount);
                }    
            }
        }


        return $next($request);
    }
}
