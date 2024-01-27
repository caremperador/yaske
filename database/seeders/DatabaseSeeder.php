<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use App\Models\Tipo;
use App\Models\User;
use App\Models\Lista;
use App\Models\Video;
use App\Models\Categoria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\RoleAssignSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {/* 
        // Crear categorías
        Categoria::factory(40)->create();

        // Crear tipos específicos
        $nombresTipos = ['series', 'animes', 'doramas', 'documentales', 'cursos', 'hentai', 'novelas'];
        foreach ($nombresTipos as $nombreTipo) {
            Tipo::firstOrCreate(['name' => $nombreTipo]);
        }

        // Asegurarse de que el tipo 'peliculas' existe para asignarlo a videos sin lista
        $tipoPeliculas = Tipo::firstOrCreate(['name' => 'peliculas']);

        // Crear listas sin asignar el tipo 'peliculas'
        $tiposExcluyendoPeliculas = Tipo::where('name', '<>', 'peliculas')->get();
        Lista::factory(70)->create()->each(function ($lista) use ($tiposExcluyendoPeliculas) {
            $lista->tipo()->associate($tiposExcluyendoPeliculas->random())->save();
        });

        // Crear videos y asignar tipo 'peliculas' solo a los que no están en una lista
        Video::factory(100)->make()->each(function ($video) use ($tipoPeliculas, $tiposExcluyendoPeliculas) {
            if (is_null($video->lista_id)) {
                // Asignar tipo 'peliculas' si el video no está en una lista
                $video->tipo()->associate($tipoPeliculas);
            } else {
                // Asegurar que los videos en una lista no tengan el tipo 'peliculas'
                $video->tipo()->associate($tiposExcluyendoPeliculas->random());
            }
            $video->save();
        }); */

        // Crear usuarios
        User::factory(10)->create();

        // Llamar a otro seeder específico para la asignación de roles
        $this->call(RoleAssignSeeder::class);
    }
}
