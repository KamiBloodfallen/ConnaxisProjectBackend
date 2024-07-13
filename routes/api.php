<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Generador_contenidoController;
use App\Http\Middleware\CorsMiddleware;
use App\Http\Controllers\Api\V1\AuthController;

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



Route::post('/registro',[Generador_contenidoController::class,'registrar']);


Route::get('/estudiante/{id}',function(){
    return 'estidiante con id ';
});


Route::put('/estudiante',function(){
    return 'actualizando al estudiante';
});

Route::delete('/estudiante',function(){
    return 'borrando al estudiante';
});


//rutas del login

Route::post('/login',[App\Http\Controllers\Api\V1\AuthController::class,'login']);

Route::post('/logout',[App\Http\Controllers\Api\V1\AuthController::class,'logout']);