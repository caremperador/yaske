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
    {
       /*  // Crear categorías
        Categoria::factory(40)->create();

        // Crear tipos específicos
        $nombresTipos = ['series', 'animes', 'doramas', 'documentales', 'cursos', 'hentai', 'novelas'];
        foreach ($nombresTipos as $nombreTipo) {
            Tipo::firstOrCreate(['name' => $nombreTipo]);
        }

        // Asegurarse de que el tipo 'peliculas' existe para asignarlo a videos sin lista
        $tipoPeliculas = Tipo::firstOrCreate(['name' => 'peliculas']);

        // Crear listas y luego asociar categorías a través de la tabla intermedia
        $tiposExcluyendoPeliculas = Tipo::where('name', '<>', 'peliculas')->get();
        Lista::factory(70)->create()->each(function ($lista) use ($tiposExcluyendoPeliculas) {
            $tipoAleatorio = $tiposExcluyendoPeliculas->random();
            $lista->tipo_id = $tipoAleatorio->id;
            $lista->save();

            // Asignar categorías aleatorias a la lista
            $categoriasAleatorias = Categoria::inRandomOrder()->take(rand(1, 5))->pluck('id');
            $lista->categorias()->sync($categoriasAleatorias);
        });

        // El proceso de creación de videos y asignación de tipos sigue siendo válido
        Video::factory(100)->make()->each(function ($video) use ($tipoPeliculas, $tiposExcluyendoPeliculas) {
            if (is_null($video->lista_id)) {
                $video->tipo_id = $tipoPeliculas->id;
            } else {
                $video->tipo_id = $tiposExcluyendoPeliculas->random()->id;
            }
            $video->save();
        }); */

        // Crear usuarios y cualquier otro proceso de seeding necesario
        User::factory(4)->create();
        $this->call(RoleAssignSeeder::class);
    }
}
