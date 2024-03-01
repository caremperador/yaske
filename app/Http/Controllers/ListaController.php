<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use App\Models\Lista;
use App\Models\Video;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListaController extends Controller
{
    public function index()
    {
        // Obtén todas las listas ordenadas de manera descendente
        // Puedes ordenarlas por 'created_at', 'id', u otro campo
        $listas = Lista::orderBy('created_at', 'desc')->paginate(12); // Ajusta el número según la cantidad de listas que quieras por página

        return view('listas.index', compact('listas'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('name')->get(); // Ordena las categorías alfabéticamente
        $tipos = Tipo::all(); // Obtén todos los tipos
        return view('listas.create', compact('categorias', 'tipos')); // Pasa los datos a la vista
    }

    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $validatedData = $request->validate([
            'titulo' => 'required|max:255',
            'es_titulo' => 'nullable',
            'lat_titulo' => 'nullable',
            'descripcion' => 'nullable',
            'thumbnail' => 'sometimes|image|max:2048', // Uso de sometimes para permitir archivos no subidos o usar URL de TMDB
            'thumbnailUrl' => 'nullable|url', // Campo para la URL del thumbnail de TMDB
            'tmdb_id' => 'nullable', // Eliminar la regla unique aquí
            'tipo_id' => 'required|exists:tipos,id',
            'categoria_id' => 'required|array',
            'categoria_id.*' => 'exists:categorias,id',
        ]);

        // Verifica si tmdb_id está presente y es único, solo si tmdb_id es proporcionado
        if (!empty($request->tmdb_id) && Lista::where('tmdb_id', $request->tmdb_id)->exists()) {
            return back()->withErrors(['tmdb_id' => 'Esta serie ya ha sido registrada.'])->withInput();
        }

        // Añadir validación unique de tmdb_id solo si está presente
        if (!empty($request->tmdb_id)) {
            $request->validate([
                'tmdb_id' => 'unique:listas,tmdb_id',
            ]);
        }

        // Manejo de la imagen (sin cambios aquí)
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
        } elseif (!empty($validatedData['thumbnailUrl'])) {
            $imageContents = file_get_contents($validatedData['thumbnailUrl']);
            $imageName = 'thumbnail_' . time() . '.jpg';
            Storage::disk('public')->put("thumbnails/{$imageName}", $imageContents);
            $path = "thumbnails/{$imageName}";
        } else {
            $path = null; // Asigna null o el path de una imagen predeterminada
        }

        // Creación de la lista (sin cambios aquí)
        $lista = new Lista();
        $lista->titulo = $validatedData['titulo'];
        $lista->es_titulo = $validatedData['es_titulo'] ?? null;
        $lista->lat_titulo = $validatedData['lat_titulo'] ?? null;
        $lista->descripcion = $validatedData['descripcion'] ?? null;
        $lista->thumbnail = $path; // Asignar path de la imagen subida o descargada
        $lista->tipo_id = $validatedData['tipo_id'];
        $lista->tmdb_id = $validatedData['tmdb_id'] ?? null; // Asignar el tmdb_id, puede ser null
        $lista->save();

        // Asignar categorías a la lista (sin cambios aquí)
        $lista->categorias()->sync($validatedData['categoria_id']);

        return redirect()->route('listas.create')->with('success', 'Lista creada con éxito');
    }






    public function show($id)
    {
        // Encuentra la lista por su ID
        $lista = Lista::findOrFail($id);

        // Carga los videos asociados con paginación
        $videos = Video::where('lista_id', $lista->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15); // Número de videos por página

        return view('listas.show', compact('lista', 'videos'));
    }
}
