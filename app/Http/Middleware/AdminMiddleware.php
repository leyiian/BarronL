<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        if (Auth::check() && Auth::user()->rol === 'A') {
            return $next($request);
        }

        return redirect('/home')->with('error', 'No tienes acceso a esta sección eres un bribon y un muchichito muy rebelde.');
    }
}
