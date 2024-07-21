<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Consultorio;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConsultorioTest extends TestCase
{

    use RefreshDatabase;

    public function test_consultorio_creation()
    {
        $consultorio = Consultorio::factory()->create([
            'numero' => 101,
        ]);

        $this->assertDatabaseHas('consultorios', [
            'numero' => 101,
        ]);
    }

    public function test_consultorio_update()
    {
        $consultorio = Consultorio::factory()->create([
            'numero' => 101,
        ]);

        $consultorio->update(['numero' => 102]);

        $this->assertDatabaseHas('consultorios', [
            'numero' => 102,
        ]);

        $this->assertDatabaseMissing('consultorios', [
            'numero' => 101,
        ]);
    }

    public function test_consultorio_deletion()
    {
        $consultorio = Consultorio::factory()->create([
            'numero' => 101,
        ]);

        $consultorio->delete();

        $this->assertDatabaseMissing('consultorios', [
            'numero' => 101,
        ]);
    }
}
