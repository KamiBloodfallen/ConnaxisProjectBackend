<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;

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





//obtener el token para cambiarlo por el id del usuario
public function _getUserAccessToken(Request $request) {
	$this->_getCode = $request->input('code');
	$params = array(
		'endpoint_url' => $this->_apiBaseUrl . 'oauth/access_token',
		'type' => 'POST',
		'url_params' => array(
			'app_id' => $this->_appId,
			'app_secret' => $this->_appSecret,
			'grant_type' => 'authorization_code',
			'redirect_uri' => $this->_redirectUrl,
			'code' => $this->_getCode
		)
	);

	$response = $this->_makeApiCall( $params );
    $this->_userAccessToken = $response['access_token'];

	$res= $this->_getLongLivedUserAccessToken($response);
    $this->_userAccessTokenExpires = $res['access_token'];
	
	return $res;
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
