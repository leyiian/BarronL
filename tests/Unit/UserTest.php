<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserTest extends TestCase
{

    use RefreshDatabase;

    public function test_user_creation()
    {
        $user = User::factory()->create([
            'name' => 'Juan Pérez',
            'email' => 'juan.perez@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Juan Pérez',
            'email' => 'juan.perez@example.com',
        ]);
    }
}
