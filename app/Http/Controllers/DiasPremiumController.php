<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\DiasPremiumUser;
use Spatie\Permission\Models\Role;
use App\Events\TransactionApproved;
use App\Events\TransactionRejected;
use App\Events\TransactionCancelled;
use Illuminate\Support\Facades\Auth;
use App\Models\DiasPremiumRevendedor;
use Illuminate\Support\Facades\Storage;


class DiasPremiumController extends Controller
{
    public function index_comprar_dias_revendedor()
    {
        return view('diaspremium.buy_dias_revendedor');
    }

    public function store_comprar_dias_revendedor(Request $request)
    {
        // Validación de formulario
        $request->validate([
            'cantidad_dias' => 'required|integer|min:1', // Asegura que la cantidad sea un número entero positivo
        ]);

        $cantidadDias = $request->input('cantidad_dias');

        // Obtén el usuario autenticado (el revendedor)
        $revendedor = Auth::user();

        // Obtén o crea un modelo individual de DiasPremiumRevendedor asociado al usuario revendedor
        $diasPremiumRevendedor = $revendedor->diasPremiumRevendedor()->firstOrNew([]);

        // Incrementa el valor de 'dias_revendedor_premium'
        $diasPremiumRevendedor->dias_revendedor_premium += $cantidadDias;

        // Guarda el modelo en la base de datos
        $diasPremiumRevendedor->save();

        // Redirige de vuelta al formulario con un mensaje de éxito
        return redirect()->route('comprar_dias_revendedor.index')->with('success', 'Días premium comprados con éxito.');
    }


    // funcion vender dias

