<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\YouTube;
use Google\Service\YouTubeAnalytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;


class ProfileController extends Controller
{
    function index (Request $request){

        $connected = true;
        $checkbox = $request->input('metrica',null);
        
        if($checkbox == null){

            $client =new Client ();
            $service = new YouTube($client);    

            if(Session::has('google_oauth_token')){
                $client->setAccessToken(Session::get('google_oauth_token'));
                
            }else{
                return redirect('/');
            }

            $queryParams = [
                'mine' => true
            ];

            $response = $service->channels->listChannels('snippet',$queryParams);
            
            if (!empty($response->items[0]->id)) {
                
                $id = $response->items[0]->id;
                Session::put('channel_id', $id);
                return view('confi');
                
            }else{
                return redirect('/');
            }
            
        }else{

            $client =new Client ();
            $service = new YouTubeAnalytics($client);

            if(Session::has('google_oauth_token')){
                $client->setAccessToken(Session::get('google_oauth_token'));
                
            }else{
                return redirect('/');
            }

            foreach($checkbox as $check){

             if($metricas == null){
                 $metricas = $check;
             }else{
                  $metricas = $metricas.",".$check;
              }
           
          }
         $metricas = str_replace('"', "'" , $metricas);

         $queryParams = [
            'endDate' => '2024-03-31',
            'ids' => 'channel==' . $id,
            'metrics' =>  $metricas,
            'startDate' => '2023-09-01'
          ];

          $response = $service->reports->query($queryParams);

          return view('profile') -> with (['connected' => $connected , 'token' => $token ?? null , 'respuesta' => $response ?? null]);

        }
            
        
    }
}
