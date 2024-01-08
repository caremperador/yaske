<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use App\Models\Lista;
use App\Models\Video;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    public function index()
    {
        $tipos = Tipo::all();
        return view('tipos.index', compact('tipos'));
    }
    public function create()
    {
        return view('tipos.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:tipos,name',
        ]);

        $tipo = new Tipo();
        $tipo->name = Str::slug($validatedData['name'], '-');
        $tipo->save();

        return redirect()->route('dashboard')->with('success', 'Tipo creado con éxito.');
    }

    public function show($tipoSlug)
    {
        // Encuentra el tipo por su slug (nombre normalizado)
        $tipo = Tipo::where('name', $tipoSlug)->firstOrFail();

        // Obtén los videos asociados a este tipo y que no están en ninguna lista
        $videos = Video::where('tipo_id', $tipo->id)
            ->whereNull('lista_id')
            ->orderBy('created_at', 'desc')
            ->paginate(32);

        return view('tipos.show', compact('tipo', 'videos'));
    }
    public function show_con_listas($tipoSlug)
    {
        $tipo = Tipo::where('name', $tipoSlug)->firstOrFail();

        // Obtén las listas asociadas a este tipo
        $listas = Lista::where('tipo_id', $tipo->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('tipos.show_con_listas', compact('tipo', 'listas'));
    }
}
