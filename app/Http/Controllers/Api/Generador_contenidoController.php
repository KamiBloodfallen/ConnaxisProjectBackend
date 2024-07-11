<?php

namespace App\Http\Controllers\Api;
use App\Models\GeneradorContenido; 
use App\Models\Interes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class Generador_contenidoController extends Controller
{
    public function prueba()
    {
        $listaGeneradores = GeneradorContenido::all();

        if ($listaGeneradores->isEmpty()) {
            return response()->json("La lista está vacía", 200);
        } else {
            return response()->json($listaGeneradores, 200);
        }
    }

    public function registrar(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'Nombre' => 'required|string',
            'Apellido' => 'required|string',
            'Celular' => 'required|integer',
            'CorreoElectronico' => 'required|email|unique:generador_contenidos',
            'FechaNacimiento' => 'required|date',
            //'Descripcion'=>'required|string',
            'Sexo' => 'required|string',
            'Contraseña' => 'required|string',
            'ResidenciaDepartamento' => 'required|string'
        ]);

        if ($validador->fails()) {
            $data = [
                'mensaje' => 'Error al registrar los datos',
                'errors' => $validador->errors(),
                'status' => 400
            ];
            return response()->json($data, 200);
        } else {
            $contraseñaHasheada = Hash::make($request->input('Contraseña'));

            // Crear el generador de contenido con la contraseña hasheada
            $generador = GeneradorContenido::create([
                'Nombre' => $request->input('Nombre'),
                'Apellido' => $request->input('Apellido'),
                'Celular' => $request->input('Celular'),
                'CorreoElectronico' => $request->input('CorreoElectronico'),
                'FechaNacimiento' => $request->input('FechaNacimiento'),
                'Sexo' => $request->input('Sexo'),
                'Contraseña' => $contraseñaHasheada, // Guardar la contraseña hasheada
                'ResidenciaDepartamento' => $request->input('ResidenciaDepartamento'),
            ]);

            if (!$generador) {
                $data = [
                    'mensaje' => 'Error al crear el usuario',
                    'status' => 500
                ];
                return response()->json($data, 200);
            } else {
                $data = [
                    'generador' => $generador,
                    'status' => 200
                ];
                return response()->json($data, 200);
            }
        }
    }

    public function obtenerPorId($id)
    {
        // Busca el generador de contenido por ID
        $generador = GeneradorContenido::find($id);

        if (!$generador) {
            // Si no se encuentra el generador de contenido, retorna un mensaje de error
            return response()->json([
                'mensaje' => 'Generador de contenido no encontrado',
                'status' => 404
            ], 404);
        }

        // Retorna los datos del generador de contenido
        return response()->json([
            'generador' => $generador,
            'status' => 200
        ], 200);
    }

    /**
     * Actualizar el Nombre_perfil de un generador de contenido por su ID.
     */
    public function actualizarNombrePerfil(Request $request, $id)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'Nombre_perfil' => 'required|string|max:255',
        ]);

        // Buscar el generador de contenido por ID
        $generador = GeneradorContenido::find($id);

        if (!$generador) {
            // Si no se encuentra el generador de contenido, retorna un mensaje de error
            return response()->json([
                'mensaje' => 'Generador de contenido no encontrado',
                'status' => 404
            ], 404);
        }

        // Actualizar el campo Nombre_perfil
        $generador->Nombre_perfil = $request->Nombre_perfil;
        $generador->save();

        // Retorna los datos actualizados del generador de contenido
        return response()->json([
            'generador' => $generador,
            'status' => 200
        ], 200);
    }

    public function getIntereses($id){
        // Busca intereses del generador de contenido
        $interes_generador =Interes::where('IdUsu', $id)->first();
        if (!$interes_generador) {
            // Si no se encuentra el interes del generador de contenido, retorna un mensaje de error
            return response()->json([
                'mensaje' => 'Intereses del Generador de contenido no encontrados',
                'status' => 404
            ], 404);
        }

        // Retorna los interesces del generador de contenido
        return response()->json([
            'generador' => $interes_generador,
            'status' => 200
        ], 200);
    }

    //registrar los intereses del generador de contenido
    public function postIntereses(Request $request){
       
            
    $interes = new Interes();
    $interes->IdUsu = $request->input('IdUsu'); // Asume que recibes IdUsu desde el formulario o solicitud
    $interes->Intereses_Usuario = $request->input('Intereses_Usuario');

    $interes->save();

    return response()->json([
        'message' => 'Interés registrado correctamente',
        'data' => $interes,
    ], 201);
        
    }


    public function actualizarDescripcion(Request $request, $id){
       
        // Validar los datos de la solicitud
        $request->validate([
            'Descripcion' => 'required|string|max:255',
        ]);

        // Buscar el generador de contenido por ID
        $generador = GeneradorContenido::find($id);

        if (!$generador) {
            // Si no se encuentra el generador de contenido, retorna un mensaje de error
            return response()->json([
                'mensaje' => 'Generador de contenido no encontrado',
                'status' => 404
            ], 404);
        }

        // Actualizar el campo Nombre_perfil
        $generador->Descripcion = $request->Descripcion;
        $generador->save();

        // Retorna los datos actualizados del generador de contenido
        return response()->json([
            'generador' => $generador,
            'status' => 200
        ], 200);

    }
}
