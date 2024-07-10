<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Request\V1\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
     $credentials = $request->only('CorreoElectronico', 'Contraseña');
     dump($credentials['Contraseña']);

     if (Auth::attempt(['CorreoElectronico' => $credentials['CorreoElectronico'], 'Contraseña' => $credentials['Contraseña']])) {
         $user = Auth::user();
         $token = $user->createToken('tokensesion')->plainTextToken;
         return response()->json(['token' => $token], 200);
     }

     return response()->json(['error' => 'Credenciales inválidas, intente de nuevo.'], 401);
    //     $user = User::where('email', $request->input('email'))->first();
    // if(!$user || Hash::check($request->password, $user->password) ){
    //     return response ()->json([
    //         'message' => 'Credenciales incorrectas',
    //     ],401);
    // }
    // return response()->json([
    //     'user' => [
    //         'name' => $user->name,
    //         'email' => $user->email,
    //     ],
    //     'token' => $user->createToken('api')->plainTextToken,
    // ]);
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
}
