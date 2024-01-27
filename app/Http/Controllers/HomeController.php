<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use App\Models\Lista;
use App\Models\Video;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Tipos específicos
        $tipos = ['peliculas', 'series', 'animes', 'doramas', 'documentales', 'cursos', 'hentai', 'novelas']; // Ejemplo de tipos

        $secciones = [];

        foreach ($tipos as $tipoNombre) {
            $tipo = Tipo::where('name', $tipoNombre)->first();

            if ($tipo) {
                // Videos que no están en ninguna lista
                $videosSinLista = Video::where('tipo_id', $tipo->id)
                    ->whereNull('lista_id')
                    ->orderBy('created_at', 'desc')
                    ->take(4)
                    ->get();

                // Listas que pertenecen a este tipo
                $listas = Lista::where('tipo_id', $tipo->id)
                    ->orderBy('created_at', 'desc')
                    ->take(4)
                    ->get();

                $secciones[] = [
                    'tipo' => $tipo,
                    'videos' => $videosSinLista,
                    'listas' => $listas
                ];
            }
        }

        return view('home.index', compact('secciones'));
    }
    // En tu VideoController

    
}
