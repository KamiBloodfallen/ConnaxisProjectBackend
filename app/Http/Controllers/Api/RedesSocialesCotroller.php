<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;

class RedesSocialesCotroller extends Controller
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




public function getUrlInstagram(){
    $data = [
        'urlInstagram' => $this->_apiBaseUrl,
        'status' => 500
    ];
    return response()->json($data, 200);
}

}
