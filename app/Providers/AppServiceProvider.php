<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\DiasPremiumController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.template', function ($view) {
            if (auth()->check()) {
                $user = auth()->user();
                $controller = new DiasPremiumController();
                $diasPremium = $controller->verificarYActualizarEstadoPremium($user);
                $view->with('diasPremium', $diasPremium);
            }
        });

        // Composer para 'layouts.template-configuracion'
        View::composer('layouts.template-configuracion', function ($view) {
            if (auth()->check()) {
                // Envía el ID del usuario a la vista
                $view->with('userId', Auth::id());
            }
        });
    }
}
