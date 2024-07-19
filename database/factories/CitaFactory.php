<?php

namespace Database\Factories;

use App\Models\Cita;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cita>
 */
class CitaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Cita::class;

    public function definition(): array
    {
        return [
            'id_paciente' => $this->faker->numberBetween(1, 100),
            'fecha' => $this->faker->dateTime,
            'id_especialidades' => $this->faker->numberBetween(1, 10),
            'Observaciones' => $this->faker->text,
            'id_doctor' => $this->faker->numberBetween(1, 100),
            'estado' => $this->faker->randomElement(['Pendiente', 'Autorizado', 'Rechazado']),
        ];
    }
}
