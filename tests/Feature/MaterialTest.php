<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Material;
use Tests\TestCase;

class MaterialTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(); // Crear un usuario para autenticación
    }

    public function test_create_material()
    {
        $response = $this->actingAs($this->user)->post(route('guardar.material'), [
            'codigo' => 'MAT123',
            'descripcion' => 'Descripción del material',
            'precio' => 49.99,
            'existencia' => 100,
            'fecha_caducidad' => '2025-12-31',
        ]);

        // Verificar que la respuesta redirige correctamente
        $response->assertStatus(302);
        $response->assertRedirect(route('materiales'));

        // Verificar que los datos se han guardado en la base de datos
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
            'descripcion' => 'Descripción inicial',
            'precio' => 49.99,
            'existencia' => 100,
            'fecha_caducidad' => '2025-12-31',
        ]);

        $response = $this->actingAs($this->user)->post(route('guardar.material'), [
            'id' => $material->id, // Se pasa el ID para actualizar
            'codigo' => 'MAT124',
            'descripcion' => 'Descripción actualizada',
            'precio' => 59.99,
            'existencia' => 120,
            'fecha_caducidad' => '2026-01-01',
        ]);

        // Verificar que la respuesta redirige correctamente
        $response->assertStatus(302);
        $response->assertRedirect(route('materiales'));

        // Verificar que los datos se han actualizado en la base de datos
        $this->assertDatabaseHas('material', [
            'id' => $material->id,
            'codigo' => 'MAT124',
            'descripcion' => 'Descripción actualizada',
            'precio' => 59.99,
            'existencia' => 120,
            'fecha_caducidad' => '2026-01-01',
        ]);
    }

    public function test_delete_material()
    {
        $material = Material::factory()->create([
            'codigo' => 'MAT123',
            'descripcion' => 'Descripción del material',
            'precio' => 49.99,
            'existencia' => 100,
            'fecha_caducidad' => '2025-12-31',
        ]);

        $response = $this->actingAs($this->user)->post(route('borrar.material'), [
            'id' => $material->id,
        ]);

        // Verificar que la respuesta redirige correctamente
        $response->assertStatus(302);
        $response->assertRedirect(route('materiales'));

        // Verificar que los datos se han eliminado de la base de datos
        $this->assertDatabaseMissing('material', [
            'id' => $material->id,
            'codigo' => 'MAT123',
            'descripcion' => 'Descripción del material',
            'precio' => 49.99,
            'existencia' => 100,
            'fecha_caducidad' => '2025-12-31',
        ]);
    }


}