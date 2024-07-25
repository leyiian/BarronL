<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Especialidad;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->name,
            'apellido_paterno' => $this->faker->lastName,
            'apellido_materno' => $this->faker->lastName,
            'id_especialidad' => Especialidad::factory(),
            'cedula' => $this->faker->unique()->numberBetween(1000, 9999),
            'telefono' => $this->faker->phoneNumber,
        ];
    }
}
