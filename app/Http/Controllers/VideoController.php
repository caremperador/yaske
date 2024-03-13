<?php

namespace App\Http\Controllers;


use App\Models\Tipo;
use App\Models\Lista;
use App\Models\Video;
use App\Models\Categoria;
use App\Models\VideoEnlace;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

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
        $categorias = Categoria::orderBy('name')->get(); // Ordena las categorías alfabéticamente

        return view('videos.create', compact('listas', 'tipos', 'categorias')); // Pasa los datos a la vista
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'nullable',
            'es_titulo' => 'nullable',
            'lat_titulo' => 'nullable',
            'descripcion' => 'nullable',
            'estado' => 'required',
            'es_calidad_cam' => 'nullable',
            'url_video' => 'nullable|url',
            'es_url_video' => 'nullable|url',
            'lat_url_video' => 'nullable|url',
            'sub_url_video' => 'nullable|url',
            'url_video_gratis' => 'nullable|url',
            'es_url_video_gratis' => 'nullable|url',
            'lat_url_video_gratis' => 'nullable|url',
            'sub_url_video_gratis' => 'nullable|url',
            'tmdb_id' => 'nullable|unique:videos,tmdb_id', // Asegura que el ID de TMDB sea único en la tabla videos
            'thumbnail' => 'sometimes|image|max:2048', // Uso de sometimes para permitir archivos no subidos
            'thumbnailUrl' => 'nullable|url',
            'lista_id' => 'nullable|exists:listas,id',
            'tipo_id' => 'required|exists:tipos,id',
            'categoria_id' => 'required|array',
            'categoria_id.*' => 'exists:categorias,id',
        ]);

        // Manejo de la imagen
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
        } elseif (!empty($validatedData['thumbnailUrl'])) {
            $imageContents = file_get_contents($validatedData['thumbnailUrl']);
            $imageName = basename($validatedData['thumbnailUrl']);
            Storage::disk('public')->put("thumbnails/{$imageName}", $imageContents);
            $path = "thumbnails/{$imageName}";
        } else {
            $path = null; // O establece un valor predeterminado para 'thumbnail'
        }

        /*  // Verifica si ya existe un video con el mismo ID de TMDB
        if (Video::where('tmdb_id', $request->tmdb_id)->exists()) {
            return back()->withErrors(['tmdb_id' => 'Este video ya ha sido registrado.'])->withInput();
        } */
        // Verifica si ya existe un video con el mismo ID de TMDB solo si tmdb_id es proporcionado
        if (!empty($request->tmdb_id) && Video::where('tmdb_id', $request->tmdb_id)->exists()) {
            return back()->withErrors(['tmdb_id' => 'Este video ya ha sido registrado.'])->withInput();
        }

        // Preparar datos para creación, excluyendo 'thumbnailUrl' y 'categoria_id'
        $videoData = Arr::except($validatedData, ['thumbnailUrl', 'categoria_id']);
        $videoData['thumbnail'] = $path;
        $videoData['tmdb_id'] = $request->tmdb_id; // Asegúrate de incluir el ID de TMDB en los datos a guardar



        // Crear el video
        $video = Video::create($videoData);

        // Asignar categorías al video si están presentes
        if (!empty($validatedData['categoria_id'])) {
            $video->categorias()->sync($validatedData['categoria_id']);
        }

        return redirect()->route('videos.create')->with('success', 'Video creado con éxito.');
    }


    public function show(Video $video)
    {
        // Carga las relaciones 'lista' y 'comentarios' del video
        $video->load('lista', 'comentarios.user', 'puntuaciones');
        // Incrementa el contador de visitas
        $video->increment('views_count');

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

    public function mostrarVideo($videoId, $idioma)
    {
        $video = Video::findOrFail($videoId);
        $videoUrl = '';

        switch ($idioma) {
            case 'sub':
                $videoUrl = $video->sub_url_video;
                break;
            case 'es':
                $videoUrl = $video->es_url_video;
                break;
            case 'lat':
                $videoUrl = $video->lat_url_video;
                break;
            case 'eng':
                $videoUrl = $video->url_video;
                break;
            case 'sub-gratis':
                $videoUrl = $video->sub_url_video_gratis;
                break;
            case 'es-gratis':
                $videoUrl = $video->es_url_video_gratis;
                break;
            case 'lat-gratis':
                $videoUrl = $video->lat_url_video_gratis;
                break;
            case 'eng-gratis':
                $videoUrl = $video->url_video_gratis;
                break;
            default:
                abort(404); // O manejar de otra manera si el idioma no es válido
        }

        if (empty($videoUrl)) {
            return redirect()->back()->withErrors(['message' => 'URL del video no disponible.']);
        }

        // Verificar el User-Agent para identificar si la solicitud proviene de una WebView de Android
        $userAgent = request()->header('User-Agent');
        $isWebView = strpos($userAgent, 'wv') !== false;

        // Pasar la variable $isWebView a la vista
        return view('videos.mostrarVideo', compact('videoUrl', 'isWebView'));
    }



    public function search(Request $request)
    {
        $query = $request->input('query');

        // Buscar en todos los videos
        $videos = Video::where('titulo', 'LIKE', '%' . $query . '%')
            ->orWhere('es_titulo', 'LIKE', '%' . $query . '%')
            ->orWhere('lat_titulo', 'LIKE', '%' . $query . '%')
            ->orderBy('created_at', 'desc') // Ordena por fecha de creación descendente
            ->paginate(10); // Puedes ajustar la cantidad por página

        return view('videos.resultados', compact('videos'));
    }
    public function admin_todos_los_videos(Request $request)
    {
        $query = $request->input('query');

        // Buscar en todos los videos
        $videos = Video::where('titulo', 'LIKE', '%' . $query . '%')
            ->orWhere('es_titulo', 'LIKE', '%' . $query . '%')
            ->orWhere('lat_titulo', 'LIKE', '%' . $query . '%')
            ->orderBy('created_at', 'desc') // Ordena por fecha de creación descendente
            ->paginate(10); // Puedes ajustar la cantidad por página

        return view('admin.admin_todos_los_videos', compact('videos'));
    }
    public function destroy(Video $video)
    {

        // Eliminar relaciones en video_categoria
        $video->categorias()->detach();


        $video->delete();
        // eliminar la imagen guardada tambien  en el storage
        Storage::disk('public')->delete($video->thumbnail);

        return redirect()->route('admin.todos_los_videos')->with('success', 'Video eliminado correctamente.');
    }
    public function edit(Video $video)
    {
        $video = Video::findOrFail($video->id);
        $listas = Lista::all(); // Obtiene todas las listas
        $tipos = Tipo::all(); // Obtiene todos los tipos (asegúrate de que esto se defina en tu controlador)
        $categorias = Categoria::all(); // Obtiene todas las categorías (asegúrate de que esto se defina en tu controlador)

        // Pasar a la vista el video a editar
        return view('videos.edit', compact('video', 'listas', 'tipos', 'categorias'));
    }

    public function update(Request $request, Video $video)
    {
        $validatedData = $request->validate([
            'titulo' => 'required',
            'es_titulo' => 'nullable',
            'lat_titulo' => 'nullable',
            'descripcion' => 'nullable',
            'estado' => 'required',
            'es_calidad_cam' => 'nullable',
            'url_video' => 'nullable|url',
            'es_url_video' => 'nullable|url',
            'lat_url_video' => 'nullable|url',
            'sub_url_video' => 'nullable|url',
            'url_video_gratis' => 'nullable|url',
            'es_url_video_gratis' => 'nullable|url',
            'lat_url_video_gratis' => 'nullable|url',
            'sub_url_video_gratis' => 'nullable|url',
            'thumbnail' => 'sometimes|image|max:2048', // 'sometimes' para que sea opcional
            'lista_id' => 'nullable|exists:listas,id',
            'tipo_id' => 'required|exists:tipos,id',
            'categoria_id' => 'sometimes|array',
            'categoria_id.*' => 'exists:categorias,id',
        ]);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $video->thumbnail = $path;
        }

        // Actualizar los otros campos del video
        $video->titulo = $validatedData['titulo'];
        $video->es_titulo = $validatedData['es_titulo'];
        $video->es_calidad_cam = $request->input('es_calidad_cam', false);
        $video->lat_titulo = $validatedData['lat_titulo'];
        $video->descripcion = $validatedData['descripcion'];
        $video->estado = $validatedData['estado'];
        $video->url_video = $validatedData['url_video'];
        $video->es_url_video = $validatedData['es_url_video'];
        $video->lat_url_video = $validatedData['lat_url_video'];
        $video->sub_url_video = $validatedData['sub_url_video'];
        $video->url_video_gratis = $validatedData['url_video_gratis'];
        $video->es_url_video_gratis = $validatedData['es_url_video_gratis'];
        $video->lat_url_video_gratis = $validatedData['lat_url_video_gratis'];
        $video->sub_url_video_gratis = $validatedData['sub_url_video_gratis'];
        $video->tipo_id = $validatedData['tipo_id'];

        if (isset($validatedData['lista_id'])) {
            $video->lista_id = $validatedData['lista_id'];
        }

        $video->save();

        // Actualizar relaciones de categorías
        if (isset($validatedData['categoria_id'])) {
            $video->categorias()->sync($validatedData['categoria_id']);
        }

        return redirect()->route('admin.todos_los_videos')->with('success', 'Video actualizado con éxito.');
    }
    public function estrenosGratis()
    {
        // Obtener todos los videos donde es_calidad_cam es true
        $videos = Video::where('es_calidad_cam', true)->paginate(10); // Ajusta la paginación según necesites

        return view('estrenos.estrenos_gratis', compact('videos'));
    }

    public function createCapitulos()
    {
        $listas = Lista::all(); // Asegúrate de importar el modelo Lista en la parte superior.
        return view('videos.crear_capitulos', compact('listas'));
    }
    public function storeCapitulos(Request $request)
    {
        // Validación de los datos recibidos del formulario
        $request->validate([
            'lista_id' => 'required|exists:listas,id',
            'tipo_id' => 'required|exists:tipos,id',
            'titulo' => 'required|string|max:255',
            'url_video' => 'nullable|url',
            'es_url_video' => 'nullable|url',
            'lat_url_video' => 'nullable|url',
            'sub_url_video' => 'nullable|url',
            'url_video_gratis' => 'nullable|url',
            'es_url_video_gratis' => 'nullable|url',
            'lat_url_video_gratis' => 'nullable|url',
            'sub_url_video_gratis' => 'nullable|url',
            'descripcion' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048', // Cambia 'sometimes' por 'nullable' y quita 'required'
            'thumbnail_url' => 'nullable|url', // Asegúrate de validar también la URL del thumbnail si se envía
            'estado' => 'required|boolean',
        ]);

        $thumbnailPath = ''; // Puedes establecer una ruta a una imagen por defecto si lo deseas
        // Verifica si se proporcionó una URL para el thumbnail y úsala
        if (!empty($request->input('thumbnail_url'))) {
            // Descarga y guarda la imagen de TMDB
            $thumbnailUrl = $request->input('thumbnail_url');
            $contents = file_get_contents($thumbnailUrl);
            $name = substr($thumbnailUrl, strrpos($thumbnailUrl, '/') + 1);
            $name = time() . '_' . $name; // Asegura un nombre único
            $path = 'thumbnails/' . $name;
            Storage::disk('public')->put($path, $contents);
            $thumbnailPath = $path;
        } elseif ($request->hasFile('thumbnail')) {
            // Manejo de la carga de la imagen thumbnail subida manualmente
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnailPath = $thumbnail->storeAs('thumbnails', $thumbnailName, 'public');
        }

        // Creación del nuevo capítulo (video)
        $video = new Video;
        $video->lista_id = $request->lista_id;
        $video->tipo_id = $request->tipo_id;
        $video->titulo = $request->titulo;
        $video->descripcion = $request->descripcion;
        $video->url_video = $request->url_video;
        $video->es_url_video = $request->input('es_url_video');
        $video->lat_url_video = $request->input('lat_url_video');
        $video->sub_url_video = $request->input('sub_url_video');
        $video->url_video_gratis = $request->url_video_gratis;
        $video->es_url_video_gratis = $request->input('es_url_video_gratis');
        $video->lat_url_video_gratis = $request->input('lat_url_video_gratis');
        $video->sub_url_video_gratis = $request->input('sub_url_video_gratis');
        $video->estado = $request->estado;
        $video->thumbnail = $thumbnailPath; // Guarda la ruta de la imagen

        $video->save(); // Guarda el capítulo en la base de datos

        // Redirecciona a la página que prefieras con un mensaje de éxito
        return redirect()->route('capitulos.create')->with('success', 'Capítulo añadido con éxito.');
    }
    public function mostrarVideosConEnlacesCaidos()
    {
        // Obtener todos los videos que tienen al menos un enlace marcado como caído
        $videosConEnlacesCaidos = Video::whereHas('enlaces', function ($query) {
            $query->where('caido', true);
        })->paginate(10);

        return view('videos.enlaces_caidos', compact('videosConEnlacesCaidos'));
    }
    public function deleteEnlaceCaido(VideoEnlace $enlace)
    {
        $enlace->delete();

        return back()->with('success', 'Enlace eliminado correctamente.');
    }



    public function reportarEnlaceCaido(Request $request, Video $video)
    {
        $tipo = $request->input('tipo');
        $urlColumn = match ($tipo) {
            'default' => $video->url_video_gratis,
            'es' => $video->es_url_video_gratis,
            'lat' => $video->lat_url_video_gratis,
            'sub' => $video->sub_url_video_gratis,
            default => null,
        };

        if (!$urlColumn) {
            return back()->with('error', 'Tipo de enlace no válido.');
        }

        try {
            $response = Http::get($urlColumn);
            if ($response->status() == 404 || str_contains(strtolower($response->body()), 'not found') || str_contains(strtolower($response->body()), 'deleted')) {
                $caido = true;
            } else {
                $caido = false;
            }
        } catch (\Exception $e) {
            // Considera manejar diferentes tipos de excepciones de manera diferente
            $caido = true;
        }

        if ($caido) {
            VideoEnlace::updateOrCreate(
                ['video_id' => $video->id, 'tipo' => $tipo],
                ['url' => $urlColumn, 'caido' => true]
            );

            return back()->with('success', 'El enlace ha sido reportado como caído. Gracias por tu ayuda.');
        } else {
            return back()->with('info', 'El enlace parece estar funcionando correctamente.');
        }
    }
}
