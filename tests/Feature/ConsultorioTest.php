<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Consultorio;
use Tests\TestCase;

class ConsultorioTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['rol' => 'A']);  
    }

    public function test_create_consultorio()
    {
        $response = $this->actingAs($this->user)->post(route('guardar.consultorio'), [
            'numero' => '101',
        ]);

        // Verificar que la respuesta redirige correctamente
        $response->assertStatus(302);
        $response->assertRedirect(route('consultorios'));

        // Verificar que los datos se han guardado en la base de datos
        $this->assertDatabaseHas('consultorios', [
            'numero' => '101',
        ]);
    }

    public function test_update_consultorio()
    {
        // Primero, crear un consultorio para actualizar
        $consultorio = Consultorio::create([
            'numero' => '101',
        ]);

        // Actualizar el consultorio
        $response = $this->actingAs($this->user)->post(route('guardar.consultorio'), [
            'id' => $consultorio->id,
            'numero' => '202',
        ]);

        // Verificar que la respuesta redirige correctamente
        $response->assertStatus(302);
        $response->assertRedirect(route('consultorios'));

        // Verificar que los datos se han actualizado en la base de datos
        $this->assertDatabaseHas('consultorios', [
            'id' => $consultorio->id,
            'numero' => '202',
        ]);
    }

    public function test_delete_consultorio()
    {
        // Primero, crear un consultorio para eliminar
        $consultorio = Consultorio::create([
            'numero' => '101',
        ]);

        // Eliminar el consultorio
        $response = $this->actingAs($this->user)->post(route('borrar.consultorio'), [
            'id' => $consultorio->id,
        ]);

        // Verificar que la respuesta redirige correctamente
        $response->assertStatus(302);
        $response->assertRedirect(route('consultorios'));

        // Verificar que los datos se han eliminado de la base de datos
        $this->assertDatabaseMissing('consultorios', [
            'id' => $consultorio->id,
        ]);
    }


}
