<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class NotAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->is_admin) {
            return redirect('admin'.$request->server()['REQUEST_URI']);
        }

        return $next($request);
    }
}
