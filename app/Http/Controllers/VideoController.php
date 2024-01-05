<?php

namespace App\Http\Controllers;


use App\Models\Tipo;
use App\Models\Lista;
use App\Models\Video;
use App\Models\Categoria;
use Illuminate\Http\Request;

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
        // Validación de los datos del formulario
        // Aquí se definen las reglas de validación para los campos del formulario
        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'nullable',
            'url_video' => 'required|url', // Asegúrate de que sea una URL válida
            'thumbnail' => 'required|url', // Cambiado para validar una URL
            'lista_id' => 'nullable|exists:listas,id', // Asegúrate de que el lista_id exista en la tabla 'listas'
            'tipo_id' => 'required|exists:tipos,id', // Asegúrate de que el tipo_id exista en la tabla 'tipos'
            'categoria_id' => 'nullable|array', // Asegúrate de que sea un array
            'categoria_id.*' => 'exists:categorias,id', // Cada elemento debe existir en la tabla 'categorias'
        ]);

        // Creación y guardado del nuevo Video en la base de datos
        $video = new Video;
        $video->titulo = $request->titulo;
        $video->descripcion = $request->descripcion;
        $video->url_video = $request->url_video; // Guarda la URL directa proporcionada
        $video->thumbnail = $request->thumbnail; // Ahora simplemente guarda la URL proporcionada
        $video->lista_id = $request->lista_id;
        $video->tipo_id = $request->tipo_id;
        $video->save();

        // Asignar categorías al video si están presentes
        if ($request->has('categoria_id')) {
            $video->categorias()->sync($request->categoria_id);
        }

        // Redirección con mensaje de éxito
        return redirect()->route('dashboard')->with('success', 'Video uploaded successfully.');
    }



    public function show(Video $video)
    {
        // Carga la relación 'lista' del video
        $video->load('lista');

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
        return view('videos.show', compact('video', 'prevVideo', 'nextVideo'));
    }
}
