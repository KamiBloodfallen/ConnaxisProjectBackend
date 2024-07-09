<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneradorContenido extends Model
{
    use HasFactory;

    protected $table = 'generador_contenidos';
    protected $primaryKey = 'IdUsuario';

    protected $fillable = [
        'Nombre', 'Apellido', 'Celular', 'CorreoElectronico', 'FechaNacimiento', 'Descripcion', 'Sexo', 'Contraseña', 'ResidenciaDepartamento','Nombre_perfil'
    ];

    public $timestamps = true;
}
