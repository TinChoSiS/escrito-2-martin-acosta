<?php

namespace Tests\Feature;

use App\Models\Persona;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonaTest extends TestCase
{
    use DatabaseTransactions;

    public function test_alta_sin_datos()
    {
        $response = $this->post('/api/v1/alta');

        $response->assertStatus(400);
    }

    function test_alta_con_datos()
    {
        $response = $this->post('/api/v1/alta', [
            'nombre' => 'ElViejo',
            'apellido' => 'DeLaBolsa',
            'telefono' => '1234567890',
        ]);

        $response->assertJson([
            'nombre' => 'ElViejo',
            'apellido' => 'DeLaBolsa',
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

    function test_listar_sin_filtros()
    {
        $response = $this->get('/api/v1/listar');

        $response->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'apellido',
                    'telefono',
                    'updated_at',
                ],
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);
        $response->assertStatus(200);
    }

    function test_listar_con_filtros()
    {
        $peronsa = [
            'nombre' => 'ElViejo',
            'apellido' => 'DeLaBolsa',
            'telefono' => '6767676767',
        ];

        $this->post('/api/v1/alta', $peronsa);

        $response = $this->get('/api/v1/listar?nombre=ElViejo&apellido=DeLaBolsa&telefono=6767676767');

        $response->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'apellido',
                    'telefono',
                    'updated_at',
                ],
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);

        $response->assertJson(['data' => [$peronsa]]);

        $response->assertStatus(200);
    }

    public function test_listar_con_filtro_nombre()
    {
        $persona = [
            'nombre' => 'ElViejo',
            'apellido' => 'DeLaBolsa',
            'telefono' => '6767676767',
        ];

        $this->post('/api/v1/alta', $persona);

        $response = $this->get('/api/v1/listar?nombre=ElVi');

        $response->assertJson(['data' => [$persona]]);
        $response->assertStatus(200);
    }

    public function test_listar_con_filtro_apellido()
    {
        $persona = [
            'nombre' => 'ElViejo',
            'apellido' => 'DeLaBolsa',
            'telefono' => '6767676767',
        ];

        $this->post('/api/v1/alta', $persona);

        $response = $this->get('/api/v1/listar?apellido=DeLa');

        $response->assertJson(['data' => [$persona]]);
        $response->assertStatus(200);
    }

    public function test_listar_con_filtro_telefono()
    {
        $persona = [
            'nombre' => 'ElViejo',
            'apellido' => 'DeLaBolsa',
            'telefono' => '6767676767',
        ];

        $this->post('/api/v1/alta', $persona);

        $response = $this->get('/api/v1/listar?telefono=6767');

        $response->assertJson(['data' => [$persona]]);
        $response->assertStatus(200);
    }

    public function test_buscar_persona()
    {
        $persona = [
            'id' => 9999999,
            'nombre' => 'ElViejo',
            'apellido' => 'DeLaBolsa',
            'telefono' => '6767676767',
        ];

        Persona::create($persona);

        $response = $this->get("/api/v1/buscar/$persona[id]");

        $response->assertJson($persona);
        $response->assertStatus(200);
    }

    public function test_buscar_persona_no_encontrada()
    {
        $response = $this->get('/api/v1/buscar/99999999999999999999');

        $response->assertJson([]);
        $response->assertStatus(404);
    }

    public function test_modificar_persona()
    {
        $persona = [
            'id' => 9999999,
            'nombre' => 'ElViejo',
            'apellido' => 'DeLaBolsa',
            'telefono' => '6767676767',
        ];

        Persona::create($persona);

        $response = $this->put("/api/v1/modificar/$persona[id]", [
            'nombre' => 'ElViejo',
            'apellido' => 'DeLaBolsa',
            'telefono' => '6767676767',
        ]);

        $response->assertJson([
            'id' => 9999999,
            'nombre' => 'ElViejo',
            'apellido' => 'DeLaBolsa',
            'telefono' => '6767676767',
        ]);

        $response->assertStatus(200);
    }

    public function test_modificar_persona_no_encontrada()
    {
        $response = $this->put('/api/v1/modificar/99999999999999999999', [
            'nombre' => 'ElViejo',
            'apellido' => 'DeLaBolsa',
            'telefono' => '6767676767',
        ]);

        $response->assertJson([]);
        $response->assertStatus(404);
    }

    public function test_modificar_persona_sin_datos()
    {
        $response = $this->put('/api/v1/modificar/99999999999999999999');

        $response->assertStatus(400);
    }

    public function test_modificar_persona_con_datos_vacios()
    {
        $persona = [
            'id' => 9999999,
            'nombre' => 'ElViejo',
            'apellido' => 'DeLaBolsa',
            'telefono' => '6767676767',
        ];

        Persona::create($persona);

        $response = $this->put("/api/v1/modificar/$persona[id]");

        $response->assertStatus(400);
    }

    public function test_modificar_persona_con_nombre()
    {
        $persona = [
            'id' => 9999999,
            'nombre' => 'ElViejo',
            'apellido' => 'DeLaBolsa',
            'telefono' => '6767676767',
        ];

        Persona::create($persona);

        $response = $this->put("/api/v1/modificar/$persona[id]", [
            'nombre' => 'ElViejo2',
        ]);

        $response->assertJson([
            'id' => 9999999,
            'nombre' => 'ElViejo2',
            'apellido' => 'DeLaBolsa',
            'telefono' => '6767676767',
        ]);

        $response->assertStatus(200);
    }

    public function test_modificar_persona_con_apellido()
    {
        $persona = [
            'id' => 9999999,
            'nombre' => 'ElViejo',
            'apellido' => 'DeLaBolsa',
            'telefono' => '6767676767',
        ];

        Persona::create($persona);

        $response = $this->put("/api/v1/modificar/$persona[id]", [
            'apellido' => 'DeLaBolsa2',
        ]);

        $response->assertJson([
            'id' => 9999999,
            'nombre' => 'ElViejo',
            'apellido' => 'DeLaBolsa2',
            'telefono' => '6767676767',
        ]);

        $response->assertStatus(200);
    }

    public function test_modificar_persona_con_telefono()
    {
        $persona = [
            'id' => 9999999,
            'nombre' => 'ElViejo',
            'apellido' => 'DeLaBolsa',
            'telefono' => '6767676767',
        ];

        Persona::create($persona);

        $response = $this->put("/api/v1/modificar/$persona[id]", [
            'telefono' => '6767676768',
        ]);

        $response->assertJson([
            'id' => 9999999,
            'nombre' => 'ElViejo',
            'apellido' => 'DeLaBolsa',
            'telefono' => '6767676768',
        ]);

        $response->assertStatus(200);
    }
}
