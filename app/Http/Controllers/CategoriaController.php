<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        // Obtén todas las categorías y pásalas a la vista
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }
    public function create()
    {
        // Simplemente devuelve la vista para crear una nueva categoría
        return view('categorias.create');
    }

    public function store(Request $request)
{
    // Validación de los datos del formulario con regla unique
    $validatedData = $request->validate([
        'name' => 'required|max:255|unique:categorias,name',
    ]);

    // Normalización del nombre de la categoría
    $normalized_name = Str::slug($validatedData['name'], '-');

    // Creación de la categoría
    $categoria = new Categoria();
    $categoria->name = $normalized_name;
    $categoria->save();

    // Redirección con mensaje de éxito
    return redirect()->route('dashboard')->with('success', 'Categoría creada con éxito.');
}
}
