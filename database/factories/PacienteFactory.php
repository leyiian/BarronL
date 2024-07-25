<?php

namespace Database\Factories;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paciente>
 */
class PacienteFactory extends Factory
{
    protected $model = Paciente::class;

    public function definition() : array
    {
        return [
            'nombre' => $this->faker->name,
            'apPat' => $this->faker->lastName,
            'apMat' => $this->faker->lastName,
            'telefono' => $this->faker->phoneNumber,
        ];
    }
}
