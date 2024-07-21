<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Especialidad;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EspecialidadTest extends TestCase
{
    use RefreshDatabase;

    public function test_especialidad_creation()
    {
        $especialidad = Especialidad::factory()->create([
            'nombre' => 'Cardiología',
        ]);

        $this->assertDatabaseHas('especialidades', [
            'nombre' => 'Cardiología',
        ]);
    }
    public function test_modificar_especialidad()
    {
        $especialidad = Especialidad::factory()->create([
            'nombre' => 'Cardiología',
        ]);

        $especialidad->nombre = 'Neurología';
        $especialidad->save();

        $this->assertDatabaseHas('especialidades', [
            'nombre' => 'Neurología',
        ]);

        $this->assertDatabaseMissing('especialidades', [
            'nombre' => 'Cardiología',
        ]);
    }
    public function test_eliminar_especialidad()
    {
        $especialidad = Especialidad::factory()->create([
            'nombre' => 'Cardiología',
        ]);

        $especialidad->delete();

        $this->assertDatabaseMissing('especialidades', [
            'nombre' => 'Cardiología',
        ]);
    }
}
