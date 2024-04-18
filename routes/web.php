<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/',[App\Http\Controllers\HomeController::class,'index'])->name('index');

Route::get('/outhYoutube',[App\Http\Controllers\SocialMediaController::class,'VistaYoutube'])->name('outhYoutube');