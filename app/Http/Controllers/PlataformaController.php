<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use App\Models\Video;
use App\Models\Categoria;
use Illuminate\Http\Request;

class PlataformaController extends Controller
{
    public function filtrarVideosPorTipoYCategoria($tipo, $plataforma = null, $categoria = null)
    {
        // Buscar el tipo de video
        $tipoVideo = Tipo::where('name', $tipo)->first();
        if (!$tipoVideo) {
            return redirect()->route('home')->with('error', 'Tipo de video no válido.');
        }

        // Iniciar la consulta
        $query = Video::where('tipo_id', $tipoVideo->id);

        // Filtrar por la plataforma si está presente
        if ($plataforma) {
            $categoriaPlataforma = Categoria::where('name', $plataforma)->first();
            if ($categoriaPlataforma) {
                $query->whereHas('categorias', function ($query) use ($categoriaPlataforma) {
                    $query->where('categoria_id', $categoriaPlataforma->id);
                });
            }
        }

        // Filtrar por la categoría adicional si está presente
        if ($categoria) {
            $categoriaVideo = Categoria::where('name', $categoria)->first();
            if ($categoriaVideo) {
                $query->whereHas('categorias', function ($query) use ($categoriaVideo) {
                    $query->where('categoria_id', $categoriaVideo->id);
                });
            }
        }

        $videos = $query->paginate(24);

        return view('videos.filtrar', compact('videos'));
    }
}
