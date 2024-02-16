<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use App\Models\Lista;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiTMDBController extends Controller
{

    // En VideoController.php
    public function buscarPeliculaTMDB(Request $request, $id)
    {
        $apiKey = env('TMDB_API_KEY');
        $language = $request->input('language', 'en'); // Default a inglés si no se especifica
        $region = $request->input('region', ''); // Sin región por defecto

        $url = "https://api.themoviedb.org/3/movie/{$id}?api_key={$apiKey}&language={$language}";
        if (!empty($region)) {
            $url .= "&region={$region}";
        }

        $response = Http::get($url);
        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Película no encontrada'], 404);
    }
    public function buscarSerieTMDB(Request $request, $id)
    {
        $apiKey = env('TMDB_API_KEY');
        $language = $request->input('language', 'en'); // Idioma por defecto es inglés
        $region = $request->input('region', ''); // Región opcional

        // Construye la URL para buscar series en TMDB
        $url = "https://api.themoviedb.org/3/tv/{$id}?api_key={$apiKey}&language={$language}";
        if (!empty($region)) {
            $url .= "&region={$region}";
        }

        $response = Http::get($url);
        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Serie no encontrada'], 404);
    }
}