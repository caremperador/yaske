<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class IsRevendedor
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->hasRole('revendedor')) {
            return $next($request);
        }

        return redirect('/')->with('error', 'No tienes permiso para acceder a esta área.');
    }
}