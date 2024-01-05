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
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         // Lista de IDs de video de YouTube para seleccionar aleatoriamente
         $youtubeVideoIds = ['yci475Vwc10', 'dQw4w9WgXcQ', 'eYq7WapuDLU']; // Añade más IDs según necesites

        return [
            'titulo' => $this->faker->sentence,
            'descripcion' => $this->faker->paragraph,
            'url_video' => 'https://www.youtube.com/embed/' . $this->faker->randomElement($youtubeVideoIds),
            'thumbnail' => 'https://via.placeholder.com/210x118',
            'lista_id' => Lista::inRandomOrder()->first()->id ?? Lista::factory()->create()->id,
            'tipo_id' => Tipo::inRandomOrder()->first()->id ?? Tipo::factory()->create()->id,
           
        ];
    }
}
