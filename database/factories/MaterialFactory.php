<?php

namespace Database\Factories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory
{
    protected $model = Material::class;

    public function definition()
    {
        return [
            'codigo' => $this->faker->unique()->word,
            'descripcion' => $this->faker->sentence,
            'precio' => $this->faker->randomFloat(2, 1, 1000), // Precio entre 1 y 1000 con 2 decimales
            'existencia' => $this->faker->numberBetween(0, 100), // Existencia entre 0 y 100
            'fecha_caducidad' => $this->faker->date,
        ];
    }
}
