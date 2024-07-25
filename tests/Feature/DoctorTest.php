<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\Especialidad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class DoctorTest extends TestCase
{
    use RefreshDatabase;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear y autenticar un usuario

        $this->user = User::factory()->create(['rol' => 'A']);
    }

    public function test_create_doctor()
    {
        $especialidad = Especialidad::factory()->create();

        $response = $this->actingAs($this->user)->post(route('guardar.doctor'), [
            'nombre' => 'Juan',
            'apellido_paterno' => 'Pérez',
            'apellido_materno' => 'González',
            'id_especialidad' => $especialidad->id,
            'cedula' => '1234567890',
            'telefono' => '1234567890',
            'email' => 'juan@example.com',
            'password' => 'password123',
            'rol' => 'D',
        ]);

        // Verificar que la respuesta redirige correctamente
        $response->assertStatus(302);
        $response->assertRedirect(route('doctores'));

        // Verificar que los datos se guardan en la base de datos
        $this->assertDatabaseHas('doctores', [
            'nombre' => 'Juan',
            'apellido_paterno' => 'Pérez',
            'apellido_materno' => 'González',
            'id_especialidad' => $especialidad->id,
            'cedula' => '1234567890',
            'telefono' => '1234567890',
        ]);
    }
}
