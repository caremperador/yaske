<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\NewTransaction;
use Spatie\Permission\Models\Role;
use App\Events\TransactionCancelled;
use Illuminate\Support\Facades\Auth;
use App\Models\DiasPremiumRevendedor;
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
        // Asume que tienes una relación en tu modelo User para obtener los días premium
        $revendedores = User::role('revendedor')->with('diasPremiumRevendedor')->get();

        return view('diaspremium.transacciones.seleccionarRevendedor', compact('revendedores'));
    }

    public function index_envio_comprobante($seller_id = null)
    {
        $revendedor = null;
        if ($seller_id) {
            $revendedor = User::with('diasPremiumRevendedor')->find($seller_id);
        }

        return view('diaspremium.transacciones.envioComprobante', compact('seller_id', 'revendedor'));
    }

    public function store_envio_comprobante(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
            'seller_id' => 'required|exists:users,id', // Asegúrate de que el ID del vendedor existe
        ]);

        $path = $request->file('photo')->store('photos', 'public');

        $transaction = new Transaction();
        $transaction->buyer_id = auth()->id(); // ID del comprador
        $transaction->seller_id = $request->seller_id; // ID del vendedor del formulario
        $transaction->photo_path = $path;
        $transaction->save();

        // Guardar la ruta de la imagen y el ID de la transacción en la sesión
        session(['transactionImagePath' => $path, 'transactionId' => $transaction->id]);


        // Dispara el evento después de guardar la transacción
        event(new NewTransaction($transaction));

        return back()->with('success', 'Foto subida con éxito. Ruta del archivo: ' . $path);
    }


    public function show_transacciones()
    {
        $sellerId = auth()->id(); // Obtiene el ID del vendedor autenticado
        $transactions = Transaction::where('seller_id', $sellerId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('diaspremium.transacciones.recibirComprobante', compact('transactions', 'sellerId'));
    }
    public function cancelar_transacciones($transactionId)
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

            // Eliminar la imagen de la sesión
            session()->forget(['transactionImagePath', 'transactionId']);

            // Dispara el evento de transacción cancelada
            event(new TransactionCancelled($transactionId, $sellerId));

            return back()->with('success', 'Transacción cancelada con éxito.');
        }

        return back()->with('error', 'No se pudo cancelar la transacción.');
    }

    /*
   ##########################################################
   CONFIGURACION DE REVENDEDOR
   ##########################################################
   */

    public function index_configuracion_revendedor()
    {
        return view('diaspremium.revendedor_configuracion');
    }

    public function store_configuracion_revendedor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres_beneficiario' => 'sometimes|required|string|max:255',
            'apellidos_beneficiario' => 'sometimes|required|string|max:255',
            'pais' => 'required|string',
            'moneda' => 'required|string',
            'prefijo_telefonico' => 'required|string',
            'numero_telefono' => 'required|string',
            'cantidad_minima' => 'required|integer|min:1',
            'precio' => 'required|numeric',
            // Asegúrate de validar otros campos si es necesario
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = auth()->user();
        $diasPremiumRevendedor = $user->diasPremiumRevendedor ?? new DiasPremiumRevendedor(['user_id' => $user->id]);

        // Actualiza los campos solo si el slug no ha sido generado
        if (empty($diasPremiumRevendedor->slug)) {
            $diasPremiumRevendedor->nombres_beneficiario = $request->nombres_beneficiario;
            $diasPremiumRevendedor->apellidos_beneficiario = $request->apellidos_beneficiario;
            $diasPremiumRevendedor->slug = Str::slug($request->nombres_beneficiario . ' ' . $request->apellidos_beneficiario, '-');
        }

        $diasPremiumRevendedor->pais = $request->pais;
        $diasPremiumRevendedor->moneda = $request->moneda;
        $diasPremiumRevendedor->prefijo_telefonico = $request->prefijo_telefonico;
        $diasPremiumRevendedor->numero_telefono = $request->numero_telefono;
        $diasPremiumRevendedor->cantidad_minima = $request->cantidad_minima;
        $diasPremiumRevendedor->precio = $request->precio;
        $diasPremiumRevendedor->save();

        return back()->with('success', 'Información actualizada correctamente.');
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
        $request->validate([
            'metodo_pago_nombre.*' => 'required|string|max:255',
            'metodo_pago_detalle.*' => 'required|string|max:255',
            // Agrega otras reglas de validación según sea necesario
        ]);

        $user = auth()->user();
        $revendedor = DiasPremiumRevendedor::where('user_id', $user->id)->firstOrFail();

        // Obtener los métodos de pago actuales y convertirlos en un array
        $metodosPagoExistentes = json_decode($revendedor->metodos_pago, true) ?? [];

        // Agregar los nuevos métodos al array existente
        foreach ($request->metodo_pago_nombre as $index => $nombre) {
            if (!empty($nombre) && isset($request->metodo_pago_detalle[$index])) {
                $metodosPagoExistentes[] = [
                    'nombre' => $nombre,
                    'detalle' => $request->metodo_pago_detalle[$index],
                ];
            }
        }

        // Guardar el array actualizado en la base de datos
        $revendedor->metodos_pago = $metodosPagoExistentes;
        $revendedor->save();

        return back()->with('success', 'Métodos de pago actualizados correctamente.');
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
