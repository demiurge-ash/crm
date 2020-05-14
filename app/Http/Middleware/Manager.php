<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Manager
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
        if (Auth::user() && (
                Auth::user()->hasRole('editor')
                || Auth::user()->hasRole('manager')
                || Auth::user()->hasRole('admin')
                || Auth::user()->hasRole('supermanager')
            )
        ) {
            return $next($request);
        }
        abort(403, 'Доступ запрещён.');
    }
}
