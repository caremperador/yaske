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
        $peliculasPrimevideo = $this->videosPorTipoYCategoria('peliculas', 'prime-video');

        // Obtener videos por tipo y categoría específicos.
        $peliculasFamilia = $this->videosPorTipoYCategoria('peliculas', 'familia');
        $peliculasAccion = $this->videosPorTipoYCategoria('peliculas', 'accion');
        $peliculasRecomendadas = $this->videosPorTipoYCategoria('peliculas', 'recomendadas');
        $peliculasAnimacion = $this->videosPorTipoYCategoria('peliculas', 'animacion');
        $peliculasComedia = $this->videosPorTipoYCategoria('peliculas', 'animacion');

        // Obtener listas por tipo (y categoría si se desea añadir esa funcionalidad)
        $seriesNetflix = $this->listasPorTipoYCategoria('series', 'netflix');
        $seriesEstrenos = $this->listasPorTipoYCategoria('series', 'estrenos');
        $seriesPrimevideo = $this->listasPorTipoYCategoria('series', 'prime-video');
        $animes = $this->listasPorTipoYCategoria('animes');

        // Videos de calidad CAM
        $videosCalidadCam = $this->videosCalidadCam();


        return view('home.index', compact('videos', 'estrenosNetflix', 'peliculasfamilia', 'videosCalidadCam', 'peliculasAccion', 'estrenosPrimevideo', 'peliculasAnimacion', 'peliculasComedia', 'peliculasPrimevideo', 'seriesNetflix', 'seriesPrimevideo', 'seriesEstrenos', 'animes', 'peliculasRecomendadas'));
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

        // Aplicar orden descendente aquí
        $videos = $query->orderBy('created_at', 'desc')->get();

        return $videos;
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
        // Aplicar orden descendente aquí
        $videos = $query->orderBy('created_at', 'desc')->get();

        return $videos;
    }
    public function listasPorTipoYCategoria($tipoNombre, $categoriaNombre = null)
    {
        $tipo = Tipo::where('name', $tipoNombre)->first();

        if (!$tipo) {
            // Si no se encuentra el tipo, retorna una colección vacía o maneja el error como prefieras.
            return collect();
        }

        $query = Lista::where('tipo_id', $tipo->id);

        if (!is_null($categoriaNombre)) {
            $categoria = Categoria::where('name', $categoriaNombre)->first();
            if ($categoria) {
                $query->whereHas('categorias', function ($query) use ($categoria) {
                    $query->where('categorias.id', $categoria->id);
                });
            }
        }

        // Ordenar las listas de manera descendente por fecha de creación.
        $listas = $query->orderBy('created_at', 'desc')->get();

        return $listas;
    }

    public function videosCalidadCam()
    {
        $videosCalidadCam = Video::where('es_calidad_cam', true)->orderBy('created_at', 'desc')->get();
        return $videosCalidadCam;
    }
}
