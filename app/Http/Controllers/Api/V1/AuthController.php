<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Request\V1\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\GeneradorContenido;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('CorreoElectronico', 'password');
     

      if (Auth::attempt(['CorreoElectronico' => $credentials['CorreoElectronico'], 'password' => $credentials['password']])) {
          $user = Auth::user();
          $token = $user->createToken('tokensesion')->plainTextToken;
          return response()->json(['token' => $token], 200);
      }

      return response()->json(['error' => 'Credenciales inválidas, intente de nuevo.'], 401);
    }


    /**
     * Logout user (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Ha cerrado sesión correctamente.'], 200);
    }


    //antiguo login
 
}
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