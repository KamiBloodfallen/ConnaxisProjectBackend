<?php

namespace App\Http\Controllers\Api;

use Google\Client;
use Google\Service\YouTube;
use Google\Service\YouTubeAnalytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Models\GeneradorContenido;

class YoutubeController extends Controller
{
    private $client;
     
    function getUrlYoutube (){
        $client = new Client();
        $client->setAuthConfig(base_path('youtube.json'));
        $client->setRedirectUri('https://prismatic-horse-124283.netlify.app/');
        $client->setIncludeGrantedScopes(true);
        $client->setAccessType('offline');
        $client->addScope('https://www.googleapis.com/auth/analytics');
        $client->addScope('https://www.googleapis.com/auth/analytics.readonly');
        $client->addScope('https://www.googleapis.com/auth/youtube.readonly');
        
        $authUrl = $client->createAuthUrl();
        
        return response()->json(['authUrl' => $authUrl],200);
    }

    function createTokenYoutube (Request $request) {

        $codigo = $request->input('codeYoutube');
        $token = $client->fetchAccessTokenWithAuthCode($codigo);
        $client->setAccessToken($token);
    

        return response()->json(['tokenYoutube' => $token], 200);
    }
    
    //metodo en prueba
    function saveTokenYoutube ( Request $request){
        $token = $request-> input('tokenYoutube');
        $Idus = $request-> input ('IdUsuario'); 
        Youtube::create([
            'IdGeneradorContenido' => $Idus,
            'TokenAccess' => $token,
            'IdCuenta' => null,
            'NombreCanal' => null, 
            'CantVideos' => null, 
            'CantSeguidores' => null, 
            'CantLikes' => null, 
            'Engegament' => null, 
        ]);
    }
}
