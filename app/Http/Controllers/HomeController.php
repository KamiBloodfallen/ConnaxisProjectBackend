<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\YouTube;
use Google\Service\YouTubeAnalytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    private $_appId = '1368132997230381';
	private $_appSecret = 'd83873a62a906dfce475e84130ad1632';
	private $_redirectUrl = 'https://pruebasinstagram-production.up.railway.app/';
	private $_getCode = '';
	private $_apiBaseUrl = 'https://api.instagram.com/';
	private $_graphBaseUrl = 'https://graph.instagram.com/';
	private $_userAccessToken = '';
	private $_userAccessTokenExpires = '';

	public $hasUserAccessToken = false;
	public $authorizationUrl = '';
	public $userId ='';


    function index(Request $request){
        

        $client_id='1368132997230381';
        $redirect_uri='https://65ff82f4eb203775071fafdd--prismatic-horse-124283.netlify.app';
        $url="https://api.instagram.com/oauth/authorize?client_id={$client_id}&redirect_uri={$redirect_uri}&scope=user_profile,user_media&response_type=code";

        $getVars = array( 
                     'client_id' => $this->_appId,
                     'redirect_uri' => $this->_redirectUrl,
                     'scope' => 'user_profile,user_media',
                     'response_type' => 'code'
                 );
             // create url
       //$this->authorizationUrl = $this->_apiBaseUrl . 'oauth/authorize?' . http_build_query( $getVars );
       $authorizationUrl = $this->_apiBaseUrl . 'oauth/authorize?' . http_build_query( $getVars );

        //METODO QUE SOLICITA Y GUARDA EL TOKEN OUTH 2.0 EN LA SESSION DE GOOGLE PARA SU POSTERIOR USO

        // Es la URL a la que la API redirecciona al terminar el flujo de autorización.
        // Esta URL debe coincidir exactamente con uno de los URI de redireccionamiento autorizados para el cliente OAuth 2.0, que configuró en la página Credenciales de la consola de la API.
         $redirectUrl = 'https://7819-189-28-66-122.ngrok-free.app';
        //$redirectUrl = 'https://agencia-de-creadores.stage.cnxbol.com/';

        // Crear y configurar al nuevo cliente
        $client = new Client();
        $client->setAuthConfig(base_path('youtube.json'));
        $client->setRedirectUri($redirectUrl);
        $client->setIncludeGrantedScopes(true);
        $client->setAccessType('offline');
        $client->addScope('https://www.googleapis.com/auth/analytics');
        $client->addScope('https://www.googleapis.com/auth/analytics.readonly');
        $client->addScope('https://www.googleapis.com/auth/youtube.readonly');
        

        # === SCENARIO 1: Preparación para la autorización ===
         if (!$request->has('code') && !Session::has('google_oauth_token')) {
            // Session::put('code_verifier', $client->getOAuth2Service()->generateCodeVerifier());
            //Obtener la URL del servidor OAuth de Google para iniciar el proceso de autenticacion y autorizacion.
             $authUrl = $client->createAuthUrl();

             $connected = false;
         }

        # === SCENARIO 2: Autorizacion completa ===
        // Si tenemos un codigo de autorizacion, manejamos el callback de google y lo guardamos
        if ($request->has('code')) {
            // Intercambio de codigo de autorizacion por el token de acceso
            //$token = $client->fetchAccessTokenWithAuthCode($request->input('code'), Session::get('code_verifier'));
            $codigo = $request->input('code');
            $token = $client->fetchAccessTokenWithAuthCode($codigo);
            $client->setAccessToken($token);
            Session::put('google_oauth_token', $token);
            //dd($token);
            return redirect($redirectUrl);
        }

        # === SCENARIO 3: ya Autorizado ===
        // Si ya esta autorizado se verifica si se tiene guardado el token de acceso en la session
        if (Session::has('google_oauth_token')) {
            $client->setAccessToken(Session::get('google_oauth_token'));
            if ($client->isAccessTokenExpired()) {
                Session::forget('google_oauth_token');
                $connected = false;
            }
            $connected = true;
        }

        # === SCENARIO 4: Autorizacion terminada===
        if(isset($_GET['disconnect'])) {
            Session::forget('google_oauth_token');
            Session::forget('code_verifier');
            return redirect($redirectUrl);
        }
        dump($client);
        return view('index')->with(['connected' => $connected, 'authorizationUrl'=> $authorizationUrl ?? null , 'authUrl' => $authUrl?? null]);  
     }


     function recoverData () {
        
        //METODO PARA RECUPERAR EL ID O LOS IDS DE LOS CANALES ASOCIADOS A LA CUENTA DE GOOGLE

        $client =new Client ();
        //$client = $request->session()->get('client');
        //$client = new Google_Client();
        $service = new YouTube($client);
       
        //$service = new Google_Service_YouTubeAnalytics($client);

       
        if(Session::has('google_oauth_token')){
             $client->setAccessToken(Session::get('google_oauth_token'));

         }else{
             return redirect('/');
         }

       //EJEMPLO 1 IDS DE CANAL
       //funciona #1
       $queryParams = [
        'mine' => true
    ];
        
       
        // $response = $service->channels->listChannels('id',$queryParams);
        // return response()->json($response);
        //funciona #1

        //   $queryParams = [
        //       'dimensions' => 'day,insightTrafficSourceType',
        //       'endDate' => '2024-03-31',
        //       'ids' => 'channel==MINE',
        //       'metrics' => 'views,estimatedMinutesWatched',
        //       'sort' => 'day,-views',
        //       'startDate' => '2023-09-01'
        //   ];

         $response = $service->channels->listChannels('snippet',$queryParams);
          
          //dd($response->items[0]->snippet);
          //dd($response);
          
          //Obtener el id del canal
          //dd($response->items[0]->id);
          //obtener el nombre del canal
          //dd($response->items[0]->snippet->customUrl); 

           if (!empty($response->items[0]->id)) {

             $id = $response->items[0]->id;
             Session::put('channel_id', $id);
             return view('confi');

         }else{
             return redirect('/');
         }
        
        //dd($response);
          

 }
 function recoverData2(Request $request) {

    //METODO QUE VERIFICA SI SE TIENE EL TOKEN OUTH2.0 Y EL ID DEL CANAL EN LA SESSION DE LARAVEL PARA REALIZAR UNA CONSULTA DE DATOS    
        //EJEMPLO 2 METRICAS
          $client =new Client ();
          $service = new YouTubeAnalytics($client);
        //EJEMPLO 2 METRICAS

        //EJEMEPLO 3 SUBSCRIPTORES
        //  $client = new Client ();
        //  $service = new Youtube($client);
        //EJEMPLO 3 SUBSCRIPTORES

        //$client = new Google_Client();
       // $service = new Youtube($client);
       //$service = new YouTubeAnalyticsService($client);

        $metricas=null;
       
        if(Session::has('google_oauth_token')){
             $client->setAccessToken(Session::get('google_oauth_token'));

         }else{
             return redirect('/');
         }
         
        if(Session::has('channel_id')){
            $id = Session::get('channel_id');
            //dd($id);
        }else{
            return redirect('/data');
        }

        $checkbox = $request->input('metrica',null);
        if ($checkbox == null){
            return redirect()->back()->with('error', 'Se debe seleccionar uno como minimo');
        }
        //dd($checkbox);
         foreach($checkbox as $check)
         {
             if($metricas == null){
                 $metricas = $check;
             }else{
                  $metricas = $metricas.",".$check;
              }
           
         }
         $metricas = str_replace('"', "'" , $metricas);

        // dd($metricas);
        // $metricas = "'".$metricas."'";
        //EJEMPLO 2 METRICAS
        
          $queryParams = [
              'endDate' => '2024-03-31',
              'ids' => 'channel==' . $id,
              //'ids' => 'channel==UCQv7Ky41wx2llKVxPGloPJg',
              // 'metrics' => 'views,comments,likes,dislikes,estimatedMinutesWatched,averageViewDuration',
              'metrics' =>  $metricas,
              'startDate' => '2023-09-01'
            ];
        
      $response = $service->reports->query($queryParams);
      //EJEMPLO 2 METRICAS
      
    //EJEMPLO 3 SUBSCRIPTORES
    //  $queryParams = [
    //     'channelId' => 'UCQv7Ky41wx2llKVxPGloPJg'
    //      //'channelId' => $id
    //  ];
    
    //  $response = $service->subscriptions->listSubscriptions('contentDetails', $queryParams);
    // //EJEMPLO 3 SUBSCRIPTORES
   
    dd($response);
 }

// private function _setAuthorizationUrl() {
//     $getVars = array( 
//         'client_id' => $this->_appId,
//         'redirect_uri' => $this->_redirectUrl,
//         'scope' => 'user_profile,user_media',
//         'response_type' => 'code'
//     );

//     // create url
//     $this->authorizationUrl = $this->_apiBaseUrl . 'oauth/authorize?' . http_build_query( $getVars );
// }


function pruebaConsulta (){
    $data = [
        'name' => 'Beimar Alcocer',
        'email' => 'negroxcaro@gmail.com',
        'roles' => ['admin', 'editor']
    ];

    return response()->json($data);
    }
}