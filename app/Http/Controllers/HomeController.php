<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\YouTube;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{

    function index(Request $request){
        $client_id='1368132997230381';
        $redirect_uri='https://65ff82f4eb203775071fafdd--prismatic-horse-124283.netlify.app';
        $url="https://api.instagram.com/oauth/authorize?client_id={$client_id}&redirect_uri={$redirect_uri}&scope=user_profile,user_media&response_type=code";



        # Determines where the API server redirects the user after the user completes the authorization flow
        # This value must exactly match one of the authorized redirect URIs for the OAuth 2.0 client, which you configured in your client’s API Console Credentials page.
        $redirectUrl = 'https://65ff82f4eb203775071fafdd--prismatic-horse-124283.netlify.app';

        # Create an configure client
        $client = new Client();
        $client->setAuthConfig(base_path('youtube.json'));
        $client->setRedirectUri($redirectUrl);
        $client->addScope('https://www.googleapis.com/auth/youtube');

        # === SCENARIO 1: PREPARE FOR AUTHORIZATION ===
        if(!$request->has('code') && !Session::has('google_oauth_token')) {
            Session::put('code_verifier', $client->getOAuth2Service()->generateCodeVerifier());
            # Get the URL to Google’s OAuth server to initiate the authentication and authorization process
            $authUrl = $client->createAuthUrl();

            $connected = false;
        }

        # === SCENARIO 2: COMPLETE AUTHORIZATION ===
        # If we have an authorization code, handle callback from Google to get and store access token
        if ($request->has('code')) {
            # Exchange the authorization code for an access token
            $token = $client->fetchAccessTokenWithAuthCode($request->input('code'), Session::get('code_verifier'));
            $client->setAccessToken($token);
            Session::put('google_oauth_token', $token);
            return redirect($redirectUrl);
        }

        # === SCENARIO 3: ALREADY AUTHORIZED ===
        # If we’ve previously been authorized, we’ll have an access token in the session
        if (Session::has('google_oauth_token')) {
            $client->setAccessToken(Session::get('google_oauth_token'));
            if ($client->isAccessTokenExpired()) {
                Session::forget('google_oauth_token');
                $connected = false;
            }
            $connected = true;
        }

        # === SCENARIO 4: TERMINATE AUTHORIZATION ===
        if(isset($_GET['disconnect'])) {
            Session::forget('google_oauth_token');
            Session::forget('code_verifier');
            return redirect($redirectUrl);
        }

        return view('VistaBotones')->with(['connected' => $connected, 'authUrl' => $authUrl,'url' => $url?? null]);    }

    function inisioInstagram(){
       
    }
}
