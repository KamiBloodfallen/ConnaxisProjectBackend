<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instagram extends Model
{
    use HasFactory;
    protected $table = 'instagrams';
    protected $fillable = [
        'IdGeneradorContenido',
        'TokenAcces',
        'IdCuenta',
        'TokenTime',
        'NombreCuenta',
        'ImgCuenta',
        'CantPublicaciones',
        'CantSeguidores',
        'CantLikes',
        'Engagement'
    ];

    
    protected $primaryKey = 'IdInstagram';

    // Relación con el modelo GeneradorContenido
    public function generadorContenido()
    {
        return $this->belongsTo(GeneradorContenido::class, 'IdGeneradorContenido', 'IdUsuario');
    }
}
