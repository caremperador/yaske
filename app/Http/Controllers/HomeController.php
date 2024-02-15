<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use App\Models\Lista;
use App\Models\Video;
use App\Models\Categoria;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Videos generales
        $videos = Video::with('categorias')->orderBy('created_at', 'desc')->paginate(32);
        $estrenos = Video::with('categorias')->orderBy('created_at', 'desc')->take(3)->get();

        // Estrenos
        $estrenosNetflix = $this->estrenosNetflix();
        // Obtener videos por tipo y categoría específicos.
        $peliculas = $this->videosPorTipoYCategoria('peliculas');

        // Otros conjuntos de videos basados en categorías específicas
        // Por ejemplo, $accionYAnimacion = $this->videosPorCategorias(['Acción', 'Animación']);

        // Puedes añadir aquí más llamadas a métodos similares según necesites

        return view('home.index', compact('videos', 'estrenos', 'estrenosNetflix', 'peliculas'));
    }

    private function estrenosNetflix()
    {
        $categoriasNombres = ['aspernatur'];
        $categorias = Categoria::whereIn('name', $categoriasNombres)->get();
        $videosNetflix = Video::whereHas('categorias', function ($query) use ($categorias) {
            $query->whereIn('categoria_id', $categorias->pluck('id'));
        })->get();

        return $videosNetflix;
    }
    public function videosPorTipoYCategoria($tipoNombre, $categoriaNombre = null)
    {
        $tipo = Tipo::where('name', $tipoNombre)->first();

        if (!$tipo) {
            // Si no se encuentra el tipo, puedes optar por no devolver nada o lanzar un error.
            return collect();
        }

        // Iniciar la consulta filtrando por tipo.
        $query = Video::where('tipo_id', $tipo->id);

        // Si se ha proporcionado un nombre de categoría, añadir filtro por categoría.
        if (!is_null($categoriaNombre)) {
            $categoria = Categoria::where('name', $categoriaNombre)->first();
            if ($categoria) {
                $query->whereHas('categorias', function ($query) use ($categoria) {
                    $query->where('categorias.id', $categoria->id);
                });
            }
        }

        // Obtener los videos según los filtros aplicados.
        $videos = $query->get();

        return $videos;
    }
}
