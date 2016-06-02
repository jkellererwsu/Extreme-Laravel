<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfWrongChurch
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
           $user = $request->user();
            if($user && $user->church_id == $user->church_id)
            {
                return $next($request);
            }
        //abort(404, 'No way.');
        return redirect('contacts');


    }
}
