<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DoctorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && (Auth::user()->rol === 'D' || Auth::user()->rol === 'A')) {
            return $next($request);
        }

        return redirect('/home')->with('error', 'No tienes acceso a esta sección eres un bribon y un muchachito muy rebelde.');
    }
}
