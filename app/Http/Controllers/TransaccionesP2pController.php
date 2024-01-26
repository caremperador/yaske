<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\NewTransaction;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Events\TransactionCancelled;
use Illuminate\Support\Facades\Auth;
use App\Models\DiasPremiumRevendedor;
use App\Models\AdminConfiguracionPais;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class TransaccionesP2pController extends Controller
{
    public function mostrarPerfil($slug)
    {
        $revendedor = DiasPremiumRevendedor::where('slug', $slug)->firstOrFail();
        return view('diaspremium.perfil_revendedor', compact('revendedor'));
    }


    public function seleccionarRevendedor()
    {
        $revendedores = User::role('revendedor')
            ->select('users.*', 'diaspremium_revendedores.moneda', 'diaspremium_revendedores.precio')
            ->join('diaspremium_revendedores', 'users.id', '=', 'diaspremium_revendedores.user_id')
            ->where('diaspremium_revendedores.estado_conectado', true)
            ->where('diaspremium_revendedores.dias_revendedor_premium', '>', 0) // Añadir esta línea
            ->orderBy('diaspremium_revendedores.moneda') // Ordenar primero por moneda
            ->orderBy('diaspremium_revendedores.precio') // Luego por precio
            ->with('diasPremiumRevendedor')
            ->paginate(10);

        // Conversión manual para 'ultimo_conexion' a Carbon
        foreach ($revendedores as $revendedor) {
            if ($revendedor->diasPremiumRevendedor && $revendedor->diasPremiumRevendedor->ultimo_conexion) {
                $revendedor->diasPremiumRevendedor->ultimo_conexion = Carbon::parse($revendedor->diasPremiumRevendedor->ultimo_conexion)->locale('es');
            }
        }

        return view('diaspremium.transacciones.seleccionarRevendedor', compact('revendedores'));
    }


    public function seleccionarRevendedorFiltrado(Request $request)
    {
        $paisSeleccionado = $request->input('pais');

        $query = User::role('revendedor')
            ->select('users.*')
            ->join('diaspremium_revendedores', 'users.id', '=', 'diaspremium_revendedores.user_id')
            ->where('diaspremium_revendedores.estado_conectado', true)
            ->where('diaspremium_revendedores.dias_revendedor_premium', '>', 0) // Añadir esta línea
            ->with('diasPremiumRevendedor');

        if ($paisSeleccionado) {
            $query->where('diaspremium_revendedores.pais', $paisSeleccionado);
        }

        // Ordenar por precio de menor a mayor
        $query->orderBy('diaspremium_revendedores.precio');

        $revendedores = $query->paginate(10);

        // Conversión manual para 'ultimo_conexion' a Carbon
        foreach ($revendedores as $revendedor) {
            if ($revendedor->diasPremiumRevendedor && $revendedor->diasPremiumRevendedor->ultimo_conexion) {
                $revendedor->diasPremiumRevendedor->ultimo_conexion = Carbon::parse($revendedor->diasPremiumRevendedor->ultimo_conexion)->locale('es');
            }
        }

        return view('diaspremium.transacciones.seleccionarRevendedor', compact('revendedores'));
    }




    public function index_envio_comprobante($seller_id = null)
    {
        $user = auth()->user();
        $ultimaTransaccion = Transaction::where('buyer_id', $user->id)
            ->latest()
            ->first();

        $transaccionAprobada = $ultimaTransaccion ? $ultimaTransaccion->aprobada : false;

        $revendedor = null;
        $metodosPago = [];
        $cantidadMinima = 0;
        $precioPorDia = 0;
        $moneda = '';
        $pais = '';

        if ($seller_id) {
            $revendedor = User::with('diasPremiumRevendedor')->find($seller_id);
            if ($revendedor && $revendedor->diasPremiumRevendedor) {
                $metodosPago = json_decode($revendedor->diasPremiumRevendedor->metodos_pago, true) ?? [];
                $cantidadMinima = $revendedor->diasPremiumRevendedor->cantidad_minima;
                $precioPorDia = $revendedor->diasPremiumRevendedor->precio;
                $moneda = $revendedor->diasPremiumRevendedor->moneda;
                $pais = $revendedor->diasPremiumRevendedor->pais;
            }
        }

        return view('diaspremium.transacciones.envioComprobante', compact('seller_id', 'revendedor', 'metodosPago', 'cantidadMinima', 'precioPorDia', 'moneda', 'pais', 'transaccionAprobada'));
    }



    public function store_envio_comprobante(Request $request)
    {
        // Obtener el revendedor y su cantidad mínima
        $revendedor = User::find($request->seller_id)->diasPremiumRevendedor;
        $cantidadMinima = $revendedor->cantidad_minima;
        $request->validate([
            'photo' => 'required|image|max:2048',
            'seller_id' => 'required|exists:users,id', // Asegúrate de que el ID del vendedor existe
            'cantidad_dias' => 'required|integer|min:' . $cantidadMinima,
        ]);

        $path = $request->file('photo')->store('photos', 'public');

        $transaction = new Transaction();
        $transaction->buyer_id = auth()->id(); // ID del comprador
        $transaction->seller_id = $request->seller_id; // ID del vendedor del formulario
        $transaction->photo_path = $path;
        $transaction->metodo_pago = $request->input('metodo_pago');
        $transaction->cantidad_dias = $request->input('cantidad_dias'); // Asegúrate de que este campo se envíe desde el formulario
        $transaction->monto_total = $request->input('monto_total'); // Este valor deberías calcularlo basado en el precio por día y la cantidad de días
        $transaction->save();





        // Dispara el evento después de guardar la transacción
        event(new NewTransaction($transaction));

        return redirect()->route('transacciones.estado', $transaction->id);
    }

    public function conectarDesconectar()
    {
        $revendedor = Auth::user()->diasPremiumRevendedor;

        if (!$revendedor) {
            return redirect()->route('configuracion_revendedor.index')
                ->with('error', 'Por favor, completa tu configuración de revendedor primero.');
        }

        // Verificar si el revendedor tiene métodos de pago y días premium
        $metodosPago = json_decode($revendedor->metodos_pago, true);
        $tieneMetodosPago = !empty($metodosPago);
        $tieneDiasPremium = $revendedor->dias_revendedor_premium > 0;

        if ($tieneMetodosPago && $tieneDiasPremium) {
            // Cambiar estado de conexión y actualizar último momento de conexión
            $revendedor->estado_conectado = !$revendedor->estado_conectado;
            if ($revendedor->estado_conectado) {
                $revendedor->ultimo_conexion = now(); // Actualizar solo si se está conectando
            }
            
            $revendedor->save();

            return back()->with('success', $revendedor->estado_conectado ? 'Conectado' : 'Desconectado');
        } else {
            // Mensaje de error si no cumple los requisitos
            $mensajeError = '';
            if (!$tieneMetodosPago) {
                $mensajeError = 'Debes añadir al menos un método de pago. ';
            }
            if (!$tieneDiasPremium) {
                $mensajeError .= 'Debes tener días premium disponibles.';
            }

            return back()->with('error', $mensajeError);
        }
    }




    public function show_transacciones()
    {
        $sellerId = auth()->id(); // Obtiene el ID del vendedor autenticado

        // Obtener información de días premium del revendedor
        $revendedor = DiasPremiumRevendedor::where('user_id', $sellerId)->first();

        // Comprueba si el revendedor tiene días premium y que no sean negativos
        if ($revendedor && $revendedor->dias_revendedor_premium > 0) {
            // Obtiene las transacciones si cumple con las condiciones
            $transactions = Transaction::where('seller_id', $sellerId)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Si no cumple con las condiciones, establece las transacciones como un array vacío
            $transactions = collect();
        }

        return view('diaspremium.transacciones.recibirComprobante', compact('transactions', 'sellerId'));
    }



    /*
   ##########################################################
   CONFIGURACION DE REVENDEDOR
   ##########################################################
   */

    public function index_configuracion_revendedor()
    {
        $user = auth()->user();
        $diasPremiumRevendedor = $user->diasPremiumRevendedor ?? new DiasPremiumRevendedor(['user_id' => $user->id]);

        $preciosPaises = AdminConfiguracionPais::all();

        return view('diaspremium.revendedor_configuracion', compact('diasPremiumRevendedor', 'preciosPaises'));
    }

    public function store_configuracion_revendedor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres_beneficiario' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'apellidos_beneficiario' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'pais' => 'required|string',
            'moneda' => 'required|string',
            'prefijo_telefonico' => 'required|string',
            'numero_telefono' => 'required|string',
            'cantidad_minima' => 'required|integer|min:1',
            'precio' => 'required|numeric',
            // Asegúrate de validar otros campos si es necesario
        ]);

        if ($validator->fails()) {
            Session::flash('error', 'Hay errores en el formulario. Por favor, revisa los datos ingresados.');
            return back()->withErrors($validator)->withInput();
        }
        $user = auth()->user();
        $diasPremiumRevendedor = $user->diasPremiumRevendedor ?? new DiasPremiumRevendedor(['user_id' => $user->id]);

        if (empty($diasPremiumRevendedor->slug)) {
            $nombres = $request->input('nombres_beneficiario');
            $apellidos = $request->input('apellidos_beneficiario');
            $slugPropuesto = Str::slug($nombres . ' ' . $apellidos, '-');

            $existeSlug = DiasPremiumRevendedor::where('slug', $slugPropuesto)->exists();
            if ($existeSlug) {
                return redirect()->back()
                    ->with('error', 'El nombre y apellido ingresado ya está en uso. Por favor, elige otro.')
                    ->withInput();
            }


            $diasPremiumRevendedor->nombres_beneficiario = $nombres;
            $diasPremiumRevendedor->apellidos_beneficiario = $apellidos;
            $diasPremiumRevendedor->slug = $slugPropuesto;
        }

        // Obtener la configuración del país seleccionado
        $configuracionPais = AdminConfiguracionPais::where('pais', $request->pais)->first();

        // Validar el precio dentro del rango permitido
        if ($configuracionPais) {
            $request->validate([
                'precio' => 'required|numeric|min:' . $configuracionPais->precio_minimo . '|max:' . $configuracionPais->precio_maximo,
            ]);
        } else {
            // Si no hay configuración para ese país, puedes decidir si permites cualquier precio
            // o si aplicas una validación genérica
            $request->validate([
                'precio' => 'required|numeric',
            ]);
        }

        $diasPremiumRevendedor->pais = $request->pais;
        $diasPremiumRevendedor->moneda = $request->moneda;
        $diasPremiumRevendedor->prefijo_telefonico = $request->prefijo_telefonico;
        $diasPremiumRevendedor->numero_telefono = $request->numero_telefono;
        $diasPremiumRevendedor->cantidad_minima = $request->cantidad_minima;
        $diasPremiumRevendedor->precio = $request->precio;

        try {
            $diasPremiumRevendedor->save();
            return back()->with('success', 'Información actualizada correctamente.');
        } catch (\Exception $e) {
            \Log::error('Error al guardar configuración de revendedor: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al guardar la configuración. Por favor, inténtalo de nuevo.');
        }
    }


    /*
   ##########################################################
   METODOS DE PAGO
   ##########################################################
   */

    public function index_metodos_pago()
    {
        $user = auth()->user();
        $revendedor = DiasPremiumRevendedor::where('user_id', auth()->id())->firstOrFail();
        $metodosPagoExistentes = json_decode($revendedor->metodos_pago, true) ?? [];


        return view('diaspremium.añadir_metodos_pago', compact('metodosPagoExistentes'));
    }

    public function store_metodos_pago(Request $request)
    {
        try {
            $request->validate([
                'metodo_pago_nombre.*' => 'required|string|max:255',
                'metodo_pago_detalle.*' => 'required|string|max:255',
                // Agrega otras reglas de validación según sea necesario
            ]);

            $user = auth()->user();
            $revendedor = DiasPremiumRevendedor::where('user_id', $user->id)->firstOrFail();

            // Depuración: Ver los datos enviados
            Log::info('Datos del formulario:', $request->all());

            $metodosPagoExistentes = json_decode($revendedor->metodos_pago, true) ?? [];

            foreach ($request->metodo_pago_nombre as $index => $nombre) {
                if (!empty($nombre) && isset($request->metodo_pago_detalle[$index])) {
                    $metodosPagoExistentes[] = [
                        'nombre' => $nombre,
                        'detalle' => $request->metodo_pago_detalle[$index],
                    ];
                }
            }

            $revendedor->metodos_pago = $metodosPagoExistentes;
            $revendedor->save();

            return back()->with('success', 'Métodos de pago actualizados correctamente.');
        } catch (\Exception $e) {
            \Log::error('Error al guardar métodos de pago:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Hubo un error al guardar los métodos de pago.');
        }
    }


    /*
   ##########################################################
   EDITAR PERFIL DE REVENDEDOR
   ##########################################################
   */
    public function index_perfil_revendedor()
    {
        $revendedor = Auth::user()->diasPremiumRevendedor;


        return view('diaspremium.form_perfil_revendedor', compact('revendedor'));
    }

    public function store_perfil_revendedor(Request $request)
    {
        $request->validate([
            'mensaje_perfil' => 'nullable|string',
            'link_telegram' => 'nullable|url',
            'link_whatsapp' => 'nullable|url',
            'foto_perfil' => 'nullable|image|max:2048', // 2MB como máximo
        ]);

        $revendedor = Auth::user()->diasPremiumRevendedor()->firstOrCreate(['user_id' => Auth::id()]);

        if ($request->hasFile('foto_perfil') && $request->file('foto_perfil')->isValid()) {
            // Almacenar la foto y obtener la ruta
            $rutaFoto = $request->foto_perfil->store('fotos_perfil', 'public');

            // Si quieres borrar la foto antigua del servidor, descomenta la siguiente línea
            // Storage::disk('public')->delete($revendedor->foto_perfil);

            $revendedor->foto_perfil = $rutaFoto;
        }

        $revendedor->mensaje_perfil = $request->mensaje_perfil;
        $revendedor->link_telegram = $request->link_telegram;
        $revendedor->link_whatsapp = $request->link_whatsapp;
        $revendedor->save();

        return redirect()->back()->with('success', 'Perfil actualizado con éxito.');
    }
}
