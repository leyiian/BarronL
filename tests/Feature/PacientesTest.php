<?php

namespace Tests\Feature;

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PacientesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear un usuario autenticado para las pruebas
        $this->user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'rol' => 'A', // Asignar el rol de administrador para las pruebas
        ]);
    }

    public function test_create_paciente()
    {
        $response = $this->actingAs($this->user)->post(route('guardar.paciente'), [
            'nombre' => 'Juan',
            'apPat' => 'Pérez',
            'apMat' => 'García',
            'telefono' => '555-1234',
            'email' => 'juan@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('pacientes'));

        $this->assertDatabaseHas('pacientes', [
            'nombre' => 'Juan',
            'apPat' => 'Pérez',
            'apMat' => 'García',
            'telefono' => '555-1234',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'juan@example.com',
            'rol' => 'P',
        ]);
    }

    public function test_update_paciente()
    {
        // Crear un paciente primero
        $paciente = Paciente::factory()->create([
            'nombre' => 'Juan',
            'apPat' => 'Pérez',
            'apMat' => 'García',
            'telefono' => '555-1234',
            'idUsr' => $this->user->id,
        ]);

        // Actualizar el paciente
        $response = $this->actingAs($this->user)->post(route('guardar.paciente'), [
            'id' => $paciente->id,
            'nombre' => 'Juan Updated',
            'apPat' => 'Pérez Updated',
            'apMat' => 'García Updated',
            'telefono' => '555-5678',
            'email' => 'juan.updated@example.com',
            'password' => 'newpassword123'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('pacientes'));

        $this->assertDatabaseHas('pacientes', [
            'id' => $paciente->id,
            'nombre' => 'Juan Updated',
            'apPat' => 'Pérez Updated',
            'apMat' => 'García Updated',
            'telefono' => '555-5678',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'email' => 'juan.updated@example.com',
        ]);
    }

    public function test_delete_paciente()
    {
        // Crear un paciente primero
        $paciente = Paciente::factory()->create([
            'nombre' => 'Juan',
            'apPat' => 'Pérez',
            'apMat' => 'García',
            'telefono' => '555-1234',
            'idUsr' => $this->user->id,
        ]);

        // Eliminar el paciente
        $response = $this->actingAs($this->user)->post(route('borrar.paciente'), [
            'id' => $paciente->id,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('pacientes'));

        $this->assertDatabaseMissing('pacientes', [
            'id' => $paciente->id,
        ]);
    }
}
