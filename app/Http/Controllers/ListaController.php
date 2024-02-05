<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use App\Models\Lista;
use App\Models\Video;
use App\Models\Categoria;
use Illuminate\Http\Request;

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
            'descripcion' => 'nullable',
            'thumbnail' => 'required|image|max:2048',
            'categoria_id' => 'required|array',
            'categoria_id.*' => 'exists:categorias,id',
            'tipo_id' => 'required|exists:tipos,id',
        ]);

        // Procesamiento y almacenamiento del archivo
        $path = $request->file('thumbnail')->store('thumbnails', 'public');

        // Creación de la lista
        $lista = new Lista();
        $lista->titulo = $validatedData['titulo'];
        $lista->descripcion = $validatedData['descripcion'] ?? null; // Usa el operador de fusión null para asignar un valor por defecto si es necesario
        $lista->thumbnail = $path; // Asigna la ruta del archivo
        $lista->tipo_id = $validatedData['tipo_id'];
        $lista->save();

        // Asignar categorías a la lista
        $lista->categorias()->sync($validatedData['categoria_id']);

        // Redirige a alguna parte con un mensaje
        return redirect()->route('listas.index')->with('success', 'Lista creada con éxito');
    }



    public function show($id)
    {
        // Encuentra la lista por su ID
        $lista = Lista::findOrFail($id);

        // Carga los videos asociados con paginación
        $videos = Video::where('lista_id', $lista->id)
            ->orderBy('created_at', 'desc')
            ->paginate(2); // Número de videos por página

        return view('listas.show', compact('lista', 'videos'));
    }
}
