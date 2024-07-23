<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Generador_contenidoController;
use App\Http\Middleware\CorsMiddleware;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RedesSocialesCotroller;
use App\Http\Controllers\Api\YoutubeController;

Route::get('/estudiante',[Generador_contenidoController::class,'prueba']);

Route::get('/generador/{id}',[Generador_contenidoController::class,'obtenerPorId']);

Route::get('/generador/intereses/{id}',[Generador_contenidoController::class,'getIntereses']);

//Registrar intereses de un generador_contenido

Route::post('/generador/intereses',[Generador_contenidoController::class,'postIntereses']);

//actualizar nombre-perfil Generador contenido

Route::put('/generador/{id}/nombre-perfil', [Generador_ContenidoController::class, 'actualizarNombrePerfil']);
Route::patch('/generador/{id}/nombre-perfil', [Generador_ContenidoController::class, 'actualizarNombrePerfil']);

//actualizar descripcion Generador contenido

Route::put('/generador/{id}/descripcion', [Generador_contenidoController::class,'actualizarDescripcion']);


//Registrar un generador_contenido

Route::post('/registro',[Generador_contenidoController::class,'registrar']);

//get UrlApi Instagram

Route::get('/instagram',[RedesSocialesCotroller::class,'getUrlInstagram']);

//get token Instagram

Route::post('/instagramToken',[RedesSocialesCotroller::class,'registro']);



Route::get('/estudiante/{id}',function(){
    return 'estidiante con id ';
});


Route::put('/estudiante',function(){
    return 'actualizando al estudiante';
});

Route::delete('/estudiante',function(){
    return 'borrando al estudiante';
});


//Rutas de de autentificación

Route::post('/login',[AuthController::class,'login']);

Route::post('/logout',[AuthController::class,'logout']);

//get UrlApi Youtube

Route::get('/youtube', [YoutubeController::class, 'getUrlYoutube']);
Route::post('/youtube-tokenYoutube', [YoutubeController::class, 'createTokenYoutube']);
Route::post('/youtube-saveTokenYoutube', [YoutubeController::class, 'saveTokenYoutube']);