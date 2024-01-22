<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiasPremiumRevendedor;
use App\Models\AdminConfiguracionPais;

class AdminConfiguracionPaisController extends Controller
{
    // Método para mostrar el formulario de configuración
    public function index()
    {
        $configuraciones = AdminConfiguracionPais::all();
        $paises = DiasPremiumRevendedor::select('pais')->distinct()->pluck('pais');
    
        return view('admin.admin_configuracion_pais', compact('configuraciones', 'paises'));
    }
    



    // Método para procesar y guardar la configuración
    public function store(Request $request)
    {
        $request->validate([
            'pais' => 'required|string|max:255',
            'precio_minimo' => 'required|numeric|min:0',
            'precio_maximo' => 'required|numeric|min:0|gte:precio_minimo',
        ]);

        try {
            AdminConfiguracionPais::updateOrCreate(
                ['pais' => $request->pais],
                [
                    'precio_minimo' => $request->precio_minimo,
                    'precio_maximo' => $request->precio_maximo
                ]
            );

            return redirect()->route('admin.configuracion.pais')->with('success', 'Configuración guardada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar la configuración del país: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al guardar la configuración. Inténtalo de nuevo.');
        }
    }
}
