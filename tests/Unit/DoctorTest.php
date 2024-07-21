<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Doctor;
use App\Models\Especialidad;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DoctorTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_creation()
    {
        $especialidad = Especialidad::factory()->create();

        $doctor = Doctor::factory()->create([
            'id_especialidad' => $especialidad->id,
        ]);

        $this->assertDatabaseHas('doctores', [
            'nombre' => $doctor->nombre,
            'apellido_paterno' => $doctor->apellido_paterno,
            'apellido_materno' => $doctor->apellido_materno,
            'id_especialidad' => $doctor->id_especialidad,
            'cedula' => $doctor->cedula,
            'telefono' => $doctor->telefono,
        ]);
    }

    public function test_doctor_update()
    {
        $especialidad = Especialidad::factory()->create();

        $doctor = Doctor::factory()->create([
            'id_especialidad' => $especialidad->id,
        ]);

        $nuevaEspecialidad = Especialidad::factory()->create();

        $doctor->update([
            'nombre' => 'NuevoNombre',
            'apellido_paterno' => 'NuevoApellidoPaterno',
            'apellido_materno' => 'NuevoApellidoMaterno',
            'id_especialidad' => $nuevaEspecialidad->id,
            'cedula' => '1234567890',
            'telefono' => '1234567890',
        ]);

        $this->assertDatabaseHas('doctores', [
            'id' => $doctor->id,
            'nombre' => 'NuevoNombre',
            'apellido_paterno' => 'NuevoApellidoPaterno',
            'apellido_materno' => 'NuevoApellidoMaterno',
            'id_especialidad' => $nuevaEspecialidad->id,
            'cedula' => '1234567890',
            'telefono' => '1234567890',
        ]);
    }
    public function test_doctor_deletion()
    {
        $especialidad = Especialidad::factory()->create();

        $doctor = Doctor::factory()->create([
            'id_especialidad' => $especialidad->id,
        ]);

        $doctor->delete();
        
        $this->assertDatabaseMissing('doctores', [
            'id' => $doctor->id,
        ]);
    }

}
