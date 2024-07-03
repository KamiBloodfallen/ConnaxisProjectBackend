<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CorsMiddleware;

Route::get('/',[App\Http\Controllers\HomeController::class,'index'])->name('index');

Route::get('/data',[App\Http\Controllers\HomeController::class,'recoverData'])->name('data');

Route::get('/profile',[App\Http\Controllers\ProfileController::class,'index'])->name('profile');

Route::post('/data2',[App\Http\Controllers\HomeController::class,'recoverData2'])->name('data2');

/*
Pruebas de http
*/
Route::get('/consulta',[App\Http\Controllers\HomeController::class,'pruebaConsulta'])->middleware(CorsMiddleware::class);