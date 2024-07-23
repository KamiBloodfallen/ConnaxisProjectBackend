<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\GeneradorContenido;

class AuthController extends Controller
{
    //Funcion para autenticarse con las base de datos
    public function login(Request $request)
    {
        $credentials = $request->only('CorreoElectronico', 'password');
     

      if (Auth::attempt(['CorreoElectronico' => $credentials['CorreoElectronico'], 'password' => $credentials['password']])) {
          $user = Auth::user();
          $token = $user->createToken('tokensesion')->plainTextToken;
          $usuario = GeneradorContenido::where('CorreoElectronico', $credentials['CorreoElectronico'])->select('IdUsuario', 'Nombre', 'Apellido', 'CorreoElectronico')->first();

          return response()->json(['token' => $token, 'usuario' => $usuario], 200);
      }

      return response()->json(['error' => 'Credenciales inválidas, intente de nuevo.'], 401);
    }


    /**
     * Logout user (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

     //Funcion para desloguearse (todavia no se usa)
    public function logout(Request $request)
    {
        
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Ha cerrado sesión correctamente.'], 200);
    }


   
 
}


// Alternativa de login

// $validated = $request->validate([
//     'CorreoElectronico' => 'required|email',
//     'password' => 'required',
// ]);

// $user = GeneradorContenido::where('CorreoElectronico', $validated['CorreoElectronico'])->first();
//  if($user && Hash::check($validated['password'], $user->password) ){
//      return response()->json([
//         'user' => [
//             'Nombre' => $user->Nombre,
//             'Correo' => $user->CorreoElectronico,
//         ],
//         'token' => $user->createToken('tokenSession')->plainTextToken,
//     ]);
//  }
//  return response ()->json([
//     'message' => 'Credenciales incorrectas',
// ],401);