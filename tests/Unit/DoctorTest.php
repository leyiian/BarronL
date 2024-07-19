<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Doctor;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DoctorTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_creation()
    {
        $doctor = Doctor::factory()->create();

        $this->assertDatabaseHas('doctores', [
            'nombre' => $doctor->nombre,
            'apellido_paterno' => $doctor->apellido_paterno,
            'apellido_materno' => $doctor->apellido_materno,
            'id_especialidad'=> $doctor->id_especialidad,
            'cedula'=> $doctor->cedula,
            'telefono' => $doctor->telefono
        ]);
    }
}