    public function index_vender_dias_directo()
    {
        return view('diaspremium.sell_dias_revendedor');
    }
    public function store_vender_dias_directo(Request $request)
    {
        // Validación de formulario
        $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'cantidad_dias' => 'required|integer|min:1',
        ]);

        $usuarioId = $request->input('usuario_id');
        $cantidadDias = $request->input('cantidad_dias');

        // Obtén el usuario autenticado (el revendedor)
        $revendedor = Auth::user();

        // Obtén el modelo individual de DiasPremiumRevendedor del revendedor
        $diasPremiumRevendedor = $revendedor->diasPremiumRevendedor()->first();

        // Verifica que el revendedor tenga suficientes días premium para vender
        if ($diasPremiumRevendedor && $diasPremiumRevendedor->dias_revendedor_premium >= $cantidadDias) {
            // Obtén el usuario al que se van a vender los días premium
            $usuarioComprador = User::find($usuarioId);

            if ($usuarioComprador) {
                // Obtén o crea un modelo de DiasPremiumUsuario asociado al usuario comprador
                $diasPremiumUsuario = $usuarioComprador->diasPremiumUsuario()->firstOrNew([]);
                $diasPremiumUsuario->dias_usuario_premium += $cantidadDias; // Acumula los días premium
                $diasPremiumUsuario->save();

                // Actualiza el modelo del revendedor
                $diasPremiumRevendedor->decrement('dias_revendedor_premium', $cantidadDias);

                // Asignar el rol "premium" si es necesario
                $premiumRole = Role::where('name', 'premium')->first();
                if ($premiumRole && !$usuarioComprador->hasRole($premiumRole)) {
                    $usuarioComprador->assignRole($premiumRole);
                }

                // Redirigir con mensaje de éxito
                return redirect()->route('vender_dias_directo.index')->with('success', 'Días premium vendidos con éxito.');
            } else {
                // El usuario comprador no existe, muestra un mensaje de error
                return redirect()->route('vender_dias_directo.index')->with('error', 'El usuario comprador no existe.');
            }
        } else {
            // El revendedor no tiene suficientes días premium para vender, muestra un mensaje de error
            return redirect()->route('vender_dias_directo.index')->with('error', 'No tienes suficientes días premium para vender.');
        }
    }




    // activar dias premium cuando vea el video premium


    public function activarDiasPremium($userId)
    {
        $user = User::find($userId);
        $diasPremiumUsuario = $user->diasPremiumUsuario()->first();

        // Asegúrate de que el usuario tiene días premium disponibles.
        if ($diasPremiumUsuario && $diasPremiumUsuario->dias_usuario_premium > 0) {

            // Comprueba si actualmente hay un período premium activo.
            $fechaFinEsPasada = $diasPremiumUsuario->fin_fecha_dias_usuario_premium
                ? Carbon::parse($diasPremiumUsuario->fin_fecha_dias_usuario_premium)->isPast()
                : true;

            if ($fechaFinEsPasada) {
                // Si no hay un período premium activo, activa uno nuevo y descuenta un día.
                $diasPremiumUsuario->inicio_fecha_dias_usuario_premium = now();
                $diasPremiumUsuario->fin_fecha_dias_usuario_premium = now()->addDay();
                $diasPremiumUsuario->dias_usuario_premium -= 1; // Decrementa un día.
                $diasPremiumUsuario->save();
            }
        }
    }



    // funcion comprobar si tiene dias premium caducados y si es asi quitarle el rol premium



    public function verificarYActualizarEstadoPremium($user)
    {
        // Verificar si el usuario tiene algún registro de días premium
        $diasPremiumUsuario = $user->diasPremiumUsuario()->first();

        // Inicializar valores para comprobar si tiene días premium y si la fecha de fin ha pasado
        $tieneDiasPremium = $diasPremiumUsuario ? $diasPremiumUsuario->dias_usuario_premium > 0 : false;
        $esFechaFinPasada = $diasPremiumUsuario && $diasPremiumUsuario->fin_fecha_dias_usuario_premium
            ? Carbon::parse($diasPremiumUsuario->fin_fecha_dias_usuario_premium)->isPast()
            : true;

        // Quitar el rol premium solo si el usuario no tiene días premium y la fecha de fin ha pasado
        if (!$tieneDiasPremium && $esFechaFinPasada) {
            if ($user->hasRole('premium')) {
                $user->removeRole('premium');
            }
        }

        // Asignar o mantener el rol premium si tiene días premium o la fecha de fin no ha pasado
        if ($tieneDiasPremium || !$esFechaFinPasada) {
            if (!$user->hasRole('premium')) {
                $user->assignRole('premium');
            }
        }

        // Devolver la cantidad de días premium restantes o cero si no tiene
        return $tieneDiasPremium ? $diasPremiumUsuario->dias_usuario_premium : 0;
    }

    public function gastarDiaPremium(Request $request, $videoId)
    {
        if (Auth::check() && Auth::user()->hasRole('premium')) {
            $this->activarDiasPremium(Auth::id());

            // Redirigir a la página del video con una sesión flash para mostrar el video
            return redirect()->route('videos.show', $videoId)->with('dia_premium_gastado', true);
        } else {
            return redirect()->route('videos.show', $videoId)->withErrors('No tienes permisos para ver este video.');
        }
    }
    public function obtenerDiasPremiumUsuario($userId)
    {
        return User::find($userId)->diasPremiumUsuario()->first();
    }

    public function aprobarTransaccion($transactionId)
    {
        $transaction = Transaction::find($transactionId);

        // Verifica si la transacción existe y si el usuario autenticado es el vendedor.
        if ($transaction && $transaction->seller_id == auth()->id()) {
            $revendedor = DiasPremiumRevendedor::where('user_id', $transaction->seller_id)->first();
            $comprador = DiasPremiumUser::where('user_id', $transaction->buyer_id)->firstOrCreate(['user_id' => $transaction->buyer_id]);

            // Calcula los nuevos días premium
            $diasPremiumTransferidos = $transaction->cantidad_dias;
            $revendedor->dias_revendedor_premium -= $diasPremiumTransferidos;
            $comprador->dias_usuario_premium += $diasPremiumTransferidos;

            // Guarda los cambios en la base de datos
            try {
                $revendedor->save();
                $comprador->save();

                // Elimina la foto del almacenamiento
                Storage::delete('public/' . $transaction->photo_path);
                // Elimina la transacción después de la aprobación
                $transaction->delete();
                // Disparar el evento cuando una transacción es aprobada
                event(new TransactionApproved($transactionId));
                return back()->with('success', 'Transacción aprobada y días premium transferidos correctamente.');
            } catch (\Exception $e) {
                \Log::error('Error al aprobar la transacción: ' . $e->getMessage());
                return back()->with('error', 'Ocurrió un error al aprobar la transacción. Por favor, inténtalo de nuevo.');
            }
        }

        return back()->with('error', 'No se pudo aprobar la transacción.');
    }

    public function cancelarTransaccionCliente($transactionId)
    {
        $transaction = Transaction::find($transactionId);

        // Verifica si la transacción existe y si el usuario autenticado es el comprador.
        if ($transaction && $transaction->buyer_id == auth()->id()) {

            // Guarda el ID del vendedor antes de eliminar la transacción
            $sellerId = $transaction->seller_id;
            // Elimina la foto del almacenamiento
            Storage::delete('public/' . $transaction->photo_path);

            // Elimina la transacción de la base de datos
            $transaction->delete();

            // Eliminar la imagen y el ID de la transacción de la sesión
            session()->forget(['transactionImagePath', 'transactionId']);

            event(new TransactionCancelled($transactionId, $sellerId));
            return redirect()->route('envio_comprobante.index', $transaction->seller_id)->with('success', 'Transacción cancelada con éxito.');
        }

        return back()->with('error', 'No se pudo cancelar la transacción.');
    }


    public function rechazarTransaccion($transactionId)
    {
        $transaction = Transaction::find($transactionId);
        // ... Lógica para manejar el rechazo de la transacción ...
        event(new TransactionRejected($transactionId));
        // ... Resto de la lógica del controlador ...
    }


    public function estadoTransaccion($transactionId)
    {
        $transaction = Transaction::with('buyer')->find($transactionId);
        $sellerId = $transaction->seller_id;
        $transactionId = $transaction->id;
        $buyerId = $transaction->buyer_id;
        if (!$transaction || $transaction->buyer_id != auth()->id()) {
            return redirect()->route('transacciones.envio')->with('error', 'Transacción no encontrada.');
        }

        return view('diaspremium.transacciones.estado_transaccion', compact('transaction', 'sellerId', 'transactionId', 'buyerId'));
    }
    public function transaccionAprobada()
    {
        return view('diaspremium.transacciones.estado_aprobado');
    }
}
