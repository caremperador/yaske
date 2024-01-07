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
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // Crear categorías
        Categoria::factory()->count(40)->create();

        // Crear tipos específicos
        $nombresTipos = ['peliculas', 'series', 'animes', 'doramas', 'documentales', 'cursos', 'hentai'];
        foreach ($nombresTipos as $nombreTipo) {
            Tipo::firstOrCreate(['name' => $nombreTipo]);
        }

        // Crear listas
        // Suponiendo que quieres asignar aleatoriamente tipos a las listas
        $tipos = Tipo::all();
        Lista::factory()->count(20)->create()->each(function ($lista) use ($tipos) {
            $lista->tipo_id = $tipos->random()->id;
            $lista->save();
        });

        // Crear videos
        Video::factory()->count(30)->create();

         // Crear una cantidad determinada de usuarios aleatorios
        User::factory()->count(10)->create(); // Cambia el número 10 por la cantidad de usuarios que quieras crear
       
        // Llama al seeder de roles y usuarios
        $this->call(RoleAssignSeeder::class);
    }
}
