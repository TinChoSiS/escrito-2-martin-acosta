<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonaTest extends TestCase
{
    use DatabaseTransactions;

    public function test_alta_sin_datos()
    {
        $response = $this->post('/api/alta');

        $response->assertStatus(400);
    }

    function test_alta_con_datos()
    {
        $response = $this->post('/api/alta', [
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'telefono' => '1234567890',
        ]);

        $response->assertJson([
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'telefono' => '1234567890',
        ]);

        $response->assertJsonStructure([
            'id',
            'nombre',
            'apellido',
            'telefono',
            'updated_at',
        ]);
        
        $response->assertStatus(201);
    }
}
