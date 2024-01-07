<?php

namespace Database\Factories;


use App\Models\Tipo;
use App\Models\Lista;
use App\Models\Video;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Video>
 */
class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition(): array
    {
        $youtubeVideoIds = ['yci475Vwc10', 'dQw4w9WgXcQ', 'eYq7WapuDLU'];

        // Encontrar o crear el tipo 'peliculas'
        $tipoPeliculas = Tipo::firstOrCreate(['name' => 'peliculas']);
        
        // Obtener un tipo que no sea 'peliculas'
        $otroTipo = Tipo::where('name', '<>', 'peliculas')->inRandomOrder()->first() ?? Tipo::factory()->create();

        // Determinar aleatoriamente si este video pertenece a una lista
        $perteneceALista = $this->faker->boolean;

        return [
            'titulo' => $this->faker->sentence,
            'descripcion' => $this->faker->paragraph,
            'url_video' => 'https://www.youtube.com/embed/' . $this->faker->randomElement($youtubeVideoIds),
            'thumbnail' => 'https://via.placeholder.com/210x118',
            'lista_id' => $perteneceALista ? Lista::inRandomOrder()->first()->id ?? Lista::factory()->create()->id : null,
            'tipo_id' => $perteneceALista ? $otroTipo->id : $tipoPeliculas->id,
        ];
    }
}