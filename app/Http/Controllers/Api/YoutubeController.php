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

use Illuminate\Support\Facades\Log;

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
        $code = $request->input('codeYoutube');
        
        $client = new Client();
        $client->setAuthConfig(base_path('youtube.json'));
        $client->setRedirectUri('https://prismatic-horse-124283.netlify.app/');
        $client->setIncludeGrantedScopes(true);
        $client->setAccessType('offline');
        $client->addScope('https://www.googleapis.com/auth/analytics');
        $client->addScope('https://www.googleapis.com/auth/analytics.readonly');
        $client->addScope('https://www.googleapis.com/auth/youtube.readonly');


        if (!$request->has('codeYoutube')) {
            return response()->json(['El codigo de confirmacion no existe'], 500);
         }
       
        Log::info("codigo recibido: " . $code);
        $token = $client->fetchAccessTokenWithAuthCode($code);
        $client->setAccessToken($token);

        return response()->json(['tokenYoutube' => $token], 200);
    }
    
    //metodo en prueba
    function saveTokenYoutube ( Request $request){
        $token = $request-> input('tokenYoutube');
        $Idus = $request-> input ('IdUsuario'); 

        $client = new Client();
        $client->setAuthConfig(base_path('youtube.json'));
        $client->setIncludeGrantedScopes(true);
        $client->setAccessType('offline');
        $client->addScope('https://www.googleapis.com/auth/analytics');
        $client->addScope('https://www.googleapis.com/auth/analytics.readonly');
        $client->addScope('https://www.googleapis.com/auth/youtube.readonly');

        $client->setAccessToken($token);
        $service = new YouTube($client);
    
             $queryParams = [
                 'mine' => true,
                 'pageToken' => $token 
             ];
    
         $response = $service->channels->listChannels('id',$queryParams);
         $cuenta = $response->items[0]->id;

        Youtube::create([
            'IdGeneradorContenido' => $Idus,
            'TokenAccess' => $token,
            'IdCuenta' => $cuenta,
            'NombreCanal' => null, 
            'CantVideos' => null, 
            'CantSeguidores' => null, 
            'CantLikes' => null, 
            'Engegament' => null, 
        ]);

        return response()->json(['confirmacion' => true  , 'cuenta' => $cuenta ], 200);
        
    }

  

    function cardData (Request $request) {
        $cuenta = $request->input('IdCuenta');
        $client =new Client ();
        $client->setAuthConfig(base_path('youtube.json'));
        $client->setIncludeGrantedScopes(true);
        $client->setAccessType('offline');
        $client->addScope('https://www.googleapis.com/auth/analytics');
        $client->addScope('https://www.googleapis.com/auth/analytics.readonly');
        $client->addScope('https://www.googleapis.com/auth/youtube.readonly');
        
        $service = new YouTube($client);

        $foto = "";
        $nombre = "";
        $email = "";
        $followers = 0;

        $queryParams = [
        'id' => $cuenta
        ];
         
         $response = $service->channels->listChannels('statistics,snippet',$queryParams);

         $item = $response->items[0];
         $foto = $item->snippet->thumbnails->medium->url ;
         $nombre = $item->snippet->title;
         $email = $item-> $snippet -> customUrl;
         $followers = $item->statistics->subscriberCount;

         return response()->json(['foto' => $foto , 'nombre' => $nombre, 'email' => $email, 'followers' => $followers , 'cuenta' => $cuenta], 200);

    }


    // function cardData2(Request $request) {
    
    //          $client = new Client ();
    //          $service = new Youtube($client);
    //          $seguidores = 0 ;
     
    //       $queryParams = [
    //          'channelId' => 'UCQv7Ky41wx2llKVxPGloPJg'
    //          //'channelId' => $id
    //       ];
        
    //      $response = $service->subscriptions->listSubscriptions('contentDetails', $queryParams);
    //      return response()->json(['seguidores' => $seguidores ], 200);
   
    //  }
    

      // function setIdAccount (Request $request){
    //     $IdUsu = $request-> input ('IdUsuario');
    //     $token = $request-> input ('Token');
    //     $newIdCuenta = '';
    //     $client = new Client();
    //     $client->setAccessToken($token);

    //     $queryParams = [
    //         'mine' => true,
    //         'pageToken' => $token 
    //     ];

    //     $response = $service->channels->listChannels('id',$queryParams);
        
    //     Youtube::where('IdUsuario', $IdUsu)->where('TokenAccess', $token)->update(['IdCuenta' => $response->items[0]->id]);

    // }
    }

