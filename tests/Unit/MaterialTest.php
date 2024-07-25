<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaterialTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_material()
    {
        $material = Material::factory()->create([
            'codigo' => 'MAT123',
            'descripcion' => 'Descripción del material',
            'precio' => 49.99,
            'existencia' => 100,
            'fecha_caducidad' => '2025-12-31',
        ]);

        $this->assertDatabaseHas('material', [
            'codigo' => 'MAT123',
            'descripcion' => 'Descripción del material',
            'precio' => 49.99,
            'existencia' => 100,
            'fecha_caducidad' => '2025-12-31',
        ]);
    }

    public function test_update_material()
    {
        $material = Material::factory()->create([
            'codigo' => 'MAT123',
            'descripcion' => 'Descripción del material',
            'precio' => 49.99,
            'existencia' => 100,
            'fecha_caducidad' => '2025-12-31',
        ]);

        $material->update([
            'codigo' => 'MAT124',
            'descripcion' => 'Descripción actualizada',
            'precio' => 59.99,
            'existencia' => 120,
            'fecha_caducidad' => '2026-01-01',
        ]);

        $this->assertDatabaseHas('material', [
            'codigo' => 'MAT124',
            'descripcion' => 'Descripción actualizada',
            'precio' => 59.99,
            'existencia' => 120,
            'fecha_caducidad' => '2026-01-01',
        ]);
    }

    public function test_delete_a_material()
    {
        $material = Material::factory()->create([
            'codigo' => 'MAT123',
            'descripcion' => 'Descripción del material',
            'precio' => 49.99,
            'existencia' => 100,
            'fecha_caducidad' => '2025-12-31',
        ]);

        $material->delete();

        $this->assertDatabaseMissing('material', [
            'codigo' => 'MAT123',
            'descripcion' => 'Descripción del material',
            'precio' => 49.99,
            'existencia' => 100,
            'fecha_caducidad' => '2025-12-31',
        ]);
    }
}
