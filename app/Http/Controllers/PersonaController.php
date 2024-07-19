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
            $request->post('nombre') &&
            $request->post('apellido') &&
            $request->post('telefono')
        ) {
            $persona = new Persona([
                'nombre' => $request->post('nombre'),
                'apellido' => $request->post('apellido'),
                'telefono' => $request->post('telefono'),
            ]);
            $persona->save();
            return response()->json($persona, 201);
        }

        return response()->json([], 400);
    }

    public function listar(Request $request)
    {
        $personas = Persona::where('nombre', 'like', '%' . $request->get('nombre') . '%')
            ->where('apellido', 'like', '%' . $request->get('apellido') . '%')
            ->where('telefono', 'like', '%' . $request->get('telefono') . '%')
            ->paginate(10);

        return response()->json($personas, 200);
    }

    public function buscar($id)
    {
        $persona = Persona::find($id);

        return $persona
            ? response()->json($persona, 200)
            : response()->json([], 404);
    }

    public function modificar(Request $request, $id)
    {
        if (
            !$request->post('nombre') && !$request->post('apellido') && !$request->post('telefono')
        ) return response()->json([], 400);

        $persona = Persona::find($id);

        if (!$persona) return response()->json([], 404);

        if ($request->post('nombre')) $persona->nombre = $request->post('nombre');
        if ($request->post('apellido')) $persona->apellido = $request->post('apellido');
        if ($request->post('telefono')) $persona->telefono = $request->post('telefono');

        $persona->save();
        return response()->json($persona, 200);   
    }
}
