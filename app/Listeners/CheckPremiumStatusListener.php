<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;
use App\Models\User;
use Spatie\Permission\Models\Role;


class CheckPremiumStatusListener
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;

        // Comprobar si el usuario tiene días premium que aún no han caducado
        $diasPremium = $user->diasPremiumUsuario()->where('fin_fecha_dias_usuario_premium', '>', Carbon::now())->first();

        if ($diasPremium) {
            // Caso 1: El usuario tiene días premium disponibles que no han caducado
            // Asegurarse de que tenga el rol 'premium'
            if (!$user->hasRole('premium')) {
                $user->assignRole('premium');
            }
        } else {
            // Caso 2: El usuario no tiene días premium o han caducado
            // Eliminar el rol 'premium' si lo tiene
            if ($user->hasRole('premium')) {
                $user->removeRole('premium');
            }
        }
    }
}