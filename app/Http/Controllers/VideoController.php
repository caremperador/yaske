<?php

namespace App\Http\Controllers;


use App\Models\Tipo;
use App\Models\Lista;
use App\Models\Video;
use App\Models\Categoria;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function index()
    {
        // Define la cantidad de elementos por página
        $itemsPerPage = 12; // Puede ser 12, 24, 36, etc.

        // Obtén todos los videos, independientemente de si están en una lista o no
        // ordenados por ID de manera descendente y paginados
        $videos = Video::orderBy('id', 'desc')->paginate($itemsPerPage);

        return view('videos.index', compact('videos'));
    }

    public function create()
    {
        $listas = Lista::all(); // Obtén todas las listas
        $tipos = Tipo::all();
        $categorias = Categoria::all();
        return view('videos.create', compact('listas', 'tipos', 'categorias')); // Pasa los datos a la vista
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required',
            'descripcion' => 'nullable',
            'estado' =>'required',
            'url_video' => 'nullable|url',
            'es_url_video' => 'nullable|url',
            'lat_url_video' => 'nullable|url',
            'sub_url_video' => 'nullable|url',
            'thumbnail' => 'required|url',
            'lista_id' => 'nullable|exists:listas,id',
            'tipo_id' => 'required|exists:tipos,id',
            'categoria_id' => 'required|array', // Asegúrate de que al menos una categoría esté seleccionada
            'categoria_id.*' => 'exists:categorias,id', // Cada ID de categoría debe existir
        ]);
    
        // Asegúrate de que al menos una URL de video esté presente
        if (empty($validatedData['url_video']) && empty($validatedData['es_url_video']) && empty($validatedData['lat_url_video']) && empty($validatedData['sub_url_video'])) {
            return back()->withErrors('Por favor, proporciona al menos una URL de video.');
        }
    
        // Crear el video sin la información de categorías
        $videoData = Arr::except($validatedData, ['categoria_id']);
        $video = Video::create($videoData);
    
        // Asignar categorías al video si están presentes
        if (!empty($validatedData['categoria_id'])) {
            $video->categorias()->sync($validatedData['categoria_id']);
        }
    
        // Redirección con mensaje de éxito
        return redirect()->route('dashboard')->with('success', 'Video uploaded successfully.');
    }
    




    public function show(Video $video)
    {
        // Carga las relaciones 'lista' y 'comentarios' del video
        $video->load('lista', 'comentarios.user', 'puntuaciones');

        /* // Verificar el estado del video y el rol del usuario
        if ($video->estado == 0 && !Auth::user()->hasRole('premium')) {
            // Redirigir al usuario o mostrar una vista de error
            return redirect()->route('home')->with('error', 'No tienes acceso a este video.');
        } */

        $usuarioHaVotado = $video->puntuaciones()->where('user_id', Auth::id())->exists();

        // Esto te da la puntuación promedio
        $puntuacionPromedio = $video->puntuaciones()->avg('puntuacion') ?? 0;

        // Calcular el total de opiniones
        $totalOpiniones = $video->puntuaciones()->count();
        // Calcular las opiniones por puntuación
        $opinionesPorPuntuacion = [];
        for ($i = 1; $i <= 5; $i++) {
            $opinionesPorPuntuacion[$i] = $video->puntuaciones()->where('puntuacion', $i)->count();
        }

        // Encuentra el anterior y siguiente video en la lista
        $prevVideo = null;
        $nextVideo = null;

        // Lógica para encontrar el video anterior y siguiente en la lista
        if ($video->lista) {
            $videosEnLista = $video->lista->videos()->orderBy('id')->get();

            $currentKey = $videosEnLista->search(function ($v) use ($video) {
                return $v->id === $video->id;
            });

            $prevVideo = $videosEnLista->get($currentKey - 1);
            $nextVideo = $videosEnLista->get($currentKey + 1);
        }
        // Devuelve la vista 'videos.show', pasando las variables 'video', 'prevVideo', 'nextVideo'
        return view('videos.show', compact(
            'video',
            'prevVideo',
            'nextVideo',
            'puntuacionPromedio',
            'totalOpiniones',
            'opinionesPorPuntuacion',
            'usuarioHaVotado'
        ));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Buscar en todos los videos
        $videos = Video::where('titulo', 'LIKE', '%' . $query . '%')
            ->orWhere('descripcion', 'LIKE', '%' . $query . '%')
            ->paginate(10); // Puedes ajustar la cantidad por página

        return view('videos.resultados', compact('videos'));
    }
}
