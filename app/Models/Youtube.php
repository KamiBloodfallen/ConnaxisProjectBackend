<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Youtube extends Model
{
    use HasFactory;

    protected $fillable = [
        'IdYoutube', 
        'IdGeneradorContenido',
        'TokenAccess',
        'IdCuenta',
        'NombreCanal',
        'CantVideos',
        'CantSeguidores',
        'CantLikes',
        'Engegament'
    ];
}
