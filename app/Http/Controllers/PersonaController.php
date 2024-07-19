<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class PersonaController extends Controller
{
    public function alta(Request $request)
    {
        if (
            $request->has('nombre') &&
            $request->has('apellido') &&
            $request->has('telefono')
        ) {
            $persona = new Persona([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'telefono' => $request->telefono,
            ]);
            $persona->save();
            return response()->json($persona, 201);
        }

        return response()->json([], 400);
    }

    public function listar()
    {
        $personas = Persona::all();
        return response()->json($personas, 200);
    }

    public function buscar($id)
    {
        $persona = Persona::find($id);

        return $persona
            ? response()->json($persona, 200)
            : response()->json([], 404);
    }
}
