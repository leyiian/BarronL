<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Medicamento;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MedicamentoTest extends TestCase
{
    use RefreshDatabase;

    public function test_medicamento_creation()
    {
        $medicamento = Medicamento::factory()->create([
            'codigo' => 'MED123',
            'descripcion' => 'Descripción del medicamento',
            'precio' => 99.99,
            'existencia' => 50,
            'fecha_caducidad' => '2025-12-31',
        ]);

        $this->assertDatabaseHas('medicamentos', [
            'codigo' => 'MED123',
            'descripcion' => 'Descripción del medicamento',
            'precio' => 99.99,
            'existencia' => 50,
            'fecha_caducidad' => '2025-12-31',
        ]);
    }

    public function test_medicamento_update()
    {
        $medicamento = Medicamento::factory()->create([
            'codigo' => 'MED123',
            'descripcion' => 'Descripción inicial',
            'precio' => 99.99,
            'existencia' => 50,
            'fecha_caducidad' => '2025-12-31',
        ]);

        $medicamento->update([
            'descripcion' => 'Descripción actualizada',
            'precio' => 149.99,
            'existencia' => 75,
        ]);

        $this->assertDatabaseHas('medicamentos', [
            'codigo' => 'MED123',
            'descripcion' => 'Descripción actualizada',
            'precio' => 149.99,
            'existencia' => 75,
            'fecha_caducidad' => '2025-12-31',
        ]);
    }

    public function test_medicamento_deletion()
    {
        $medicamento = Medicamento::factory()->create([
            'codigo' => 'MED123',
            'descripcion' => 'Descripción del medicamento',
            'precio' => 99.99,
            'existencia' => 50,
            'fecha_caducidad' => '2025-12-31',
        ]);

        $medicamento->delete();

        $this->assertDatabaseMissing('medicamentos', [
            'codigo' => 'MED123',
            'descripcion' => 'Descripción del medicamento',
            'precio' => 99.99,
            'existencia' => 50,
            'fecha_caducidad' => '2025-12-31',
        ]);
    }
}
