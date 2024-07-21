<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Paciente;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PacienteTest extends TestCase
{
    use RefreshDatabase;

    public function test_paciente_creation()
    {
        $paciente = Paciente::factory()->create([
            'nombre' => 'Juan Pérez',
            'apPat' => 'Pérez',
            'apMat' => 'García',
            'telefono' => '555-1234',
        ]);

        $this->assertDatabaseHas('pacientes', [
            'nombre' => 'Juan Pérez',
            'apPat' => 'Pérez',
            'apMat' => 'García',
            'telefono' => '555-1234',
        ]);
    }

    public function test_paciente_update()
    {
        $paciente = Paciente::factory()->create([
            'nombre' => 'Ana López',
            'apPat' => 'López',
            'apMat' => 'Martínez',
            'telefono' => '555-5678',
        ]);

        $paciente->update([
            'nombre' => 'Ana Martínez',
            'apPat' => 'Martínez',
            'apMat' => 'Pérez',
            'telefono' => '555-8765',
        ]);

        $this->assertDatabaseHas('pacientes', [
            'nombre' => 'Ana Martínez',
            'apPat' => 'Martínez',
            'apMat' => 'Pérez',
            'telefono' => '555-8765',
        ]);
    }

    public function test_paciente_deletion()
    {
        $paciente = Paciente::factory()->create([
            'nombre' => 'Luis Gómez',
            'apPat' => 'Gómez',
            'apMat' => 'Hernández',
            'telefono' => '555-4321',
        ]);

        $paciente->delete();

        $this->assertDatabaseMissing('pacientes', [
            'nombre' => 'Luis Gómez',
            'apPat' => 'Gómez',
            'apMat' => 'Hernández',
            'telefono' => '555-4321',
        ]);
    }
}
