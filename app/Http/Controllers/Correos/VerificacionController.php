<?php

namespace App\Http\Controllers\Correos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificacionMailable;

class VerificacionController extends Controller
{
    public function EnviarCorreo( Request $request)
    {
        $correoElectronico=$request->input('CorreoElectronico');
        
        Mail::to($correoElectronico)->send(new VerificacionMailable);

        return response()->json([
            'Mensaje' =>'Correo electronico enviado correctamente a:ok' ,
            'status' => 200
        ]);

    }
}
