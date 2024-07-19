<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

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
}
