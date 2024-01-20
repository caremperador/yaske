<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TokenPremiumController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('revendedor')) {
            $referidos = $user->referidos; // Obtener los referidos del usuario revendedor

            $token = $user->token_referido;
            $tokenExpiresAt = $user->token_referido_expires_at;
            $timeLeft = null;

            if ($token && $tokenExpiresAt) {
                $currentTime = Carbon::now();
                $expiresAt = Carbon::parse($tokenExpiresAt);

                if ($currentTime->lt($expiresAt)) {
                    $totalSeconds = $expiresAt->diffInSeconds($currentTime);
                    $minutes = intdiv($totalSeconds, 60);
                    $seconds = $totalSeconds % 60;
                    $timeLeft = $minutes . ' minuto' . ($minutes != 1 ? 's' : '') . ' y ' . $seconds . ' segundo' . ($seconds != 1 ? 's' : '');
                }
            }

            return view('token_referido', compact('referidos', 'token', 'timeLeft'));
        }
        // Redirigir si el usuario no es un revendedor
        return redirect()->route('home')->with('error', 'No autorizado');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('revendedor')) {
            $token = Str::random(6); // Genera un token de 6 caracteres
            $expiresAt = Carbon::now()->addMinutes(10);

            // Restablecer el campo token_referido_used a false
            $user->token_referido_used = false;
            $user->token_referido = $token;
            $user->token_referido_expires_at = $expiresAt;
            $user->save();

            // Almacenar en la sesión para persistencia después de la recarga
            session(['token' => $token, 'token_expires_at' => $expiresAt->toDateTimeString()]);

            return redirect()->back();
        } else {
            return redirect()->back()->with('error', 'No autorizado');
        }
    }
}
