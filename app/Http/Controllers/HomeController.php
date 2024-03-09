<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use App\Models\Lista;
use App\Models\Video;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Videos generales incluyendo aquellos que no pertenecen a una lista y excluyendo tipos específicos a través de su lista
        $videos = Video::with('categorias')
            ->whereDoesntHave('lista', function ($query) {
                $query->whereHas('tipo', function ($query) {
                    $query->whereIn('name', ['hentai-sin-censura', 'hentai']);
                });
            })
            //->orWhereDoesntHave('lista') // Incluye videos que no están asociados a ninguna lista
            ->orderBy('created_at', 'desc')
            ->paginate(32);

        $tiposDeListas = ['series', 'animes'];
        $ultimosVideosPorTipoDeLista = $this->ultimoVideoPorTipoDeLista($tiposDeListas);

        // Obtener los videos más vistos del mes
        $videosMasVistos = $this->videosMasVistosDelMes();

        // mostrar videos por categorias
        $estrenosNetflix = $this->videosPorCategorias(['netflix', 'estrenos']);
        $estrenosPrimevideo = $this->videosPorCategorias(['prime-video', 'estrenos']);


        // Obtener videos por tipo y categoría específicos.
        $ultimasPeliculasAgregadas = $this->videosPorTipoYCategoria('peliculas');
        $peliculasTerror = $this->videosPorTipoYCategoria('peliculas', ['terror']);
        $comediayromance = $this->videosPorTipoYCategoria('peliculas', ['romance', 'comedia']);
        $peliculasPrimevideo = $this->videosPorTipoYCategoria('peliculas', ['prime-video']);
        $peliculasFamilia = $this->videosPorTipoYCategoria('peliculas', ['familia']);
        $peliculasAccion = $this->videosPorTipoYCategoria('peliculas', ['accion']);
        $peliculasRecomendadas = $this->videosPorTipoYCategoria('peliculas', ['recomendadas']);
        $peliculasAnimacion = $this->videosPorTipoYCategoria('peliculas', ['animacion']);
        $peliculasComedia = $this->videosPorTipoYCategoria('peliculas', ['animacion']);

        // Obtener listas por tipo (y categoría si se desea añadir esa funcionalidad)
        $seriesNetflix = $this->listasPorTipoYCategoria('series', 'netflix');
        $seriesEstrenos = $this->listasPorTipoYCategoria('series');
        $seriesPrimevideo = $this->listasPorTipoYCategoria('series', 'prime-video');
        $animes = $this->listasPorTipoYCategoria('animes');

        // Videos de calidad CAM
        $videosCalidadCam = $this->videosCalidadCam();

        // Verificar el User-Agent para identificar si la solicitud proviene de una WebView de Android
        $userAgent = request()->header('User-Agent');
        $isWebView = strpos($userAgent, 'wv') !== false;


        return view('home.index', compact(
            'videos',
            'estrenosNetflix',
            'peliculasFamilia',
            'videosCalidadCam',
            'peliculasAccion',
            'estrenosPrimevideo',
            'peliculasAnimacion',
            'peliculasComedia',
            'peliculasPrimevideo',
            'seriesNetflix',
            'seriesPrimevideo',
            'seriesEstrenos',
            'animes',
            'peliculasRecomendadas',
            'peliculasTerror',
            'comediayromance',
            'ultimasPeliculasAgregadas',
            'ultimosVideosPorTipoDeLista',
            'isWebView',
            'videosMasVistos'
        ));
    }

    private function ultimoVideoPorTipoDeLista($tipos)
    {
        $ultimosVideos = [];

        foreach ($tipos as $tipo) {
            $videos = Video::whereHas('lista.tipo', function ($query) use ($tipo) {
                $query->where('name', $tipo);
            })->with('lista')->latest('videos.created_at')->get();

            $listasUnicas = $videos->unique('lista_id');

            foreach ($listasUnicas as $video) {
                $ultimosVideos[] = $video; // Cambio aquí: acumulamos todos los videos en un arreglo simple
            }
        }

        // Ordenar globalmente por fecha, si es necesario
        // Este paso es opcional si ya se garantiza el orden por la consulta
        usort($ultimosVideos, function ($a, $b) {
            return $b->created_at <=> $a->created_at; // Orden descendente por fecha
        });

        return $ultimosVideos;
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

    public function videosPorTipoYCategoria($tipoNombre, $categoriasNombres = [])
    {
        $tipo = Tipo::where('name', $tipoNombre)->first();

        if (!$tipo) {
            return collect();
        }

        $query = Video::where('tipo_id', $tipo->id);

        if (!empty($categoriasNombres)) {
            $query->whereHas('categorias', function ($query) use ($categoriasNombres) {
                $query->whereIn('name', $categoriasNombres);
            }, '=', count($categoriasNombres)); // Asegurar que el video tiene todas las categorías
        }

        $videos = $query->withCount(['categorias' => function ($query) use ($categoriasNombres) {
            $query->whereIn('name', $categoriasNombres);
        }])->having('categorias_count', '=', count($categoriasNombres))
            ->orderBy('created_at', 'desc')
            ->get();

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
    public function videosMasVistosDelMes()
    {
        $fechaInicio = Carbon::now()->subDays(30); // Fecha de inicio hace 30 días
        $fechaFin = Carbon::now(); // Fecha actual
        
        /* // Obtener el primer y último día del mes actual
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth(); */

        $videosMasVistos = Video::whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->whereDoesntHave('lista', function ($query) {
                $query->whereHas('tipo', function ($query) {
                    $query->whereIn('name', ['hentai-sin-censura', 'hentai']);
                });
            })
            ->orderBy('views_count', 'desc')
            ->paginate(12); // Ajusta el número de items por página a tu necesidad

        return $videosMasVistos;
    }
}
