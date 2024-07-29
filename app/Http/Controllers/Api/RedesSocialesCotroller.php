<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Models\Instagram; 

class RedesSocialesCotroller extends Controller
{

    private $_appId = '1368132997230381';
	private $_appSecret = 'd83873a62a906dfce475e84130ad1632';
	private $_redirectUrl = 'https://prismatic-horse-124283.netlify.app/';
	//private $_redirectUrl = 'https://labrador-harmless-totally.ngrok-free.app/';
	
	private $_getCode = '';
	private $_apiBaseUrl = 'https://api.instagram.com/';
	private $_graphBaseUrl = 'https://graph.instagram.com/';
	private $_userAccessToken = '';
	private $_userAccessTokenExpires = '';

	public $hasUserAccessToken = false;
	public $authorizationUrl = '';
	public $userId ='';
     
public function getUrlInstagram(){
	$this->_setAuthorizationUrl();
    $data = [
        'urlInstagram' => $this->authorizationUrl,
        'status' => 500
    ];
    return response()->json($data, 200);
}

private function _setAuthorizationUrl() {
	$getVars = array( 
		'client_id' => $this->_appId,
		'redirect_uri' => $this->_redirectUrl,
		'scope' => 'user_profile,user_media',
		'response_type' => 'code'
	);

	// create url
	$this->authorizationUrl = $this->_apiBaseUrl . 'oauth/authorize?' . http_build_query( $getVars );
}

public function registro(Request $request) {
    
	$codigo=$request->input('code');
	$idUsuario=$request->input('IdUsuario');
    $response=$this->_getUserAccessToken($codigo) ;
    $responseToken=$this->_getLongLivedUserAccessToken($response) ;
	//$x="IGQWROalF2WDdZAUEZAPbVpLNm8xbWUxcV9SalZA2VE93M01NVDN6Ym0ybU5JaXBlOHZAlSGUyNndvdDh2OFlyeDhjSTJjZAzQ4dzREZA0Vua080VGo4U25iNldxSi1pUTYwR3I0VmZAKYVZAmRS1RdwZDZD";
	$idCuenta= $response['user_id'];
	$accessToken=$responseToken['access_token'];
	$tiempoToken=$responseToken['expires_in'];
	$dias = $tiempoToken / (60 * 60 * 24);
	$fechaActual = new \DateTime();
	$fechaExpiracion = $fechaActual->add(new \DateInterval('P' . round($dias) . 'D'));
	$fechaExpiracionFormateada = $fechaExpiracion->format('Y-m-d');


	//$accessToken=$x;
   // $idCuenta=17875084627980325;

    $usuario=$this->getUser($accessToken);
		
	$userMedia=$this->getMedia($accessToken); 
	$profilePicture = isset($userMedia['data'][0]['media_url']) ? $userMedia['data'][0]['media_url'] : null;
    $cantFlowers=$this->_getFollowersCount($idCuenta, $accessToken);
	
    $datos = [
		'IdGeneradorContenido' => $idUsuario,
		'TokenAcces' => $accessToken,
		'IdCuenta' => strval($idCuenta),
		'TokenTime' => /*'2024-05-21'*/$fechaExpiracionFormateada,
		'NombreCuenta' => $usuario['username'],
		'ImgCuenta' => $profilePicture,
		'CantPublicaciones' =>$usuario['media_count'],
		'CantSeguidores' => $cantFlowers,
		'CantLikes' => 120,// valor por defecto que se debe de cambiar
		'Engagement' => 12,
	];
     
    $confirmacion= $this->registroBaseDatos($datos);

    return response()->json([
		'username' => $usuario['username'],
        'media_count' => $usuario['media_count'],
        'followers_count' => $cantFlowers,
        'profile_picture' => $profilePicture,
		'response'=>$confirmacion,
		'status' => 404
	],);

}

//registrar en la base de datos
private function registroBaseDatos($request){


	$validator = Validator::make($request, [
        'IdGeneradorContenido' => 'required|exists:generador_contenidos,IdUsuario',
        'TokenAcces' => 'nullable|string',
        'IdCuenta' => 'required|string',
        'TokenTime' => 'nullable|date',
        'NombreCuenta' => 'nullable|string',
        'ImgCuenta' => 'nullable|string',
        'CantPublicaciones' => 'nullable|integer',
        'CantSeguidores' => 'nullable|integer',
        'CantLikes' => 'nullable|integer',
        'Engagement' => 'nullable|integer'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Error de validación',
            'errors' => $validator->errors(),
            'status' => 422
        ], 422);
    }

