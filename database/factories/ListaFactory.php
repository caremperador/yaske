<?php

namespace Database\Factories;


use App\Models\Tipo;
use App\Models\Lista;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Lista>
 */
class ListaFactory extends Factory
{
    protected $model = Lista::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->sentence,
            'descripcion' => $this->faker->paragraph,
            'thumbnail' => 'https://via.placeholder.com/210x118',
            'categoria_id' => Categoria::factory(),
            'tipo_id' => Tipo::inRandomOrder()->first()->id,
        ];
    }
}
