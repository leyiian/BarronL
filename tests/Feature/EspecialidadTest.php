<?php

namespace Tests\Feature;

use App\Models\Especialidad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\User;

class EspecialidadTest extends TestCase
{
    use RefreshDatabase;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear y autenticar un usuario
        $this->user = User::factory()->create([
            'password' => Hash::make('password'), // Establecer una contraseña para el usuario
        ]);

        $this->actingAs($this->user);
    }

    public function test_create_especialidad()
    {
        $response = $this->actingAs($this->user)->post(route('guardar.especialidades'), [
            'nombre' => 'Cardiología',
        ]);

        $response->assertStatus(302); // Redirige después de crear
        $this->assertDatabaseHas('especialidades', [
            'nombre' => 'Cardiología',
        ]);
    }
    
    public function test_update_especialidad()
    {
        $especialidad = Especialidad::create([
            'nombre' => 'Pediatría',
            'estado' => true,
        ]);

        $response = $this->actingAs($this->user)->post(route('guardar.especialidades'), [
            'id' => $especialidad->id,
            'nombre' => 'Ginecología',
        ]);

        $response->assertStatus(302); // Redirige después de actualizar
        $this->assertDatabaseHas('especialidades', [
            'nombre' => 'Ginecología',
        ]);
    }

    public function test_delete_especialidad()
    {
        $especialidad = Especialidad::create([
            'nombre' => 'Oftalmología',
            'estado' => true,
        ]);

        $response = $this->actingAs($this->user)->post(route('borrar.especialidad'), [
            'id' => $especialidad->id,
        ]);

        $response->assertStatus(302); // Redirige después de eliminar
        $this->assertDatabaseMissing('especialidades', [
            'nombre' => 'Oftalmología',
        ]);
    }
}