    $validatedData = $validator->validated();

    // Crear un nuevo registro en la tabla 'instagrams'
    $instagram = Instagram::create($validatedData);

    // Retornar una respuesta con el nuevo registro creado
    return response()->json([
        'message' => 'Datos insertados exitosamente',
        'data' => $instagram,
        'status' => 201
    ], 201);

}

//obtener id y nombre del usuario
private function getUser($token) {
	$params = array(
		'endpoint_url' => $this->_graphBaseUrl . 'me',
		'type' => 'GET',
		'url_params' => array(
			'fields' => 'id,username,media_count,account_type',
			'access_token' => $token,
		)
	);

	$response = $this->_makeApiCall( $params );
	return $response;
}
//obtener contenido del usuario
public function getMedia( $token ) {
	$params = array(
		'endpoint_url' => $this->_graphBaseUrl . 'me/media',
        'type' => 'GET',
        'url_params' => array(
            'fields' => 'id,caption,media_type,media_url,permalink,thumbnail_url,timestamp',
            'access_token' => $token
	    )
	);
	$response = $this->_makeApiCall( $params );
	return $response;
}

// obtener la cantidad de seguidores
private function _getFollowersCount($userId, $token) {
    $params = array(
        'endpoint_url' => $this->_graphBaseUrl . $userId,
        'type' => 'GET',
        'url_params' => array(
            'fields' => 'followers_count',
            'access_token' => $token
        )
    );

    $response = $this->_makeApiCall($params);
    return isset($response['followers_count']) ? $response['followers_count'] : 185;
	
}

//obtener el token para cambiarlo por el id del usuario
public function _getUserAccessToken($codigo) {
	$params = array(
		'endpoint_url' => $this->_apiBaseUrl . 'oauth/access_token',
		'type' => 'POST',
		'url_params' => array(
			'app_id' => $this->_appId,
			'app_secret' => $this->_appSecret,
			'grant_type' => 'authorization_code',
			'redirect_uri' => $this->_redirectUrl,
			'code' => $codigo,
		)
	);

	$response = $this->_makeApiCall( $params );
   // $this->_userAccessToken = $response['access_token'];

	//$res= $this->_getLongLivedUserAccessToken($response);
   // $this->_userAccessTokenExpires = $res['access_token'];
	
	return $response;
	//return $params;
}

//Metodo que cambiar el token de corta duracion por uno de larga duracion 

private function _getLongLivedUserAccessToken($response) {
	$params = array(
		'endpoint_url' => $this->_graphBaseUrl . 'access_token',
		'type' => 'GET',
		'url_params' => array(
			'grant_type' => 'ig_exchange_token',
			'client_secret' => $this->_appSecret,
			'access_token'=> $response['access_token'],
		)
	);

	$response = $this->_makeApiCall( $params );
	return $response;
}



//metodo que hace las consultas por parte de laravel 


private function _makeApiCall( $params ) {
	$ch = curl_init();

	$endpoint = $params['endpoint_url'];

	if ( 'POST' == $params['type'] ) { // post request
		curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params['url_params'] ) );
		curl_setopt( $ch, CURLOPT_POST, 1 );
	} elseif ( 'GET' == $params['type']) { // get request ['paging']

		//add params to endpoint
		$endpoint .= '?' . http_build_query( $params['url_params'] );
	}

	// general curl options
	curl_setopt( $ch, CURLOPT_URL, $endpoint );

	curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

	$response = curl_exec( $ch );

	curl_close( $ch );

	$responseArray = json_decode( $response, true );

	if ( isset( $responseArray['error_type'] ) ) {
		var_dump( $responseArray );
		die();
	} else {
		return $responseArray;
	}
}


}
