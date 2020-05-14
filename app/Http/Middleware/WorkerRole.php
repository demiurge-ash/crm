<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class WorkerRole
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
                || Auth::user()->hasRole('admin')
                || Auth::user()->hasRole('manager')
                || Auth::user()->hasRole('supermanager')
                || Auth::user()->hasRole('designer')
                )
            ) {
            return $next($request);
        }
        abort(403, 'Доступ запрещён.');
    }
}
