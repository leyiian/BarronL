<?php

namespace Database\Factories;

use App\Models\Consultorio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consultorio>
 */
class ConsultorioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Consultorio::class;
    
    public function definition(): array
    {
        return [
            'numero' => $this->faker->unique()->numberBetween(1000, 9999),
        ];
    }
}
