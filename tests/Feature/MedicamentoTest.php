<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Medicamento;
use Tests\TestCase;

class MedicamentoTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['rol' => 'A']); 
    }

    public function test_create_medicamento()
    {
        $response = $this->actingAs($this->user)->post(route('guardar.medicamento'), [
            'codigo' => 'MED123',
            'descripcion' => 'Descripción del medicamento',
            'precio' => 99.99,
            'existencia' => 50,
            'fecha_caducidad' => '2025-12-31',
        ]);

        // Verificar que la respuesta redirige correctamente
        $response->assertStatus(302);
        $response->assertRedirect(route('medicamentos'));

        // Verificar que los datos se han guardado en la base de datos
        $this->assertDatabaseHas('medicamentos', [
            'codigo' => 'MED123',
            'descripcion' => 'Descripción del medicamento',
            'precio' => 99.99,
            'existencia' => 50,
            'fecha_caducidad' => '2025-12-31',
        ]);
    }

    public function test_update_medicamento()
    {
        $medicamento = Medicamento::factory()->create([
            'codigo' => 'MED123',
            'descripcion' => 'Descripción inicial',
            'precio' => 99.99,
            'existencia' => 50,
            'fecha_caducidad' => '2025-12-31',
        ]);

        $response = $this->actingAs($this->user)->post(route('guardar.medicamento'), [
            'id' => $medicamento->id, // Se pasa el ID para actualizar
            'codigo' => 'MED124',
            'descripcion' => 'Descripción actualizada',
            'precio' => 109.99,
            'existencia' => 60,
            'fecha_caducidad' => '2026-01-01',
        ]);

        // Verificar que la respuesta redirige correctamente
        $response->assertStatus(302);
        $response->assertRedirect(route('medicamentos'));

        // Verificar que los datos se han actualizado en la base de datos
        $this->assertDatabaseHas('medicamentos', [
            'id' => $medicamento->id,
            'codigo' => 'MED124',
            'descripcion' => 'Descripción actualizada',
            'precio' => 109.99,
            'existencia' => 60,
            'fecha_caducidad' => '2026-01-01',
        ]);
    }

    public function test_delete_medicamento()
    {
        $medicamento = Medicamento::factory()->create([
            'codigo' => 'MED123',
            'descripcion' => 'Descripción del medicamento',
            'precio' => 99.99,
            'existencia' => 50,
            'fecha_caducidad' => '2025-12-31',
        ]);

        $response = $this->actingAs($this->user)->post(route('borrar.medicamento'), [
            'id' => $medicamento->id,
        ]);

        // Verificar que la respuesta redirige correctamente
        $response->assertStatus(302);
        $response->assertRedirect(route('medicamentos'));

        // Verificar que los datos se han eliminado de la base de datos
        $this->assertDatabaseMissing('medicamentos', [
            'id' => $medicamento->id,
            'codigo' => 'MED123',
            'descripcion' => 'Descripción del medicamento',
            'precio' => 99.99,
            'existencia' => 50,
            'fecha_caducidad' => '2025-12-31',
        ]);
    }


}
