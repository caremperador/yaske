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
            $diasPremiumRevendedor = auth()->user()->diasPremiumRevendedor;

            // Verificar y actualizar el estado si es necesario
            if ($diasPremiumRevendedor && $diasPremiumRevendedor->dias_revendedor_premium <= 0) {
                $diasPremiumRevendedor->estado_conectado = false;
                $diasPremiumRevendedor->save();
            }

            return $next($request);
        }

        return redirect('/')->with('error', 'No tienes permiso para acceder a esta área.');
    }
}
