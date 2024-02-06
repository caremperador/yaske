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

    public function definition(): array
    {
        return [
            'titulo' => $this->faker->sentence,
            'descripcion' => $this->faker->paragraph,
            'thumbnail' => 'https://via.placeholder.com/210x118',
            // No asignar categoria_id aquí
            'tipo_id' => Tipo::inRandomOrder()->first()->id,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Lista $lista) {
            // Asigna categorías después de crear la lista
            $categorias = Categoria::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $lista->categorias()->sync($categorias);
        });
    }
}
