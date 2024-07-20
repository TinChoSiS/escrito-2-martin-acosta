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
    use WithFaker;

    public function test_alta_sin_datos()
    {
        $response = $this->post('/api/v1/alta');

        $response->assertStatus(400);
    }

    function test_alta_con_datos()
    {
        $personaDatos = [
            'nombre' => $this->faker->name,
            'apellido' => $this->faker->lastName,
            'telefono' => $this->faker->phoneNumber,
        ];

        $response = $this->post('/api/v1/alta', $personaDatos);

        $response->assertJson($personaDatos);

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
        $personaDatos = [
            'nombre' => $this->faker->name,
            'apellido' => $this->faker->lastName,
            'telefono' => $this->faker->phoneNumber,
        ];

        $this->post('/api/v1/alta', $personaDatos);

        $response = $this->get(
            "/api/v1/listar?nombre=".
            "$personaDatos[nombre]&".
            "apellido=$personaDatos[apellido]&". 
            "telefono=$personaDatos[telefono]");

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

        $response->assertJson(['data' => [$personaDatos]]);

        $response->assertStatus(200);
    }

    public function test_listar_con_filtro_nombre()
    {
        $personaDatos = [
            'nombre' => $this->faker->name,
            'apellido' => $this->faker->lastName,
            'telefono' => $this->faker->phoneNumber,
        ];

        $this->post('/api/v1/alta', $personaDatos);

        $response = $this->get("/api/v1/listar?nombre=$personaDatos[nombre]");

        $response->assertJson(['data' => [$personaDatos]]);
        $response->assertStatus(200);
    }

    public function test_listar_con_filtro_apellido()
    {
        $personaDatos = [
            'nombre' => $this->faker->name,
            'apellido' => $this->faker->lastName,
            'telefono' => $this->faker->phoneNumber,
        ];

        $this->post('/api/v1/alta', $personaDatos);

        $response = $this->get("/api/v1/listar?apellido=$personaDatos[apellido]");

        $response->assertJson(['data' => [$personaDatos]]);
        $response->assertStatus(200);
    }

    public function test_listar_con_filtro_telefono()
    {
        $personaDatos = [
            'nombre' => $this->faker->name,
            'apellido' => $this->faker->lastName,
            'telefono' => $this->faker->phoneNumber,
        ];

        $this->post('/api/v1/alta', $personaDatos);

        $response = $this->get("/api/v1/listar?telefono=$personaDatos[telefono]");

        $response->assertJson(['data' => [$personaDatos]]);
        $response->assertStatus(200);
    }

    public function test_buscar_persona()
    {
        $personaDatos = [
            'nombre' => $this->faker->name,
            'apellido' => $this->faker->lastName,
            'telefono' => $this->faker->phoneNumber,
        ];

        $persona = Persona::create($personaDatos);

        $response = $this->get("/api/v1/buscar/$persona[id]");

        $response->assertJson($personaDatos);
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
        $personaDatos = [
            'nombre' => $this->faker->name,
            'apellido' => $this->faker->lastName,
            'telefono' => $this->faker->phoneNumber,
        ];

        $persona = Persona::create($personaDatos);

        $response = $this->put("/api/v1/modificar/$persona[id]", $personaDatos);

        $response->assertJson($personaDatos);

        $response->assertStatus(200);
    }

    public function test_modificar_persona_no_encontrada()
    {
        $response = $this->put('/api/v1/modificar/99999999999999999999', [
            'nombre' => $this->faker->name,
            'apellido' => $this->faker->name,
            'telefono' => $this->faker->name,
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
        $personaDatos = [
            'nombre' => $this->faker->name,
            'apellido' => $this->faker->lastName,
            'telefono' => $this->faker->phoneNumber,
        ];

        $persona = Persona::create($personaDatos);

        $response = $this->put("/api/v1/modificar/$persona[id]");

        $response->assertStatus(400);
    }

    public function test_modificar_persona_con_nombre()
    {
        $personaDatos = [
            'nombre' => $this->faker->name,
            'apellido' => $this->faker->lastName,
            'telefono' => $this->faker->phoneNumber,
        ];

        $persona = Persona::create($personaDatos);

        $response = $this->put("/api/v1/modificar/$persona[id]", [
            'nombre' => 'ElViejo',
        ]);

        $response->assertJson([
            'nombre' => 'ElViejo',
            'apellido' => $personaDatos['apellido'],
            'telefono' => $personaDatos['telefono'],
        ]);

        $response->assertStatus(200);
    }

    public function test_modificar_persona_con_apellido()
    {
        $personaDatos = [
            'nombre' => $this->faker->name,
            'apellido' => $this->faker->lastName,
            'telefono' => $this->faker->phoneNumber,
        ];

        $persona = Persona::create($personaDatos);

        $response = $this->put("/api/v1/modificar/$persona[id]", [
            'apellido' => 'DeLaBolsa',
        ]);

        $response->assertJson([
            'nombre' => $personaDatos['nombre'],
            'apellido' => 'DeLaBolsa',
            'telefono' => $personaDatos['telefono'],
        ]);

        $response->assertStatus(200);
    }

    public function test_modificar_persona_con_telefono()
    {
        $personaDatos = [
            'nombre' => $this->faker->name,
            'apellido' => $this->faker->lastName,
            'telefono' => $this->faker->phoneNumber,
        ];

        $persona = Persona::create($personaDatos);

        $response = $this->put("/api/v1/modificar/$persona[id]", [
            'telefono' => '6767676768',
        ]);

        $response->assertJson([
            'nombre' => $personaDatos['nombre'],
            'apellido' => $personaDatos['apellido'],
            'telefono' => '6767676768',
        ]);

        $response->assertStatus(200);
    }

    public function test_eliminar_persona()
    {
        $personaDatos = [
            'nombre' => $this->faker->name,
            'apellido' => $this->faker->lastName,
            'telefono' => $this->faker->phoneNumber,
        ];

        $persona = Persona::create($personaDatos);

        $response = $this->delete("/api/v1/eliminar/$persona[id]");

        $response->assertStatus(204);
    }

    public function test_eliminar_persona_no_encontrada()
    {
        $response = $this->delete('/api/v1/eliminar/99999999999999999999');

        $response->assertJson([]);
        $response->assertStatus(404);
    }
}
