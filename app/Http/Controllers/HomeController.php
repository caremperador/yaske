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

        // mostrar videos por categorias
        $estrenosNetflix = $this->videosPorCategorias(['netflix', 'estrenos']);
        $estrenosPrimevideo = $this->videosPorCategorias(['prime-video', 'estrenos']);
        $peliculasPrimevideo = $this->videosPorCategorias(['prime-video']);

        // Obtener videos por tipo y categoría específicos.
        $peliculas = $this->videosPorTipoYCategoria('peliculas');
        $peliculasAccion = $this->videosPorTipoYCategoria('peliculas', 'accion');
        $peliculasAnimacion = $this->videosPorTipoYCategoria('peliculas', 'animacion');
        $peliculasComedia = $this->videosPorTipoYCategoria('peliculas', 'animacion');

        // Videos de calidad CAM
        $videosCalidadCam = $this->videosCalidadCam();


        return view('home.index', compact('videos', 'estrenosNetflix', 'peliculas', 'videosCalidadCam', 'peliculasAccion', 'estrenosPrimevideo', 'peliculasAnimacion', 'peliculasComedia', 'peliculasPrimevideo'));
    }

    private function videosPorCategorias(array $nombresCategorias)
    {
        // Iniciar la consulta de videos
        $query = Video::query();

        // Aplicar un filtro `whereHas` para cada categoría requerida
        foreach ($nombresCategorias as $nombreCategoria) {
            $query->whereHas('categorias', function ($query) use ($nombreCategoria) {
                $query->where('name', $nombreCategoria);
            });
        }

        $videos = $query->get();

        return $videos;
    }



    /*   private function estrenosNetflix()
    {
        $categoriasNombres = ['aspernatur'];
        $categorias = Categoria::whereIn('name', $categoriasNombres)->get();
        $videosNetflix = Video::whereHas('categorias', function ($query) use ($categorias) {
            $query->whereIn('categoria_id', $categorias->pluck('id'));
        })->get();

        return $videosNetflix;
    } */
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

    public function videosCalidadCam()
    {
        $videosCalidadCam = Video::where('es_calidad_cam', true)->orderBy('created_at', 'desc')->get();
        return $videosCalidadCam;
    }
}
